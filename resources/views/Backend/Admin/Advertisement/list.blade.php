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
                                <th>Business Name</th>
                                <th>Link</th>
                                <th>Categories</th>
                                <th>Cities</th>
                                <th>Price</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($advertisements as $key => $advertisement)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>
                                        @if (!empty($advertisement->image) && file_exists(public_path('storage/' . $advertisement->image)))
                                            <img src="{{ asset('storage/' . $advertisement->image) }}"
                                                class="place_list_thumb" alt="Default Logo">
                                        @elseif(!empty($default_logo->image) &&
                                            file_exists(public_path('storage/'.$default_logo->image)))
                                            <img src="{{ asset('storage/' . $default_logo->image) }}"
                                                class="place_list_thumb">
                                        @else
                                            <img class="place_list_thumb" src="{{ asset('defaultImg/defaultImg.png') }}"
                                                alt="Default Logo" />
                                        @endif
                                    </td>
                                    <td>{{ $advertisement->business->name ?? '' }}</td>

                                    <td>{{ $advertisement->link ?? '' }}</td>
                                    <td>
                                        @foreach ($advertisement->categories as $key => $category)
                                            {{ $category->category->name }}@if ($key + 1 < count($advertisement->categories)),@endif
                                        @endforeach
                                    </td>
                                    <td>
                                        @foreach ($advertisement->cities as $key => $city)
                                            {{ $city->city->name }}@if ($key + 1 < count($advertisement->cities)),@endif
                                        @endforeach
                                    </td>
                                    <td>{{ $advertisement->price ?? '' }}</td>
                                    <td>
                                        <form action={{ route('admin.advertisement.status') }} method="post">
                                            @csrf
                                            @method("put")
                                            <input type="checkbox" class="js-switch" name="status"
                                                data-id="{{ $advertisement->id }}"
                                                {{ $advertisement->status == 1 ? 'checked' : '' }}
                                                onchange="this.form.submit();" />
                                            <input type="hidden" name="id" value={{ $advertisement->id }} />
                                            <input type="hidden" name="status" value={{ $advertisement->status }} />
                                        </form>

                                    </td>

                                    <td class="golo-flex">
                                        <form onsubmit="return confirm('Are you sure to do?')?true:false;"
                                            action={{ route('admin.advertisement.destroy', $advertisement->id) }}
                                            method="post">
                                            @csrf
                                            @method("delete")
                                            <button type="submit"
                                                class="btn btn-danger btn-xs default_logo_delete">Delete</button>
                                        </form>

                                        <a href="{{ route('admin.advertisement.edit', $advertisement) }}"><button
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
            $(".module-title").text("Advertisement");
            $(".top-add-button").html(
                '<a href="{{ route('admin.advertisement.create') }}"><button class="btn btn-primary" type="button">+ Add New</button></a>'
            );
        });
    </script>
@endpush
