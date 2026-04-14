<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Support System') }}</title>
    @viteReactRefresh
    @vite(['resources/js/spa.tsx'])
</head>
<body style="margin:0;height:100%">
    <div id="root" style="height:100%"></div>
</body>
</html>
