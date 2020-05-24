<tr>
    <td>{{ $key + 1 }}</td>
    <td>{{ $relay->id ?? '-' }}</td>
    <td>{{ $relay->name }}</td>
    <td>{{ $relay->device->hid }}</td>
    <td>{{ $relay->description }}</td>
    <td>{{ $relay->expected_status }}</td>
    <td>
        @include('relays.parts.actions')
    </td>
</tr>

