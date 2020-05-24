@if(!$device->id)
    @include('devices.modals.add_device')
@else
    <a href="{{ route('devices.show', $device) }}"><i class="fas fa-eye"></i></a>
@endif
