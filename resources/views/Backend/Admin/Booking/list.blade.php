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
                <div class="x_title">
                    <div class="clearfix"></div>
                </div>

                <div class="x_content">

                    <table class="table table-striped table-bordered golo-datatable">
                        <thead>
                            <tr>
                                <th width="3%">ID</th>
                                <th width="15%">Name</th>
                                <th width="15%">Business</th>
                                <th width="15%">Phone No</th>
                                <th width="15%">Email</th>
                                <th width="15%">Booking at</th>
                                <th width="5%">Status</th>
                                <th width="5%">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($bookings as $key => $booking)
                                @php
                                    if ($booking->status == 1) {
                                        $status = 'Approved';

                                        $status_value1 = 0;
                                        $status_value2 = 2;

                                        $status_class1 = 'btn-info';
                                        $status_class2 = 'btn-danger';

                                        $statis_label1 = 'Pending';
                                        $statis_label2 = 'Cancel';
                                    } elseif ($booking->status == 2) {
                                        $status = 'Cancelled';

                                        $status_value1 = 0;
                                        $status_value2 = 1;

                                        $status_class1 = 'btn-info';
                                        $status_class2 = 'btn-success';

                                        $statis_label1 = 'Pending';
                                        $statis_label2 = 'Approve';
                                    } else {
                                        $status = 'Pending';

                                        $status_value1 = 1;
                                        $status_value2 = 2;

                                        $status_class1 = 'btn-success';
                                        $status_class2 = 'btn-danger';

                                        $statis_label1 = 'Approve';
                                        $statis_label2 = 'Cancel';
                                    }
                                @endphp
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $booking->name }}</td>
                                    <td>{{ $booking->business->name }}</td>
                                    <td>
                                        <div class="phoneDiv">{{ $booking->phone }}</div>
                                    </td>
                                    <td>{{ $booking->email }}</td>
                                    <td>{{ $booking->created_at }}</td>
                                    <td>{{ $status }}</td>
                                    <td class="golo-flex">

                                        <form action={{ route('admin.booking.status',$booking) }} method="post">
                                            @csrf
                                            @method("put")
                                            <input type="hidden" name="id" value={{ $booking->id }} />
                                            <input type="hidden" name="status" value="{{ $status_value1 }}" />
                                            <button type="submit"
                                                class="btn {{ $status_class1 }} btn-xs">{{ $statis_label1 }}</button>
                                        </form>

                                        <form action={{ route('admin.booking.status',$booking) }} method="post">
                                            @csrf
                                            @method("put")
                                            <input type="hidden" name="id" value={{ $booking->id }} />
                                            <input type="hidden" name="status" value="{{ $status_value2 }}" />
                                            <button type="submit"
                                                class="btn {{ $status_class2 }} btn-xs">{{ $statis_label2 }}</button>
                                        </form>

                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $(".module-title").text("User");
            $(".x_panel").css("width", "auto");
        });
    </script>
@endpush
