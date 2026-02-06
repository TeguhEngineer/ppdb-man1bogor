@props(['for' => null, 'messages' => null])

@php
    $errorMessages = $messages ?? ($for ? $errors->get($for) : []);
@endphp

@if ($errorMessages && count($errorMessages) > 0)
    <div {{ $attributes->merge(['class' => 'mt-1 text-sm text-red-600']) }}>
        @foreach ((array) $errorMessages as $message)
            <p>{{ $message }}</p>
        @endforeach
    </div>
@endif
