<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>:: WC | Admin Console ::</title>
    <link rel="icon" href="{{ asset('img/icon.png') }}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/AdminLTE.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/skin-purple.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/dataTables.bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
</head>

<body class="hold-transition skin-purple sidebar-mini">
    <div class="loading">Loading&#8230;</div>
    <div class="wrapper">
        <header class="main-header">
            <a href="{{ url('/') }}" class="logo">
                <span class="logo-mini"><b>A</b>C</span>
                <span class="logo-lg"><b>Admin</b> Console</span>
            </a>
            <nav class="navbar navbar-static-top" role="navigation">
                <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                    <span class="sr-only">Toggle navigation</span>
                </a>
            </nav>
        </header>
        <aside class="main-sidebar">
            <section class="sidebar">
                <div class="user-panel">
                    <div class="pull-left image">
                        <img src="{{ asset('img/icon.png') }}" class="img-circle" alt="User Image">
                    </div>
                    <div class="pull-left info">
                        <p>Administrator</p>
                        <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
                    </div>
                </div>
                <ul class="sidebar-menu">
                    <li class="header">Main Menu</li>
                    <li class="active"><a href="{{ url('/') }}"><i class="fa fa-user"></i> <span>Employee</span></a></li>
                </ul>
            </section>
        </aside>
        <div class="content-wrapper">
            @yield('content')
        </div>
        <footer class="main-footer">
            <div class="pull-right hidden-xs">
                Athul Babu - Machine Test
            </div>
            <strong>Copyright &copy; {{ date('Y') }} <a href="https://webandcrafts.com/" target="_blank">Web & Crafts</a>.</strong> All rights reserved.
        </footer>
        <div class="control-sidebar-bg"></div>
    </div>
    <script src="{{ asset('js/jQuery-2.1.4.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('js/dataTables.bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/sweetalert.min.js') }}"></script>
    <script src="{{ asset('js/app.min.js') }}"></script>
    <script src="{{ asset('js/custom.js') }}"></script>
</body>

</html>