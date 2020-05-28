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
     * @throws FileNotFoundException
     */
    protected function toggle(Relay $relay, bool $newStatus): void
    {
        $search = sprintf('%s_%d=%b', $relay->device->name, $relay->number, !$newStatus);
        $replace = sprintf('%s_%d=%b', $relay->device->name, $relay->number, $newStatus);

        $replacedResponse = str_replace($search, $replace, $this->getResponseFromDevices(), $count);

        $action = $newStatus === true ? 'toggle on' : 'toggle off';
        if( $count > 0 ) {
            if(!Storage::disk('devices')->put(self::$pathToFile, $replacedResponse)) {
                attachToFlash('error', "fail of $action of the relay $relay->name");
            }
        } else {
            attachToFlash('error', "when $action the relay $relay->name is lost");
        }
    }
}
