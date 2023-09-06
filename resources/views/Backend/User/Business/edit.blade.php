@extends('Backend.User.Layout.app')
@push('style')
    <style>

    </style>
@endpush
@section('main')
    <div class="page-title">
        <div class="title_left">
            <!-- <h3>Business create</h3> -->
        </div>
    </div>
    <div class="clearfix"></div>

    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">

                <div class="x_content">
                    <div class="col-lg-3">
                        <ul class="nav nav-tabs tabs-left place_create_menu">
                            <li class="general_side"><a href="#genaral">General</a></li>
                            <li class="location"><a href="#location">Location</a></li>
                            <li class="contact_info_side"><a href="#contact_info">Contact info</a></li>
                            <li class="primium_pack_field_only"><a href="#social_network">Social network</a></li>
                            <li class="oh_side"><a href="#opening_hours">Open hours</a></li>
                            <li class="primium_pack_field_only"><a href="#media">Media</a></li>
                            <li class=""><a href=" #packageDetail">Package details</a></li>
                            <li class="primium_pack_field_only"><a href="#otherDetail">Other details</a></li>
                        </ul>
                    </div>
                    <div class="col-lg-8 col-xs-12">
                        <form action="{{ route('user.business.update', $business) }}" enctype="multipart/form-data"
                            method="post">
                            @csrf
                            @method("put")
                            <div class="tab-content">

                                <div id="genaral">
                                    <p class="lead">Genaral</p>

                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label for="name">Date: *</label>

                                                <div class="form-control">
                                                    {{$business->business_upgrade_latest->upgraded_date ? date('Y-m-d', strtotime($business->business_upgrade_latest->upgraded_date)) : ""}}
                                                </div>

                                            @if ($errors->has('upgraded_date'))
                                                <p style="color:red;">{{ $errors->first('upgraded_date') }}</p>
                                            @endif
                                            <input type="hidden" value="{{$business->business_upgrade_latest->upgraded_date ? date('Y-m-d', strtotime($business->business_upgrade_latest->upgraded_date)) : ""}}" name="upgraded_date">
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label for="name">Package Name: *</label>

                                            <div class="form-control">
                                               {{$business->business_upgrade_latest->package->name}}
                                            </div>
                                            <input type="hidden" value="{{$business->business_upgrade_latest->package_id}}" name="package_id">

                                            @if ($errors->has('package_id'))
                                                <p style="color:red;">{{ $errors->first('package_id') }}</p>
                                            @endif
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label for="user_id">Business Customer: *</label>

                                            <div class="form-control">
                                                {{$business->user->fname}} {{$business->user->lname}}
                                             </div>
                                             <input type="hidden" value="{{$business->user_id}}" name="user_id">

                                            @if ($errors->has('user_id'))
                                                <p style="color:red;">{{ $errors->first('user_id') }}</p>
                                            @endif
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label for="name">Business Name
                                                : *</label>
                                            <input type="text" class="form-control" name="name"
                                                placeholder="What is name of business" autocomplete="off"
                                                value="{{ old('name') ?? $business->name }}" required>
                                            @if ($errors->has('name'))
                                                <p style="color:red;">{{ $errors->first('name') }}</p>
                                            @endif
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label for="category_id">Category: *</label>
                                            <select class="form-control" name="category_id" id="category_id" required>
                                                <option value="">Select category</option>
                                                @foreach ($categories as $category)
                                                    <option
                                                        {{ isSelected(old('category_id') ?? $business->category->category_id, $category->id) }}
                                                        value="{{ $category->id }}">{{ $category->name }}</option>
                                                @endforeach
                                            </select>
                                            @if ($errors->has('category_id'))
                                                <p style="color:red;">{{ $errors->first('category_id') }}</p>
                                            @endif
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label for="sub_category_ids">Sub Category: *</label>
                                            <select class="form-control " title="Select Sub Category"
                                                name="sub_category_ids[]" id="sub_category_ids" data-live-search="true"
                                                multiple>
                                                <option value="">Select sub category</option>
                                                @foreach ($subCategories as $subCategory)

                                                    @php
                                                        $selected = '';
                                                        foreach ($business->subCategories as $subCategory1) {
                                                            if ($subCategory->id == $subCategory1->sub_category_id) {
                                                                $selected = 'selected';
                                                                break;
                                                            }
                                                        }
                                                    @endphp

                                                    <option {{ $selected }} value="{{ $subCategory->id }}">
                                                        {{ $subCategory->name }}</option>
                                                @endforeach
                                            </select>
                                            @if ($errors->has('sub_category_ids'))
                                                <p style="color:red;">{{ $errors->first('sub_category_ids') }}</p>
                                            @endif
                                        </div>

                                        <div class="form-group col-md-12">
                                            <label for="description">Description
                                                : *</label>
                                            <textarea type="text" class="form-control editor" name="description"
                                                rows="6">{{ old('description') ?? $business->description }}</textarea>
                                            @if ($errors->has('description'))
                                                <p style="color:red;">{{ $errors->first('description') }}</p>
                                            @endif
                                        </div>

                                    </div>

                                </div>

                                <div id="location">
                                    <p class="lead">Location</p>

                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label for="select_country">Country: *</label>
                                            <select class="form-control" name="country_id" id="country_id" required>
                                                <option value="">Select country</option>
                                                @foreach ($countries as $key => $country)
                                                    <option value="{{ $country->id }}"
                                                        {{ isSelected($business->country_id, $country->id) }}>
                                                        {{ $country->name }}</option>
                                                @endforeach
                                            </select>
                                            @if ($errors->has('country_id'))
                                                <p style="color:red;">{{ $errors->first('country_id') }}</p>
                                            @endif
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="select_country">Province: *</label>
                                            <select class="form-control" name="province_id" id="province_id" required>
                                                <option value="">Select province</option>
                                                @foreach ($provinces as $key => $province)
                                                    <option value="{{ $province->id }}"
                                                        {{ isSelected($business->province_id, $province->id) }}>
                                                        {{ $province->name }}</option>
                                                @endforeach
                                            </select>
                                            @if ($errors->has('province_id'))
                                                <p style="color:red;">{{ $errors->first('province_id') }}</p>
                                            @endif
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label for="select_city">City: *</label>
                                            <select class="form-control" name="city_id" id="city_id" required>
                                                <option value="">Select city</option>
                                                @foreach ($cities as $key => $city)
                                                    <option value="{{ $city->id }}"
                                                        {{ isSelected($business->city_id, $city->id) }}>
                                                        {{ $city->name }}</option>
                                                @endforeach
                                            </select>
                                            @if ($errors->has('city_id'))
                                                <p style="color:red;">{{ $errors->first('city_id') }}</p>
                                            @endif
                                        </div>

                                        <div class="form-group col-md-8">
                                            <label for="address">Business Address: *</label>
                                            <input type="text" class="form-control" id="address" name="address"
                                                placeholder="Full Address" autocomplete="off" required
                                                value="{{ old('address') ?? $business->address }}">

                                            <input type="hidden" id="place_lat" name="lat"
                                                value="{{ old('lat') ?? $business->lat }}">
                                            <input type="hidden" id="place_lng" name="lng"
                                                value="{{ old('lng') ?? $business->lng }}">

                                            @if ($errors->has('address'))
                                                <p style="color:red;">{{ $errors->first('address') }}</p>
                                            @endif

                                            @if ($errors->has('lat'))
                                                <p style="color:red;">{{ $errors->first('lat') }}</p>
                                            @endif

                                            @if ($errors->has('lng'))
                                                <p style="color:red;">{{ $errors->first('lng') }}</p>
                                            @endif
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label for="address">Postal Code : *</label>
                                            <input type="text" class="form-control alphanumeric code"
                                                placeholder="Postal Code" name="postcode"
                                                value="{{ old('postcode') ?? $business->postcode }}" required
                                                minlength="6" maxlength="7">
                                            @if ($errors->has('postcode'))
                                                <p style="color:red;">{{ $errors->first('postcode') }}</p>
                                            @endif
                                        </div>

                                    </div>

                                    <div id="map-canvas" style="height: 300px;"></div>

                                </div>

                                <div id="contact_info">
                                    <p class="lead">Contact info</p>
                                    <div class="form-group">
                                        <label for="email">Email:*</label>
                                        <input type="text" class="form-control email email-unique" data-field="email"
                                            name="email" required value="{{ old('email') ?? $business->email }}"
                                            data-table="businesses">
                                        @if ($errors->has('email'))
                                            <p style="color:red;">{{ $errors->first('email') }}</p>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label for="phone">Phone number:*</label>
                                        <input type="text" class="form-control phone" name="phone"
                                            placeholder="444-444-4444" maxlength="12" minlength="10" required
                                            value="{{ old('phone') ?? $business->phone }}">
                                        @if ($errors->has('phone'))
                                            <p style="color:red;">{{ $errors->first('phone') }}</p>
                                        @endif
                                    </div>
                                    <div class="form-group websiteDiv">
                                        <label for="website">Website(www.google.com) :</label>
                                        <input type="text" class="form-control website" name="website"
                                            value="{{ old('website') ?? $business->website }}">

                                        @if ($errors->has('website'))
                                            <p style="color:red;">{{ $errors->first('website') }}</p>
                                        @endif
                                    </div>
                                </div>

                                <div id="online_order_detail" class="row primium_pack_field_only">

                                    <div class="col-md-12 row">
                                        <div class="form-group col-md-6">
                                            <label for="name">Order online: *</label>
                                            <select class="form-control" name="online_order" id="online_order">
                                                <option value="">Select</option>
                                                <option
                                                    {{ isSelected(old('online_order') ?? $business->online_order, 1) }}
                                                    value="1">Yes</option>
                                                <option
                                                    {{ isSelected(old('online_order') ?? $business->online_order, 0) }}
                                                    value="0">No</option>
                                            </select>
                                            @if ($errors->has('online_order'))
                                                <p style="color:red;">{{ $errors->first('online_order') }}</p>
                                            @endif
                                        </div>

                                        @php
                                            $style = '';
                                            if ($business->online_order == '0') {
                                                $style = 'style=display:none;';
                                            }
                                        @endphp

                                        <div class="form-group col-md-6 oldiv" {{ $style }}>
                                            <label for="name">Order Online Link: *</label>
                                            <input class="form-control" type="text" name="online_order_link"
                                                id="online_order_link"
                                                value="{{ old('online_order_link') ?? $business->online_order_link }}" />
                                            @if ($errors->has('online_order_link'))
                                                <p style="color:red;">{{ $errors->first('online_order_link') }}</p>
                                            @endif
                                        </div>
                                    </div>

                                </div>

                                <div id="social_network" class="primium_pack_field_only">
                                    <p class="lead">Social Networks</p>
                                    <div id="social_list">

                                        @forelse($business->socialMedias as $socialMedia)

                                            <div class="row form-group social_item">
                                                <div class="col-md-6">
                                                    <select class="form-control" name="social_names[]">
                                                        <option value="">Select</option>
                                                        @foreach (SOCIAL_LIST as $value)
                                                            <option {{ isSelected($socialMedia->name, $value['name']) }}
                                                                value="{{ $value['name'] }}">{{ $value['name'] }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    @if ($errors->has('social_names'))
                                                        <p style="color:red;">{{ $errors->first('social_names') }}</p>
                                                    @endif
                                                </div>
                                                <div class="col-md-5 websiteDiv">
                                                    <input type="text" class="form-control website" name="social_urls[]"
                                                        placeholder="Enter URL(www.google.com)"
                                                        value="{{ $socialMedia->url }}">
                                                    @if ($errors->has('social_urls'))
                                                        <p style="color:red;">{{ $errors->first('social_urls') }}</p>
                                                    @endif
                                                </div>
                                                <div class="col-md-1">
                                                    <button type="button" class="btn btn-danger social_item_remove">X</button>
                                                </div>
                                            </div>

                                        @empty
                                            <div class="row form-group social_item">
                                                <div class="col-md-6">
                                                    <select class="form-control" name="social_names[]">
                                                        <option value="">Select</option>
                                                        @foreach (SOCIAL_LIST as $value)
                                                            <option {{ isSelected(old('social_names'), $value['name']) }}
                                                                value="{{ $value['name'] }}">{{ $value['name'] }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    @if ($errors->has('social_names'))
                                                        <p style="color:red;">{{ $errors->first('social_names') }}</p>
                                                    @endif
                                                </div>
                                                <div class="col-md-5 websiteDiv">
                                                    <input type="text" class="form-control website" name="social_urls[]"
                                                        placeholder="Enter URL(www.google.com)">
                                                    @if ($errors->has('social_urls'))
                                                        <p style="color:red;">{{ $errors->first('social_urls') }}</p>
                                                    @endif
                                                </div>
                                                <div class="col-md-1">
                                                    <button type="button" class="btn btn-danger social_item_remove">X</button>
                                                </div>
                                            </div>
                                        @endforelse

                                    </div>
                                    <button type="button" class="btn btn-round btn-default" id="social_addmore">+ Add
                                        more</button>
                                </div>

                                <div id="opening_hours">
                                    <p class="lead">Opening hours</p>
                                    <div id="openinghour_list">
                                        @foreach (DAYS as $key => $day)
                                            @foreach ($business->business_day_timings as $opening)
                                                @php
                                                    $hide_style = '';
                                                    $open_from_to_hours = '11:00 am - 7:00 pm';
                                                    $from_date = '11:00 am';
                                                    $to_date = '7:00 pm';
                                                    if ($day == $opening->day) {
                                                        if ($opening->time == 'Closed') {
                                                            $hide_style = 'style="display:none;"';
                                                            $open_from_to_hours = 'Closed';
                                                        } else {
                                                            $from_time = date('g:i a', strtotime($opening->from_time));
                                                            $to_time = date('g:i a', strtotime($opening->to_time));
                                                        }
                                                        break;
                                                    }
                                                @endphp
                                            @endforeach
                                            <div class="row form-group openinghour_item">
                                                <div class="col-md-5">
                                                    <input type="text" class="form-control" name="opening_days[]"
                                                        value="{{ $day }}" required>
                                                </div>
                                                <div class="col-md-2">
                                                    <select class="form-control open_or_closed" name="open_or_closed[]">
                                                        <option value="Open">Open</option>
                                                        <option @if ($open_from_to_hours == 'Closed') selected @endif value="Closed">
                                                            Closed
                                                        </option>
                                                    </select>
                                                </div>

                                                <div class="col-md-2" {!! $hide_style !!}>
                                                    <select class="form-control opening_from_a_day">
                                                        <option value="">From</option>
                                                        @for ($i = 1; $i <= 12; $i++)
                                                            <option {{ $i . ':00 am' == $from_time ? 'selected' : '' }}>
                                                                {{ $i }}:00 am</option>
                                                        @endfor
                                                        @for ($i = 1; $i <= 12; $i++)
                                                            <option>{{ $i }}:00 pm</option>
                                                        @endfor
                                                    </select>
                                                </div>
                                                <div class="col-md-2" {!! $hide_style !!}>
                                                    <select class="form-control opening_to_a_day">
                                                        <option value="">To</option>
                                                        @for ($i = 1; $i <= 12; $i++)
                                                            <option>{{ $i }}:00 am</option>
                                                        @endfor
                                                        @for ($i = 1; $i <= 12; $i++)
                                                            <option {{ $i . ':00 pm' == $to_time ? 'selected' : '' }}>
                                                                {{ $i }}:00 pm</option>
                                                        @endfor
                                                    </select>
                                                </div>

                                                <input type="hidden" class="form-control opening_hour_per_day"
                                                    name="opening_hour_timing[]" value="{{ $open_from_to_hours }}"
                                                    required>

                                                <input type="hidden" class="form-control opening_from_per_day"
                                                    name="opening_from_timing[]" value="11:00:00 am" required>

                                                <input type="hidden" class="form-control opening_to_per_day"
                                                    name="opening_to_timing[]" value="7:00:00 pm" required>

                                                <div class="col-md-1">
                                                </div>
                                            </div>
                                        @endforeach

                                    </div>
                                </div>

                                <div id="media" class="primium_pack_field_only">
                                    <p class="lead">Media</p>
                                    <div class="row image-div">
                                        <div class="col-md-6">
                                            <p><strong>Thumbnail image:(size width:160px height:140px)</strong></p>

                                            @if (!empty($business->image) && file_exists(public_path('storage/' . $business->image)))
                                                <img src="{{ asset('storage/' . $business->image) }}" id="image-preview"
                                                    class="file-image-preview">
                                            @else
                                                <img id="image-preview"
                                                    src="https://via.placeholder.com/120x150?text=thumbnail"
                                                    class="file-image-preview">
                                            @endif

                                            <input type="file" class="form-control" name="image" accept="image/*"
                                                data-id="image-preview">
                                            @if ($errors->has('image'))
                                                <p style="color:red;">{{ $errors->first('image') }}</p>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="row mt-20">

                                        <div class="col-md-12 gallery">
                                            <p><strong>Gallery images:(size width:1200px height:800px)</strong></p>
                                            <div id="image_galleries">
                                                @if ($business->galleries)
                                                    @foreach ($business->galleries as $gallery)
                                                        <div class="col-sm-2 media-thumb-wrap">
                                                            <figure class="media-thumb">
                                                                @if (!empty($gallery->image) && file_exists(public_path('storage/' . $gallery->image)))
                                                                    <img src="{{ asset('storage/' . $gallery->image) }}"
                                                                        alt="page thumb"
                                                                        class="file-gallery-image-preview" />
                                                                @else
                                                                    <img src="{{ asset('defaultImg/defaultImg.png') }}"
                                                                        alt="page thumb"
                                                                        class="file-gallery-image-preview" />
                                                                @endif
                                                                <div class="media-item-actions">
                                                                    <a class="icon icon-delete" href="#"
                                                                        data-id="{{ $gallery->id }}"">
                                                                                    <svg xmlns="
                                                                        http://www.w3.org/2000/svg" width="15" height="16"
                                                                        viewBox="0 0 15 16">
                                                                        <g fill="#5D5D5D" fill-rule="nonzero">
                                                                            <path
                                                                                d="M14.964 2.32h-4.036V0H4.105v2.32H.07v1.387h1.37l.924 12.25H12.67l.925-12.25h1.369V2.319zm-9.471-.933H9.54v.932H5.493v-.932zm5.89 13.183H3.65L2.83 3.707h9.374l-.82 10.863z">
                                                                            </path>
                                                                            <path
                                                                                d="M6.961 6.076h1.11v6.126h-1.11zM4.834 6.076h1.11v6.126h-1.11zM9.089 6.076h1.11v6.126h-1.11z">
                                                                            </path>
                                                                        </g>
                                                                        </svg>
                                                                    </a>
                                                                    <input type="hidden" name="galleries[]"
                                                                        value="{{ $gallery->image }}">
                                                                    <span class="icon icon-loader d-none"><i
                                                                            class="fa fa-spinner fa-spin"></i></span>
                                                                </div>
                                                            </figure>
                                                        </div>
                                                    @endforeach
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <input type="file" class="form-control" id="gallery" name="banner"
                                                accept="image/*">
                                        </div>
                                    </div>

                                    <div class="form-group video">
                                        <label for="">Video:</label>
                                        <input type="text" class="form-control" name="video"
                                            placeholder="Youtube, Vimeo video url" value="{{old("video")??$business->video}}">
                                        @if ($errors->has('video'))
                                            <p style="color:red;">{{ $errors->first('video') }}</p>
                                        @endif
                                    </div>
                                </div>

                                <div class="ln_solid"></div>

                                <div id="otherDetail" class="primium_pack_field_only">
                                    <p class="lead">Other Details</p>
                                    <div class="form-group">
                                        <label for="area_of_practice">Area Of Practice:</label>
                                        <textarea id="area_of_practice" name="area_of_practice"
                                            class="form-control editor">{{ old('area_of_practice') ?? ($business->area_of_practice ?? '') }}</textarea>
                                        @if ($errors->has('area_of_practice'))
                                            <p style="color:red;">{{ $errors->first('area_of_practice') }}</p>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label for="product_and_services">Product and Services:</label>
                                        <textarea class="form-control editor"
                                            name="product_and_service">{{ old('product_and_service') ?? ($business->product_and_service ?? '') }}</textarea>
                                        @if ($errors->has('product_and_service'))
                                            <p style="color:red;">{{ $errors->first('product_and_service') }}</p>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label for="specialties">Specialization:</label>
                                        <textarea class="form-control editor"
                                            name="specialization">{{ old('specialization') ?? ($business->specialization ?? '') }}</textarea>
                                        @if ($errors->has('specialization'))
                                            <p style="color:red;">{{ $errors->first('specialization') }}</p>
                                        @endif
                                    </div>

                                </div>

                                <div class="row primium_pack_field_only">

                                    <div class="form-group col-md-12">
                                        <label for="languages">Languages: *</label>
                                        <select class="form-control chosen-select" name="languages[]" multiple
                                            data-live-search="true">
                                            @foreach ($languages as $language)
                                                @php
                                                    $selected = '';
                                                    foreach ($business->languages as $language1) {
                                                        if ($language->id == $language1->language_id) {
                                                            $selected = 'selected';
                                                            break;
                                                        }
                                                    }
                                                @endphp
                                                <option {{ $selected }} value="{{ $language->id }}">
                                                    {{ $language->name }}</option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('languages'))
                                            <p style="color:red;">{{ $errors->first('languages') }}</p>
                                        @endif
                                    </div>

                                    <div class="form-group col-md-12">
                                        <label for="languages">Payment Methods: </label>
                                        <select class="form-control chosen-select" name="payment_methods[]" multiple
                                            data-live-search="true">
                                            @foreach ($paymentMethods as $paymentMethod)
                                                @php
                                                    $selected = '';
                                                    foreach ($business->payment_methods as $paymentMethod1) {
                                                        if ($paymentMethod->id == $paymentMethod1->payment_method_id) {
                                                            $selected = 'selected';
                                                            break;
                                                        }
                                                    }
                                                @endphp
                                                <option {{ $selected }} value="{{ $paymentMethod->id }}">{{ $paymentMethod->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('payment_methods'))
                                            <p style="color:red;">{{ $errors->first('payment_methods') }}</p>
                                        @endif
                                    </div>

                                </div>

                            </div>
                            <button type="submit" class="btn btn-primary mt-20">Submit</button>
                    </div>

                    </form>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
    </div>
@endsection

@push('scripts')
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/4.9.2/tinymce.min.js"></script>

    <script>
        $(document).ready(function() {

            base_url = "{{ URL::to('/') }}";

            tinymce.init({

                selector: '.editor', // change this value according to your HTML
                themes: "modern",
                menubar: false,
                statusbar: false,
                height: 250,
                valid_elements: "@[class],p[style],h3,h4,h5,h6,a[href|target],strong/b," +
                    "div[align],br,table,tbody,thead,tr,td,ul,ol,li,img[src],i",

                plugins: [
                    "advlist autolink lists link image charmap print preview anchor code",
                    "searchreplace visualblocks code fullscreen table",
                ],
                //font_formats: "Calibri=calibri,sans-serif; Arial=arial,sans-serif",
                fontsize_formats: "12px 14px 16px 18px 24px 28px 30px 36px 40px",
                toolbar: "fontsizeselect | fontselect | insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link table | code"

            });

            $("#online_order").change(function(e) {
                e.preventDefault();

                if ($(this).val() == "1") {
                    $(".oldiv").css("display", "block");
                    $("#online_order_link").prop("required", true);
                } else {
                    $(".oldiv").css("display", "none");
                    $("#online_order_link").prop("required", false);
                }

            });

            package_service();
            // province_collection($("#country_id").val());

            $("#sub_category_ids").selectpicker();

            $("#package_id").change(function(e) {
                e.preventDefault();
                package_service();
            });

            $("#country_id").change(function(e) {
                e.preventDefault();
                country_id = $(this).val();
                if (country_id == "") {
                    $("#province_id").html('<option value="">First select country</option>');
                } else {
                    province_collection(country_id);
                }
            });

            $("#province_id").change(function(e) {
                e.preventDefault();
                province_id = $(this).val();
                if (province_id == "") {
                    $("#city_id").html('<option value="">First select province</option>');
                } else {
                    city_collection(province_id);
                }
            });

            $("#category_id").change(function(e) {
                e.preventDefault();
                category_id = $(this).val();

                if (category_id == "") {
                    $("#sub_category_ids").html('<option value="">First select category</option>');
                } else {
                    sub_category_collection(category_id);
                }

                setTimeout(function() {
                    $("#sub_category_ids").selectpicker('destroy');
                    $('#sub_category_ids').attr('multiple', 'multiple');
                    $('#sub_category_ids option').prop('selected', false);
                    $("#sub_category_ids").selectpicker();
                }, 1000);
            });

            $(document).on("click", ".icon-delete", function(event) {
                event.preventDefault();
                if (confirm("Are you sure to remove?")) {

                    vm = $(this);
                    vm.closest('.media-thumb-wrap').remove();

                    // $.ajax({
                    //     type: "get",
                    //     url: "{{ route('user.business.galleryRemove') }}",
                    //     data: {
                    //         "id" : vm.attr("data-id"),
                    //         "_ token" : "{{ csrf_token() }}",
                    //     },
                    //     dataType: 'json"',
                    //     success: function(response) {
                    //         if (response == "success") {
                    //             vm.closest('.media-thumb-wrap').remove();
                    //         }
                    //     },
                    //     error: function(jqXHR) {
                    //         response = $.parseJSON(jqXHR.responseText);
                    //         if (response.message) {
                    //             alert(response.message);"
                    //         }
                    //     }
                    // });
                }
            });

            $(document).on("click", "#social_addmore", function(event) {
                let social_list = $('#social_list');
                let social_item = $('.social_item').length;
                social_list.append(`
                    <div class="row form-group social_item">
                        <div class="col-md-6">
                            <select class="form-control" name="social_names[]">
                                <option value="">Select</option>
                                <option value="Facebook">Facebook</option>
                                <option value="Instagram">Instagram</option>
                                <option value="Youtube">Youtube</option>
                                <option value="Twitter">Twitter</option>
                                <option value="Pinterest">Pinterest</option>
                                <option value="Snapchat">Snapchat</option>
                            </select>
                        </div>
                        <div class="col-md-5 websiteDiv">
                            <input type="text" class="form-control website" name="social_urls[]" placeholder="Enter URL(www.google.com)">
                            <span class="field-error websiteErr">Please enter valid website(Format:www.google.com)</span>
                        </div>
                        <div class="col-md-1">
                            <button type="button" class="btn btn-danger social_item_remove">X</button>
                        </div>
                    </div>
                `);
            });

            $(document).on("click", ".social_item_remove", function(event) {
                $(this).parent().closest(".social_item").remove();
            });

            $(".open_or_closed").change(function(e) {
                e.preventDefault();
                if ($(this).val() == "Closed") {
                    $(this).parents(".openinghour_item").find(".opening_from_a_day,.opening_to_a_day")
                        .parent("div")
                        .hide();
                    $(this).parents(".openinghour_item").find(".opening_from_a_day,.opening_to_a_day").prop(
                        "required", false);
                    $(this).parents(".openinghour_item").find(".opening_hour_per_day").val("Closed");
                    $(this).parents(".openinghour_item").find(".opening_from_per_day").val("Closed");
                    $(this).parents(".openinghour_item").find(".opening_to_per_day").val("Closed");
                } else {
                    $(this).parents(".openinghour_item").find(".opening_from_a_day,.opening_to_a_day")
                        .parent("div")
                        .show();
                    $(this).parents(".openinghour_item").find(".opening_from_a_day,.opening_to_a_day").prop(
                        "required", true);
                    $(this).parents(".openinghour_item").find(".opening_hour_per_day").val("");
                    $(this).parents(".openinghour_item").find(".opening_from_per_day").val("");
                    $(this).parents(".openinghour_item").find(".opening_to_per_day").val("");
                }
            });

            $(".opening_from_a_day,.opening_to_a_day").change(function(e) {
                e.preventDefault();
                from = $(this).parents(".openinghour_item").find(".opening_from_a_day").val();
                to = $(this).parents(".openinghour_item").find(".opening_to_a_day").val();
                if (from != "" && to != "") {
                    from_to = from + " - " + to;
                    $(this).parents(".openinghour_item").find(".opening_hour_per_day").val(from_to);
                    $(this).parents(".openinghour_item").find(".opening_from_per_day").val(from);
                    $(this).parents(".openinghour_item").find(".opening_to_per_day").val(to);
                } else {
                    $(this).parents(".openinghour_item").find(".opening_hour_per_day").val("");
                }
            });

            $("form").submit(function(e) {
                languages = $('#languages').val();
                package_id = $("#package_id").val();

                if (package_id == "1") {
                    if (languages.length <= 0) {
                        content = "Please select languages";
                        alert(content)
                        e.preventDefault();
                        return false;
                    }
                }
            });

            $(document).on('change', '.image-div input[type=file]', function(e) {
                e.preventDefault();
                readURL(this);
            });

            $('#gallery').change(function() {
                var form_data = new FormData();
                form_data.append('image', this.files[0]);
                form_data.append('_token', CSRF_TOKEN);
                $.ajax({
                    url: "{{ route('user.business.galleryUpload') }}",
                    data: form_data,
                    type: 'POST',
                    contentType: false,
                    processData: false,
                    success: function(res) {
                        if (res.fail) {
                            alert(res.errors['image']);
                        } else {
                            if (res.code === 200) {
                                let html = `
                                <div class="col-sm-2 media-thumb-wrap">
                                    <figure class="media-thumb">
                                        <img src="${base_url}/storage/${res.file_name}" class="file-gallery-image-preview">
                                        <div class="media-item-actions">
                                            <a class="icon icon-delete" data-filename="${res.file_name}" href="#">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="16" viewBox="0 0 15 16">
                                                    <g fill="#5D5D5D" fill-rule="nonzero">
                                                        <path d="M14.964 2.32h-4.036V0H4.105v2.32H.07v1.387h1.37l.924 12.25H12.67l.925-12.25h1.369V2.319zm-9.471-.933H9.54v.932H5.493v-.932zm5.89 13.183H3.65L2.83 3.707h9.374l-.82 10.863z"></path>
                                                        <path d="M6.961 6.076h1.11v6.126h-1.11zM4.834 6.076h1.11v6.126h-1.11zM9.089 6.076h1.11v6.126h-1.11z"></path>
                                                    </g>
                                                </svg>
                                            </a>
                                            <input type="hidden" name="galleries[]" value="${res.file_name}">
                                            <span class="icon icon-loader" style="display: none;"><i class="fa fa-spinner fa-spin"></i></span>
                                        </div>
                                    </figure>
                                </div>
                            `;
                                $('#image_galleries').append(html);
                            }
                        }
                    },
                    error: function(xhr, status, error) {
                        alert('An error occurred!');
                        console.log(xhr.responseText);
                    }
                });
            });

        });

        function province_collection(country_id = null) {
            $.ajax({
                type: "get",
                url: "{{ route('user.common.province.collection') }}",
                data: {
                    "country_id": country_id,
                },
                dataType: "JSON",
                success: function(response) {
                    content = '<option value="">Select Province</option>';
                    for (i = 0; response.length > i; i++) {
                        content += '<option value="' + response[i].id + '">' + response[i].name + '</option>';
                    }
                    $("#province_id").html(content);
                }
            });
        }

        function city_collection(province_id = null) {
            $.ajax({
                type: "get",
                url: "{{ route('user.common.city.collection') }}",
                data: {
                    "province_id": province_id,
                },
                dataType: "JSON",
                success: function(response) {
                    content = '<option value="">Select City</option>';
                    for (i = 0; response.length > i; i++) {
                        content += '<option value="' + response[i].id + '">' + response[i].name + '</option>';
                    }
                    $("#city_id").html(content);
                }
            });
        }

        function sub_category_collection(category_id = null) {
            $.ajax({
                type: "get",
                url: "{{ route('user.common.subCategory.collection') }}",
                data: {
                    "category_id": category_id,
                },
                dataType: "JSON",
                success: function(response) {
                    // content = '<option value="" disabled>Select Sub Category</option>';
                    content = '';
                    for (i = 0; response.length > i; i++) {
                        content += '<option value="' + response[i].id + '">' + response[i].name + '</option>';
                    }
                    $("#sub_category_ids").html(content);
                }
            });
        }

        function package_service() {

            package_id = $("#package_id").val();

            if (package_id == 2) {

                $("#social_network").hide();
                $("#media").hide();
                $("#otherDetail").hide();

                $(".primium_pack_field_only").css("display", "none");

            } else if (package_id == 1) {

                $("#social_network").show();
                $("#media").show();
                $("#otherDetail").show();

                $(".primium_pack_field_only").css("display", "block");
            }
        }
    </script>

    <script type="text/javascript">
        var map = null;
        var marker;
        let place_lat = parseFloat($('#place_lat').val()) || 43.651070;
        let place_lng = parseFloat($('#place_lng').val()) || -79.347015;

        function showlocation() {
            // navigator.geolocation.getCurrentPosition(callback);
        }

        function callback(position) {

            if (marker != null) {
                marker.setMap(null);
            }

            $('#place_lat').val(place_lat);
            $('#place_lng').val(place_lng);

            var latLong = new google.maps.LatLng(place_lat, place_lng);
            marker = new google.maps.Marker({
                position: latLong,
                draggable: true
            });

            marker.setMap(map);
            map.setZoom(16);
            map.setCenter(marker.getPosition());

            // drag marker
            google.maps.event.addListener(marker, 'dragend', function() {
                const place = marker.getPosition();
                $('#place_lat').val(place.lat());
                $('#place_lng').val(place.lng());
            });

            // Search location
            let input = document.getElementById('address');
            let searchBox = new google.maps.places.Autocomplete(input, {
                // componentRestrictions: { country: "us" },
                fields: ["formatted_address", "geometry", "name", "address_components"],
                origin: map.getCenter(),
                strictBounds: false,
                componentRestrictions: {
                    country: "CA"
                },
                types: ["establishment", "geocode"],
            });

            // triger search
            google.maps.event.addListener(searchBox, 'place_changed', function() {
                marker.setVisible(false);
                const place = searchBox.getPlace();


                if (!place.geometry || !place.geometry.location) {
                    window.alert("No details available for input: '" + place.name + "'");
                    return;
                }

                if (place.geometry.viewport) {
                    map.fitBounds(place.geometry.viewport);
                } else {
                    map.setCenter(place.geometry.location);
                    map.setZoom(17);
                }

                marker.setPosition(place.geometry.location);
                marker.setVisible(true);
                console.log(place.geometry.location.lat);

                $('#address').val(place.formatted_address);
                $('#place_lat').val(place.geometry.location.lat());
                $('#place_lng').val(place.geometry.location.lng());

            });
        }


        // map init
        function initMap() {
            var mapOptions = {
                center: new google.maps.LatLng(0, 0),
                zoom: 1,
                mapTypeId: google.maps.MapTypeId.ROADMAP
            };
            map = new google.maps.Map(document.getElementById("map-canvas"), mapOptions);
            callback()
        }

        // preview image
        function readURL(input) {
            var targetImg = $(input).attr('data-id');
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    $('#' + targetImg).attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]); // convert to base64 string
            }
        }
    </script>

<script
src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCZuRJggt3Hg37Vrl5EeL9j9FREsD7SBo8&libraries=places&callback=initMap&v=weekly"
defer></script>

@endpush
