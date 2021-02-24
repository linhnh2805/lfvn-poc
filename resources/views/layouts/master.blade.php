<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {{--CSRF Token--}}
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="/images/favicon.png" type="image/x-png">

    <title>@yield('title', config('app.name', '@Master Layout'))</title>

    {{--Styles css common--}}
    <link rel="stylesheet" href="{{ asset('vendor/bootstrap4/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    @yield('style-libraries')
    {{--Styles custom--}}
    <!-- Add icon library -->
    <link rel="stylesheet" href="{{ asset('vendor/fontawesome/css/all.min.css') }}">
    @yield('styles')
</head>
<body class='bg-light'>
  <div class="container">
    @include('partial.header')

    @yield('content')

    @include('partial.footer')
  </div>

    {{--Scripts js common--}}
    <script src="{{ asset('js/jquery-3.5.1.min.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap4/popper.min.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap4/bootstrap.min.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap4/holder.min.js') }}"></script>
    {{--Scripts link to file or js custom--}}
    @yield('scripts')
</body>
</html>