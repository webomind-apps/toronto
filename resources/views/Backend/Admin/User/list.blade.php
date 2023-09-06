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
                                <th width="15%">Country</th>
                                <th width="15%">Province</th>
                                <th width="15%">City</th>
                                <th width="5%">Status</th>
                                <th width="5%">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $key => $user)

                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>
                                        <div class="nameDiv">{{ $user->fname }} {{ $user->lname }}</div>
                                    </td>
                                    <td>
                                        <div class="phoneDiv">{{ $user->phone }}</div>
                                    </td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->country->name ?? '' }}</td>
                                    <td>{{ $user->province->name ?? '' }}</td>
                                    <td>{{ $user->city->name ?? '' }}</td>
                                    <td>
                                        <form action={{ route('admin.user.status') }} method="post">
                                            @csrf
                                            @method("put")
                                            <input type="checkbox" class="js-switch" name="status"
                                                data-id="{{ $user->id }}" {{ $user->status == 1 ? 'checked' : '' }}
                                                onchange="this.form.submit();" />
                                            <input type="hidden" name="id" value={{ $user->id }} />
                                            <input type="hidden" name="status" value={{ $user->status }} />
                                        </form>
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.user.show', $user) }}"><button type="button"
                                                class="btn btn-warning btn-xs">View
                                            </button></a>
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
