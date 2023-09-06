@extends('Backend.Admin.Layout.app')

@section('main')

    <form action="{{ route('admin.footerContent.store') }}" enctype="multipart/form-data" method="post">
        @csrf
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_content row">
                    <div class="form-group col-md-12">
                        <label for="name">Name: *</label>
                        <textarea type="text" class="form-control editor" name="content"
                            rows="6">{!! old('content') !!}</textarea>
                        @if ($errors->has('content'))
                            <p style="color:red;">{{ $errors->first('content') }}</p>
                        @endif
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
            $(".module-title").text("Footer Content");

            tinymce.init({

                selector: '.editor', // change this value according to your HTML
                themes: "modern",
                menubar: false,
                statusbar: false,
                height: 450,
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
        });
    </script>
@endpush
