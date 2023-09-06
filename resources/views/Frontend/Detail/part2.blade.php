@push('style')
    <style>
        .dayTd {
            width: 30% !important;
        }

        .timeTd {
            width: 35% !important;
        }

        .noTd {
            width: 15% !important;
        }

        .modal-width {
            max-width: 500px;
            margin: 0px auto;
        }

        .image-gallery.owl-theme .owl-nav [class*=owl-] span {
            height: 25px;
            display: block;
            width: 25px;
            background: #175689;
            border-radius: 50%;
            color: #fff;
            line-height: 20px;
        }

        .image-gallery.owl-theme .owl-nav.disabled {
            display: block;
        }

        .offset-lg-1-5 {
            margin-left: 12.666667%;
        }

        .payment-icon {
            font-size: 35px;
        }

        .table-striped tbody>tr:nth-child(even)>td,
        .table-striped tbody>tr:nth-child(even)>th {
            background: #fff5f5;
        }

        .payment-img {
            height: 50px;
            width: 50px;
        }

    </style>
@endpush

<div class="col-12 detail-desc">
    <div class="row">

        <div class="col-lg-9">

            <div class="details-desc">
                <h2>Details & Description</h2>
                <p>
                    {!! $business->description !!}
                </p>
            </div>

            @if ($business->business_upgrade_latest->package_id == '1' && date('Y-m-d', strtotime($business->business_upgrade_latest->expired_date)) >= date('Y-m-d'))

                <div class="other-info">
                    <div class="col-12">
                        <div class="row otherDetails">

                            @if (!empty($business->area_of_practice))
                                <div class="col-md-5">
                                    <h4>Area Of Practice</h4>
                                    {!! $business->area_of_practice !!}
                                </div>
                            @endif

                            @if (!empty($business->product_and_service))
                                <div class="col-md-5 psDiv">
                                    <h4>Products and Services</h4>
                                    {!! $business->product_and_service !!}
                                </div>
                            @endif

                            @if (!empty($business->specialization))
                                <div class="col-md-5">
                                    <h4>Specialization</h4>
                                    {!! $business->specialization !!}
                                </div>
                            @endif

                            @if (!empty($business->languages))
                                <div class="col-md-5">
                                    <h4>Languages Spoken</h4>
                                    <div class="col-md-12 languageDiv">
                                        @foreach ($business->languages as $key => $language)
                                            <span class="language-known">{{ $language->language->name }}</span>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                        </div>
                    </div>
                </div>

            @endif

            <div class="row">
                <div class="col-md-12">
                    <div class="other-info mt-4">
                        <div class="col-12">
                            <br>
                            <h2>Information</h2>
                            <div class="row">
                                <div class="col-md-5">
                                    <h4 class="mb-20">Opening Hours </h4>
                                    <table class="openHourSingleDayTable" style="display:none;">
                                        <tr>
                                            @if (!empty($business->business_day_timings))
                                                @foreach ($business->business_day_timings as $open)
                                                    @if ($open->day == date('l'))
                                                        <td class="dayTd">{{ $open->day }}
                                                        </td>
                                                        <td class="timeTd">
                                                            {{ $open->time }}</td>
                                                        <td class="noTd"><i class="fa fa-chevron-down"></i>
                                                        </td>
                                                    @endif
                                                @endforeach
                                            @endif
                                        </tr>
                                    </table>
                                    <table class="openHourAllDayTable table-striped">
                                        @if (!empty($business->business_day_timings))
                                            @foreach ($business->business_day_timings as $key => $open)
                                                @php
                                                    $background = $open->day == date('l') ? 'style=background:#efbebe' : '';
                                                @endphp
                                                <tr {{ $background }}>
                                                    <td {{ $background }} class="dayTd">{{ $open->day }}
                                                    </td>
                                                    <td {{ $background }} class="timeTd">{{ $open->time }}
                                                    </td>
                                                    <td {{ $background }} class="noTd">
                                                        @if ($key == 0)
                                                            <i class="fa fa-chevron-up"></i>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif
                                    </table>

                                    @if (!empty($business->payment_methods))
                                        <div class="col-md-12 mt-30">
                                            <h4>Payment Methods</h4>
                                            <div class="col-md-12 paymentDiv">
                                                @foreach ($business->payment_methods as $key => $pay)
                                                    @if (!empty($business->image) && file_exists(public_path('storage/' . $business->image)))
                                                        <img src="{{ asset('storage/' . $pay->PaymentMethod->image) }}"
                                                            class="payment-img" />
                                                    @endif
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif

                                </div>

                                <div class="col-md-5">
                                    <h4>Book An Appointment</h4>
                                    <form class="form-horizontal form-popup" method="POST"
                                        action="{{ route('booking.appointment') }}" enctype="multipart/form-data">
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-12 mt-10">
                                                <div class="form-group row">
                                                    <div class="col-lg-12">
                                                        <input type="text" class="form-control con" name="name"
                                                            placeholder="Name*" value="{{ old('name') }}" required>
                                                        @if ($errors->has('name'))
                                                            <p style="color:red;">{{ $errors->first('name') }}</p>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12 mt-10">
                                                <div class="form-group row">
                                                    <div class="col-lg-12">
                                                        <input type="email" class="form-control con" name="email"
                                                            placeholder="Email address*" value="{{ old('email') }}"
                                                            required>
                                                        @if ($errors->has('email'))
                                                            <p style="color:red;">{{ $errors->first('email') }}</p>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12 mt-10">
                                                <div class="form-group row">
                                                    <div class="col-lg-12">
                                                        <input type="text" class="form-control phone con" name="phone"
                                                            placeholder="Phone No. (444-444-4444)" minlength="10"
                                                            maxlength="14" value="{{ old('phone') }}" required>
                                                        @if ($errors->has('phone'))
                                                            <p style="color:red;">{{ $errors->first('phone') }}</p>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12 mt-10">
                                                <div class="form-group row">
                                                    <div class="col-lg-12">
                                                        <input type="text" class="form-control date con" name="date"
                                                            placeholder="Date*" required autocomplete="off"
                                                            value="{{ old('date') }}">
                                                        @if ($errors->has('date'))
                                                            <p style="color:red;">{{ $errors->first('date') }}</p>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-12 mt-10">
                                                <div class="form-group row">
                                                    <div class="col-lg-12">
                                                        {{-- Date:<span style="color:red">*</span> --}}
                                                        <textarea type="date" class="form-control con" rows="1"
                                                            name="message" placeholder="Comments*"
                                                            required>{{ old('message') }}</textarea>
                                                        @if ($errors->has('message'))
                                                            <p style="color:red;">{{ $errors->first('message') }}</p>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group row">
                                                <button type="submit" class="btn btn-primary pop_submit">Book
                                                    Now</button>
                                            </div>
                                        </div>
                                        <input type="hidden" name="business_id" value={{ $business->id }}>
                                        <input type="hidden" name="user_id" value={{ $business->user_id }}>
                                    </form>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="col-lg-3 details-desc">

            <div id="map-canvas" style="width:269px;height:226px;margin-bottom:15px;"></div>
            {{-- </a> --}}
            <div class="address width-400">
                <p><i class="fa fa-map-marker"></i>{{ $business->address }}</p>
            </div>
            <div class="mt-10">
                @foreach ($advertisement300s as $advertisement)
                    <a href="https://{{ $advertisement->link }}" target="_blank">
                        @if (!empty($advertisement->image) && file_exists(public_path('storage/' . $advertisement->image)))
                            <img src="{{ url('storage/' . $advertisement->image) }}" class="img-fluid my-2"
                                alt="ad banner">
                        @else
                            <img src="{{ url('defaultImg/defaultImg.png') }}" class="img-fluid my-2"
                                alt="ad banner" />
                        @endif
                    </a>
                @endforeach

                @foreach ($advertisement600s as $advertisement)
                    <a href="{{ $advertisement->link }}" target="_blank">
                        @if (!empty($advertisement->image) && file_exists(public_path('storage/' . $advertisement->image)))
                            <img src="{{ asset('storage/' . $advertisement->image) }}" class="img-fluid my-2"
                                alt="ad banner">
                        @else
                            <img src="{{ url('defaultImg/defaultImg.png') }}" class="img-fluid my-2"
                                alt="ad banner" />
                        @endif
                    </a>
                @endforeach

            </div>
        </div>
    </div>

    @if ($business->business_upgrade_latest->package_id == '1' && date('Y-m-d', strtotime($business->business_upgrade_latest->expired_date)) >= date('Y-m-d'))

        @if (!empty($business->galleries))
            <div class="col-12">
                <div class="owl-carousel owl-theme image-gallery">

                    @foreach ($business->galleries as $gallery)
                        <div class="item">

                            @if (!empty($gallery->image) && file_exists(public_path('storage/' . $gallery->image)))

                                <a href="{{ asset('storage/' . $gallery->image) }}" data-fancybox="images">
                                    <img src="{{ asset('storage/' . $gallery->image) }}"
                                        style="height:180px;width:180px;">
                                </a>
                            @else
                                <a href="{{ asset('defaultImg/defaultImg.png') }}" data-fancybox="images">
                                    <img src="{{ asset('defaultImg/defaultImg.png') }}"
                                        style="height:180px;width:180px;" />
                                </a>
                            @endif

                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    @endif


