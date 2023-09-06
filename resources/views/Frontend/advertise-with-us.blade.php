@extends('Frontend.Layout.app')

@push('style')
    <style>
        .pack-signup a {
            margin: 10px !important;
        }

        .container {
            max-width: 1250px;
        }

    </style>
@endpush

@section('main')
    {{-- search bar --}}
    @include('Frontend.Layout.search-layout')

    <div class="container package-container">
        <div class="tab-pane" id="step2">
            <h2 class="text-center">Packages details</h2>
            <div class="row">

                <div class="col-md-3 p-2">
                    <div class="pack-box">
                        <div class="pack-title blue-1 text-center">
                            <h4>Free Listing</h4>
                            <span class="price">$0.00</span>
                        </div>
                        <ul class="pack-options">
                            <li>Business Name</li>
                            <li>Website URL</li>
                            <li>Telephone</li>
                            <li>Fax</li>
                            <li>Email</li>
                            <li>Province</li>
                            <li>City</li>
                            <li>Category</li>
                            <li>Sub Category</li>
                            <li>Business Address </li>
                            <li>Business Description</li>
                            <li>Business Hours</li>
                            <li>Map Location</li>
                            <li>Add Reviews</li>
                        </ul>

                    </div>
                </div>

                <div class="col-md-3 p-2">
                    <div class="pack-box">
                        <div class="pack-title text-center">
                            <h4>Premium Listing</h4>
                            <span class="price">${{ $package->price ?? 99 }}</span>
                        </div>
                        <ul class="pack-options">
                            <li>Business Name</li>
                            <li>Business Logo</li>
                            <li>Website URL</li>
                            <li>Telephone</li>
                            <li>Fax</li>
                            <li>Email</li>
                            <li>Business Address</li>
                            <li>Business Description</li>
                            <li>Category</li>
                            <li>Sub Category</li>
                            <li>Areas of Practice</li>
                            <li>Products and Services</li>
                            <li>Languages</li>
                            <li>Business Hours</li>
                            <li>Social Media Links</li>
                            <li>Gallery</li>
                            <li>Payment Methods</li>
                            <li>Video Link</li>
                            <li>Map Location</li>
                            <li>Add Reviews</li>
                        </ul>

                    </div>
                </div>

                <div class="col-md-3 p-2">

                    <div class="pack-box">

                        <div class="pack-title text-center">
                            <h4>Banner</h4>
                            <h4>Advertising</h4>
                            <span class="price"></span>
                        </div>

                        <img src="{{ asset('webo/images/300/300x300_5.jpg') }}" class="register-banner-img"
                            style="margin-bottom: 15px;" />

                        <img src="{{ asset('webo/images/300/300x600_5.jpg') }}" class="register-banner-img" />

                    </div>

                </div>

                <div class="col-md-3 p-2">

                    <div class="pack-box">

                        <div class="pack-title text-center">
                            <h4>Feature listing</h4>
                            <h4>Advertising</h4>
                            <span class="price"></span>
                        </div>

                        <img src="{{ asset('webo/images/300/featured_banner.png') }}" class="" />

                    </div>

                </div>

            </div>

            <div class="register" style="text-align: center;">
                <a href="{{ route('registration.step1') }}" class="btn btn-success">Register Now</a>
            </div>
        </div>
    </div>

@endsection
