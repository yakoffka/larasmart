<?php


namespace App\Services\DeviceService;


use App\Relay;

class USBDeviceService extends DeviceServiceAbstract
{
    /**
     * @return string
     */
    public function getResponseFromDevices(): string
    {
        return shell_exec("usbrelay -la 2>&1");
    }

    /**
     * @param Relay $relay
     * @param bool $newStatus
     */
    public function setStatusRelay(Relay $relay, bool $newStatus): void
    {
        // TODO: Implement setStatusRelayDevice() method.
    }

    /**
     * @param Relay $relay
     * @param bool $newStatus
     */
    protected function toggle(Relay $relay, bool $newStatus): void
    {
        // TODO: Implement toggle() method.
    }
}
