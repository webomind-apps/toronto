@extends('Frontend.Layout.app')

@push('style')
    <style>
        .book-btn {
            margin: auto;
            width: 78%;
        }

    </style>
@endpush

@section('main')
    {{-- search bar --}}

    @include('Frontend.Layout.search-layout')

    <section class="package_page account mb-5" style="margin-top:300px;">
        <div class="container">
            <div class="row">
                @include('Frontend.BusinessUser.Dashboard.menu')

                <div class="col-md-9 bg-lg-grey">
                    <h3>Wishlist</h3>

                    <div class="col-12">
                        @foreach ($businesses as $business)
                            <div class="result-box">
                                <div class="result-img">
                                    @if (!empty($business->image) && file_exists(public_path('storage/' . $business->image)))
                                        <img src="{{ url('storage/' . $business->image) }}" class="img-fluid"
                                            alt="{{ $business->name }}">
                                    @elseif(!empty($default_logo->image) &&
                                        file_exists(public_path('storage/'.$default_logo->image)))
                                        <img src="{{ url('storage/' . $default_logo->image) }}" class="img-fluid">
                                    @else
                                        <img class="img-fluid" src="{{ url('defaultImg/defaultImg.png') }}"
                                            alt="{{ $business->name }}" />
                                    @endif
                                </div>
                                <div class="result-desc">
                                    <div class="left-desc">
                                        <h3><a class="itemName"
                                                href="{{ route('detail.page',$business->id) }}">{{ $business->name }}
                                            </a>
                                        </h3>
                                        <div class="address">
                                            <p style="width:65%;"><i class="fa fa-map-marker"></i>{{ $business->address }}
                                            </p>
                                        </div>

                                        <div class="moreDescription">
                                            <p style="line-height:20px !important;font-size:14px;">
                                                {!! \Illuminate\Support\Str::limit($business->description, 100, '...') !!}

                                                @if (strlen($business->description) > 100)
                                                    <a href="#" onClick="return false;" class="desReadMore">Read more</a>
                                            </p>
                        @endif

                    </div>
                    <div class="lessDescription" style="display:none;">
                        <p style="line-height:20px !important;font-size:14px;">{{ $business->description }} <a href="#"
                                onClick="return false;" class="desReadLess">Read less</a></p>
                    </div>
                    <ul class="keytags">
                        <a href="{{ route('listing.page', ['category' => $business->category->id]) }}"
                            title="{{ $business->category->name }}">
                            <li>{{ $business->category->name }}</li>
                        </a>
                    </ul>

                </div>

                <div class="rating">
                    <p><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i
                            class="fa fa-star"></i><i class="fa fa-star-half"></i>
                        <span>({{ $business->avg_review == null ? 0 : round($business->avg_review, 1) }})</span>
                    </p>
                    @if (!empty($business->business_day_timing_today))
                        @php
                            $closed = 'Closed Now';
                            if ($business->business_day_timing_today->time != 'Closed'):
                                if (strtotime($business->business_day_timing_today->from_time) <= time() && time() < strtotime($business->business_day_timing_today->to_time)):
                                    $closed = 'Open Now';
                                endif;
                            endif;
                        @endphp

                        @if (!empty($closed))
                            {{ $closed }}
                        @endif
                    @endif
                </div>

                <div class="contact-details">
                    @if ($business->email != null)
                        <a href="mailto:{{ $business->email }}" target="_blank"> <i class="fa fa-envelope"></i> Email</a>
                    @endif

                    @if ($business->phone_number != null)
                        <a href="tel:{{ $business->phone_number }}" target="_blank"><i class="fa fa-phone"></i>
                            Phone</a>
                    @endif

                    @if ($business->website != null)
                        <a href="http://{{ $business->website }}" target="_blank"><i class="fa fa-desktop"></i>
                            Website</a>
                    @endif

                    <a href="" id="" data-id="{{ $business->id }}"
                        class="btn btn-labeled btn-primary mb-10 mt-10 bookingClick" data-toggle="modal"
                        data-target="#modal"><i class="fa fa-clock-o"></i> Appointment</a>
                </div>
            </div>
        </div>
        @endforeach
        </div>
        <div class="row" class="text-right" style="margin-left:3px;">
            {!! $businesses->appends(request()->input())->links() !!}
        </div>
        </div>

        </div>
        </div>

    </section>

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
                    <form class="form-horizontal form-popup" method="POST" action="{{route('booking.appointment')}}"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-10 offset-lg-1 mt-10">
                                <div class="form-group row">
                                    <div class="col-lg-12">
                                        <input type="text" class="form-control con name" name="name" placeholder="Name*"
                                            required value="{{old("name")}}">
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
                                            placeholder="Email address*" required value="{{old("email")}}">
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
                                            placeholder="Phone No. (444-444-4444)" minlength="10" maxlength="14" value="{{old("phone")}}" required>
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
                                        required autocomplete="off" value="{{old("date")}}">
                                        @if ($errors->has('date'))
                                        <p style="color:red;">{{ $errors->first('date') }}</p>
                                    @endif
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-10 offset-lg-1 mt-10">
                                <div class="form-group row">
                                    <div class="col-lg-12">
                                        <textarea type="date" class="form-control con" rows="4" name="message" placeholder="Comments*"
                                            required>{{old("message")}}</textarea>
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

    {{-- Ad --}}
    {{-- @include('frontend.webo.home.ad') --}}
@endsection


@push('scripts')
    <script>
        $(document).ready(function() {

            $(".date").datepicker({
                dateFormat: 'dd-mm-yy',
                changeMonth: true,
                changeYear: true,
                minDate: 0,
            });

            $(".bookingClick").click(function(e) {
                e.preventDefault();
                $("#modal_business_id").val($(this).attr("data-id"));
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
