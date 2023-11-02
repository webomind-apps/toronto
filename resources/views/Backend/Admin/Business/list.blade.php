@extends('Backend.Admin.Layout.app')

@push('style')
    <style>
        .line-through {
            -webkit-text-decoration-line: line-through;
            /* Safari */
            text-decoration-line: line-through;
        }

        .update-package-btn {
            padding: 2px;
            font-size: 10px;
            font-weight: bold;
        }

        .badge.bg-orange {
            padding: 7%;
        }
    </style>
@endpush
@section('main')
    <div class="page-title">
        <div class="title_left">
        </div>
        <div class="title_right">
            <div class="">
                <form action="{{route('admin.business.export')}}" method="post">
                    @csrf
                    <input type="hidden" value="{{request('category_id')}}" name="category_id">
                    <input type="hidden" value="{{request('province_id')}}" name="province_id">
                    <input type="hidden" value="{{request('package_id')}}" name="package_id">
                    <input type="hidden" value="{{request('status')}}" name="status">
                    <button type="submit" class="btn btn-primary">Export</button>
                </form>
            </div>
        </div>
    </div>
    <div class="clearfix"></div>

    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel" style="width:auto;">
                <div class="x_content">
                    <form action="" method="get">
                        <div class="row mb-3">
                            <div class="col-sm-3">
                                <select name="province_id" id="province_id" class="form-control">
                                    <option value="">Select province</option>
                                </select>
                            </div>
                            <div class="col-sm-3">
                                <select name="category_id" id="category_id" class="form-control">
                                    <option value="">Select Category</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm-2">
                                <select name="package_id" id="package_id" class="form-control">
                                    <option value="">Select Package</option>
                                    @foreach ($packages as $package)
                                        <option value="{{ $package->id }}">{{ $package->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm-2">
                                <select name="sts" id="status" class="form-control">
                                    <option value="1">Active</option>
                                    <option value="0">Not Active</option>
                                </select>
                            </div>
                            <div class="col-2">
                                <button class="btn btn-success" type="submit">Search</button>
                                <a href="{{route('admin.business.index')}}" class="btn btn-danger">Clear</a>
                            </div>
                        </div>
                    </form>
                    <table class="table table-striped table-bordered golo-datatable">
                        <thead>
                            <tr>
                                <th>S.No</th>
                                <th>Image</th>
                                <th>Business Name</th>
                                <th>Category</th>
                                <th>Country</th>
                                <th>Province</th>
                                <th>City</th>
                                <th>Package</th>
                                <th>Price</th>
                                <th>GST</th>
                                <th>Total</th>
                                <th>Expired Date</th>
                                <th>Feature</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($businesses as $key => $business)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>
                                        @if (!empty($business->image) && file_exists(public_path('storage/' . $business->image)))
                                            <img src="{{ asset('storage/' . $business->image) }}" class="place_list_thumb"
                                                alt="{{ $business->name }}">
                                        @elseif(!empty($default_logo->image) && file_exists(public_path('storage/' . $default_logo->image)))
                                            <img src="{{ asset('storage/' . $default_logo->image) }}"
                                                class="place_list_thumb">
                                        @else
                                            <img class="place_list_thumb" src="{{ asset('defaultImg/defaultImg.png') }}"
                                                alt="{{ $business->name }}" />
                                        @endif
                                    </td>
                                    <td>{{ $business->name }}</td>
                                    <td>{{ $business->category->category->name }}</td>
                                    <td>{{ $business->country->name }}</td>
                                    <td>{{ $business->province->name }}</td>
                                    <td>{{ $business->city->name }}</td>
                                    <td>

                                        @if ($business->business_upgrade_latest->package->id == 1)
                                            @if (date('Y-m-d', strtotime($business->business_upgrade_latest->expired_date)) >= date('Y-m-d'))
                                                {{ $business->business_upgrade_latest->package->name }}
                                            @else
                                                <span
                                                    class="line-through">{{ $business->business_upgrade_latest->package->name }}</span><br />
                                                <span class="badge bg-orange">Free Pack</span>
                                            @endif
                                        @else
                                            {{ $business->business_upgrade_latest->package->name }}<br /><br />
                                            <a href="#" class="btn btn-success update-package-btn">Upgrade</a>
                                        @endif

                                    </td>

                                    <td>
                                        $ {{ $business->business_upgrade_latest->package_price }}
                                    </td>

                                    <td>
                                        ${{ $business->business_upgrade_latest->gst_amount }}
                                    </td>

                                    <td>
                                        ${{ $business->business_upgrade_latest->package_price + $business->business_upgrade_latest->gst_amount }}
                                    </td>

                                    <td>
                                        {{ $business->business_upgrade_latest->expired_date }}<br /><br />
                                        @if (date('Y-m-d', strtotime($business->business_upgrade_latest->expired_date . '-7 day')) <= date('Y-m-d'))
                                            <a href="#" class="btn btn-success update-package-btn">Renewal</a>
                                        @endif
                                    </td>
                                    <td>

                                        <form action={{ route('admin.business.isFeature') }} method="post">
                                            @csrf
                                            @method('put')
                                            <input type="checkbox" class="js-switch" name="status"
                                                data-id="{{ $business->id }}"
                                                {{ $business->is_feature == 1 ? 'checked' : '' }}
                                                onchange="this.form.submit();" />
                                            <input type="hidden" name="id" value={{ $business->id }} />
                                            <input type="hidden" name="is_feature" value={{ $business->is_feature }} />
                                        </form>

                                    </td>

                                    <td>

                                        <form action={{ route('admin.business.status') }} method="post">
                                            @csrf
                                            @method('put')
                                            <input type="checkbox" class="js-switch" name="status"
                                                data-id="{{ $business->id }}"
                                                {{ $business->status == 1 ? 'checked' : '' }}
                                                onchange="this.form.submit();" />
                                            <input type="hidden" name="id" value={{ $business->id }} />
                                            <input type="hidden" name="status" value={{ $business->status }} />
                                        </form>

                                    </td>
                                    <td class="golo-flex">
                                        <a href="{{ route('admin.business.edit', $business) }}"><button type="button"
                                                class="btn btn-warning btn-xs">Edit
                                            </button></a>
                                        <a href="{{ route('admin.business.show', $business) }}"><button type="button"
                                                class="btn btn-warning btn-xs">view
                                            </button></a>
                                        {{-- <div class="list-icons">
                                            <div class="dropdown">
                                                <a href="#" class="list-icons-item" data-toggle="dropdown">
                                                    <i class="fa fa-navicon"></i>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <a class="dropdown-item place_edit"
                                                        href="{{ route('admin.business.edit', $business) }}">
                                                        <i class="fa fa-pencil"></i> Edit</a>
                                                </div>
                                            </div>
                                        </div> --}}
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
            // provience_id=$('#provience_id').val();
            // package_id=$('#package_id').val();
            // status=$('#status').val();
            // $('#provience_id_export').val(provience_id),
            // $('#package_id_export').val(package_id),
            // $('#status_export').val(status),
            $.ajax({
                type: "get",
                url: "{{ route('admin.common.province.collection') }}",
                data: {
                    "country_id": 1,
                },
                dataType: "JSON",
                success: function(response) {
                    content = '<option value="">Select Province</option>';
                    for (i = 0; response.length > i; i++) {
                        content += '<option value="' + response[i].id + '">' + response[i].name +
                            '</option>';
                    }
                    $("#province_id").html(content);
                }
            });
            $(".module-title").text("Business");
            $(".top-add-button").html(
                '<a href="{{ route('admin.business.create') }}" class="btn btn-primary">+ Add New</a>'
            );
        });
    </script>
@endpush
