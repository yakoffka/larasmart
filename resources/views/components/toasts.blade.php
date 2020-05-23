<div class="toasts">
    @if ($errors->any())
        @foreach ($errors->all() as $key => $error)
            @php
                $errors ??= null;
                $n = $errors->count() - $key;
                $color = 'a60d10';
            @endphp

            @include('components.toast')
        @endforeach
    @endif
</div>
