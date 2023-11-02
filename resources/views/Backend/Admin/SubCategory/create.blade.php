@extends('Backend.Admin.Layout.app')

@section('main')

    <form action="{{ route('admin.subCategory.store') }}" enctype="multipart/form-data" method="post">
        @csrf
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_content" id="multiple_row">
                    <div class="row align-items-end">
                        <div class="form-group col-md-4">
                            <label for="name">Category:</label>
                            <select class="form-control" name="category_id" required>
                                <option value="">Select Category</option>
                                @foreach ($categories as $category)
                                    <option {{ isSelected(old('category_id'), $category->id) }} value="{{ $category->id }}">
                                        {{ $category->name }}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('category_id'))
                                <p style="color:red;">{{ $errors->first('category_id') }}</p>
                            @endif
                        </div>
                        <div class="form-group col-md-8">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="name">Name: *</label>
                            <input class="form-control" type="text" name="name[]" value="{{ old('name') }}"
                                required />
                            @if ($errors->has('name'))
                                <p style="color:red;">{{ $errors->first('name') }}</p>
                            @endif
                        </div>
                        <div class="form-group col-md-2">
                            <button class="btn btn-success m-0" type="button" id="add_btn">+</button>
                        </div>

                        <div class="form-group col-md-6">
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary mt-20">Submit</button>
            </div>
        </div>
    </form>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $(".module-title").text("Add Sub Category");
        });
    </script>
    <script>
        $('#add_btn').click(() => {
            element =
                '<div class="parentDiv row align-items-end"><div class="form-group col-md-4"><label for="name">Name: *</label><input class="form-control" type="text" name="name[]" required /></div><div class="form-group col-md-2"><button class="child btn btn-danger m-0" type="button">-</button></div><div class="form-group col-md-6"></div></ div>'
            $('#multiple_row').append(element);
        });

        $('#multiple_row').on('click', '.child', function() {
            $(this).parent().parent().remove();
        });
    </script>
@endpush
