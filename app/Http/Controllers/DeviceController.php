<?php

namespace App\Http\Controllers;

use App\Device;
use App\Http\Requests\StoreDeviceRequest;
use App\Services\DeviceService\DeviceServiceAbstract;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;


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
     */
    public function store(StoreDeviceRequest $request): void
    {
        Device::create($request->validated());
        redirect()->route('devices.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Device  $device
     * @return \Illuminate\Http\Response
     */
    public function show(Device $device)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Device  $device
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
     * @param  \App\Device  $device
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Device $device)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Device  $device
     * @return \Illuminate\Http\Response
     */
    public function destroy(Device $device)
    {
        //
    }
}
