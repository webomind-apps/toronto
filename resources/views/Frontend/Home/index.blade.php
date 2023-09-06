@extends('Frontend.Layout.app')

@section('main')

  {{-- Banner --}}
    @include('Frontend.Home.banner')
  {{-- Featured Listing --}}
    @include('Frontend.Home.featured')

@endsection

@push('style')
    <link  rel="stylesheet" href="{{asset('webo/css/animate.css')}}" />
    <link rel="stylesheet" href="{{asset('webo/css/carousel.css')}}" />
    <link rel="stylesheet" href="{{asset('webo/css/carousel-theme.css')}}" />
@endpush

@push('scripts')
    <script src="{{asset('webo/js/carousel.js')}}"></script>
    <script src="{{asset('webo/js/wow.js')}}"></script>
    <script>
        new WOW({
                mobile: false,
            }).init();

            $(document).ready(function () {
                $(".search-ul").css("position","absolute")
            });
    </script>
@endpush



