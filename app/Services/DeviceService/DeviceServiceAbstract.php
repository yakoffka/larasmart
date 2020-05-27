<?php


namespace App\Services\DeviceService;


use App\Device;
use App\Relay;
use Illuminate\Support\Collection;

abstract class DeviceServiceAbstract
{
    /**
     * Collection of all active relays
     */
    public Collection $activeRelays;

    /**
     * @return string
     */
    abstract public function getResponseFromDevices(): string;

    /**
     * @param Relay $relay
     * @param bool $newStatus
     * @todo: заменить string $status на boolean!
     */
    public function setStatusRelay(Relay $relay, bool $newStatus): void
    {
        if ($this->isConsistentStatus($relay)) {
            $this->toggle($relay, $newStatus);
            $relay->update(['status' => $newStatus]);
            session()->flash('success', array_merge(session('success') ?? [], ['relay ' . $relay->name . ' is ' . ($newStatus === '1' ? 'on' : 'off')]));
        }
        session()->flash('warning', array_merge(session('warning') ?? [], ['relay ' . $relay->name . ' already is ' . ($newStatus === '1' ? 'on' : 'off')]));
    }

    abstract protected function toggle(Relay $relay, bool $newStatus): void;

    /**
     * @return Collection
     */
    public function getOnlineDevices(): Collection
    {
        $this->getActiveRelays();
        // dd(__LINE__, $relaysState);
        // $devicesArray = $this->getDevicesArray($relaysState);
        // return $this->getNewDevices($devicesArray);
        return $this->getActiveDevices();
    }

    /**
     * @param array $strings
     * @return mixed
     */
//    protected function getDevicesArray(array $strings)
//    {
//        array_map(static function (string $key, string $val) use (&$devicesArray) {
//            $devicesArray[substr($key, 0, 5)][substr($key, 0, 7)] = $val === '1';
//        }, array_keys($strings), $strings);
//        return $devicesArray;
//    }

    /**
     * @param $devicesArray
     * @return Collection
     */
//    private function getNewDevices($devicesArray): Collection
//    {
//        $devices = collect([]);
//
//        foreach ($devicesArray as $hid => $item) {
//            $device = new Device();
//            $device->hid = $hid;
//            $device->number_relay = count($item);
//            $device->online_status = true;
//
//            $devices->push($device);
//        }
//        return $devices;
//    }

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
        $hidRelaysReport = array_filter($this->getActiveRelays(), fn(string $item) => preg_match($pattern, $item));
        foreach ($hidRelaysReport as $relayReport) {
            $statusesRelaysByHid[$relayReport[6]] = $relayReport[8] === '1';
        }
        return $statusesRelaysByHid ?? [];
    }

    /**
     *
     */
    public function getActiveRelays(): void
    {
        if (empty($this->activeRelays)) {
            $relaysStrings = $this->getRelaysStrings($this->getResponseFromDevices());
            foreach ($relaysStrings as $string) {
                $relays[] = Relay::firstOrNew([
                    'name' => substr($string, 0, 7)
                ], [
                    'number' => (int)$string[6],
                    'status' => $string[8] === '1',
                ]);
            }
            $this->activeRelays = collect($relays ?? []);
        }
    }

    /**
     * @return Collection
     */
    private function getActiveDevices(): Collection
    {
        foreach ($this->activeRelays as $relay) {
            $hid = substr($relay->name, 0, 5);
            $devices[$hid] = Device::firstOrNew([
                'hid' => $hid,
            ], [
                'status' => 'online',
                'description' => 'example description',
           ]);
        }
        return collect(array_values($devices ?? []));
    }

    /**
     * @param Relay $relay
     * @return bool
     */
    private function isConsistentStatus(Relay $relay): bool
    {
        dd(__LINE__);
    }

    /**
     * @param string $responseFromDevices
     * @return false|string[]
     */
    protected function getRelaysStrings(string $responseFromDevices)
    {
        $strings = explode(PHP_EOL, $responseFromDevices);
        $pattern = '~^[A-Z\d]{5}_\d=[0|1]$~';
        $needleStrings = array_filter($strings, fn(string $string) => preg_match($pattern, $string));
        return $needleStrings;
    }
}
