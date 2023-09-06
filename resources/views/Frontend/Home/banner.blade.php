@push('style')
<style>
/* .slider {
} */
</style>
@endpush

<div class="banner-slider">
      <div class="owl-carousel owl-theme carousel-fade">
      @foreach($banners as $key=>$banner)
            @if(!empty($banner->image) && file_exists(public_path('storage/'.$banner->image)))
            <div class="item"><img src="{{ asset('storage/'.$banner->image) }}" class="d-block w-100" alt="..."></div>
            @else
            <div class="item"><img class="d-block w-100" src="{{url('defaultImg/defaultImg.png')}}" alt="..." /></div>
            @endif
      @endforeach
      </div>
</div>
<section class="slider">
    <div class="carousel-item active">
        <div class="slide-text">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        @include('Frontend.Layout.search-bar')
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@push('scripts')
<script>

$(document).ready(function() {

    $('.carousel-fade').owlCarousel({
        loop:true,
        margin:0,
        nav:false,
        animateOut: 'fadeOut',
        autoplay:true,
        autoplayTimeout:5000,
        autoplayHoverPause:false,
        responsive:{
            0:{
                items:1
            },
            600:{
                items:1
            },
            1000:{
                items:1
            }
        }
    });
});
</script>
@endpush
