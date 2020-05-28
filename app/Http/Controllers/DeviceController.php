<?php

namespace App\Http\Controllers;

use App\Device;
use App\Http\Requests\StoreDeviceRequest;
use App\Relay;
use App\Services\DeviceService\DeviceServiceAbstract;
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
        parent::__construct();
        $this->deviceService = $deviceService;
    }

    /**
     * Display a listing of the resource.
     *
     */
    public function index()
    {
        $storedDevices = Device::with('relays')->get();
        $devices = $this->deviceService->getOnlineDevices();

        return view('devices.index', compact('devices'));
    }

    /**
     * Store a newly created resource in storage.
     * @param StoreDeviceRequest $request
     * @return RedirectResponse
     */
    public function store(StoreDeviceRequest $request): RedirectResponse
    {
        if (Device::whereHid($request->validated()['hid'])->first()) {
            attachToFlash('warning', 'this device already exists in the system');
        } else {
            // @todo: add transaction?
            $device = Device::create($request->validated());
            $this->createDeviceRelays($device);
            attachToFlash('success', 'this device has been successfully added to the system.');
        }

        return redirect()->route('devices.index');
    }

    /**
     * Display the specified resource.
     *
     * @param Device $device
     * @return View
     */
    public function show(Device $device): View
    {
        $statusesRelays = $this->deviceService->getStatusesRelaysByDeviceID($device->id);
        // @todo: учесть актуальные состояния реле устройства!
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
     * @param \Illuminate\Http\Request $request
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
        $report = $this->deviceService->getResponseFromDevices();
        $datetime = date('Y.m.d H:m:s');
        return view('devices.report', compact('report', 'datetime'));
    }

    /**
     * @param $device
     */
    protected function createDeviceRelays($device): void
    {
        $activeRelays = $this->deviceService->getActiveRelays();
        for ($i = 1; $i <= $device->number_relay; $i++) {
            $relay = $activeRelays->where('name', $device->hid . '_' . $i)->first();
            if ($relay) {// @todo: избавиться от неявного приведения типов?
                $relay->device_id = $device->id;
                $relay->save();
            }
        }
    }

    /**
     * @param Relay $relay
     * @return RedirectResponse
     */
    public function toggleOn(Relay $relay): RedirectResponse
    {
        $this->deviceService->setStatusRelay($relay, true);
        return redirect()->route('devices.show', $relay->device_id);
    }

    /**
     * @param Relay $relay
     * @return RedirectResponse
     */
    public function toggleOff(Relay $relay): RedirectResponse
    {
        $this->deviceService->setStatusRelay($relay, false);
        return redirect()->route('devices.show', $relay->device_id);
    }
}
