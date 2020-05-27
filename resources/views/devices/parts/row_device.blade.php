<tr>
    <td>{{ $key + 1 }}</td>
    <td>{{ $device->id ?? '-' }}</td>
    <td>{{ $device->name ?? 'unsaved device' }}</td>
    <td>{{ $device->hid ?? '-' }}</td>
    <td>{{ $device->number_relay ?? '-' }}</td>
    <td><div class="online" title="{{ $device->status }}"></div></td>
    <td>
        @include('devices.parts.actions')
    </td>
</tr>

