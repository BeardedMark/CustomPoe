<link rel="stylesheet" href="{{ asset('css/reset.css') }}">
{{-- <link rel="stylesheet" href="{{ asset('css/templates.css') }}"> --}}
<link rel="stylesheet" href="{{ asset('css/styles.css') }}">

@php
    $path = public_path('css/styles');

    if (!File::exists($path)) {
        $path = base_path('public_html/css/styles');
    }
    
    $files = scandir($path);
@endphp

@foreach ($files as $file)
    @if (pathinfo($file, PATHINFO_EXTENSION) === 'css')
        <link rel="stylesheet" href="{{ asset('css/styles/' . $file) }}">
    @endif
@endforeach
