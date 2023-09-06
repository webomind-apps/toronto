@push('style')

    <style>
        .popularFooter ul{
            padding: 0!important;
            display: inline-block!important;
        }

        .aboutFooter ul{
            padding: 0!important;
        }
    </style>

@endpush

<footer class="footer_all">
    <div class="footer">
        <div class="container spacer b-t">

            <div class="footer-top d-flex justify-content-between">
                <a title="Logo" href="{{route('home.index')}}" class="footer-logo">
                    <img  class="img-fluid" src="{{asset('assets/images/assets/logo.png')}}" alt="logo">
                </a>
                <div class="footer-subscribe">
                    <div class="input-group mb-3">

                    </div>
                </div>
            </div>

            <div class="row footerContent">

            </div>

        </div>
    </div>
    <div class="bottom-bar">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <p class="mt-3 mb-3 copyright">&copy; Copyright 2021 Toronto Connection. All rights reserved </p>
                </div>
            </div>
        </div>
    </div>
</footer>

<div class="top_awro pull-right" id="back-to-top" ><i class="fa fa-chevron-up" aria-hidden="true"></i> </div>

@push('scripts')

<script>
    $(document).ready(function () {

        jQuery.ajax({
            type: "POST",
            url: "{{route('common.footer_content')}}",
            datatype: "script",
            data: {
                _token: "{{ csrf_token() }}",
            },
            success: function(response) {
                $(".footerContent").html(response);
            },
            error: function(xhr, ajaxOptions, thrownError) {}
        });

    });
</script>

@endpush


