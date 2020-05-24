<?php


namespace App\Services\DeviceService;


class USBDeviceService extends DeviceServiceAbstract
{
    /**
     * @return string
     */
    public function getStatusDevices(): string
    {
        return shell_exec("usbrelay -la 2>&1");
    }
}
