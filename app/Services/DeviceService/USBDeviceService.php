<?php


namespace App\Services\DeviceService;


use App\Device;
use App\Relay;

class USBDeviceService extends DeviceServiceAbstract
{
    /**
     * @return string
     */
    public function getStatusDevices(): string
    {
        return shell_exec("usbrelay -la 2>&1");
    }

    /**
     * @param Device $device
     * @param Relay $relay
     * @param string $status
     */
    public function setStatusRelay(Device $device, Relay $relay, string $status = '1'): void
    {
        // TODO: Implement setStatusRelayDevice() method.
    }
}
