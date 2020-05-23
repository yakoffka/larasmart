<?php


namespace App\Services\DeviceService;


use App\Device;
use Illuminate\Support\Collection;

abstract class DeviceServiceAbstract
{
    abstract protected function getStatusDevices(): string;

    public function getOnlineDevices(): Collection
    {
        $statusDevices = $this->getStatusDevices();
        $strings = $this->getRelayStrings($statusDevices);
        $devicesArray = $this->getDevicesArray($strings);
        return $this->getNewDevices($devicesArray);
    }

    /**
     * @param string $statusDevices
     * @return false|string[]
     */
    protected function getRelayStrings(string $statusDevices)
    {
        $pattern = '~^[A-Z\d]{5}_\d=[0|1]$~';
        $strings = explode(PHP_EOL, $statusDevices);
        $strings = array_filter($strings, fn(string $string) => preg_match($pattern, $string));
        return $strings;
    }

    /**
     * @param array $strings
     * @return mixed
     */
    protected function getDevicesArray(array $strings)
    {
        array_map(static function (string $key, string $val) use (&$devicesArray) {
            $devicesArray[substr($key, 0, 5)][] = $val;
        }, $strings, $strings);
        return $devicesArray;
    }

    /**
     * @param $devicesArray
     * @return Collection
     */
    private function getNewDevices($devicesArray): Collection
    {
        $devices = collect([]);

        foreach ($devicesArray as $hid => $item) {
            $device = new Device();
            $device->hid = $hid;
            $device->number_relay = count($item);
            $device->online_status = true;

            $devices->push($device);
        }
        return $devices;
    }
}
