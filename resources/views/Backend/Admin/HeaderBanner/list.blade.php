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
                                <th>Image</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($headerBanners as $key => $headerBanner)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>
                                        @if (!empty($headerBanner->image) && file_exists(public_path('storage/' . $headerBanner->image)))
                                            <img src="{{ asset('storage/' . $headerBanner->image) }}"
                                                class="place_list_thumb" alt="Header Banner">
                                        @elseif(!empty($default_logo->image) &&
                                            file_exists(public_path('storage/'.$default_logo->image)))
                                            <img src="{{ asset('storage/' . $default_logo->image) }}"
                                                class="place_list_thumb">
                                        @else
                                            <img class="place_list_thumb" src="{{ asset('defaultImg/defaultImg.png') }}"
                                                alt="Header Banner" />
                                        @endif
                                    </td>

                                    <td>

                                        <form action={{ route('admin.headerBanner.status') }} method="post">
                                            @csrf
                                            @method("put")
                                            <input type="checkbox" class="js-switch" name="status"
                                                data-id="{{ $headerBanner->id }}"
                                                {{ $headerBanner->status == 1 ? 'checked' : '' }}
                                                onchange="this.form.submit();" />
                                            <input type="hidden" name="id" value={{ $headerBanner->id }} />
                                            <input type="hidden" name="status" value={{ $headerBanner->status }} />
                                        </form>

                                    </td>

                                    <td class="golo-flex">
                                        <form onsubmit="return confirm('Are you sure to do?')?true:false;"
                                            action={{ route('admin.headerBanner.destroy', $headerBanner) }} method="post">
                                            @csrf
                                            @method("delete")
                                            <button type="submit"
                                                class="btn btn-danger btn-xs default_logo_delete">Delete</button>
                                        </form>

                                        <a href="{{ route('admin.headerBanner.edit', $headerBanner) }}"><button
                                                type="button" class="btn btn-warning btn-xs">Edit
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
            $(".module-title").text("Header Banner");
            $(".top-add-button").html(
                '<a href="{{ route('admin.headerBanner.create') }}"><button class="btn btn-primary" type="button">+ Add New</button></a>'
            );
        });
    </script>
@endpush
