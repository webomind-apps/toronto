@push('style')
    <style>
        .input-icons i {
            position: absolute;
            right: 10px;
        }

        .input-icons {
            /* width: 100%; */
            margin-bottom: 10px;
        }

        .icon {
            padding: 10px;
            min-width: 40px;
            margin-left: 21%;
        }

        @media screen and (max-width: 900px) {
            .icon {
                padding: 8px;
                margin-left: 75%;
            }
        }

        .required {
            color: red;
        }
    </style>
@endpush
<h3>Create Account</h3>
<fieldset>
    <form action="{{ route('registration.submit.step1') }}" method="post">
        @csrf
        <div class="panel-body row">
            <div class="form-group">
                <label class="col-sm-4 col-md-4 control-label">Email id <span class="required">*
                    </span> :</label>
                <div class="col-sm-8 col-md-8 emailDiv">
                    <input type="email" data-field="email" data-table="users" class="form-control email email-unique"
                        placeholder="Email Address" name="email" value="{{ old('email') }}" required>
                    @if ($errors->has('email'))
                        <p style="color:red;">{{ $errors->first('email') }}</p>
                    @endif
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-4 col-md-4 control-label">Phone<span class="required">*
                    </span> :</label>
                <div class="col-sm-8 col-md-8">
                    <input type="text" class="form-control phone" placeholder="444-444-4444" name="phone"
                        value="{{ old('phone') }}" id="step1_phone_number" minlength="10" maxlength="12" required>
                    @if ($errors->has('phone'))
                        <p style="color:red;">{{ $errors->first('phone') }}</p>
                    @endif
                </div>
            </div>
            <div class="form-group" style="position: relative;">
                <label class="col-sm-4 col-md-4 control-label">Password
                    <span class="required">*</span> :
                </label>
                <div class="col-sm-8 col-md-8 input-icons">
                    <i class="fa fa-eye icon password-eye"></i>
                    <input type="password" class="form-control input-field" id="pass" placeholder="Password"
                        name="password" value="{{ old('password') }}" required>
                    @if ($errors->has('password'))
                        <p style="color:red;">{{ $errors->first('password') }}</p>
                    @endif
                </div>
            </div>
            <div class="form-group" style="position: relative;">
                <label class="col-sm-4 col-md-4 control-label">Confirm <span class="required">*
                    </span> :</label>
                <div class="col-sm-8 col-md-8 input-icons">
                    <i class="fa fa-eye icon password-eye"></i>
                    <input type="password" class="form-control input-field" id="passConfirmation"
                        placeholder="Confirm Password" name="password_confirmation"
                        value="{{ old('password_confirmation') }}" required>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-4 col-md-4 control-label">First Name <span class="required">* </span>
                    :</label>
                <div class="col-sm-8 col-md-8">
                    <input type="text" class="form-control name" placeholder="First Name" name="fname"
                        value="{{ old('fname') }}" id="step1_first_name" required>
                    {{-- @error('fname')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror --}}
                    @if ($errors->has('fname'))
                        <p style="color:red;">{{ $errors->first('fname') }}</p>
                    @endif
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-4 col-md-4 control-label">Last Name <span class="required">* </span>
                    :</label>
                <div class="col-sm-8 col-md-8">
                    <input type="text" class="form-control name" placeholder="Last Name" name="lname"
                        value="{{ old('lname') }}" id="step1_last_name" required>
                    @if ($errors->has('lname'))
                        <p style="color:red;">{{ $errors->first('lname') }}</p>
                    @endif
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-4 col-md-4 control-label">Address <span class="required">*
                    </span> :</label>
                <div class="col-sm-8 col-md-8">
                    <input class="form-control " placeholder="Address" name="address" id="admin_address"
                        value="{{ old('address') }}" autocomplete="off" required>

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
                <input type="hidden" id="place_lat" name="lat" value="">
                <input type="hidden" id="place_lng" name="lng" value="">
            </div>

            <div class="form-group">
                <label class="col-sm-4 col-md-4 control-label">Country <span class="required">*
                    </span> :</label>
                <div class="col-sm-8 col-md-8">
                    <select class="form-control" name="country_id" id="country_id" required>
                        @if (!$countries->isEmpty())
                            @foreach ($countries as $key => $country)
                                <option value="{{ $country->id }}"
                                    {{ isSelected(old('country_id'), $country->id) }}>
                                    {{ $country->name }}
                                </option>
                            @endforeach
                        @endif
                    </select>
                    @if ($errors->has('country_id'))
                        <p style="color:red;">{{ $errors->first('country_id') }}</p>
                    @endif
                </div>
            </div>

            <div id="map-canvas" style="height:200px;width:96%;margin:20px auto;"></div>

            <div class="form-group">
                <label class="col-sm-4 col-md-4 control-label">Province <span class="required">*
                    </span> :</label>
                <div class="col-sm-8 col-md-8">
                    <select class="form-control province" name="province_id" id="province_id" required>
                        <option value="">First select country</option>

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
                    <select class="form-control city" name="city_id" id="city_id" required>
                        <option value="">First select province</option>
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
                    <input type="text" class="form-control alphanumeric code" id="postcode"
                        placeholder="Postal Code" name="postcode" value="{{ old('postcode') }}" required
                        minlength="6" maxlength="7">

                    @if ($errors->has('postcode'))
                        <p style="color:red;">{{ $errors->first('postcode') }}</p>
                    @endif
                </div>
            </div>
        </div>
        <input type="hidden" id="register_button_name" value="register_button_step1" />
        <input style="display:none;" type="submit" id="register_button_step1" value="" />
    </form>
