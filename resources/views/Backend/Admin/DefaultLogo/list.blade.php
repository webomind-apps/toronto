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
                                <th>Logo</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($defaultLogoes as $key => $defaultLogo)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>
                                        <img class="place_list_thumb" src="{{ asset('storage/'.$defaultLogo->image) }}"
                                            alt="Default Logo">
                                    </td>

                                    <td>

                                        <form action={{ route('admin.defaultLogo.status') }} method="post">
                                            @csrf
                                            @method("put")
                                            <input type="checkbox" class="js-switch" name="status"
                                                data-id="{{ $defaultLogo->id }}"
                                                {{ $defaultLogo->status == 1 ? 'checked' : '' }}
                                                onchange="this.form.submit();" />
                                            <input type="hidden" name="id" value={{ $defaultLogo->id }} />
                                            <input type="hidden" name="status" value={{ $defaultLogo->status }} />
                                        </form>

                                    </td>

                                    <td>
                                        <form onsubmit="return confirm('Are you sure to do?')?true:false;"
                                            action={{ route('admin.defaultLogo.destroy', $defaultLogo) }} method="post">
                                            @csrf
                                            @method("delete")
                                            <button type="submit"
                                                class="btn btn-danger btn-xs default_logo_delete">Delete</button>
                                        </form>

                                        <a href="{{ route('admin.defaultLogo.edit', $defaultLogo) }}"><button type="button"
                                                class="btn btn-warning btn-xs">Edit
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
            $(".module-title").text("Default logoes");
            $(".top-add-button").html(
                '<a href="{{ route('admin.defaultLogo.create') }}"><button class="btn btn-primary" type="button">+ Add New</button></a>'
            );
        });
    </script>
@endpush
