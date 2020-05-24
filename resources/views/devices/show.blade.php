@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">

                <h1 class="text-center blue">{{ $device->hid }} devices</h1>

                @if($device->relays->count() > 0)
                    <ul>
                        <tr>
                            <th>num</th>
                            <th>id</th>
                            <th>name</th>
                            <th>device hid</th>
                            <th>description</th>
                            <th>last status</th>
                            <th>actions</th>
                        </tr>

                        @foreach($device->relays as $relay)
                            <li>{{ $relay->name }}</li>
                        @endforeach
                    </ul>
                @else
                    this device does not have a relay
                @endif

            </div>
        </div>
    </div>
@endsection
