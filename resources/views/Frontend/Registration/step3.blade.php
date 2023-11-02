@push('style')
    <style>
        .btn-group {
            background: #fff !important;
            display: block !important;
            padding: 0 !important;
        }

        .btn-group:hover,
        .btn-group button:hover {
            background: #fff !important;
            color: #212529;
        }

        .multiselect {
            border: 1px solid #ced4da !important;
            border-radius: .25rem !important;
            width: 100% !important;
            text-align: left !important;
        }

        .btn-group ul {
            width: 100% !important;
        }

        .btn-group .multiselect-container>li>a>label {
            padding-left: 20px !important;
        }

        .checkbox {
            width: 100% !important;
        }

        .mt-20 {
            margin-top: 20px;
        }

        .required {
            color: red;
        }
    </style>
@endpush('style')
<h3>Business Details</h3>
<fieldset>
    {{-- @if ($errors->any())
        {{ implode('', $errors->all('<div>:message</div>')) }}
    @endif --}}
    <form action="{{ route('registration.submit.step3') }}" enctype="multipart/form-data" method="post">
        @csrf

        <div class="panel-body">

            <div class="row">

                <h4 class="title">General</h4>
                <hr />

                <div class="form-group">
                    <label class="col-sm-4 col-md-4 control-label">Category <span class="required">*
                        </span> : </label>
                    <div class="col-sm-8 col-md-8">
                        <select name="category_id" id="category_id" class="form-control " required>
                            <option value="">Select category</option>
                            @if (!$categories->isEmpty())
                                @foreach ($categories as $category)
                                    <option {{ isSelected(old('category_id'), $category->id) }}
                                        value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            @endif
                        </select>
                        @if ($errors->has('category_id'))
                            <p style="color:red;">{{ $errors->first('category_id') }}</p>
                        @endif
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-4 col-md-4 control-label">Sub category <span class="required">*
                        </span> : </label>
                    <div class="col-sm-8 col-md-8">
                        <select name="sub_category_ids[]" id="sub_category_ids" class="form-control "
                            data-live-search="true" required>
                            <option value="">First select category</option>
                        </select>
                        @if ($errors->has('sub_category_ids'))
                            <p style="color:red;">{{ $errors->first('sub_category_ids') }}</p>
                        @endif
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-4 col-md-4 control-label">Business Name <span class="required">* </span>
                        :</label>
                    <div class="col-sm-8 col-md-8">
                        <input type="text" class="form-control " placeholder="Business Name" name="name"
                            id="name" value="{{ old('name') }}" required>
                        @if ($errors->has('name'))
                            <p style="color:red;">{{ $errors->first('name') }}</p>
                        @endif
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-4 col-md-4 control-label">Email id <span class="required">*
                        </span> :</label>
                    <div class="col-sm-8 col-md-8 emailDiv">
                        <input type="email" class="form-control email email-unique" id="email" data-field="email"
                            data-table="businesses" placeholder="Email Address" name="email"
                            value="{{ old('email') ?? (session()->get('registration_step1')['email'] ?? '') }}"
                            required>
                        @if ($errors->has('email'))
                            <p style="color:red;">{{ $errors->first('email') }}</p>
                        @endif
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-4 col-md-4 control-label">Phone <span class="required">*
                        </span> :</label>
                    <div class="col-sm-8 col-md-8">
                        <input type="text" class="form-control  phone" placeholder="444-444-4444" minlength="10"
                            maxlength="12" name="phone" id="phone"
                            value="{{ old('phone') ?? (session()->get('registration_step1')['phone'] ?? '') }}"
                            required>
                        @if ($errors->has('phone'))
                            <p style="color:red;">{{ $errors->first('phone') }}</p>
                        @endif
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-4 col-md-4 control-label">Website <span class="required">*
                        </span> :</label>
                    <div class="col-sm-8 col-md-8 websiteDiv">
                        <input type="text" class="form-control" placeholder="Website(www.google.com)"
                            name="website" id="website" value="{{ old('website') }}" required>
                        @if ($errors->has('website'))
                            <p style="color:red;">{{ $errors->first('website') }}</p>
                        @endif
                    </div>
                </div>

                <div class="row">
                    <label class="col-sm-4 col-md-2 control-label">Description <span class="required">*
                        </span> :</label>
                    <div class="col-sm-8 col-md-10">
                        <textarea class="form-control editor" placeholder="Description" name="description" id="description">{{ old('description') }}</textarea>
                        @if ($errors->has('description'))
                            <p style="color:red;">{{ $errors->first('description') }}</p>
                        @endif
                    </div>
                </div>

            </div>

            <h4 class="title">Location</h4>
            <hr />

            <div class="row">

                <div class="form-group">
                    <label class="col-sm-4 col-md-4 control-label">Country <span class="required">*
                        </span> : </label>
                    <div class="col-sm-8 col-md-8">
                        @php
                            $country_id = session()->get('registration_step1')['country_id'];
                            $country = \App\Models\Country::find($country_id);
                        @endphp
                        <select class="form-control" name="country_id">
                            <option value="{{ $country_id }}">
                                {{ $country->name }}</option>
                        </select>
                        @if ($errors->has('country_id'))
                            <p style="color:red;">{{ $errors->first('country_id') }}</p>
                        @endif
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-4 col-md-4 control-label">Province <span class="required">*
                        </span> : </label>
                    <div class="col-sm-8 col-md-8">

                        @php
                            $province_id = session()->get('registration_step1')['province_id'];
                            $province = \App\Models\Province::find($province_id);

                            // dd($province->name);

                        @endphp

                        {{-- {{ dd($province->name) }} --}}
                        <select class="form-control" name="province_id">
                            <option value="{{ $province_id }}">{{ $province->name }}
                            </option>
                        </select>
                        @if ($errors->has('province_id'))
                            <p style="color:red;">{{ $errors->first('province_id') }}</p>
                        @endif
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-4 col-md-4 control-label">City <span class="required">*
                        </span> : </label>
                    <div class="col-sm-8 col-md-8">
                        @php
                            $city_id = session()->get('registration_step1')['city_id'];
                            $city = \App\Models\City::find($city_id);
                        @endphp
                        <select class="form-control" name="city_id">
                            <option value="{{ $city_id }}">{{ $city->name }}
                            </option>
                        </select>
                        @if ($errors->has('city_id'))
                            <p style="color:red;">{{ $errors->first('city_id') }}</p>
                        @endif
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-4 col-md-4 control-label">Postal Code <span class="required">* </span>
                        :</label>
                    <div class="col-sm-8 col-md-8 codeDiv">
                        <input type="text" class="form-control alphanumeric code" placeholder="Postal Code"
                            name="postcode"
                            value="{{ old('postcode') ?? (session()->get('registration_step1')['postcode'] ?? '') }}"
                            minlength="6" maxlength="7" id="postcode" required>
                        @if ($errors->has('postcode'))
                            <p style="color:red;">{{ $errors->first('postcode') }}</p>
                        @endif
                    </div>
                </div>

                <div class="row">
                    <label class="col-sm-4 col-md-2 control-label">Business Address <span class="required">*
                        </span> :</label>
                    <div class="col-sm-8 col-md-10">
                        <input class="form-control " placeholder="Address" name="address" id="address" required
                            value="{{ old('address') ?? (session()->get('registration_step1')['address'] ?? '') }}">
                        <input type="hidden" id="place_lat" name="lat"
                            value="{{ old('lat') ?? (session()->get('registration_step1')['lat'] ?? '') }}">
                        <input type="hidden" id="place_lng" name="lng"
                            value="{{ old('lng') ?? (session()->get('registration_step1')['lng'] ?? '') }}">
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
                </div>

                <div id="map-canvas" style="height:200px;width:96%;margin:20px auto;"></div>

            </div>

            <div class="row">

                <h4 class="title">Opening Hours</h4>
                <hr />

                @foreach (DAYS as $key => $day)
                    <div class="form-group">
                        <label class="col-sm-4 col-md-4 control-label">Day <span class="required">*
                            </span> :</label>
                        <div class="col-sm-8 col-md-8">
                            <input type="text" class="form-control" name="opening_days[]"
                                value="{{ $day }}" readonly required>
                        </div>
                    </div>

                    <div class="form-group openinghour_item">
                        <label class="col-sm-4 col-md-4 control-label">Opening Hour <span class="required">*
                            </span> :</label>

                        <div class="col-md-2 ml-10">
                            <select class="form-control open_or_closed" name=open_or_closed[]>
                                <option value="Open">Open</option>
                                <option @if ($key == 5 || $key == 6) selected @endif value="Closed">
                                    Closed
                                </option>
                            </select>
                        </div>

                        @php
                            $hide_style = '';
                            $open_from_to_hours = '11:00 am - 7:00 pm';
                            if ($key == 5 || $key == 6):
                                $open_from_to_hours = 'Closed';
                                $hide_style = 'style="display:none;"';
                            endif;
                        @endphp

                        <div class="col-md-2 ml-10 " {!! $hide_style !!}>
                            <select class="form-control opening_from_a_day">
                                <option value="">From</option>
                                @for ($i = 1; $i <= 12; $i++)
                                    <option {{ $i == 11 ? 'selected' : '' }}>{{ $i }}:00 am</option>
                                @endfor
                                @for ($i = 1; $i <= 12; $i++)
                                    <option>{{ $i }}:00 pm</option>
                                @endfor
                            </select>
                        </div>
                        <div class="col-md-2 ml-10" {!! $hide_style !!}>
                            <select class="form-control opening_to_a_day">
                                <option value="">To</option>
                                @for ($i = 1; $i <= 12; $i++)
                                    <option>{{ $i }}:00 am</option>
                                @endfor
                                @for ($i = 1; $i <= 12; $i++)
                                    <option {{ $i == 7 ? 'selected' : '' }}>{{ $i }}:00 pm</option>
                                @endfor
                            </select>
                        </div>
                        <input type="hidden" class="form-control opening_hour_per_day" name="opening_hour_timing[]"
                            value="{{ $open_from_to_hours }}" required>

                        <input type="hidden" class="form-control opening_from_per_day" name="opening_from_timing[]"
                            value="11:00 am" required>

                        <input type="hidden" class="form-control opening_to_per_day" name="opening_to_timing[]"
                            value="7:00 pm" required>
                    </div>
                @endforeach
            </div>

            <div class="row primium_pack_field_only">

                <h4 class="title">Social Media</h4>
                <hr />

                <div class="w-100 d-md-flex social_lnk_cmpnt">
                    <div class="form-group social_network">
                        <label class="col-sm-4 col-md-4 control-label">Social Network<span class="required">
                            </span> :</label>
                        <div class="col-sm-8 col-md-8">
                            <select name="social_names[]" class="form-control">
                                <option value="">select</option>
                                @foreach (SOCIAL_LIST as $value)
                                    <option value="{{ $value['name'] }}">{{ $value['name'] }}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('social_names'))
                                <p style="color:red;">{{ $errors->first('social_names') }}</p>
                            @endif
                        </div>
                    </div>

                    <div class="form-group social_url social_append">
                        <label class="col-sm-3 col-md-3 control-label">Url<span class="required">
                            </span> :</label>
                        <div class="col-sm-8 col-md-8 websiteDiv">
                            <input type="text" class="form-control  website business_social"
                                placeholder="Enter URL(www.google.com)" name="social_urls[]" value="">
                            @if ($errors->has('social_urls'))
                                <p style="color:red;">{{ $errors->first('social_urls') }}</p>
                            @endif
                        </div>
                        <div class="col-md-1">
                            <button type="button" class="btn btn-danger social_item_remove">X</button>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-4 col-md-4 control-label"></label>
                    <div class="col-sm-8 col-md-8">
                        <button type="button" class="btn btn-round btn-default" id="social_add_more">+ Add
                            more</button>
                        <button type="button" class="btn btn-round btn-default" id="social_remove">- Remove</button>
                    </div>
                </div>

            </div>

            <div class="row primium_pack_field_only">
                <h4 class="title">Other Details</h4>
                <hr />

                <div class="form-group col-md-6 ">
                    <label class="col-sm-4 col-md-4 control-label">Order online <span class="required">*
                        </span> :</label>

                    <div class="col-sm-8 col-md-8">
                        <select class="form-control " name="online_order" id="online_order" required>
                            <option value="">Select</option>
                            <option {{ isSelected(old('online_order'), '1') }} value="1">Yes</option>
                            <option {{ isSelected(old('online_order'), '0') }} value="0">No</option>
                        </select>
                        @if ($errors->has('online_order'))
                            <p style="color:red;">{{ $errors->first('online_order') }}</p>
                        @endif
                    </div>

                </div>

                <div class="form-group col-md-6 oldiv ">

                    <label class="col-sm-4 col-md-4 control-label">Order Online Link <span class="required">*
                        </span> :</label>

                    <div class="col-sm-8 col-md-8">
                        <input class="form-control " type="text" name="online_order_link" id="online_order_link"
                            value="{{ old('online_order_link') }}" />
                        @if ($errors->has('online_order_link'))
                            <p style="color:red;">{{ $errors->first('online_order_link') }}</p>
                        @endif
                    </div>

                </div>

                <div class="form-group ">
                    <label class="col-sm-4 col-md-4 control-label ">Languages <span class="required">*
                        </span> : </label>
                    <div class="col-sm-8 col-md-8">
                        <select name="languages[]" id="languages" class="form-control multiselect"
                            data-live-search="true">
                            @if (!$languages->isEmpty())
                                @foreach ($languages as $language)
                                    <option {{ isSelected(old('languages'), $language->id) }}
                                        value="{{ $language->id }}">{{ $language->name }}</option>
                                @endforeach
                            @endif
                        </select>
                        @if ($errors->has('languages'))
                            <p style="color:red;">{{ $errors->first('languages') }}</p>
                        @endif
                    </div>
                </div>

                <div class="form-group ">
                    <label class="col-sm-4 col-md-4 control-label">Payment methods: <span class="required">
                        </span> : </label>
                    <div class="col-sm-8 col-md-8">
                        <select class="form-control multiselect" id="payment_methods" name="payment_methods[]"
                            data-live-search="true">
                            @foreach ($paymentMethods as $paymentMethod)
                                <option {{ isSelected(old('payment_methods'), $paymentMethod->id) }}
                                    value="{{ $paymentMethod->id }}">{{ $paymentMethod->name }}</option>
                            @endforeach
                        </select>
                        @if ($errors->has('payment_methods'))
                            <p style="color:red;">{{ $errors->first('payment_methods') }}</p>
                        @endif
                    </div>
                </div>

                <div class="form-group video_link ">
                    <label class="col-sm-4 col-md-4 control-label">Video Link:<span class="required">
                        </span> </label>
                    <div class="col-sm-8 col-md-8">
                        <input type="text" class="form-control " name="video" id="video"
                            value="{{ old('video') }}">
                        @if ($errors->has('video'))
                            <p style="color:red;">{{ $errors->first('video') }}</p>
                        @endif
                    </div>
                </div>

                <div class="row ">
                    <label class="col-sm-4 col-md-2 control-label">Area Of Practice:<span class="required">
                        </span> :</label>
                    <div class="col-sm-8 col-md-10">
                        <textarea class="form-control  editor" placeholder="Area Of Practice" name="area_of_practice" id="area_of_practice">{{ old('area_of_practice') }}</textarea>
                        @if ($errors->has('area_of_practice'))
                            <p style="color:red;">{{ $errors->first('area_of_practice') }}</p>
                        @endif
                    </div>
                </div>

                <div class="row mt-20">
                    <label class="col-sm-4 col-md-2 control-label">Product and Services:<span class="required">
                        </span> :</label>
                    <div class="col-sm-8 col-md-10">
                        <textarea class="form-control editor" placeholder="Product and Services" name="product_and_service"
                            id="product_and_service">{{ old('product_and_service') }}</textarea>
                        @if ($errors->has('product_and_service'))
                            <p style="color:red;">{{ $errors->first('product_and_service') }}</p>
                        @endif
                    </div>
                </div>
                <div class="row mt-20">
                    <label class="col-sm-4 col-md-2 control-label">Specialization<span class="required">
                        </span> :</label>
                    <div class="col-sm-8 col-md-10">
                        <textarea class="form-control  editor" placeholder="Specialization" name="specialization" id="specialization">{{ old('specialization') }}</textarea>
                        @if ($errors->has('specialization'))
                            <p style="color:red;">{{ $errors->first('specialization') }}</p>
                        @endif
                    </div>
                </div>

            </div>

            <h4 class="title">Image</h4>
            <hr />

            <div class="row">
                <div class="form-group ">
                    <label class="col-sm-4 col-md-4 control-label">Thumbnail image <span class="required">
                        </span> :</label>
                    <div class="col-sm-8 col-md-8 image-div">
                        <input type="file" class="form-control " name="image" id="image" accept="image/*"
                            data-id="image-preview">
                        (Type: jpeg,jpg,png only)
                        <img id="image-preview" src="https://via.placeholder.com/120x150?text=thumbnail"
                            class="file-image-preview" />
                        @if ($errors->has('image'))
                            <p style="color:red;">{{ $errors->first('image') }}</p>
                        @endif
                    </div>
                </div>
            </div>

        </div>
        <div class="row">
            <div class="col-md-12 text-center mt-10">
                <label class="checkContainer">
                    <input type="checkbox" class="checkbox" required value="accepted" name="termsAndCondition"
                        id="termsAndCondition">
                    Terms & condition
                </label>
            </div>
        </div>

        <input type="hidden" id="package_id" name="package_id" value="{{ session()->get('package_id') ?? '' }}">

        <input type="hidden" id="register_button_name" value="register_button_step3" />
        <input style="display:none;" type="submit" id="register_button_step3" value="" />
        <input type="hidden" name="table_name" value="business_temps" />
    </form>