</div>

@push('scripts')
<script
src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCZuRJggt3Hg37Vrl5EeL9j9FREsD7SBo8&libraries=places&callback=initMap&v=weekly"
defer></script>


    <script>
        $(document).ready(function() {

            $(".openHourSingleDayTable").click(function() {
                $(".openHourSingleDayTable").hide();
                $(".openHourAllDayTable").show();
            });
            $(".openHourAllDayTable").click(function() {
                $(".openHourAllDayTable").hide();
                $(".openHourSingleDayTable").show();
            });

            $(".date").datepicker({
                dateFormat: 'dd-mm-yy',
                changeMonth: true,
                changeYear: true,
                minDate: 0,
            });

            $('.owl-carousel.image-gallery').owlCarousel({
                loop: true,
                rewind: true,
                margin: 10,
                nav: true,
                dots: false,
                responsive: {
                    0: {
                        items: 1
                    },
                    600: {
                        items: 3
                    },
                    1000: {
                        items: 6
                    }
                }
            });

        });

        var map = null;
        var marker;
        let business_lat = {{ $business->lat }} || null;
        let business_lng = {{ $business->lng }} || null;
        let title = "{{ $business->name }}";

        function initMap() {
            setTimeout(() => {
                const map = new google.maps.Map(document.getElementById("map-canvas"), {
                    zoom: 10,
                    center: {
                        lat: parseFloat(business_lat),
                        lng: parseFloat(business_lng)
                    },
                });
                if (business_lat != null || business_lng != null) {
                    setMarkers(map);
                }

            }, 2000);

        }

        function setMarkers(map) {
            new google.maps.Marker({
                position: {
                    lat: parseFloat(business_lat),
                    lng: parseFloat(business_lng)
                },
                map,
                animation: google.maps.Animation.DROP,
                title: title,
            });
        }
    </script>

@endpush
