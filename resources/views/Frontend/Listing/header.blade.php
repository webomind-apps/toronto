@push('style')
    <style>
        .loclanSearch {
            display: block;
        }

        .loclanSearch li {
            list-style: none;
            display: inline;
            margin: 0px 20px;
        }

        .searchField {
            border: 1px solid #dddddd;
            border-radius: 3px;
            padding: 5px 0px 15px 5px;
        }

        .form-check-input {
            margin-left: 5px !important;
            margin-right: 5px !important;
        }

        .searchActive {
            background: green;
        }

        .searchActive button {
            color: #fff !important;
        }

        .cursor {
            cursor: pointer;
        }

    </style>
@endpush

<div class="search-title">
    <h2>

        @if ($search_category)
            <b>{{ $search_category }}</b>
        @elseif ($search_city)
            <b>{{ $search_city }}</b>
        @endif

        @if ($search_city && !empty($search_category))
            in <b>{{ $search_city }}</b>
        @else
            in <b>Toronto Connection ON</b>
        @endif

    </h2>


    <span class="result-count">({{ $businesses->total() }} Result(s))</span>

    <div class="btn-group pull-right">
        <button type="button" class="btn dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
            aria-expanded="false">
            {{ ucwords($relevance) }}
        </button>
        <div class="dropdown-menu dropdown-menu-right relevance">
            <!-- <button class="dropdown-item relevanceClick" value="a" type="submit">Closest</button> -->

            <form action="{{ route('listing.page') }}" method="GET">
                <input type="hidden" name="search_category" value="{{ $search_category }}" />
                <input type="hidden" name="search_city" value="{{ $search_city }}" />
                <input type="hidden" name="relevance" value="highest rated" />
                <button class="dropdown-item relevanceClick" value="b" type="submit">Highest Rated</button>
            </form>
            <form action="{{ route('listing.page') }}" method="GET">
                <input type="hidden" name="search_category" value="{{ $search_category }}" />
                <input type="hidden" name="search_city" value="{{ $search_city }}" />
                <input type="hidden" name="relevance" value="most reviewed" />
                <button class="dropdown-item relevanceClick" value="b" type="submit">Most Reviewed</button>
            </form>
            <form action="{{ route('listing.page') }}" method="GET">
                <input type="hidden" name="search_category" value="{{ $search_category }}" />
                <input type="hidden" name="search_city" value="{{ $search_city }}" />
                <input type="hidden" name="relevance" value="alphabetical" />
                <button class="dropdown-item relevanceClick" value="b" type="submit">Alphabetical</button>
            </form>
            <form action="{{ route('listing.page') }}" method="GET">
                <input type="hidden" name="search_category" value="{{ $search_category }}" />
                <input type="hidden" name="search_city" value="{{ $search_city }}" />
                <input type="hidden" name="relevance" value="nearest" />
                <button class="dropdown-item relevanceClick" value="b" type="submit">Nearest</button>
            </form>

        </div>
    </div>
</div>
<form method="GET" action="{{ route('listing.page') }}" id="catLanSearchForm">
    <div class="sub-filters col-12">
        <div class="left-filter">
            <ul class="loclanSearch">

                <li class="searchField {{ (($searchType == "category service search")?"searchActive":"") }}" id="first-li">
                    <button type="button" class="btn dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
                        aria-expanded="false">
                        Category Service
                    </button>
                    <div class="dropdown-menu fliter-dropdown">
                        @if (!empty(!$subCategories->isEmpty()))
                            <div class="row">
                                @foreach ($subCategories as $key => $subCategory)
                                    <div class="col-md-4">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input searchCategoryService"
                                                name="searchCategoryService[]"
                                                value="{{ $subCategory->id }}" {{isChecked($subCategory->id,$categoryServiceSearchArray)}}>
                                            <label class="form-check-label"
                                                for="exampleCheck1">{{ $subCategory->name }}</label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <div class="row text-center">
                                <div class="col-md-2 cursor categorySearch">
                                    Apply
                                </div>
                            </div>
                        @else
                            <h4 class="text-center">No data found</h4>
                        @endif
                    </div>
                </li>

                <li class="searchField {{ (($searchType == "language search")?"searchActive":"") }}" id="second-li">
                    <button type="button" class="btn dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
                        aria-expanded="false">
                        Languages
                    </button>

                    <div class="dropdown-menu fliter-dropdown">
                        <!-- <p class="text-dark">Pick the area(s) you would like to see results in</p> -->
                        @if (!empty($languages))
                            <div class="row">
                                @foreach ($languages as $key => $languages)
                                    <div class="col-md-4">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input searchLanguage"
                                                name="searchLanguage[]"
                                                value="{{ $languages->id }}" {{isChecked($languages->id,$languageSearchArray)}}>
                                            <label class="form-check-label"
                                                for="exampleCheck1">{{ $languages->name }}</label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <div class="row text-right">
                                <div class="col-md-3 cursor languageSearch">
                                    Apply
                                </div>
                            </div>
                        @else
                            <h4 class="text-center">No data found</h4>
                        @endif
                    </div>
                </li>

                <li class="searchField {{ (($searchType=="most popular")?"searchActive":"") }}" id="first-li">
                    <button type="button" class="btn most_popular">
                        Most Popular
                    </button>
                </li>

                <li class="searchField {{ (($searchType=="open now")?"searchActive":"") }}" id="first-li">
                    <button type="button" class="btn open_now">
                        Open Now
                    </button>
                </li>

            </ul>
        </div>
    </div>
    <input type="hidden" value="" name="searchType" id="searchType" required />
    <input type="hidden" name="search_category" value="{{ $search_category }}" />
    <input type="hidden" name="search_city" value="{{ $search_city }}" />
</form>
<form action="{{ route('listing.page') }}" method="GET" id="most_popular_form" style="display:none;">
    <input type="hidden" name="search_category" value="{{ $search_category }}" />
    <input type="hidden" name="search_city" value="{{ $search_city }}" />
    <input type="hidden" name="searchType" value="most popular" />
</form>
<form action="{{ route('listing.page') }}" method="GET" id="open_now_form" style="display:none;">
    <input type="hidden" name="search_category" value="{{ $search_category }}" />
    <input type="hidden" name="search_city" value="{{ $search_city }}" />
    <input type="hidden" name="searchType" value="open now" />
</form>
@push('scripts')
    <script>
        $(document).ready(function() {

            $(".most_popular").click(function(e) {
                $("#most_popular_form").submit();
            });

            $(".open_now").click(function(e) {
                $("#open_now_form").submit();
            });

            $(".categorySearch").click(function() {
                $("#searchType").val("category service search");
                $("#catLanSearchForm").submit();
            });
            $(".languageSearch").click(function() {
                $("#searchType").val("language search");
                $("#catLanSearchForm").submit();
            });

            $("#first-li").click(function() {
                $(".searchLanguage").prop("checked", false);
            });
            $("#second-li").click(function() {
                $(".searchCategoryService").prop("checked", false);
            });
        });
    </script>
@endpush
