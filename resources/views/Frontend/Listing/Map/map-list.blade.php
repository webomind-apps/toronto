
@php
    $open_row_count = 0;
    $open_now="";
@endphp

@if(!empty($business->opening_hour))
    @foreach($business->opening_hour as $open)
        @if($open['title'] == date('l'))
            @php
                $a= explode("-",$open['value']);
                $closed = "";
                $open_now = "";
                if(count($a)>1):
                    $opening_time = strtotime($a[0]);
                    $closing_time = strtotime($a[1]);
                    if($opening_time <= time() && time() < $closing_time):
                        $open_now = 'Open Now';
                    else:
                        $open_now = 'Closed Now';
                    endif;
                else:
                    $open_now = $open['value'].' Now';
                endif;
            @endphp
        @endif
    @endforeach
@endif
<div class="left-listing-item">
    {{-- heading --}}
    <div>
        <div class="marker-icon ">
            <span class="marker-no">{{ $loop->iteration }}</span>
            <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="map-marker" class="svg-inline--fa fa-map-marker fa-w-12" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><path fill="currentColor" d="M172.268 501.67C26.97 291.031 0 269.413 0 192 0 85.961 85.961 0 192 0s192 85.961 192 192c0 77.413-26.97 99.031-172.268 309.67-9.535 13.774-29.93 13.773-39.464 0z"></path></svg>
        </div>
        <h6 class=""><a class="itemName" href="{{ route('detail.page',$business->id) }}">{{$business->name}} </a></h6>
    </div>

    {{-- address --}}
    <div class="address text-truncate">
        {{$business->address}}
    </div>

    {{-- description --}}
    <div class="moreDescription">
        {!! \Illuminate\Support\Str::limit($business->description, 100, '...') !!}
    </div>

    {{-- cats --}}
    <ul class="keytags">
            <li>
                <a href="{{route('listing.page', ['category' => $business->category->category->id])}}" title="{{$business->category->category->name}}">
                    {{$business->category->category->name}}
                </a>
            </li>
    </ul>

    {{-- ratings --}}
    <div class="rating">
        @php $review=$business->avg_review == null ? 0 : round($business->avg_review); @endphp
        <p>
            @for($mm=1;$mm<6;$mm++)
                @if ($mm<=$review)
                    <i class="fa fa-star"></i>
                @else
                    <i class="fa fa-star-o"></i>
                @endif
            @endfor
            <span>({{ $review }})</span>
        </p>
        <h6>{!!$open_now!!}</h6>
    </div>

    {{-- buttons --}}
    <div class="contact-buttons mt-2">
        @if ($business->phone != null)
            <a href="tel:{{$business->phone}}" target="_blank"><i class="fa fa-phone"></i> Phone</a>
        @endif

        @if ($business->website != null)
            <a href="http://{{$business->website}}" target="_blank"><i class="fa fa-desktop"></i> Website</a>
        @endif

        @if ($business->lat != null && $business->lng != null)
            <a href="//www.google.com/maps/search/{{$business->lat}},{{$business->lng}}" target="_blank"><i class="fa fa-map-marker"></i> Directions</a>
        @endif
    </div>
</div>
