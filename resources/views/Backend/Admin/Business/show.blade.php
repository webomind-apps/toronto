@extends('Backend.Admin.Layout.app')
@push('style')
<style>
    .business-thumb img{
        height:120px;
        width:auto;
    }
    .business-gallery img{
        height:120px;
        width:auto;
        margin :0px 5px;
    }
</style>
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

                    <h2>User Details</h2>
                    <hr/>

                    <table class="table customer-table">

                        <tr>
                            <th>Name</th>
                            <td>{{ $business->user->fname ?? '' }} {{ $business->user->lname ?? '' }}</td>

                            <th>Email</th>
                            <td>{{ $business->user->email ?? '' }}</td>
                        </tr>

                        <tr>
                            <th>Phone</th>
                            <td>{{ $business->user->phone ?? '' }}</td>

                            <th>Address</th>
                            <td>{{ $business->user->address ?? '' }}</td>
                        </tr>

                        <tr>
                            <th>Country</th>
                            <td>{{ $business->user->country->name ?? '' }}</td>

                            <th>Province</th>
                            <td>{{ $business->user->province->name ?? '' }}</td>
                        </tr>

                        <tr>
                            <th>City</th>
                            <td>{{ $business->user->city->name ?? '' }}</td>

                            <th>Status</th>
                            <td>{{ $business->user->status == 1 ? 'Active' : 'Inactive' }}</td>
                        </tr>

                        <tr>
                            <th>Business</th>
                            <td colspan="2">
                                {{ $business->name ?? '' }}
                                {{-- @foreach ($business->user->businesses as $key => $business)
                                    {{$key+1}}. {{ $business->name ?? '' }}<br/>
                                @endforeach --}}
                            </td>
                        </tr>

                    </table>

                    <h2>Business Details</h2>
                    <hr/>

                    <table class="table customer-table">

                        <tr>
                            <th>Name</th>
                            <td>{{ $business->name ?? '' }} </td>

                            <th>Email</th>
                            <td>{{ $business->email ?? '' }}</td>
                        </tr>

                        <tr>
                            <th>Phone</th>
                            <td>{{ $business->phone ?? '' }}</td>

                            <th>Address</th>
                            <td>{{ $business->address ?? '' }}</td>
                        </tr>

                        <tr>
                            <th>Category</th>
                            <td>{{ $business->category->category->name ?? '' }}</td>

                            <th>Sub Category</th>
                            <td>
                                @foreach ($business->subCategories as $key => $suCategory)
                                    {{ $suCategory->subCategory->name ?? '' }}@if ($key + 1 != count($business->subCategories)),@endif
                                @endforeach
                            </td>
                        </tr>

                        <tr>
                            <th>Country</th>
                            <td>{{ $business->country->name ?? '' }}</td>

                            <th>Province</th>
                            <td>{{ $business->province->name ?? '' }}</td>
                        </tr>

                        <tr>
                            <th>City</th>
                            <td>{{ $business->city->name ?? '' }}</td>

                            <th>Status</th>
                            <td>{{ $business->status == 1 ? 'Active' : 'Inactive' }}</td>
                        </tr>

                        <tr>
                            <th>Post Code</th>
                            <td>{{ $business->postcode ?? '' }}</td>

                            <th>Website</th>
                            <td>{{ $business->website ?? '' }}</td>
                        </tr>

                        <tr>
                            <th>Online Order</th>
                            <td>{{ $business->online_order == 1 ? 'Yes' : 'No' }}</td>

                            <th>Online Order Link</th>
                            <td>{{ $business->online_order_link ?? '' }}</td>
                        </tr>

                        <tr>
                            <th>Video</th>
                            <td>{{ $business->video ?? '' }}</td>

                            <th>Is Feature</th>
                            <td>{{ $business->is_feature == 1 ? 'Active' : 'Inactive' }}</td>
                        </tr>

                        <tr>

                            <th>Languages</th>
                            <td>
                                @foreach ($business->languages as $key => $language)
                                    {{ $language->language->name ?? '' }}@if ($key + 1 != count($business->languages)),@endif
                                @endforeach
                            </td>

                            <th>Payment Methods</th>
                            <td>
                                @foreach ($business->payment_methods as $key => $paymentMethod)
                                    {{ $paymentMethod->PaymentMethod->name ?? '' }}@if ($key + 1 != count($business->payment_methods)),@endif
                                @endforeach
                            </td>
                        </tr>

                        <tr>
                            <th>Description</th>
                            <td colspan="3">{!! $business->description ?? '' !!}</td>
                        </tr>

                        <tr>
                            <th>Area of Practice</th>
                            <td colspan="3">{!! $business->area_of_practice ?? '' !!}</td>
                        </tr>

                        <tr>
                            <th>Product and Service</th>
                            <td colspan="3">{!! $business->product_and_service ?? '' !!}</td>
                        </tr>

                        <tr>
                            <th>Specialization</th>
                            <td colspan="3">{!! $business->specialization ?? '' !!}</td>
                        </tr>

                    </table>

                    <h2>Package Details</h2>
                    <hr/>

                    <table class="table customer-table">

                        <tr>
                            <th>Package Name</th>
                            <td>
                                {{$business->business_upgrade_latest->package->name ?? ''}}
                            </td>
                            <th>GST</th>
                            <td>
                                {{$business->business_upgrade_latest->gst_percentage ?? ''}}
                            </td>
                        </tr>

                        <tr>
                            <th>GST Amount</th>
                            <td>
                                ${{$business->business_upgrade_latest->gst_amount ?? ''}}
                            </td>
                            <th>Package Amount</th>
                            <td>
                                ${{$business->business_upgrade_latest->package_price ?? ''}}
                            </td>
                        </tr>

                        <tr>
                            <th>Total Amount</th>
                            <td>
                                ${{$business->business_upgrade_latest->total_amount ?? ''}}
                            </td>

                            <th>Upgraded Date </th>
                            <td>
                                {{$business->business_upgrade_latest->upgraded_date ?? ''}}
                            </td>

                        </tr>


                        <tr>
                            <th>Expired Date</th>
                            <td>
                                {{$business->business_upgrade_latest->expired_date ?? ''}}
                            </td>

                        </tr>

                    </table>

                    <h2>Opening Hours</h2>
                    <hr/>

                    <table class="table customer-table">
                        @forelse ($business->business_day_timings as $business_day_timing)
                            <tr>
                                <th>{{ $business_day_timing->day ?? '' }}</th>
                                <td>{{ $business_day_timing->time ?? '' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="2" class="text-center">No data found</td>
                            </tr>
                        @endforelse
                    </table>

                    <h2>Social Media</h2>
                    <hr/>

                    <table class="table customer-table">
                        @forelse ($business->socialMedias as $socialMedia)
                            <tr>
                                <th>{{ $socialMedia->name ?? '' }}</th>
                                <td>{{ $socialMedia->url ?? '' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="2" class="text-center">No Social Media</td>
                            </tr>
                        @endforelse
                    </table>

                    <h2>Thumb</h2>
                    <hr/>

                    <div class="business-thumb">
                        @if (!empty($business->image) && file_exists(public_path('storage/' . $business->image)))
                            <img src="{{ asset('storage/' . $business->image) }}" alt="{{ $business->name }}">
                        @elseif(!empty($default_logo->image) &&
                            file_exists(public_path('storage/'.$default_logo->image)))
                            <img src="{{ asset('storage/' . $default_logo->image) }}">
                        @else
                            <img class="place_list_thumb" src="{{ asset('defaultImg/defaultImg.png') }}" alt="{{ $business->name }}" />
                        @endif
                    </div>

                    <h2>Gallery</h2>
                    <hr/>

                    <div class="business-gallery">
                        @forelse ($business->galleries as $gallery)
                            @if (!empty($gallery->image) && file_exists(public_path('storage/' . $gallery->image)))
                                <img src="{{ asset('storage/' . $gallery->image) }}" alt="{{ $business->name }}">
                            @elseif(!empty($default_logo->image) &&
                                file_exists(public_path('storage/'.$default_logo->image)))
                                <img src="{{ asset('storage/' . $default_logo->image) }}">
                            @else
                                <img class="place_list_thumb" src="{{ asset('defaultImg/defaultImg.png') }}" alt="{{ $business->name }}" />
                            @endif
                        @empty
                            <h6>No data found</h6>
                        @endforelse

                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('admin/js/page_user.js') }}"></script>
    <script>
        $(document).ready(function() {
            $(".module-title").text("Business Details");
        });
    </script>
@endpush
