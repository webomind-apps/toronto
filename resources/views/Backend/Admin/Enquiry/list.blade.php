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
                                <th width="15%">Phone No</th>
                                <th width="15%">Email</th>
                                <th >Message</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($enquiries as $key => $enquiry)

                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>
                                        <div class="nameDiv">{{ $enquiry->fname }} {{ $enquiry->lname }}</div>
                                    </td>
                                    <td>
                                        <div class="phoneDiv">{{ $enquiry->phone }}</div>
                                    </td>
                                    <td>{{ $enquiry->email }}</td>
                                    <td>{{ $enquiry->message }}</td>

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
