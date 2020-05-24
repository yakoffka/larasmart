<div class="switch">
    <label>
        Off
        <input type="checkbox"{{ $relay->expected_status ? ' checked' : '' }}>
        <span class="lever" onclick="document.getElementById('form_id_{{ $device->hid }}_{{ $relay->number }}').submit();"></span> On
    </label>
    <form action="{{ route('devices.relay.toggle_' . ($relay->expected_status ? 'off' : 'on'), [$device, $relay]) }}" method="POST"
        id="form_id_{{ $device->hid }}_{{ $relay->number }}">@csrf</form>
</div>