</fieldset>
@push('scripts')
    <script
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCZuRJggt3Hg37Vrl5EeL9j9FREsD7SBo8&libraries=places&callback=initMap&v=weekly"
        defer></script>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/4.9.2/tinymce.min.js"></script>
    <script>
        $(document).ready(function() {

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


            $('.multiselect').attr('multiple', 'multiple');
            $('.multiselect option').prop('selected', false);
            $('.multiselect').multiselect({
                numberDisplayed: 1,
            });

            package_id = $("#package_id").val();
            if (package_id == "Free Pack") {

                $(".primium_pack_field_only").hide();
            } else if (package_id == "Premium Pack") {

                $(".primium_pack_field_only").show();

            }

            $("#online_order").change(function(e) {
                e.preventDefault();

                if ($(this).val() == "1") {
                    $(".oldiv").css("display", "flex");
                    $("#online_order_link").prop("required", true);
                } else {
                    $(".oldiv").css("display", "none");
                    $("#online_order_link").prop("required", false);
                }

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

            $(".btn-next").click(function(e) {
                e.preventDefault();
                btn = $("#register_button_name").val();
                result = step3_check();
                if (result == false) {
                    return false;
                }
                $('#' + btn).click();
            });

        });

        $(document).on("click", "#social_add_more", function() {
            $(".social_lnk_cmpnt:last").after(
                '<div class="w-100 d-md-flex social_lnk_cmpnt"><div class="form-group social_network"><label class="col-sm-4 col-md-4 control-label">Social Network<span class="required"></span> :</label><div class="col-sm-8 col-md-8"><select name="social_names[]" class="form-control business_social" required><option value="">select</option>@foreach (SOCIAL_LIST as $value)<option value="{{ $value['name'] }}">{{ $value['name'] }}</option>@endforeach</select></div></div><div class="form-group social_url social_append"><label class="col-sm-3 col-md-3 control-label">Url<span class="required"></span> :</label><div class="col-sm-8 col-md-8 websiteDiv"><input type="text" class="form-control website business_social" placeholder="Enter URL(www.google.com)"name="social_urls[]"  value="" required></div><div class="col-md-1"><button type="button" class="btn btn-danger social_item_remove">X</button></div></div></div>'
            );
        });
        $(document).on("click", ".social_item_remove", function(event) {
            $(this).parent().closest(".social_lnk_cmpnt").remove();
        });
        $(document).on("click", "#social_remove", function() {
            $(".social_url").not(':first').last().remove();
            $(".social_network").not(':first').last().remove();
        });

        $(document).on('change', '.image-div input[type=file]', function(e) {
            e.preventDefault();
            readURL(this);
        });

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

        function step3_check() {

            $(".step3-error").remove();
            error = 0;

            if ($("#sub_category_ids").val() == "") {
                $("#sub_category_ids").parent('div').append(
                    '<div style="color:red" class="step3-error">This field is required</div>');
                error++;
            }

            if (package_id == "1") {
                if ($("#languages").val() == "") {
                    $("#languages").parent('div').append(
                        '<div style="color:red" class="step3-error">This field is required</div>');
                    error++;
                }
            }

            if (error > 0) {
                return false;
            }
            return true;
        }
    </script>

    <script>
        var map = null;
        var marker;
        let place_lat = parseFloat($('#place_lat').val()) || 43.651070;
        let place_lng = parseFloat($('#place_lng').val()) || -79.347015;

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

                $('#address').val(place.formatted_address);
                $('#place_lat').val(place.geometry.location.lat());
                $('#place_lng').val(place.geometry.location.lng());
                // $('#postcode').val(postcode);

            });
        }

        function initMap() {
            var mapOptions = {
                center: new google.maps.LatLng(0, 0),
                zoom: 1,
                mapTypeId: google.maps.MapTypeId.ROADMAP
            };
            map = new google.maps.Map(document.getElementById("map-canvas"), mapOptions);
            callback();
        }
    </script>
@endpush
