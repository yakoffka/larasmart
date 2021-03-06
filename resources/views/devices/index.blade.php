@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">

                <h1 class="text-center blue">Available devices</h1>

                <table class="table no_border_top text-center">
                    <tr>
                        <th>num</th>
                        <th>id</th>
                        <th>name</th>
                        <th>hid</th>
                        <th>relays</th>
                        <th>status</th>
                        <th>actions</th>
                    </tr>
                    @forelse($devices as $key => $device)
                        @include('devices.parts.row_device')
                    @empty
                        <tr><td colspan="7">no devices</td></tr>
                    @endforelse
                </table>

            </div>
        </div>
    </div>
@endsection
