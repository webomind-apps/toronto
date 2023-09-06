@extends('Frontend.Layout.app')

@section('main')
{{-- search bar --}}
@include('Frontend.Layout.search-layout')

<section class="listing_section details_page">
    <div class="container">
        <div class="col-12">
            <div class="row">
            @include('Frontend.Detail.part1')
            @include('Frontend.Detail.part2')
            </div>
        </div>
    </div>
</section>
@include('Frontend.Detail.part3')
@endsection


