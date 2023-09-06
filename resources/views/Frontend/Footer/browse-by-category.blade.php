@extends('Frontend.Layout.app')

@push('style')
    <style>
        body {
            font-family: sans-serif, system-ui !important;
        }

        .list-box {
            padding: 20px 20px 0;
            background: #f6f6f6;
            margin-bottom: 20px;
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
            padding: 20px 7px;
            margin: 0px;
            justify-content: flex-start;
            display: flex;
            flex-wrap: wrap;
        }

        .lsiting_categories li {
            width: 48.2%;
            display: inline-block;
            background: #fff;
            margin: 0 0.5% 12px;
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
                        <h2>Find by category</h2>
                        <p>Canadian business directory categories</p>
                    </div>

                    @foreach ($categories1 as $category)
                        <div class="col-lg-12 list-box">
                            <h3>
                                <a class="category_name"
                                    href="{{ route('listing.page', ['search_category' => $category->name]) }}">{{ $category->name }}</a>
                            </h3>
                            <div class="row">
                                <ul class="lsiting_categories">

                                    @foreach ($category->subCategories as $subCategory)
                                        <li>
                                            <a
                                                href="{{ route('listing.page', ['search_category' => $subCategory->name]) }}">{{ $subCategory->name }}</a>
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
