<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="{{ url('favicon.ico') }}">
    <title>
       Dashboard Panel
    </title>
    <link href="{{ asset("css/app.css") }}" rel="stylesheet" id="layout-css">
</head>

<body>
    <noscript>
        <strong>We're sorry but dashboard doesn't work properly without JavaScript enabled. Please enable it to
            continue.</strong>
    </noscript>
    <div id="app"></div>
    <script src="{{ asset('js/app.js') }}"></script>
</body>

</html>
