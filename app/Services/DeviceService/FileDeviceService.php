<?php


namespace App\Services\DeviceService;


use App\Device;
use App\Relay;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Storage;

class FileDeviceService extends DeviceServiceAbstract
{
    public static string $pathToFile = 'dump.txt';
    private string $pathToExample = 'example.txt';

    /**
     * @return string
     * @throws FileNotFoundException
     */
    public function getStatusDevices(): string
    {
        if (Storage::disk('devices')->missing(self::$pathToFile)) {
            Storage::disk('devices')->copy($this->pathToExample, self::$pathToFile);
        }
        return Storage::disk('devices')->get(self::$pathToFile);
    }


    /**
     * @param Device $device
     * @param Relay $relay
     * @param string $status
     * @throws FileNotFoundException
     */
    public function setStatusRelay(Device $device, Relay $relay, string $status = '1'): void
    {
        $statusDevices = $this->getStatusDevices();
        $expectedStatus = $status === '1' ? '0' : '1';

        $toggle = false;
        foreach ($strings = explode(PHP_EOL, $statusDevices) as $key => $string) {
            if ($string === $device->hid . '_' . $relay->number . '=' . $expectedStatus) {
                $strings[$key] = $device->hid . '_' . $relay->number . '=' . $status;
                $toggle = true;
            }
        }

        if ($toggle) {
            if (Storage::disk('devices')->put(self::$pathToFile, implode(PHP_EOL, $strings))) {
                session()->flash('success', array_merge(session('success') ?? [],
                    ['device ' . $device->hid . '_' . $relay->number . ' is ' . ($status === '1' ? 'on' : 'off')]));
            } else {
                session()->flash('error', array_merge(session('error') ?? [],
                    ['error device ' . $device->hid . '_' . $relay->number . ' is ' . ($status === '1' ? 'on' : 'off')]));
            }
        } else {
            session()->flash('warning', array_merge(session('warning') ?? [],
                ['warning device ' . $device->hid . '_' . $relay->number . ' is ' . ($status === '1' ? 'on' : 'off')]));
        }

        $relay->update(['expected_status' => $status]);
    }
}
