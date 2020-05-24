<div class="toasts">
    @if ($errors->any())
        @foreach ($errors->all() as $key => $message)
            @php
                $errors ??= null;
                $n = $errors->count() - $key;
                $color = 'a60d10';
            @endphp

            @include('components.toast')
        @endforeach
    @endif

    @if (session('error'))
        @foreach (session('error') as $key => $message)
            @php
                $n = count(session('error')) - $key + 1;
                $color = 'a60d10';
            @endphp

            @include('components.toast')
        @endforeach
    @endif

    @if (session('warning'))
        @foreach (session('warning') as $key => $message)
            @php
                $n = count(session('warning')) - $key + 1;
                $color = 'a60d10';
            @endphp

            @include('components.toast')
        @endforeach
    @endif

    @if (session('success'))
        @foreach (session('success') as $key => $message)
            @php
                $n = count(session('warning')) - $key + 1;
                $color = 'a60d10';
            @endphp

            @include('components.toast')
        @endforeach
    @endif
</div>
