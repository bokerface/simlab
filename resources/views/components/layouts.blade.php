<!DOCTYPE html>
<html lang="en">

<!-- Copyright (c) 2019 Indri Junanda (https://github.com/indrijunanda/RuangAdmin) -->

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link href="{{asset('img/logo/logo.png')}}" rel="icon">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>RuangAdmin - Dashboard</title>

    <link href="{{asset('vendor/fontawesome-free/css/all.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('vendor/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('css/ruang-admin.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('css/custom.css')}}" rel="stylesheet" type="text/css">
    @stack('css')
</head>

<body id="page-top">
    <div id="wrapper">
        <!-- Sidebar -->
        @if (session('user_data')['role']==1)
        <x-admin-sidebar />
        @endif
        @if (session('user_data')['role']==2)
        <x-admin-sidebar />
        @endif
        @if (session('user_data')['role']==3)
        <x-mahasiswa-sidebar />
        @endif
        <!-- Sidebar -->
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <!-- TopBar -->
                <x-navbar />
                <!-- Topbar -->

                <!-- Container Fluid-->
                <div class="container-fluid" id="container-wrapper">
                    {{--
                    <x-breadcrumb /> --}}
                    {{ $slot }}
                </div>
                <!---Container Fluid-->
            </div>
            <!-- Footer -->
            <x-footer />
            <!-- Footer -->
        </div>
    </div>

    <!-- Scroll to top -->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <script src="{{asset('vendor/jquery/jquery.min.js')}}"></script>
    <script src="{{asset('vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{asset('vendor/jquery-easing/jquery.easing.min.js')}}"></script>
    <script src="{{asset('js/ruang-admin.min.js')}}"></script>
    @stack('js')
    {{-- {{ $js }} --}}

</body>

</html>