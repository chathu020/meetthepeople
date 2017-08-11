<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Meet The People!  </title>
    @section('styles')
    <!-- Bootstrap -->
    <link href="{{ asset("css/bootstrap.min.css") }}" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="{{ asset("css/font-awesome.min.css") }}" rel="stylesheet">
    <!-- Custom Theme Style -->
    <link href="{{ asset("css/gentelella.min.css") }}" rel="stylesheet">

    @stack('stylesheets')

    <script src="{{ asset("js/jquery.min.js") }}"></script>
    
    @show
</head>

<body class="nav-md">
    <div class="container body">
        <div class="main_container">

            @include('includes/sidebar')

            @include('includes/topbar')

            @yield('main_container')
             @if(Session::has('message'))
<p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
@endif

        </div>
    </div>
    @section('scripts')
    <!-- jQuery -->
    <!-- Bootstrap -->
    <script src="{{ asset("js/bootstrap.min.js") }}"></script>
    <!-- Custom Theme Scripts -->
    <script src="{{ asset("js/gentelella.min.js") }}"></script>

    @show
</body>
</html>