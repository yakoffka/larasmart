<tr>
    <td>{{ $key + 1 }}</td>
    <td>{{ $device->id ?? '-' }}</td>
    <td>{{ $device->name ?? 'unsaved device' }}</td>
    <td>{{ $device->hid ?? '-' }}</td>
    <td>{{ $device->number_relay ?? '-' }}</td>
    <td>{!! $device->online_status ? '<div class="online"></div>' : '<div class="offline"></div>' !!}</td>
    <td>
        @include('devices.parts.action')
    </td>
</tr>

