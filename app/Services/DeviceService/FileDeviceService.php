<?php


namespace App\Services\DeviceService;


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
    public function getResponseFromDevices(): string
    {
        if (Storage::disk('devices')->missing(self::$pathToFile)) {
            Storage::disk('devices')->copy($this->pathToExample, self::$pathToFile);
        }
        return Storage::disk('devices')->get(self::$pathToFile);
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
