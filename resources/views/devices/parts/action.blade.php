

@if(!$device->id)
    <i class="fas fa-save blue"></i>

    {{--<form action="{{ route('devices.store') }}">
        <input type="text" name="name" value="{{ $name ?? '' }}">
        <input type="text" name="description" value="{{ $description ?? '' }}">
        <input type="text" name="hid" value="{{ $hid ?? '' }}">
        <input type="text" name="number_relay" value="{{ $number_relay ?? '' }}">
    </form>--}}
@endif
