@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">

                <h1 class="text-center blue">{{ $device->hid }} devices</h1>

                @if($device->relays->count() > 0)
                    <table class="table text-center">
                        <tr>
                            <th>num</th>
                            <th>id</th>
                            <th>name</th>
                            <th>device hid</th>
                            <th>description</th>
                            <th>expected status</th>
                            <th>actions</th>
                        </tr>

                        @foreach($device->relays as $key => $relay)
                            @include('relays.parts.row_relay')
                        @endforeach
                    </table>
                @else
                    this device does not have a relay
                @endif

            </div>
        </div>
    </div>
@endsection
