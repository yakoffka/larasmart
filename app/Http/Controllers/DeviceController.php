<?php

namespace App\Http\Controllers;

use App\Device;
use App\Services\DeviceService\DeviceServiceAbstract;
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

        $devices->each(static function (Device $item) use ($onlineDevices) {
            if($onlineDevices->contains('hid', $item->hid)) {
                $item->online_status = true;
                $onlineDevices->pull(Device::whereHid($item->hid));
            }
        });

        return view('devices.index', compact('devices', 'onlineDevices'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
