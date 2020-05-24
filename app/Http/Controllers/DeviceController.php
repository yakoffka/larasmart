<?php

namespace App\Http\Controllers;

use App\Device;
use App\Http\Requests\StoreDeviceRequest;
use App\Relay;
use App\Services\DeviceService\DeviceServiceAbstract;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;


/**
 * Class DeviceController
 * @package App\Http\Controllers
 */
class DeviceController extends Controller
{
    private DeviceServiceAbstract $deviceService;

    /**
     * DeviceController constructor.
     * @param DeviceServiceAbstract $deviceService
     */
    public function __construct(DeviceServiceAbstract $deviceService)
    {
        $this->deviceService = $deviceService;
    }

    /**
     * Display a listing of the resource.
     *
     */
    public function index()
    {
        $devices = Device::all();
        $onlineDevices = $this->deviceService->getOnlineDevices();

        $devices->each(static function (Device $item) use (&$onlineDevices) {
            if($onlineDevices->contains('hid', $item->hid)) {
                $item->online_status = true;
                $onlineDevices = $onlineDevices->filter(fn($device) => $device->hid !== $item->hid);
            }
        });

        return view('devices.index', compact('devices', 'onlineDevices'));
    }

    /**
     * Store a newly created resource in storage.
     * @param StoreDeviceRequest $request
     * @return RedirectResponse
     */
    public function store(StoreDeviceRequest $request): RedirectResponse
    {
        if(Device::whereHid($request->validated()['hid'])->first()) {
            session()->flash('warning', array_merge(session('warning') ?? [], ['this device already exists in the system']));
        } else {
            $device = Device::create($request->validated());
            $this->createDeviceRelays($device);
            session()->flash('success', array_merge(session('success') ?? [], ['this device has been successfully added to the system.']));
        }

        return redirect()->route('devices.index');
    }

    /**
     * Display the specified resource.
     *
     * @param Device $device
     */
    public function show(Device $device)
    {
        return view('devices.show', compact('device'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Device $device
     * @return \Illuminate\Http\Response
     */
    public function edit(Device $device)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param Device $device
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Device $device)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Device $device
     * @return \Illuminate\Http\Response
     */
    public function destroy(Device $device)
    {
        //
    }

    /**
     * @return View
     */
    public function report(): View
    {
        $report = $this->deviceService->getStatusDevices();
        $datetime = date('Y.m.d H:m:s');
        return view('devices.report', compact('report', 'datetime'));
    }

    /**
     * @param $device
     */
    protected function createDeviceRelays($device): void
    {
        $statusesRelays = $this->deviceService->getStatusesRelaysByHid($device->hid);
        for ($i = 1; $i <= $device->number_relay; $i++) {
            Relay::create([
                'name' => $device->hid . '_' . $i,
                'description' => 'description relay #' . $i,
                'device_id' => $device->id,
                'number' => $i,
                'expected_status' => $statusesRelays[$i],
            ]);
        }
    }
}