</fieldset>
@push('scripts')
    <script
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCZuRJggt3Hg37Vrl5EeL9j9FREsD7SBo8&libraries=places&callback=initMap&v=weekly"
        defer></script>


    <script>
        $(document).ready(function() {

            $("#passConfirmation").change(function(e) {
                $(this).parent('div').find('.conPassErr').remove();
                if ($("#pass").val() != $(this).val()) {
                    $(this).parent("div").append(
                        '<div style="color:red" class="conPassErr" >Password and confirmation password is wrong</div>'
                    );
                    $(this).val("");
                }
            });

            $(".btn-next").click(function(e) {
                e.preventDefault();
                btn = $("#register_button_name").val();
                $('#' + btn).click();

            });


        });

        function step2_check() {

            package_id = 4("#package_id").val();

            $(".step3-error").remove();
            error = 0;

            if ($("#sub_category_ids").val() == "") {
                $("#sub_category_ids").parent('div').append(
                    '<div style="color:red" class="step3-error">This field is required</div>');
                error++;
            }

            if (package_id == "1") {
                if ($("#business_languages").val() == "") {
                    $("#business_languages").parent('div').append(
                        '<div style="color:red" class="step3-error">This field is required</div>');
                    error++;
                }
            }
            return (error > 0) ? false : true;
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
            let input = document.getElementById('admin_address');
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
                let postcode;
                let locality;
                let province;
                for (const component of place.address_components) {
                    // @ts-ignore remove once typings fixed
                    const componentType = component.types[0];
                    switch (componentType) {
                        case "postal_code": {
                            postcode = component['long_name'];
                            $('#postcode').val(postcode);
                            break;
                        }
                        case "locality": {
                            locality = component['long_name'];
                            setTimeout(function() {
                                $('#city_id option:contains("' + locality + '")').prop('selected', true)
                            }, 1000);
                            break;
                        }
                        case "administrative_area_level_1": {
                            province = component['long_name'];
                            $('#province_id option:contains("' + province + '")').prop('selected', true).change();
                            // $('#province_id').val(province).change();
                            break;
                        }
                    }
                }
                console.log(postcode, locality, province);


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

                $('#admin_address').val(place.formatted_address);
                $('#place_lat').val(place.geometry.location.lat());
                $('#place_lng').val(place.geometry.location.lng());

                // $('#business_postal_code').val(postcode);
                console.log(place);
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
