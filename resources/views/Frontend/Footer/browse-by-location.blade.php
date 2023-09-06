@extends('Frontend.Layout.app')

@push('style')
    <style>
        body {
            font-family: sans-serif, system-ui !important;
        }

        .list-box {
            padding: 28px;
            background: #f6f6f6;
            margin-top: 30px;
        }

        .list-box h3,
        .list-box h3 a {
            margin-bottom: 10px;
            max-width: 75%;
            font-size: 20px;
            color: #175689;
        }

        .lsiting_categories {
            list-style: none;
            padding: 20px 7px 0;
            margin: 0px;
            justify-content: flex-start;
            display: flex;
            flex-wrap: wrap;
        }

        .lsiting_categories li {
            width: 30.2%;
            display: inline-block;
            background: #fff;
            margin: 0 1.4% 12px;
        }

        .lsiting_categories li:hover {
            background: #ededed;
        }

        .lsiting_categories li a {
            color: #000;
            padding: 10px;
            display: block;
        }

        .lsiting_categories li a:hover {
            color: #c2272d;
        }

        .lsiting_categories li a:after {
            content: '\f105';
            margin-top: 4px;
            color: #737373;
            float: right;
            font: normal normal normal 14px/1 FontAwesome;
            font-size: inherit;
            text-rendering: auto;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        @media screen and (max-width:768px) {

            .lsiting_categories li {
                width: 98%;
                display: inline-block;
                background: #fff;
                margin: 0 1% 12px;
            }
        }

        .lsiting_categories li a:after {
            content: '\f105';
            margin-top: 4px;
            color: #737373;
            float: right;
            font: normal normal normal 14px/1 FontAwesome;
            font-size: inherit;
            text-rendering: auto;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

    </style>
@endpush

@section('main')
    {{-- search bar --}}
    @include('Frontend.Layout.search-layout')

    <section class="listing_section">
        <div class="container">
            <div class="col-12">
                <div class="row">
                    <div class="search-title">
                        <h2>Find local businesses in Canada</h2>
                        <p class="mt-2">Search businesses by location:</p>
                    </div>

                    @foreach ($provinces as $province)

                        <div class="col-lg-12 list-box">
                            {{-- <h3><i class="fa fa-balance-scale"></i> --}}
                            <a
                                href="{{ route('listing.page', ['search_city' => $province->name]) }}">{{ $province->name }}</a>
                            </h3>
                            <div class="row">
                                <ul class="lsiting_categories">

                                    @foreach ($province->cities as $city)
                                        <li>
                                            <a href="{{ route('listing.page', ['search_city' => $city->name]) }}">{{ $city->name }}</a>
                                        </li>
                                    @endforeach

                                </ul>
                            </div>

                        </div>

                    @endforeach

                </div>
            </div>
        </div>
    </section>
    <!-- End Trending_ads -->

@endsection

@push('scripts')

    <script>
        $(document).ready(function() {

        });
    </script>

@endpush