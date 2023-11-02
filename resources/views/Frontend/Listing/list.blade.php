@push('style')
    <style>
        .itemName:hover {
            text-decoration: underline;
        }

    </style>
@endpush
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<div class="row text-right pagination-show" style="margin-left:3px;">
    {!! $businesses->appends(request()->input())->links() !!}
</div>

@php
$open_row_count = 0;
$open_now = '';
@endphp
@foreach ($businesses as $business)
    @include('Frontend.Listing.listing-details')
@endforeach

<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-width" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalLabel">Book An Appointment</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="form-horizontal form-popup" method="POST" action="{{ route('booking.appointment') }}"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-10 offset-lg-1 mt-10">
                            <div class="form-group row">
                                <div class="col-lg-12">
                                    <input type="text" class="form-control con name" name="name" placeholder="Name*"
                                        required value="{{ old('name') }}">
                                    @if ($errors->has('lname'))
                                        <p style="color:red;">{{ $errors->first('lname') }}</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-md-10 offset-lg-1 mt-10">
                            <div class="form-group row">
                                <div class="col-lg-12">
                                    <input type="text" class="form-control con email" name="email"
                                        placeholder="Email address*" required value="{{ old('email') }}">
                                    @if ($errors->has('email'))
                                        <p style="color:red;">{{ $errors->first('email') }}</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-md-10 offset-lg-1 mt-10">
                            <div class="form-group row">
                                <div class="col-lg-12">
                                    <input type="text" class="form-control phone con" name="phone"
                                        placeholder="Phone No. (444-444-4444)" minlength="10" maxlength="14"
                                        value="{{ old('phone') }}" required>
                                    @if ($errors->has('phone'))
                                        <p style="color:red;">{{ $errors->first('phone') }}</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-md-10 offset-lg-1 mt-10">
                            <div class="form-group row">
                                <div class="col-lg-12">
                                    <input type="text" class="form-control date con" name="date" placeholder="Date*"
                                        required autocomplete="off" value="{{ old('date') }}">
                                    @if ($errors->has('date'))
                                        <p style="color:red;">{{ $errors->first('date') }}</p>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="col-md-10 offset-lg-1 mt-10">
                            <div class="form-group row">
                                <div class="col-lg-12">
                                    <textarea type="date" class="form-control con" rows="4" name="message"
                                        placeholder="Comments*" required>{{ old('message') }}</textarea>
                                    @if ($errors->has('message'))
                                        <p style="color:red;">{{ $errors->first('message') }}</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 offset-lg-7 mt-10">
                        <div class="form-group row">
                            <button type="submit" class="btn btn-primary pop_submit">Book Now</button>
                        </div>
                    </div>
                    <input type="hidden" name="business_id" id="modal_business_id" value="">
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        $(document).ready(function() {

            $(".bookingClick").click(function (e) {
                e.preventDefault();
                $("#modal_business_id").val($(this).attr("data-id"));
            });

            $(".date").datepicker({
                dateFormat: 'dd-mm-yy',
                changeMonth: true,
                changeYear: true,
                minDate: 0,
            });

            $(".desReadMore").click(function() {
                $(this).parents('.left-desc').find('.lessDescription').css("display", "block");
                $(this).parents('.left-desc').find('.moreDescription').css("display", "none");
                $(this).parents('.left-desc').find('.lessDescription').focus();
            });
            $(".desReadLess").click(function() {
                $(this).parents('.left-desc').find('.lessDescription').css("display", "none");
                $(this).parents('.left-desc').find('.moreDescription').css("display", "block");
                $(this).parents('.left-desc').find('.moreDescription').focus();
            });
        });
    </script>
@endpush
