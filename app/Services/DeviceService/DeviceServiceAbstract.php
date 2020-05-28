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
     * Receiving a response string from devices. For example, the output of the command "usbrelay"
     *
     * @return string
     */
    abstract public function getResponseFromDevices(): string;

    /**
     * @param Relay $relay
     * @param bool $newStatus
     */
    abstract protected function toggle(Relay $relay, bool $newStatus): void;

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
            session()->flash('success', array_merge(session('success') ?? [], ['relay ' . $relay->name . ' is ' . ($newStatus === true ? 'on' : 'off')]));
            return;
        }
        session()->flash('warning', array_merge(session('warning') ?? [], ['relay ' . $relay->name . ' already is ' . ($newStatus === true ? 'on' : 'off')]));
    }

    /**
     * @return Collection
     */
    public function getOnlineDevices(): Collection
    {
        $this->setActiveRelays();
        return $this->getActiveDevices();
    }

    /**
     * @param int $device_id
     * @return Collection
     */
    public function getStatusesRelaysByDeviceID(int $device_id): Collection
    {
        $this->setActiveRelays();
        return $this->activeRelays->filter(fn(Relay $relay) => $relay->device_id === $device_id);
    }

    /**
     * Set to $activeRelays property a collection of all active relays from the response from devices
     */
    public function setActiveRelays(): void
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
     * @param string $responseFromDevices
     * @return false|string[]
     */
    protected function getRelaysStrings(string $responseFromDevices)
    {
        $strings = explode(PHP_EOL, $responseFromDevices);
        $pattern = '~^[A-Z\d]{5}_\d=[0|1]$~';
        return array_filter($strings, fn(string $string) => preg_match($pattern, $string));
    }

    /**
     * @return Collection
     */
    public function getActiveRelays(): Collection
    {
        if (empty($this->activeRelays)) {
            $this->setActiveRelays();
        }
        return $this->activeRelays;
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
                'number_relay' => ($devices[$hid]['number_relay'] ?? 0) + 1,
            ]);
        }
        return collect(array_values($devices ?? []));
    }

    /**
     * @param Relay $relayFromDB
     * @return bool
     */
    private function isConsistentStatus(Relay $relayFromDB): bool
    {
        $this->setActiveRelays();
        $activeStatus = $this->activeRelays->where('name', $relayFromDB->name)->first()->status;
        $savedStatus = $relayFromDB->status;

        return $activeStatus === $savedStatus;
    }
}
