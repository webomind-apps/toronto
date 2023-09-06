<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Toronto Connection Login</title>
    <link href="{{ asset('admin/vendors/bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/vendors/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/vendors/nprogress/nprogress.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/build/css/custom.min.css') }}" rel="stylesheet">

    <style>
        .password-eye {
            position: absolute;
            top: 10px;
            right: 12px;
        }

        .position-relative {
            position: relative;
        }

    </style>
    @stack('style')
</head>

<body>
    <div id="app">
        <main class="py-4">
            @yield('main')
        </main>
    </div>

    <script src="{{ asset('/admin/vendors/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('/admin/vendors/bootstrap/dist/js/bootstrap.min.js') }}"></script>
    <script>
        /**
         * @param $form
         * return object
         */

        $(document).ready(function() {
            $(".password-eye").click(function(e) {
                pass = $(this).parent("div").find("input");
                if (pass.val() != '') {
                    passType = pass.attr('type');
                    type = (passType == "password")?"text":"password";
                    pass.attr('type', type);
                }

            });
        });
    </script>
    @stack('scripts')
</body>

</html>
