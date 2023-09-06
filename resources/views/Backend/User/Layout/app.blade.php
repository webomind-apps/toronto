<!DOCTYPE html>
<html lang="en">
<head>
    @include('Backend.Layout.header')
</head>
<body class="nav-md">
    <div class="container body">
        <div class="main_container">
            <div class="col-md-3 left_col">
                @include('Backend.User.Layout.sidebar')
            </div>
            <!-- top navigation -->
            <div class="top_nav">
                @include('Backend.User.Layout.topnav')
            </div>
            <!-- /top navigation -->
            <!-- page content -->
            <div class="right_col" role="main">
                @yield('main')
            </div>
            <!-- /page content -->
        </div>
    </div>
    @include('Backend.Layout.footer')
</body>
</html>
