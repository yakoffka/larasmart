<?php


namespace App\Services\DeviceService;


use App\Device;
use App\Relay;
use Illuminate\Support\Collection;

abstract class DeviceServiceAbstract
{
    /**
     * contains relay states of all currently connected devices
     *
     * @var array
     */
    public array $relaysState;

    /**
     * @return string
     */
    abstract public function getStatusDevices(): string;

    /**
     * @param Device $device
     * @param Relay $relay
     * @param string $status
     * @todo: заменить string $status на boolean!
     */
    abstract public function setStatusRelay(Device $device, Relay $relay, string $status = '1'): void;

    /**
     * @return Collection
     */
    public function getOnlineDevices(): Collection
    {
        $devicesArray = $this->getDevicesArray($this->getRelaysState());
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
        $pattern = '~^' . $hid . '_\d=[0|1]$~';
        $hidRelaysReport = array_filter($this->getRelaysState(), fn(string $item) => preg_match($pattern, $item));
        foreach ($hidRelaysReport as $relayReport) {
            $statusesRelaysByHid[$relayReport[6]] = $relayReport[8] === '1';
        }
       return $statusesRelaysByHid ?? [];
    }

    /**
     * @return array
     */
    public function getRelaysState(): array
    {
        if (empty($this->relaysState)) {
            $statusDevices = $this->getStatusDevices();
            $strings = explode(PHP_EOL, $statusDevices);
            $pattern = '~^[A-Z\d]{5}_\d=[0|1]$~';
            $relaysState = array_filter($strings, fn(string $string) => preg_match($pattern, $string));
            $this->relaysState = array_values($relaysState);
        }
        return $this->relaysState;
    }
}
