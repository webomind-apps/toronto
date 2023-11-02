@extends('Backend.Admin.Layout.app')
<style>
    .bt1 {
        border-top: 3px solid !important;
        border-top-color: #009688 !important;
    }

    .bt2 {
        border-top: 3px solid !important;
        border-top-color: #f44336 !important;
    }

    .bt3 {
        border-top: 3px solid !important;
        border-top-color: #7b1fa2 !important;
    }

    .bt4 {
        border-top: 3px solid !important;
        border-top-color: #ff9800 !important;
    }

    .bt5 {
        border-top: 3px solid !important;
        border-top-color: #858a90 !important;
    }

    .bt6 {
        border-top: 3px solid !important;
        border-top-color: #55a2ff !important;
    }

    .mr10 {
        margin-right: 10px;
    }

    .small-bd {
        margin-bottom: 7px;
    }

    .stb a {
        font-size: 11px;
    }

    .col-xs-12 .x_panel h2,
    .col-xs-12 .x_panel h2 {
        font-size: 16px !important;
    }

</style>

@section('main')

    <div class="clearfix"></div>
    <div class="row" style="height: 700px;">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <!-- <h2>Dashboard</h2>
                                                    <div class="clearfix"></div> -->
                </div>

                <div class="x_content">

                    <div class="row">

                        <div class="col-xs-12 col-md-2">
                            <a href="{{ route('admin.business.index') }}" title="All Business">
                                <div class="x_panel bt1">
                                    <h2>All Business</h2>
                                    <p><b>{{ $allBusinesses }}</b></p>
                                </div>
                            </a>
                        </div>

                        <div class="col-xs-12 col-md-2">
                            <a href="{{ route('admin.business.index', ['status' => 'active']) }}"
                                title="Active Business">
                                <div class="x_panel bt1">
                                    <h2>Active Business</h2>
                                    <p><b>{{ $allActiveBusinesses }}</b></p>
                                </div>
                            </a>
                        </div>

                        <div class="col-xs-12 col-md-2">
                            <a href="{{ route('admin.business.index', ['status' => 'inactive']) }}"
                                title="Inactive Business">
                                <div class="x_panel bt1">
                                    <h2>Inactive Business</h2>
                                    <p><b>{{ $allInactiveBusinesses }}</b></p>
                                </div>
                            </a>
                        </div>

                        <div class="col-xs-12 col-md-2">
                            <a href="{{ route('admin.business.index', ['status' => 'expired']) }}"
                                title="Expired Business">
                                <div class="x_panel bt1">
                                    <h2>Expired Business</h2>
                                    <p><b>{{ $allExpiredBusinesses }}</b></p>
                                </div>
                            </a>
                        </div>

                        <div class="col-xs-12 col-md-2">
                            <a href="{{ route('admin.user.index') }}" title="All User">
                                <div class="x_panel bt6">
                                    <h2>Total User</h2>
                                    <p><b>{{ $allUsers }}</b></p>
                                </div>
                            </a>
                        </div>

                        <div class="col-xs-12 col-md-2">
                            <a href="{{ route('admin.user.index', ['status' => 'active']) }}" title="Active User">
                                <div class="x_panel bt1">
                                    <h2>Active User</h2>
                                    <p><b>{{ $allActiveUsers }}</b></p>
                                </div>
                            </a>
                        </div>

                        <div class="col-xs-12 col-md-3">
                            <a href="{{ route('admin.user.index', ['status' => 'inactive']) }}"
                                title="Inactive User">
                                <div class="x_panel bt5">
                                    <h2>Inactive User</h2>
                                    <p><b>{{ $allInactiveUsers }}</b></p>
                                </div>
                            </a>
                        </div>

                        <div class="col-xs-12 col-md-3">
                            <a href="{{ route('admin.business.user.index') }}" title="All User">
                                <div class="x_panel bt6">
                                    <h2>Total Business User</h2>
                                    <p><b>{{ $allBusinessUsers }}</b></p>
                                </div>
                            </a>
                        </div>

                        <div class="col-xs-12 col-md-3">
                            <a href="{{ route('admin.business.user.index', ['status' => 'active']) }}" title="Active User">
                                <div class="x_panel bt1">
                                    <h2>Active Business User</h2>
                                    <p><b>{{ $allActiveBusinessUsers }}</b></p>
                                </div>
                            </a>
                        </div>

                        <div class="col-xs-12 col-md-3">
                            <a href="{{ route('admin.business.user.index', ['status' => 'inactive']) }}"
                                title="Inactive User">
                                <div class="x_panel bt5">
                                    <h2>Inactive Business User</h2>
                                    <p><b>{{ $allInactiveBusinessUsers }}</b></p>
                                </div>
                            </a>
                        </div>

                        <div class="col-xs-12 col-md-3">
                            <a href="{{ route('admin.business.index', ['status' => 'premium']) }}"
                                title="Active Premium Pack">
                                <div class="x_panel bt5">
                                    <h2>Active Premium Pack</h2>
                                    <p><b>{{ $allActivePremiumBusinesses }}</b></p>
                                </div>
                            </a>
                        </div>

                        <div class="col-xs-12 col-md-3">
                            <a href="{{ route('admin.advertisement.index', ['status' => 'active']) }}"
                                title="Active Advertisement">
                                <div class="x_panel bt5">
                                    <h2>Active Advertisement</h2>
                                    <p><b>{{ $allActiveAdvertisement }}</b></p>
                                </div>
                            </a>
                        </div>

                        <div class="col-xs-12 col-md-3">
                            <a href="{{ route('admin.advertisement.index', ['status' => 'inactive']) }}"
                                title="Active Advertisement">
                                <div class="x_panel bt5">
                                    <h2>Inactive Advertisement</h2>
                                    <p><b>{{ $allInactiveActiveAdvertisement }}</b></p>
                                </div>
                            </a>
                        </div>

                        <div class="col-xs-12 col-md-3">
                            <a href="{{ route('admin.country.index') }}" title="All Countries">
                                <div class="x_panel bt5">
                                    <h2>Total Countries</h2>
                                    <p><b>{{ $allCounties }}</b></p>
                                </div>
                            </a>
                        </div>

                        <div class="col-xs-12 col-md-2">
                            <a href="{{ route('admin.province.index') }}" title="All Provinces">
                                <div class="x_panel bt5">
                                    <h2>Total Provinces</h2>
                                    <p><b>{{ $allProvinces }}</b></p>
                                </div>
                            </a>
                        </div>

                        <div class="col-xs-12 col-md-2">
                            <a href="{{ route('admin.city.index') }}" title="All City">
                                <div class="x_panel bt5">
                                    <h2>Total City</h2>
                                    <p><b>{{ $allCities }}</b></p>
                                </div>
                            </a>
                        </div>
                        <div class="col-xs-12 col-md-2">
                            <a href="{{ route('admin.business.index', ['status' => 'expired']) }}"
                                title="Expired Business User">
                                <div class="x_panel bt5">
                                    <h2>Expired listing</h2>
                                    <p><b>{{ $allExpiredBusinesses }}</b></p>
                                </div>
                            </a>
                        </div>
                        <div class="col-xs-12 col-md-2">
                            <a href="{{ route('admin.business.index', ['status' => 'upcomming']) }}"
                                title="Upcoming renewal Business">
                                <div class="x_panel bt5">
                                    <h2>Upcoming Renewal</h2>
                                    <p><b>{{ $upcomingRenewalBusinesses }}</b></p>
                                </div>
                            </a>
                        </div>
                        <div class="col-xs-12 col-md-2">
                            <a href="{{ route('admin.paymentMethod.index') }}"
                                title="Expired Business User">
                                <div class="x_panel bt5">
                                    <h2>Payment Mode</h2>
                                    <p><b>{{ $allPaymentMethod }}</b></p>
                                </div>
                            </a>
                        </div>
                        <div class="col-xs-12 col-md-2">
                            <a href="{{ route('admin.enquiry.index') }}"
                                title="Expired Business User">
                                <div class="x_panel bt5">
                                    <h2>Inquires</h2>
                                    <p><b>{{ $allInquires }}</b></p>
                                </div>
                            </a>
                        </div>
                        {{-- <div class="col-xs-12 col-md-2">
                            <a href="{{ route('admin_business_user_list') }}" title="All User">
                                <div class="x_panel bt6">
                                    <h2>Total User</h2>
                                    <p><b>{{ $count_all_business_users }}</b></p>
                                </div>
                            </a>

                        </div>

                        <div class="col-xs-12 col-md-2">
                            <a href="{{ route('admin_business_user_list', ['status' => 'active-user']) }}"
                                title="Active User">
                                <div class="x_panel bt1">
                                    <h2>Active User</h2>
                                    <p><b>{{ $count_active_business_users }}</b></p>
                            </a>
                        </div>

                        <div class="col-xs-12 col-md-2">
                            <a href="{{ route('admin_business_user_list', ['status' => 'inactive-user']) }}"
                                title="Inactive User">
                                <div class="x_panel bt5">
                                    <h2>Inactive User</h2>
                                    <p><b>{{ $count_inactive_business_users }}</b></p>
                            </a>
                        </div>

                        <div class="col-xs-12 col-md-2">
                            <a href="{{ route('admin_place_list', ['packStatus' => 'active-free-pack']) }}"
                                title="Active Free Pack">
                                <div class="x_panel bt5">
                                    <h2>Active Free Pack</h2>
                                    <p><b>{{ $count_active_freepack }}</b></p>
                                </div>
                            </a>
                        </div>

                        <div class="col-xs-12 col-md-2">
                            <a href="{{ route('admin_place_list', ['packStatus' => 'expired-free-pack']) }}"
                                title="Expired Free Pack">
                                <div class="x_panel bt5">
                                    <h2>Expired Free Pack</h2>
                                    <p><b>{{ $count_inactive_freepack }}</b></p>
                                </div>
                            </a>
                        </div>

                        <div class="col-xs-12 col-md-2">
                            <a href="{{ route('admin_place_list', ['packStatus' => 'active-premium-pack']) }}"
                                title="Active Premium Pack">
                                <div class="x_panel bt5">
                                    <h2>Active Premium Pack</h2>
                                    <p><b>{{ $count_active_premiumpack }}</b></p>
                                </div>
                            </a>
                        </div>

                        <div class="col-xs-12 col-md-2">
                            <a href="{{ route('admin_place_list', ['packStatus' => 'expired-premium-pack']) }}"
                                title="Expired Premium Pack">
                                <div class="x_panel bt5">
                                    <h2>Expired Premium Pack</h2>
                                    <p><b>{{ $count_inactive_premiumpack }}</b></p>
                                </div>
                            </a>
                        </div>

                        <div class="col-xs-12 col-md-2">
                            <a href="{{ route('admin.advertisement.index', ['status' => 'active']) }}"
                                title="Active Advertisement">
                                <div class="x_panel bt5">
                                    <h2>Active Advertisement</h2>
                                    <p><b>{{ $count_active_banners }}</b></p>
                                </div>
                            </a>
                        </div>

                        <div class="col-xs-12 col-md-2">
                            <a href="{{ route('admin.advertisement.index', ['status' => 'inactive']) }}"
                                title="Active Advertisement">
                                <div class="x_panel bt5">
                                    <h2>Inactive Advertisement</h2>
                                    <p><b>{{ $count_inactive_banners }}</b></p>
                                </div>
                            </a>
                        </div>

                        <div class="col-xs-12 col-md-2">
                            <a href="{{ route('admin.country.index') }}" title="All Countries">
                                <div class="x_panel bt5">
                                    <h2>All Countries</h2>
                                    <p><b>{{ $count_countries }}</b></p>
                                </div>
                            </a>
                        </div>

                        <div class="col-xs-12 col-md-2">
                            <a href="{{ route('admin_province_list') }}" title="All Province">
                                <div class="x_panel bt5">
                                    <h2>All Province</h2>
                                    <p><b>{{ $count_provinces }}</b></p>
                                </div>
                            </a>
                        </div>

                        <div class="col-xs-12 col-md-2">
                            <a href="{{ route('admin_city_list') }}" title="All Cities">
                                <div class="x_panel bt5">
                                    <h2>All Cities</h2>
                                    <p><b>{{ $count_cities }}</b></p>
                                </div>
                            </a>
                        </div>

                        <div class="col-xs-12 col-md-2">
                            <a href="{{ route('admin_review_list') }}" title="All Reviews">
                                <div class="x_panel bt5">
                                    <h2>All Reviews</h2>
                                    <p><b>{{ $count_reviews }}</b></p>
                                </div>
                            </a>
                        </div> --}}

                    </div>

                </div>

            @endsection

            @push('scripts')
                <script>
                    $(document).ready(function() {
                        $(".module-title").text("Dashboard");
                    });
                </script>
            @endpush
