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

                <div class="x_content d-flex justify-content-center">
                    <div class="col-lg-8 col-xs-12">
                        <form action="{{ route('admin.blog.store') }}" enctype="multipart/form-data" method="post">
                            @csrf
                            <div class="tab-content">
                                <div id="genaral">
                                    <p class="lead">Create Blog</p>

                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label for="name">Title: *</label>
                                            <input class="form-control" type="text" name="title" required />

                                            @if ($errors->has('title'))
                                                <p style="color:red;">{{ $errors->first('title') }}</p>
                                            @endif
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="name">Thumbnail: *</label>
                                            <input class="form-control" type="file" name="image" required />
                                            @if ($errors->has('file'))
                                                <p style="color:red;">{{ $errors->first('file') }}</p>
                                            @endif
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label for="description">Description: *</label>
                                            <textarea type="text" class="form-control editor" name="description" rows="6">{{ old('description') }}</textarea>
                                            @if ($errors->has('description'))
                                                <p style="color:red;">{{ $errors->first('description') }}</p>
                                            @endif
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label for="description">Meta Description:</label>
                                            <textarea type="text" class="form-control" name="meta_description" rows="6">{{ old('meta_description') }}</textarea>
                                            @if ($errors->has('meta_description'))
                                                <p style="color:red;">{{ $errors->first('meta_description') }}</p>
                                            @endif
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary mt-20">Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
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
        });
    </script>
    <script>
        $(document).ready(function() {
            $(".module-title").text("Create Blog");
        });
    </script>
@endpush
