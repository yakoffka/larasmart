<?php

if (!function_exists('attachToFlash')) {
    function attachToFlash(string $type, string $message)
    {
        session()->flash($type, [...session($type) ?? [], $message]);
    }
}
