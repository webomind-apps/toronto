<style>
    .slide-text .owl-stage-outer {
        width: 906px;
    }

    .search-ul {
        background: #fff;
        list-style: none;
        text-align: left;
        position: fixed;
        width: 326px;
        height: 200px;
        overflow-y: scroll;
        overflow-x: scroll;
        display: none;
        z-index: 10;
    }

    .search-ul,
    .search-ul li {
        /* padding-left:0.7% !important; */
        font-size: 15px !important;
        /* padding-top:0.5% !important; */
        /* padding-bottom:0.5% !important; */
        padding: 10px;
    }

    .search-ul>li:nth-child(even) {
        background: #fff5f5;
    }

</style>

<div class="wow fadeIn top__element" data-wow-delay="0.4s">
    <form class="book-now-home" method="GET" action="{{ route('listing.page') }}">
        <div class="form-group">
            <input name="search_category" id="search_category"
                class="form-control text-truncate site-banner__search__input open-suggestion" placeholder="Category"
                autoComplete="off">
            <ul id="catagory-list" class="search-ul">

            </ul>
        </div>
        <div class="form-group selectdiv">

            <input name="search_city" id="search_city"
                class="form-control text-truncate site-banner__search__input open-suggestion" placeholder="Where"
                autocomplete="off" style="border-right: none;">
            <ul id="city-list" class="search-ul">

            </ul>
        </div>
        <button type="submit" class="btn btn-primary booknow btn-skin">Search Now</button>
    </form>
</div>

<div class="col-10 offset-1">
    <div class="owl-carousel owl-theme listing-banner">

        @php
            $i = 5;
        @endphp
        @foreach ($categories as $k => $category)
            @if ($i % 5 == 0)
                <ul class="services item">
            @endif
            <li class="item" style="">
                <h4>
                    <a href="{{ route('listing.page', ['search_category' => $category->name]) }}"
                        title="{{ $category->name }}">
                        {{ $category->name }}
                    </a>
                </h4>
            </li>
            @if ($i % 5 == 4)
                </ul>
            @endif
            @php
                $i++;
            @endphp
        @endforeach
    </div>
</div>
@push('scripts')
    <script>
        $(document).ready(function() {

            var owl = $('.listing-banner');
            owl.owlCarousel({
                items: 1,
                loop: true,
                nav: true,
                dots: false,
                margin: 10,
                rtl: false,
                autoplay: false,
                //        slideTransition: 'linear',
                autoplayTimeout: 5000,
                //        autoplaySpeed: 3000,
                autoplayHoverPause: false,
                navText: [
                    "<i class='fa fa-angle-left'></i>",
                    "<i class='fa fa-angle-right'></i>"
                ],
                responsive: {
                    0: {
                        items: 1,
                        autoplay: false,
                    },
                    500: {
                        items: 1,
                        slideBy: 1,
                        autoplay: false,
                    },
                    991: {
                        items: 1,
                        slideBy: 1,
                        loop: true,
                        autoplay: false,
                    },
                    1200: {
                        items: 1,
                        slideBy: 1,
                        loop: true,

                    },
                }

            });

            $("#search_category").keyup(function (e) {
                $("#catagory-list").css("cursor","pointer");
                $("#catagory-list").css("display","none");
                if($(this).val() != ""){
                    $("#catagory-list").css("display","block");
                }
                home_category_search_collection();
            });

            $("#search_category").click(function () {
                $("#category-list").css("cursor","pointer");
                $("#category-list").css("display","none");
                $("#city-list").css("display","none");
                if($(this).val() != ""){
                    $("#category-list").css("display","block");
                }
            });

            $(document).on("click",".catagory-list-li",function(){
                $("#search_category").val($(this).text());
                $("#category-list").css("display","none");
            });

            $("#search_city").keyup(function (e) {
                $("#city-list").css("cursor","pointer");
                $("#city-list").css("display","none");
                if($(this).val() != ""){
                    $("#city-list").css("display","block");
                }
                home_city_search_collection();
            });

            $("#search_city").click(function () {
                $("#city-list").css("cursor","pointer");
                $("#city-list").css("display","none");
                $("#catagory-list").css("display","none");
                if($(this).val() != ""){
                    $("#city-list").css("display","block");
                }
            });

            $(document).on("click",".city-list-li",function(){
                $("#search_city").val($(this).text());
                $("#city-list").css("display","none");
            });


            $("html").click(function (e) {
                if (!$(event.target).closest('form').length) {
                    $("#catagory-list").css("display","none");
                    $("#city-list").css("display","none");
                }
            });

        });

        function home_category_search_collection()
        {
            $.ajax({
                    type: "POST",
                    url: "{{ route('common.search.category.collection') }}",
                    data: {
                        _token: "{{ csrf_token() }}",
                        search: $("#search_category").val(),
                    },
                    dataType: 'script',
                    success: function(response) {

                        if(response !=""){
                            $("#catagory-list").html(response);

                            $("#catagory-list li").addClass("catagory-list-li");
                        }else{
                            $("#catagory-list").css("display","none");
                        }
                    },
                    error: function(jqXHR) {
                        response = $.parseJSON(jqXHR.responseText);
                        if (response.message) {
                            alert(response.message);
                        }
                    }
                });
        }

        function home_city_search_collection()
        {
            $.ajax({
                    type: "POST",
                    url: "{{ route('common.search.city.collection') }}",
                    data: {
                        _token: "{{ csrf_token() }}",
                        search: $("#search_city").val(),
                    },
                    dataType: 'script',
                    success: function(response) {

                        if(response !=""){
                            $("#city-list").html(response);

                            $("#city-list li").addClass("city-list-li");
                        }else{
                            $("#city-list").css("display","none");
                        }
                    },
                    error: function(jqXHR) {
                        response = $.parseJSON(jqXHR.responseText);
                        if (response.message) {
                            alert(response.message);
                        }
                    }
                });
        }
    </script>
@endpush
