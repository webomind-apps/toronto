<div class="left_col scroll-view">
    <div class="navbar nav_title border-0">
        <a href="{{ route('admin.dashboard') }}" class="site_title">
            <img class="img-fluid img-logo" style="max-width:100%;margin: 2px auto;"
                src="{{ url('admin/images/logo.jpg') }}" />
        </a>
    </div>
    <div class="clearfix"></div>
    <!-- sidebar menu -->
    <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
        <div class="menu_section">
            <ul class="nav side-menu">

                <li><a href="{{ route('admin.dashboard') }}"><i class="fa fa-home"></i>Dashboard</a></li>

                <li>
                    <a><i class="fa fa-user"></i> Manage <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                        <li><a href="{{route("admin.category.index")}}"><i class="fa fa-list"></i>Category</a></li>
                        <li><a href="{{route("admin.subCategory.index")}}"><i class="fa fa-list"></i>Sub Category</a></li>
                        <li><a href="{{route("admin.language.index")}}"><i class="fa fa-language"></i>Language</a></li>
                        <li><a href="{{route("admin.package.index")}}"><i class="fa fa-globe"></i>Package</a></li>
                        <li><a href="{{route("admin.footerContent.index")}}"><i class="fa fa-globe"></i>Footer</a></li>
                        <li><a href="{{route("admin.defaultLogo.index")}}"><i class="fa fa-globe"></i>Default Logo</a></li>
                        <li><a href="{{route("admin.advertisement.index")}}"><i class="fa fa-globe"></i>Advertisement</a></li>
                        <li><a href="{{route("admin.headerBanner.index")}}"><i class="fa fa-globe"></i>Header Banner</a></li>
                        <li><a href="{{route("admin.paymentMethod.index")}}"><i class="fa fa-globe"></i>Payment Method</a></li>

                    </ul>
                </li>

                <li>
                    <a><i class="fa fa-map-marker"></i> Location <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                        <li><a href="{{route("admin.country.index")}}"><i class="fa fa-globe"></i>Country</a></li>
                        <li><a href="{{route("admin.province.index")}}"><i class="fa fa-globe"></i>Province</a></li>
                        <li><a href="{{route("admin.city.index")}}"><i class="fa fa-globe"></i>City</a></li>
                    </ul>
                </li>
                <li><a href="{{ route('admin.business.index') }}"><i class="fa fa-home"></i>Business</a></li>
                <li><a href="{{ route('admin.user.index') }}"><i class="fa fa-users"></i>User</a></li>
                <li><a href="{{ route('admin.business.user.index') }}"><i class="fa fa-users"></i>Business User</a></li>
                <li><a href="{{ route('admin.booking.index') }}"><i class="fa fa-calendar"></i>Bookings</a></li>
                <li><a href="{{ route('admin.review.index') }}"><i class="fa fa-star-half-o"></i>Reviews</a></li>
                <li><a href="{{ route('admin.enquiry.index') }}"><i class="fa fa-newspaper-o"></i>Enquiry</a></li>

            </ul>
        </div>
    </div>
    <!-- /sidebar menu -->
</div>

@push('scripts')
    <script>
        $(document).ready(function() {

        });
    </script>
@endpush
