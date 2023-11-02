<html lang="en">

<head>
    <meta charset="UTF-8" />
    {{-- {!! SEO::generate() !!} --}}
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <link rel="icon" sizes="16x16" href="{{ asset('webo/images/favicon.png') }}" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    {{-- Links --}}
    <link rel="stylesheet" href="{{ asset('webo/css/bootstrap.css') }}" />
    <link rel="stylesheet" href="{{ asset('webo/css/font-awesome.css') }}" />

    <link rel="stylesheet" href="{{ asset('detail/css/animate.css') }}">
    <link rel="stylesheet" href="{{ asset('detail/css/carousel.css') }}">
    <link rel="stylesheet" href="{{ asset('detail/css/carousel-theme.css') }}">
    <link rel="stylesheet" href="{{ asset('detail/css/image-gallery.css') }}">


    <link rel="stylesheet" href="{{ asset('webo/css/style.css') }}" />
    <!-- Bootstrap CSS -->
    <title>Toronto connection</title>

    <link rel="icon" type="image/png" href="images/favicon.png">

    <script>
        var app_url = "<?= URL::to('/') ?>";
    </script>
    <style>


    </style>
    @stack('style')
</head>

<body>

    @include('Frontend.Layout.header')

    @yield('main')

    @include('Frontend.Layout.footer')

    <script src="{{ asset('webo/js/jquery.js') }}"></script>
    <script src="{{ asset('webo/js/propper.js') }}"></script>
    <script src="{{ asset('webo/js/bootstrap.js') }}"></script>
    <script src="{{ asset('assets/js/custom.js?v=1.4') }}"></script>

    <script src="{{ asset('webo/js/wow.js') }}"></script>
    <script src="{{ asset('webo/js/image-gallery.js') }}"></script>
    <script src="{{ asset('webo/js/carousel.js') }}"></script>

    <script src="{{ asset('webo/js/script.js') }}"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/js/bootstrap-multiselect.js"></script>
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/css/bootstrap-multiselect.css" />

    <link href='https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/ui-lightness/jquery-ui.css'
        rel='stylesheet'>

    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>


    <div class="modal fade review-modal" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable review-modal-dialog">
            <div class="modal-content">
                <div class="modal-header review-modal-header">
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4 text-center review-modal-body">
                    <div class="text-center" style="color: #1acb50;"><i class="fa fa-check-circle-o fa-5x"></i></div>
                    <h2 class="h1">Thank You</h2>

                    @if (session('pop-up-success'))
                        <p>{{ session('pop-up-success') }}</p>
                    @endif

                </div>
            </div>
        </div>
    </div>


    @if (session('pop-up-success'))
        <script>
            $(document).ready(function() {
                $('#exampleModal').modal('show');
                setTimeout(function() {
                    $('#exampleModal').modal('hide');
                }, 5000);

                $(".btn-close").click(function(e) {
                    e.preventDefault();
                    $('#exampleModal').modal('hide');
                });
            });
        </script>
    @endif

    <script>
        $(document).ready(function() {

            $('.phone').change(function(event) {
                string = $(this).val();
                $(this).parent('div').find('.phoneErr').remove();

                pattern = /([0-9]{3}\-[0-9]{3}\-[0-9]{4})/;
                if (!pattern.test(string) || string.length != 12) {
                    $(this).val("");
                    $(this).parent('div').append(
                        '<div style="color:red" class="phoneErr">Enter valid mobile number</div>');
                }
            });

            $('.phone').keypress(function(event) {
                phone = $(this).val();
                if (event.which < 48 || event.which > 57 || phone.length > 11) {
                    event.preventDefault();
                }
            });

            $('.phone').keyup(function(event) {
                phone = $(this).val();
                if ((phone.length == 3 || phone.length == 7) && event.which != 08) {
                    phone = phone + "-";
                }
                $(this).val(phone);
            });

            $(document).on('change', '.code', function() {

                string = $(this).val();
                $(this).parent('div').find('.codeErr').remove();

                pattern = /[a-zA-Z][0-9][a-zA-Z](-| |)[0-9][a-zA-Z][0-9]/;
                if (!pattern.test(string)) {
                    $(this).parent('div').append(
                        '<div style="color:red" class="codeErr" >Invalid pincode</div>');
                    $(this).val("");
                }

            });

            $(".alphanumeric").keypress(function(e) {
                var keyCode = e.keyCode || e.which;

                //Regex for Valid Characters i.e. Alphabets and Numbers.
                var regex = /^[A-Za-z0-9]+$/;

                //Validate TextBox value against the Regex.
                var isValid = regex.test(String.fromCharCode(keyCode));
                if (!isValid) {
                    return false
                }

                return isValid;
            });

            $(document).on('keyup', '.code', function(event) {
                code = $(this).val();
                if (code.length == 3 && event.which != 08) {
                    code = code + " ";
                }
                $(this).val(code);
            });

            
            $(".email").change(function() {
                email = $(this).val();
                $(this).parent('div').find('.emailErr').remove();
                pattern = /^\b[A-Z0-9._%-]+@[A-Z0-9.-]+\.[A-Z]{2,4}\b$/i;
                if (!pattern.test(email)) {
                    $(this).parent('div').append(
                        '<div style="color:red" class="emailErr" >Invalid email address</div>');
                    $(this).val("");
                }
            });

            $('.number').keypress(function(event) {
                if (event.which < 48 || event.which > 57) {
                    event.preventDefault();
                }
                var attr = $(this).attr('data-digit');
                if (typeof attr !== 'undefined' && attr !== false) {
                    if ($(this).val().length > attr) {
                        event.preventDefault();
                    }
                }
            });

            $('.decimal').keypress(function(event) {

                var charCode = (event.which) ? event.which : event.keyCode

                if ((charCode != 45 || $(this).val().indexOf('-') != -1) &&
                    // “-” CHECK MINUS, AND ONLY ONE.
                    (charCode != 46 || $(this).val().indexOf('.') != -1) &&
                    // “.” CHECK DOT, AND ONLY ONE.
                    (charCode < 48 || charCode > 57))
                    return false;

                return true;
            });

            $(".email-unique").change(function() {
                vm = $(this);
                vm.parent('div').find('.emailErr').remove();
                value = vm.val();
                dbField = vm.attr('data-field');
                dbTable = vm.attr('data-table');
                $.ajax({
                    type: "POST",
                    url: "{{ route('common.email_unique') }}",
                    data: {
                        value: value,
                        dbField: dbField,
                        dbTable: dbTable,
                        _token: "{{ csrf_token() }}",
                    },
                    dataType: 'json',
                    success: function(response) {
                        if (response > 0) {
                            vm.val("");
                            vm.parent('div').append(
                                '<div style="color:red" class="emailErr" >Email address already exist</div>'
                            );
                        }
                    },
                    error: function(jqXHR) {
                        response = $.parseJSON(jqXHR.responseText);
                        if (response.message) {
                            alert(response.message);
                        }
                    }
                });

            });

            $(".password-eye").click(function(e) {
                pass = $(this).parent("div").find("input");
                if (pass.val() != '') {
                    passType = pass.attr('type');
                    type = (passType == "password") ? "text" : "password";
                    pass.attr('type', type);
                }

            });

            $(document).on('focusout', '.website', function() {

                var regex = /^([wW]{3})+\.(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})$/;
                var website = $(this).val();
                $(this).parent('div').find('.webErr').remove();
                if (!regex.test(website)) {
                    $(this).val("");
                    $(this).parent('div').append(
                        '<div style="color:red" class="webErr" >Invalid Website format</div>');
                }
            })

        });
    </script>
    @stack('scripts')
</body>

</html>
