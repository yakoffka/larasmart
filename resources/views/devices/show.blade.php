@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">

                <h1 class="text-center blue">{{ $device->hid }} devices</h1>

                @if($device->relays->count() > 0)
                    <ul>
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
