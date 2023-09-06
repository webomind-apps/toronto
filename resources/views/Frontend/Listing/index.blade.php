@extends('Frontend.Layout.app')

@section('main')
    {{-- search bar --}}
    @include('Frontend.Layout.search-layout')

    {{-- result --}}
    @if (request()->listing == 'map')
        @include('Frontend.Listing.Map.map-view')
    @else
        @include('Frontend.Listing.listing-layout')
    @endif

@endsection

@push('style')
    <style>
        .section.slider.listing_page{
            overflow:hidden
        }
    </style>
@endpush


