@if(!$businesses->isEmpty())
    <section class="featured_ads">
        <div class="container">
            <!-- Row  -->
            <div class="row justify-content-center">
                <div class="col-md-7 text-center">
                    <h2 class="title">Featured Listings</h2>
                </div>
            </div>
            <!-- Row  -->
            <div class="featured-list">
                <div class="owl-carousel owl-theme listing">
                    <div class="item">
                        <div class="col-12">
                            <div class="row">
                                @php
                                    $i = 1;
                                @endphp
                                @forelse ($businesses as $business)
                                    @php
                                    if ($i == 9) {
                                        $i = 1;
                                        echo '</div></div></div>';
                                        echo ' <div class="item">
                                                    <div class="col-12">
                                                        <div class="row">';
                                    }
                                    @endphp
                                    <div class="featured-parts rounded m-t-30">
                                        <div class="featured-img">
                                            <a href="{{ route('detail.page',$business->id) }}" title="{{ $business->name }}">
                                                @if (!empty($business->image) && file_exists(public_path('storage/' . $business->image)))
                                                    <img class="img-fluid rounded-top"
                                                        src="{{ asset('storage/'.$business->image) }}" alt="{{ $business->name }}">
                                                @elseif(!empty($default_logo->image) &&
                                                    file_exists(public_path('storage/'.$default_logo->image)))
                                                    <img src="{{ asset('storage/'.$default_logo->image) }}"
                                                        class="img-fluid rounded-top" alt="{{ $business->name }}">
                                                @else
                                                    <img src="{{ asset('defaultImg/defaultImg.png') }}"
                                                        class="img-fluid rounded-top" alt="{{ $business->name  }}" />
                                                @endif
                                            </a>
                                            <div class="featured-new"> <a href="#"> Featured </a> </div>
                                        </div>
                                        <div class="featured-text">
                                            <div class="text-top d-flex justify-content-between">
                                                <div class="heading">
                                                    <a href="{{ route('detail.page',$business->id) }}"
                                                        title="{{ $business->name }}">
                                                        {{ $business->name }}
                                                    </a>
                                                </div>
                                                <div class="book-mark">
                                                    <a href="#"
                                                        class="@if($business->wish_list_count) remove_wishlist active @else @guest open-login @else add_wishlist @endguest @endif"
                                                        data-id="{{$business->id}}">
                                                        <i class="fa fa-bookmark"></i>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="text-stars m-t-5">
                                                <p><a
                                                        href="{{ route('listing.page', ['search_category' => $business->category->category->name]) }}">{{ $business->category->category->name }}</a>
                                                </p>

                                                <div class="place-preview">
                                                    <div class="place-rating pull-left mr-2">
                                                        @for ($mm = 1; $mm < 6; $mm++)
                                                            @if ($mm <= $business->avgReview)
                                                                <i class="fa fa-star"></i>
                                                            @else
                                                                <i class="fa fa-star-o"></i>
                                                            @endif

                                                        @endfor
                                                    </div>
                                                    <span class="count-reviews">({{ $business->reviews_count ?? 0 }}
                                                        {{ __('reviews') }})</span>
                                                </div>
                                            </div>


                                            <div class="featured-bottum">
                                                <ul class="d-flex justify-content-between list-unstyled m-b-20">
                                                    <li>
                                                        <a
                                                            href="{{ route('listing.page', ['search_city' => $business->city->name]) }}"><i
                                                                class="fa fa-map-marker"></i>

                                                            {{ $business->city->name }}
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    @php
                                    $i++;
                                    @endphp
                                @empty
                                <h2 class="text-center">No feature listing found</h2>
                            @endforelse
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </section>
@endif
