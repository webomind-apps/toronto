@push('style')
    <style>
        .view-btn {
            margin: 10px 0px;
        }

    </style>
@endpush
<section class="d-review mt-100">
    <div class="container">
        <div class="col-12">
            <div class="review-list">
                <ul>
                    <li>
                        <a href="javascript:void(0)" class="addFavouriteClick">
                            <i class="fa fa-heart-o"></i> Add to favourites
                        </a>
                    </li>
                    <li>
                        <a href="javascript:void(0)" class="writReviewClick reviewFormOpen" data-toggle="modal"
                            data-target="#reviewModal">
                            <i class="fa fa-star-o"></i> Write a review
                        </a>
                    </li>
                    <li>
                        <a href="javascript:void(0)">
                            <i class="fa fa-share-alt"></i> Share
                        </a>
                    </li>
                    <li>
                        <a href="javascript:void(0)">
                            <i class="fa fa-pencil-square-o"></i> Suggest an Update
                        </a>
                    </li>
                </ul>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="review-box">
                        <h3>Ratings & Reviews - {{ $business->name }}</h3>
                        <br>
                        <div class="re-box">
                                <div class="tab-content" id="myRating">
                                    <div class="tab-pane fade show active ratingStatus" id="home" role="tabpanel">
                                        <h6 class="text-center">How would you rate this business?</h6>
                                    </div>
                                </div>

                                <ul class="nav nav-tabs star-rate" id="myTab" role="tablist">
                                    <li class="nav-item">
                                        <i class="fa fa-star ratingClick ratingFill" id="star-1" data-toggle="tooltip"
                                            data-placement="bottom" title="Terrible"></i>
                                    </li>
                                    <li class="nav-item">
                                        <i class="fa fa-star ratingClick ratingFill" id="star-2" data-toggle="tooltip"
                                            data-placement="bottom" title="Poor"></i>
                                    </li>
                                    <li class="nav-item">
                                        <i class="fa fa-star ratingClick ratingFill" id="star-3" data-toggle="tooltip"
                                            data-placement="bottom" title="Average"></i>
                                    </li>
                                    <li class="nav-item">
                                        <i class="fa fa-star ratingClick ratingFill" id="star-4" data-toggle="tooltip"
                                            data-placement="bottom" title="Very good"></i>
                                    </li>
                                    <li class="nav-item">
                                        <i class="fa fa-star ratingClick ratingFill" id="star-5" data-toggle="tooltip"
                                            data-placement="bottom" title="Excellent"></i>
                                    </li>
                                </ul>

                            <div id="reviewDiv">

                                <h3>Reviews</h3>
                                @if (!$reviews->isEmpty())
                                    @foreach ($reviews as $review)

                                        <div class="row">
                                            <div class="col-md-12 row">
                                                <div class="col-md-8">
                                                    <div class="rating p-details">
                                                        <p>

                                                            @php
                                                                $score = $review->score == null ? 0 : $review->score;
                                                            @endphp

                                                            @for ($mm = 1; $mm < 6; $mm++)
                                                                @if ($mm <= $score)
                                                                    <i class="fa fa-star"></i>
                                                                @else
                                                                    <i class="fa fa-star-o"></i>
                                                                @endif
                                                            @endfor


                                                            <span>({{ $score }})</span>
                                                        </p>
                                                    </div>
                                                </div>
                                                <div class="col-md-3" style="text-align:right;padding-right:0px;">
                                                    {{ $review->created_at == null ? '' : date('F d-Y', strtotime($review->created_at)) }}
                                                </div>
                                            </div>

                                            <div class="col-md-2">

                                                @if (!empty($review->image) && file_exists(public_path('storage/' . $review->image)))
                                                    <img class="review-photo"
                                                        src="{{ asset('storage/' . $review->image . '') }}">
                                                @else
                                                    <img class="review-photo"
                                                        src="{{ asset('defaultImg/defaultImg.png') }}"
                                                        alt="{{ $business->name }}" />
                                                @endif

                                            </div>

                                            <div class="col-md-9"
                                                style="text-align:left;v-align:middle !important;">
                                                <p>
                                                    {{ $review->comment == null ? 'No Comment' : $review->comment }}
                                                </p>
                                            </div>
                                        </div>
                                        <hr />
                                    @endforeach
                                @else
                                    <h2 class="text-center">No one has rated or reviewed this business yet!</h2>
                                @endif
                            </div>

                        </div>

                    </div>

                    <div class="ot-cat">
                        <div class="col-12">
                            <div class="row">
                                <div class="col-md-1">
                                    <b>Categories</b>
                                </div>
                                <div class="col-md-10">
                                    <ul>
                                        <li>
                                            <a href="{{ route('listing.page', ['search_category' => $business->category->category->name]) }}"
                                                title="{{ $business->category->category->name }}">
                                                {{ $business->category->category->name }}
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>

