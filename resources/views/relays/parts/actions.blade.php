<div class="switch">
    <label>
        Off
        <input type="checkbox"{{ $relay->status ? ' checked' : '' }}>
        <span class="lever" onclick="document.getElementById('form_id_{{ $device->hid }}_{{ $relay->number }}').submit();"></span> On
    </label>
    <form action="{{ route('relays.toggle_' . ($relay->status ? 'off' : 'on'), [$relay]) }}" method="POST"
        id="form_id_{{ $device->hid }}_{{ $relay->number }}">@csrf</form>
</div>
