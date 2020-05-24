<?php


namespace App\Services\DeviceService;


use App\Device;
use App\Relay;
use Illuminate\Support\Collection;

abstract class DeviceServiceAbstract
{
    /**
     * @return string
     */
    abstract public function getStatusDevices(): string;

    /**
     * @param Device $device
     * @param Relay $relay
     * @param string $status
     */
    abstract public function setStatusRelay(Device $device, Relay $relay, string $status = '1'): void;

    /**
     * @return Collection
     */
    public function getOnlineDevices(): Collection
    {
        $allRelaysReport = $this->getAllRelaysReport();
        $devicesArray = $this->getDevicesArray($allRelaysReport);
        return $this->getNewDevices($devicesArray);
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

    /**
     * Gets an array of states of all device relays with the transmitted identifier: num => status
     * $statusesRelaysByHid = [
     *      1 = "0",
     *      2 = "1",
     *  ];
     *
     * @param string $hid
     * @return array
     */
    public function getStatusesRelaysByHid(string $hid): array
    {
        $allRelaysReport = $this->getAllRelaysReport();
        $pattern = '~^' . $hid . '_\d=[0|1]$~';
        $hidRelaysReport = array_filter($allRelaysReport, fn(string $string) => preg_match($pattern, $string));
        foreach ($hidRelaysReport as $relayReport) {
            $statusesRelaysByHid[$relayReport[6]] = $relayReport[8];
        }
        return $statusesRelaysByHid ?? [];
    }

/**
     * @return array
     */
    public function getAllRelaysReport(): array
    {
        $statusDevices = $this->getStatusDevices();
        $strings = explode(PHP_EOL, $statusDevices);
        $pattern = '~^[A-Z\d]{5}_\d=[0|1]$~';
        $strings = array_filter($strings, fn(string $string) => preg_match($pattern, $string));
        return $strings;
    }
}
