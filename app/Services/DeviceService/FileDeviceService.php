<?php


namespace App\Services\DeviceService;


use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Storage;

class FileDeviceService extends DeviceServiceAbstract
{
    private string $pathToFile = 'dump.txt';
    private string $pathToExample = 'example.txt';

    /**
     * @return string
     * @throws FileNotFoundException
     */
    public function getStatusDevices(): string
    {
        if (Storage::disk('devices')->missing($this->pathToFile)) {
            Storage::disk('devices')->copy($this->pathToExample, $this->pathToFile);
        }
        return Storage::disk('devices')->get($this->pathToFile);
    }
}