<div class="modal fade review-modal" id="reviewModal" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable review-modal-dialog">
        <div class="modal-content">
            <div class="modal-header review-modal-header">
                <h5 class="modal-title review-modal-title" id="exampleModalLabel">Ratings & Reviews -Toronto Connections
                </h5>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </div>

            <form action="{{ route('business.review') }}" class="form-log form-content"
                enctype="multipart/form-data" method="POST" id="review-form">
                @csrf
                <div class="modal-body review-modal-body">

                    <p>Overall, how would you describe your experience? *</p>
                    <ul class="nav nav-tabs star-rate" id="myTab" role="tablist">
                        <li class="nav-item">
                            <i class="fa fa-star formRatingClick ratingFill" id="star1-1" data-toggle="tooltip"
                                data-placement="bottom" title="Terrible"></i>
                        </li>
                        <li class="nav-item">
                            <i class="fa fa-star formRatingClick ratingFill" id="star1-2" data-toggle="tooltip"
                                data-placement="bottom" title="Poor"></i>
                        </li>
                        <li class="nav-item">
                            <i class="fa fa-star formRatingClick ratingFill" id="star1-3" data-toggle="tooltip"
                                data-placement="bottom" title="Average"></i>
                        </li>
                        <li class="nav-item">
                            <i class="fa fa-star formRatingClick ratingFill" id="star1-4" data-toggle="tooltip"
                                data-placement="bottom" title="Very good"></i>
                        </li>
                        <li class="nav-item">
                            <i class="fa fa-star formRatingClick ratingFill" id="star1-5" data-toggle="tooltip"
                                data-placement="bottom" title="Excellent"></i>
                        </li>

                        <li class="FormRatingStatus">

                        </li>
                    </ul>

                    @if ($errors->has('score'))
                        <p style="color:red;">{{ $errors->first('score') }}</p>
                    @endif

                    <p>Anything to share? </p>
                    <div class="writeReview-step__content mb-4">
                        <textarea class="form-control jsReviewComment" name="comment" minlength="6"
                            maxlength="500" placeholder="Enter your comment..."></textarea>
                        @if ($errors->has('comment'))
                            <p style="color:red;">{{ $errors->first('comment') }}</p>
                        @endif
                    </div>

                    <div class="form-group mb-4">
                        <label class="mb-2" for="exampleFormControlFile1">Add photos <small><i>(10mb maximum,
                                    .jpg
                                    files)</i></small></label>
                        <input type="file" class="form-control-file" name="image" id="image"
                            accept=".jpeg,.jpg">
                        @if ($errors->has('image'))
                            <p style="color:red;"> {{ $errors->first('image') }}</p>
                        @endif
                    </div>

                    <div class="form-group form-check mb-4 d-none fileCheck">
                        <input type="checkbox" class="form-check-input" name="review_terms">
                        <label class="form-check-label" for="exampleCheck1">I am the owner of these photos and I accept
                            the
                            <a href="{{ route('business.review.terms.conditions') }}" target="_blank">terms &
                                conditions</a></label>
                        @if ($errors->has('review_terms'))
                            <p style="color:red;"> {{ $errors->first('review_terms') }}</p>
                        @endif

                    </div>
                    <div class="form-group mb-4 review-email">
                        <label class="mb-2" for="exampleFormControlInput1">Your Email address <span
                                class="text-dark">(will
                                not be displayed) *</span></label>
                        <input type="email" name="email" id="review_email" class="form-control email" placeholder="name@example.com"
                            required value={{ old('email') }}>

                        @if ($errors->has('email'))
                            <p style="color:red;">{{ $errors->first('email') }}</p>
                        @endif
                    </div>


                </div>
                <input type="hidden" name="score" id="score" value="">
                <input type="hidden" name="business_id" id="business_id" value="{{ $business->id }}"/>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- @if ($errors->has('comment') || $errors->has('image') || $errors->has('review_terms') || $errors->has('reviwer_email') || $errors->has('score') || session()->has('review-already-given'))
    <input type="hidden" value="error-occurred" id="review_check" />
