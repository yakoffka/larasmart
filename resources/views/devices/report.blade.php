@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">

                <h1 class="text-center blue">Report devices</h1>

                <code>
                    <pre>{{ $report }}</pre>
                </code>

                {{ $datetime }}

            </div>
        </div>
    </div>
@endsection
