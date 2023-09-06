<div class="left_col scroll-view">
    <div class="navbar nav_title border-0">
        <a href="{{ route('user.dashboard') }}" class="site_title">
            <img class="img-fluid img-logo" style="max-width:100%;margin: 2px auto;"
                src="{{ url('admin/images/logo.jpg') }}" />
        </a>
    </div>
    <div class="clearfix"></div>
    <!-- sidebar menu -->
    <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
        <div class="menu_section">
            <ul class="nav side-menu">
                <li><a href="{{ route('user.business.index') }}"><i class="fa fa-home"></i>Business</a></li>
                {{-- <li><a href="{{ route('user.business.user.index') }}"><i class="fa fa-home"></i>Business User</a></li> --}}
                <li><a href="{{ route('user.booking.index') }}"><i class="fa fa-calendar"></i>Bookings</a></li>
                <li><a href="{{ route('user.review.index') }}"><i class="fa fa-star-half-o"></i>Reviews</a></li>
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
