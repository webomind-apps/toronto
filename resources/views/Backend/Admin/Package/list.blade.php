@extends('Backend.Admin.Layout.app')

@section('main')

    <div class="page-title">
        <div class="title_left">
        </div>
        <div class="title_right">
            <div class="pull-right">

            </div>
        </div>
    </div>
    <div class="clearfix"></div>

    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_content">
                    <table class="table table-striped table-bordered golo-datatable">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Package Name</th>
                                <th>Price</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($packages as $key => $package)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $package->name }}</td>
                                    <td>
                                        <form action={{ route('admin.package.price') }} method="post">
                                            @csrf
                                            @method("put")
                                            <input type="text" class="package_price decimal" name="price"
                                                value="{{ $package->price }}" onchange="this.form.submit();" />
                                            <input type="hidden" name="id" value={{ $package->id }} />
                                        </form>

                                    </td>
                                    <td>
                                        <form action={{route("admin.package.status")}} method="post">
                                        @csrf
                                        @method("put")
                                        <input type="checkbox" class="js-switch" name="status"
                                            data-id="{{$package->id}}" {{(($package->status == 1)?"checked":"")}} onchange="this.form.submit();"/>
                                        <input type="hidden" name="id" value={{$package->id}}/>
                                        <input type="hidden" name="status" value={{$package->status}}/>
                                        </form>
                                    </td>
                                    <td>
                                        <a href="{{route("admin.package.edit",$package)}}"><button type="button" class="btn btn-warning btn-xs">Edit
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
            count = "{{ $packages->count() }}";
            $(".module-title").text("Packages");
            // if (count >= 1) {
                $(".top-add-button").html(
                    '<a href="{{ route('admin.package.create') }}"><button class="btn btn-primary" type="button">+ Add New</button></a>'
                );
            // }
        });
    </script>
@endpush
