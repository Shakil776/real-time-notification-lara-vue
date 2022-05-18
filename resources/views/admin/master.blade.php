<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
<!-- BEGIN: Head-->

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="author" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') | Sukhtara International Ltd.</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,300;0,400;0,500;0,600;1,400;1,500;1,600" rel="stylesheet">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('admin/assets/img/favicon.ico') }}">
    <link rel="apple-touch-icon" href="{{ asset('admin/assets/img/apple-touch-icon.png') }}">

    @include('admin.partials._styles')
</head>
<!-- END: Head-->

<!-- BEGIN: Body-->

<body class="vertical-layout vertical-menu-modern  navbar-floating footer-static  " data-open="click" data-menu="vertical-menu-modern" data-col="">
    <div id="app">
        <!-- BEGIN: Header-->
        @include('admin.partials._header')
        <!-- END: Header-->

        <!-- BEGIN: Main Menu-->
        @include('admin.partials._sidebar')
        <!-- END: Main Menu-->

        <!-- BEGIN: Content-->
        <div class="app-content content ">
            <div class="content-overlay"></div>
            <div class="header-navbar-shadow"></div>
            @yield('content')
        </div>
        <!-- END: Content-->

        <div class="sidenav-overlay"></div>
        <div class="drag-target"></div>

        <!-- BEGIN: Footer-->
            @include('admin.partials._footer')
        <!-- END: Footer-->
    </div>
        <!-- BEGIN: Scripts-->
            @include('admin.partials._scripts')
        <!-- END: Scripts-->
    
</body>
<!-- END: Body-->
</html>