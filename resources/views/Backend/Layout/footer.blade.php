<!-- jQuery -->
<script src="{{ asset('/admin/vendors/jquery/dist/jquery.min.js') }}"></script>
<!-- Bootstrap -->
{{-- <script src="{{asset('/admin/vendors/bootstrap/dist/js/bootstrap.min.js')}}"></script> --}}
<script src="{{ asset('/admin/vendors/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
<!-- FastClick -->
<script src="{{ asset('/admin/vendors/fastclick/lib/fastclick.js') }}"></script>
<!-- NProgress -->
<script src="{{ asset('/admin/vendors/nprogress/nprogress.js') }}"></script>
<!-- Chart.js -->
<script src="{{ asset('/admin/vendors/Chart.js/dist/Chart.min.js') }}"></script>
<!-- gauge.js -->
<script src="{{ asset('/admin/vendors/gauge.js/dist/gauge.min.js') }}"></script>
<!-- bootstrap-progressbar -->
<script src="{{ asset('/admin/vendors/bootstrap-progressbar/bootstrap-progressbar.min.js') }}"></script>
<!-- iCheck -->
<script src="{{ asset('/admin/vendors/iCheck/icheck.min.js') }}"></script>
<!-- Skycons -->
<script src="{{ asset('/admin/vendors/skycons/skycons.js') }}"></script>
<!-- Flot -->
<script src="{{ asset('/admin/vendors/Flot/jquery.flot.js') }}"></script>
<script src="{{ asset('/admin/vendors/Flot/jquery.flot.pie.js') }}"></script>
<script src="{{ asset('/admin/vendors/Flot/jquery.flot.time.js') }}"></script>
<script src="{{ asset('/admin/vendors/Flot/jquery.flot.stack.js') }}"></script>
<script src="{{ asset('/admin/vendors/Flot/jquery.flot.resize.js') }}"></script>
{{-- Flot plugins --}}
<script src="{{ asset('/admin/vendors/flot.orderbars/js/jquery.flot.orderBars.js') }}"></script>
<script src="{{ asset('/admin/vendors/flot-spline/js/jquery.flot.spline.min.js') }}"></script>
<script src="{{ asset('/admin/vendors/flot.curvedlines/curvedLines.js') }}"></script>
{{-- DateJS --}}
<script src="{{ asset('/admin/vendors/DateJS/build/date.js') }}"></script>
<!-- JQVMap -->
<script src="{{ asset('/admin/vendors/jqvmap/dist/jquery.vmap.js') }}"></script>
<script src="{{ asset('/admin/vendors/jqvmap/dist/maps/jquery.vmap.world.js') }}"></script>
<script src="{{ asset('/admin/vendors/jqvmap/examples/js/jquery.vmap.sampledata.js') }}"></script>
{{-- bootstrap-daterangepicker --}}
<script src="{{ asset('/admin/vendors/moment/min/moment.min.js') }}"></script>
<script src="{{ asset('/admin/vendors/bootstrap-daterangepicker/daterangepicker.js') }}"></script>

{{-- switchery --}}
<script src="{{ asset('/admin/vendors/switchery/dist/switchery.min.js') }}"></script>

<script src="{{ asset('/admin/vendors/raphael/raphael.min.js') }}"></script>
<script src="{{ asset('/admin/vendors/morris.js/morris.min.js') }}"></script>

{{-- pnotify --}}
<script src="{{ asset('/admin/vendors/pnotify/dist/pnotify.js') }}"></script>
<script src="{{ asset('/admin/vendors/pnotify/dist/pnotify.buttons.js') }}"></script>
<script src="{{ asset('/admin/vendors/pnotify/dist/pnotify.nonblock.js') }}"></script>

{{-- dataTables --}}
<script src="{{ asset('/admin/vendors/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('/admin/vendors/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>

<script src="{{ asset('/admin/vendors/jQuery-Smart-Wizard/js/jquery.smartWizard.js') }}"></script>

<!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.8.1/css/bootstrap-select.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.8.1/js/bootstrap-select.js"></script> -->

<script src="https://cloud.tinymce.com/stable/tinymce.min.js?apiKey=e8cgxme8kbsc3u65sf2y8iixj1z0mzqlejahfw9hp9yoi1to">
</script>

<script src="{{ asset('admin/chosen/chosen.jquery.min.js') }}"></script>

<script src="{{ asset('admin/vendors/mjolnic-bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js') }}">
</script>

<script src="{{ asset('vendor/laravel-filemanager/js/stand-alone-button.js') }}"></script>

<!-- Custom Theme Scripts -->
<script src="{{ asset('/admin/build/js/custom.min.js') }}"></script>
<script src="{{ asset('/admin/js/commons.js?v=1.2') }}"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>

<script>
    $(document).ready(function() {

        $('.phone').change(function(event) {
            string = $(this).val();
            $(this).parent('div').find('.phoneErr').remove();

            pattern = /([0-9]{3}\-[0-9]{3}\-[0-9]{4})/;
            if (!pattern.test(string) || string.length != 12) {
                $(this).val("");
                $(this).parent('div').append(
                    '<div style="color:red" class="phoneErr" >Enter valid mobile number<</div>');
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
                if($(this).val().length > attr){
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
                url: "{{route('admin.common.email_unique')}}",
                data: {
                    value: value,
                    dbField: dbField,
                    dbTable: dbTable,
                    _token: "{{ csrf_token() }}",
                },
                dataType: 'json',
                success: function(response) {
                    if (response>0) {
                        vm.val("");
                        vm.parent('div').append(
                            '<div style="color:red" class="emailErr" >Emial address already exist</div>'
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

        $(document).on('focusout', '.website', function () {

			var regex = /^([wW]{3})+\.(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})$/;
			var website=$(this).val();
            $(this).parent('div').find('.webErr').remove();
			if(!regex.test(website))
			{
				$(this).val("");
                $(this).parent('div').append(
                    '<div style="color:red" class="webErr" >Invalid Webiste format</div>');
			}
		})

    });
</script>

@stack('scripts')

@if (session('error'))
    <script>
        notify("{{ session('error') }}", "error");
    </script>
@endif
@if (session('success'))
    <script>
        notify("{{ session('success') }}");
    </script>
@endif
