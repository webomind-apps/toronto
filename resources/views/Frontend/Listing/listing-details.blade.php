<div class="result-box">
    <div class="result-img">
        <a class="itemName" href="{{ route('detail.page',$business->id) }}">
            @if(!empty($business->image) && file_exists(public_path('storage/'.$business->image)))
            <img src="{{asset('storage/'.$business->image)}}" class="img-fluid" alt="{{$business->name}}">
            @elseif(!empty($default_logo->image) && file_exists(public_path('storage/'.$default_logo->image)))
            <img src="{{asset('storage/'.$default_logo->image)}}" class="img-fluid">
            @else
            <img class="img-fluid" src="{{asset('defaultImg/defaultImg.png')}}" alt="{{$business->name}}" />
            @endif
        </a>
    </div>

    <div class="result-desc">

        <div class="left-desc">
            <h3><a class="itemName" href="{{ route('detail.page',$business->id) }}">{{$business->name}} </a></h3>
            <div class="address">
                <p style="width:75%;display:block;">
                    <div class="marker-icon">
                        <span class="marker-no">{{ $loop->iteration }}</span>
                        <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="map-marker" class="svg-inline--fa fa-map-marker fa-w-12" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><path fill="currentColor" d="M172.268 501.67C26.97 291.031 0 269.413 0 192 0 85.961 85.961 0 192 0s192 85.961 192 192c0 77.413-26.97 99.031-172.268 309.67-9.535 13.774-29.93 13.773-39.464 0z"></path></svg>
                    </div>
                    {{$business->address}}
                </p>
            </div>

            <div class="moreDescription">
                <p style="line-height:24px !important;font-size:16px;">
                    {!! \Illuminate\Support\Str::limit($business->description, 100, '...') !!}
                    @if(strlen($business->description) > 100)
                        <a  href="#" onClick="return false;" class="desReadMore">Read more</a></p>
                    @endif

            </div>
            <div class="lessDescription" style="display:none;">
                <p style="line-height:24px !important;font-size:16px;">{!! $business->description !!} <a href="#"
                        onClick="return false;" class="desReadLess">Read less</a></p>
            </div>
            <ul class="keytags">
                <a href="{{route('listing.page', ['search_category' => $business->category->category->name])}}" title="{{$business->category->category->name}}">
                    <li>{{$business->category->category->name}}</li>
                </a>
            </ul>
        </div>

        <div class="rating">

        @php
            $review=$business->avg_review == null ? 0 : round($business->avg_review);
            $review_count= ($business->reviews_count) ? round($business->reviews_count) : 0;
        @endphp

            <p>
            @for($mm=1;$mm<6;$mm++)
                @if ($mm<=$review)
                    <i class="fa fa-star"></i>
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

        <div class="contact-details">
            @if ($business->email != null)
            <a href="mailto:{{$business->email}}" target="_blank"> <i class="fa fa-envelope"></i> Email</a>
            @endif

            @if ($business->phone_number != null)
            <a href="tel:{{$business->phone_number}}" target="_blank"><i class="fa fa-phone"></i> Phone</a>
            @endif

            @if ($business->website != null)
            <a href="http://{{$business->website}}" target="_blank"><i class="fa fa-desktop"></i> Website</a>
            @endif

            @if ($business->lat != null && $business->lng != null)
            <a href="//www.google.com/maps/search/{{$business->lat}},{{$business->lng}}" target="_blank"><i
                    class="fa fa-map-marker"></i> Directions</a>
            @endif
            <a href="javascript:void(0)" data-id="{{$business->id}}" class="btn btn-labeled btn-primary mb-10 mt-10 bookingClick" data-toggle="modal"
                data-target="#modal"><i class="fa fa-clock-o"></i> Appointment</a>
        </div>
    </div>
</div>
