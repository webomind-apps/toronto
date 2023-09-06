@push('style')
    <style>
        .social-icon {
            font-size: 18px;
            padding: 7px;
            margin-top: 10px;
            text-align: right;
        }

        .social-icon:hover {
            background: blue;
            color: white;
        }

    </style>
@endpush

<div class="col-lg-12">
    <div class="search-results">
        <div class="result-box reverse">
            <div class="result-img p-details">
                @if (!empty($business->image) && file_exists(public_path('storage/' . $business->image)))
                    <img src="{{ asset('storage/' . $business->image) }}" class="img-fluid"
                        alt="{{ $business->name }}">
                @elseif(!empty($default_logo->image) &&
                    file_exists(public_path('storage/'.$default_logo->image)))
                    <img src="{{ asset('storage/' . $default_logo->image) }}" class="img-fluid">
                @else
                    <img class="img-fluid" src="{{ asset('defaultImg/defaultImg.png') }}"
                        alt="{{ $business->name }}" />
                @endif
            </div>
            <div class="result-desc">
                <div class="left-desc">
                    <h3>{{ $business->name }} </h3>
                    <div class="address">
                        <p><i class="fa fa-map-marker"></i>{{ $business->address }}</p>

                    </div>
                </div>
                <div class="rating p-details">
                    @php
                        $review = $business->avgReview == null ? 0 : round($business->avgReview);
                        $review_count = count($business->reviews);
                    @endphp

                    <p>
                        @for ($mm = 1; $mm < 6; $mm++)
                            @if ($mm <= $review) <i class="fa fa-star"></i>
                            @else
                                <i class="fa fa-star-o"></i>
                            @endif
                        @endfor
                        <span>({{ $review_count }})</span>
                    </p>

                    @if (!empty($business->business_day_timing_today))
                        @php
                            $closed = 'Closed Now';
                            if ($business->business_day_timing_today->time != 'Closed'):
                                if ((strtotime($business->business_day_timing_today->from_time) < time()) && (time() < strtotime($business->business_day_timing_today->to_time))):
                                        $closed = 'Open Now';
                                endif;
                            endif;
                        @endphp

                        @if (!empty($closed))
                            {{ $closed }}
                        @endif
                    @endif

                </div>
                <div class="row">
                    <div class="col-md-8 col-lg-9 col-sm-12 contact-details">
                        @if ($business->email != null)
                            <a href="mailto:{{ $business->email }}" target="_blank"> <i class="fa fa-envelope"></i>
                                Email</a>
                        @endif

                        @if ($business->phone != null)
                            <a href="tel:{{ $business->phone }}" target="_blank"><i
                                    class="fa fa-phone"></i>
                                Phone</a>
                        @endif

                        @if ($business->website != null)
                            <a href="http://{{ $business->website }}" target="_blank"><i class="fa fa-desktop"></i>
                                Website</a>
                        @endif

                        @if ($business->lat != null && $business->lng != null)
                            <a href="//www.google.com/maps/search/{{ $business->lat }},{{ $business->lng }}"
                                target="_blank"><i class="fa fa-map-marker"></i> Directions</a>
                        @endif

                        @if ($business->online_order == 'Yes' && !empty($business->online_order_link))
                            <a href="http://{{ $business->online_order_link }}" target="_blank"><i
                                    class="fa fa-desktop"></i>
                                Online order</a>
                        @endif

                    </div>
                    <div class="col-md-4 col-lg-3 col-sm-12 social-details text-right" style="padding-right:20px;">
                        @if (!empty($business->socialMedias))
                            @foreach ($business->socialMedias as $social)
                                @if ($social->name == 'Facebook')
                                    <a href="http://{{ $social->url }}" target="_blank">
                                        <i class="fa fa-facebook social-icon"></i></a>
                                @endif
                                @if ($social->name == 'Instagram')
                                    <a href="http://{{ $social->url }}" target="_blank">
                                        <i class="fa fa-instagram social-icon"></i></a>
                                @endif
                                @if ($social->name == 'Youtube')
                                    <a href="http://{{ $social->url }}" target="_blank">
                                        <i class="fa fa-youtube social-icon"></i></a>
                                @endif
                                @if ($social->name == 'Twitter')
                                    <a href="http://{{ $social->url }}" target="_blank">
                                        <i class="fa fa-twitter social-icon"></i></a>
                                @endif
                                @if ($social->name == 'Pinterest')
                                    <a href="http://{{ $social->url }}" target="_blank">
                                        <i class="fa fa-pinterest social-icon"></i></a>
                                @endif
                                @if ($social->name == 'Snapchat')
                                    <a href="http://{{ $social->url }}" target="_blank">
                                        <i class="fa fa-snapchat social-icon"></i></a>
                                @endif
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <!--end of result-box-->
    </div>
</div>

@push('scripts')
    <script>
        $(document).ready(function() {

            // $('.alert-success').fadeIn().delay(5000).fadeOut();
        });
    </script>
@endpush
