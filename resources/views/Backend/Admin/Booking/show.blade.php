@extends('Backend.Admin.Layout.app')
@push('style')

@endpush
@section('main')
    <div class="page-title">
        <div class="title_left">

        </div>
    </div>
    <div class="clearfix"></div>

    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">

                <div class="x_content">

                    <h2>Booking Details</h2>

                    <table class="table customer-table">

                        <tr>
                            <th>Name</th>
                            <td>{{ $user->fname ?? '' }} {{ $user->lname ?? '' }}</td>

                            <th>Email</th>
                            <td>{{ $user->email ?? '' }}</td>
                        </tr>

                        <tr>
                            <th>Phone</th>
                            <td>{{ $user->phone ?? '' }}</td>

                            <th>Address</th>
                            <td>{{ $user->address ?? '' }}</td>
                        </tr>

                        <tr>
                            <th>Country</th>
                            <td>{{ $user->country->name ?? '' }}</td>

                            <th>Province</th>
                            <td>{{ $user->province->name ?? '' }}</td>
                        </tr>

                        <tr>
                            <th>City</th>
                            <td>{{ $user->city->name ?? '' }}</td>

                            <th>Status</th>
                            <td>{{ $user->status == 1 ? 'Active' : 'Inactive' }}</td>
                        </tr>

                        <tr>
                            <th>Business</th>
                            <td>{{ $user->business->name ?? '' }}</td>
                        </tr>

                    </table>

                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('admin/js/page_user.js') }}"></script>
    <script>
        $(document).ready(function() {
            $(".module-title").text("Bookings");
        });
    </script>
@endpush