@else
    <input type="hidden" value="" id="review_check" />
@endif --}}



@push('scripts')

@error('review-error')
<script>
    $(document).ready(function() {
        $("#reviewModal").modal("show");
    });
</script>
@enderror

    <script>
        $(document).ready(function() {

            // if ($("#review_check").val() == "error-occurred") {
            //     $("#reviewModal").modal("show");
            // }

            $("#image").change(function(e) {
                e.preventDefault();

                if ($(this).val() != '') {
                    $(".fileCheck").removeClass("d-none");
                    $(".fileCheck input").prop("required", true);
                } else {
                    $(".fileCheck").addClass("d-none");
                    $(".fileCheck input").prop("required", false);
                }

            });

            $(".addFavouriteClick").click(function(e) {
                e.preventDefault();
                jQuery.ajax({
                    type: "POST",
                    url: "{{route('business.add.favourite')}}",
                    datatype: "text",
                    data: {
                        business_id: "{{ $business->id }}",
                        _token: "{{ csrf_token() }}",
                    },
                    success: function(response) {
                        if (response == "success") {
                            alert("Favourite has been added successfully");
                        } else if (response == "not-login") {
                            $("#login").modal("show");
                        } else if (response == "not-user") {
                            alert("Please login as user");
                        } else if (response == "already-added") {
                            alert("Favourite already added");
                        }
                    },
                    error: function(xhr, ajaxOptions, thrownError) {}
                });
            });

            $(".ratingClick").mouseenter(function() {

                id = $(this).attr('id');
                level = id.split('-')[1];
                if (level == 1) {
                    review = "Terrible";
                } else if (level == 2) {
                    review = "Poor";
                } else if (level == 3) {
                    review = "Average";
                } else if (level == 4) {
                    review = "Very good";
                } else if (level == 5) {
                    review = "Excellent";
                }
                for (i = 1; i <= level; i++) {
                    $("#star-" + i).removeClass("ratingFill");
                }
                lev = parseInt(level) + 1;
                for (i = lev; i <= 5; i++) {
                    $("#star-" + i).addClass("ratingFill");
                }
                $(".ratingStatus").text(review);
            });

            $(".formRatingClick").click(function() {

                id = $(this).attr('id');
                level = id.split('-')[1];
                if (level == 1) {
                    review = "Terrible";
                } else if (level == 2) {
                    review = "Poor";
                } else if (level == 3) {
                    review = "Average";
                } else if (level == 4) {
                    review = "Very good";
                } else if (level == 5) {
                    review = "Excellent";
                }
                for (i = 1; i <= level; i++) {
                    $("#star1-" + i).removeClass("ratingFill");
                }
                lev = parseInt(level) + 1;
                for (i = lev; i <= 5; i++) {
                    $("#star1-" + i).addClass("ratingFill");
                }
                $(".FormRatingStatus").text(review);
                $("#score").val(level);
                $("#business_id").val("{{$business->id }}");
            });

            $('.ratingClick').mouseleave(function() {
                $(".ratingStatus").html("<h6>How would you rate this business?</h6>");
                for (i = 1; i <= 5; i++) {
                    $("#star-" + i).addClass("ratingFill");
                }
            });

            $('.ratingClick').click(function() {
                $("#reviewModal").modal("show");
            });

            $("#review-form").submit(function (e) {
                if($("#review_email").val() == "" || $("#score").val()=="" ){
                    alert("Please give the rating of the business!");
                    e.preventDefault();
                    return;
                }
            });

            $("#review_email").change(function (e) {
                vm  =   $(this);
                vm.parent().closest(".review-email").find(".review-email-err").remove();
                jQuery.ajax({
                    type: "get",
                    url: "{{route('review.email.unique')}}",
                    datatype: "scripts",
                    data: {
                        business_id: "{{ $business->id }}",
                        email: $(this).val(),
                        _token: "{{ csrf_token() }}",
                    },
                    success: function(response) {
                        if(response == "exist"){
                            vm.val("");
                            vm.parent().closest(".review-email").append('<div style="color:red" class="review-email-err" >Review already taken by this email address!</div>');
                        }
                    },
                    error: function(xhr, ajaxOptions, thrownError) {}
                });
            });

        });
    </script>

@endpush
