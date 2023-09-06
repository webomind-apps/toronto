@extends('Backend.Admin.Layout.app')

@section('main')

    <form action="{{ route('admin.headerBanner.update',$headerBanner) }}" enctype="multipart/form-data" method="post">
        @csrf
        @method("put")
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_content row">
                    <div class="form-group col-md-4 image-div">
                        <label for="name">Image: *(size width:1920px height:650px)</label>
                        <input class="form-control" type="file" name="image" value="{{ old('image') }}" data-id="image-preview" accept="image/*"
                            required />
                        @if ($errors->has('image'))
                            <p style="color:red;">{{ $errors->first('image') }}</p>
                        @endif
                        <img id="image-preview" src="{{ asset('storage/'.$headerBanner->image) }}" class="file-image-preview"/>
                    </div>
                    <div class="form-group col-md-8">
                    </div>
                    <button type="submit" class="btn btn-primary mt-20">Submit</button>
                </div>
            </div>
        </div>
    </form>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $(".module-title").text("Edit Header Banner");

            $(document).on('change', '.image-div input[type=file]', function (e) {
                e.preventDefault();
                readURL(this);
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
