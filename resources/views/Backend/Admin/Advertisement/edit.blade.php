@extends('Backend.Admin.Layout.app')

@section('main')

    <form action="{{ route('admin.advertisement.update',$advertisement) }}" enctype="multipart/form-data" method="post">
        @csrf
        @method("put")
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_content row">

                    <div class="form-group col-md-6 ">
                        <label for="name">Business: *</label>
                        <select name="business_id" id="business_id" title="" class="form-control" required>
                            <option>Select Business</option>
                            @foreach ($businesses as $business)
                                <option
                                    {{isSelected(old('business_id')??$advertisement->business_id,$business->id)}}
                                    value="{{ $business->id }}">{{ $business->name }}</option>
                            @endforeach
                        </select>
                        @if ($errors->has('business_id'))
                            <p style="color:red;">{{ $errors->first('business_id') }}</p>
                        @endif
                    </div>

                    <div class="form-group col-md-6 ">
                        <label for="name">Categories: *</label>
                        <select name="category_ids[]" id="category_ids" title="" class="form-control chosen-select" multiple data-live-search="true" required>
                            <option>Select Categories</option>
                            @foreach ($categories as $category)
                                @php
                                $selected="";
                                    foreach($advertisement->categories as $ad_category){
                                        if($category->id == $ad_category->category_id){
                                            $selected="selected";
                                            break;
                                        }
                                    }
                                @endphp
                                <option
                                {{$selected}}
                                 value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                        @if ($errors->has('category_ids'))
                            <p style="color:red;">{{ $errors->first('category_ids') }}</p>
                        @endif
                    </div>

                    <div class="form-group col-md-6 ">
                        <label for="name">Cities: *</label>
                        <select name="city_ids[]" id="city_ids" title="" class="form-control chosen-select" multiple data-live-search="true" required required>
                            <option>Select Cities</option>
                            @foreach ($cities as $city)
                            @php
                            $selected="";
                                foreach($advertisement->cities as $ad_city){
                                    if($city->id == $ad_city->city_id){
                                        $selected="selected";
                                        break;
                                    }
                                }
                            @endphp
                                <option
                                {{$selected}}
                                value="{{ $city->id }}">{{ $city->name }}</option>
                            @endforeach
                        </select>
                        @if ($errors->has('city_ids'))
                            <p style="color:red;">{{ $errors->first('city_ids') }}</p>
                        @endif
                    </div>

                    <div class="form-group col-md-6 ">
                        <label for="name">Price: *</label>
                        <input type="text" class="form-control" id="price" name="price" value="{{old("price")??$advertisement->price}}" placeholder="Price"
                            autocomplete="off" required>
                        @if ($errors->has('price'))
                            <p style="color:red;">{{ $errors->first('price') }}</p>
                        @endif
                    </div>

                    <div class="form-group col-md-6 ">
                        <label for="name">Link(www.google.com) *: </label>
                        <input type="text" class="form-control post_title website" id="link" name="link" value="{{old("link")??$advertisement->link}}"
                            placeholder="Add Link" autocomplete="off" required>
                        @if ($errors->has('link'))
                            <p style="color:red;">{{ $errors->first('link') }}</p>
                        @endif
                    </div>

                    <div class="form-group col-md-6">
                        <label for="name">Expired Date *</label>
                        <input type="date" title="Expired Date" class="form-control" id="expired_date" name="expired_date"
                            value="{{old("expired_date")??$advertisement->expired_date}}" placeholder="Expired Date" autocomplete="off" required>
                        @if ($errors->has('expired_date'))
                            <p style="color:red;">{{ $errors->first('expired_date') }}</p>
                        @endif
                    </div>

                    <div class="form-group col-md-6 image-div">
                        <label for="name">Image (width:300, height:300 or 600): *</label>
                        <input type="file" class="form-control" id="image" name="image" accept="image/*"
                            data-id="image-preview">
                        @if ($errors->has('image'))
                            <p style="color:red;">{{ $errors->first('image') }}</p>
                        @endif
                        <img id="image-preview" src="{{ asset('storage/'.$advertisement->image) }}" class="file-image-preview"/>
                    </div>

                    <div class="form-group col-md-6 "></div>
                    <button type="submit" class="btn btn-primary mt-20">Submit</button>
                </div>
            </div>
        </div>
        <input type="hidden" name="file_status" id="file_status" value="0">
    </form>

@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $(".module-title").text("Add Advertisement");

            var _URL = window.URL || window.webkitURL;
            file_upload_error = false;

            $(document).on('change', '.image-div input[type=file]', function(e) {
                e.preventDefault();
                var file, img;
                if ((file = this.files[0])) {
                    img = new Image();
                    var objectUrl = _URL.createObjectURL(file);
                    img.onload = function() {
                        file_upload_error = false;
                        if ((this.height != 300 && this.height != 600) || this.width != 300) {
                            file_upload_error = true;
                            alert("Please upload the image only 300*300 or 300*600");
                            return;
                        }
                        if(this.height == 300){
                            $("#file_status").val(0);
                        }else if(this.height == 600){
                            $("#file_status").val(1);
                        }
                        _URL.revokeObjectURL(objectUrl);
                    };
                    img.src = objectUrl;
                    readURL(this);
                }

            });


            var _URL = window.URL || window.webkitURL;
            file_upload_error = false;
            $("#post_thumb").change(function(e) {
                var file, img;
                if ((file = this.files[0])) {
                    img = new Image();
                    var objectUrl = _URL.createObjectURL(file);
                    img.onload = function() {
                        // alert(this.width + " " + this.height);
                        file_upload_error = false;
                        if ((this.height != 300 && this.height != 600) || this.width != 300) {
                            file_upload_error = true;
                            alert("Please upload the image only 300*300 or 300*600");
                            return;
                        }
                        _URL.revokeObjectURL(objectUrl);
                    };
                    img.src = objectUrl;
                    readURL(this);
                }
            });

            $("form").submit(function(e) {

                if (file_upload_error == true) {
                    alert("Please upload the image only 300*300 or 300*600");
                    return false;
                }

            });

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
    </script>
@endpush
