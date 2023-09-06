@extends('Backend.Admin.Layout.app')

@section('main')

    <form action="{{ route('admin.subCategory.update',$subCategory) }}" enctype="multipart/form-data" method="post">
        @csrf
        @method("put")
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_content row">

                    <div class="form-group col-md-4">
                        <label for="name">Category:</label>
                        <select class="form-control" name="category_id">
                            <option value="">Select Category</option>
                            @foreach($categories as $category)
                                <option
                                {{isSelected($category->id, $subCategory->category_id)}}
                                value="{{$category->id}}">{{$category->name}}</option>
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
                        <input class="form-control" type="text" name="name" value="{{ $subCategory->name }}" required />
                        @if ($errors->has('name'))
                            <p style="color:red;">{{ $errors->first('name') }}</p>
                        @endif
                    </div>

                    <div class="form-group col-md-8">
                    </div>

                    <button type="submit" class="btn btn-primary mt-20">Update</button>
                </div>
            </div>
        </div>
    </form>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $(".module-title").text("Edit Sub Category");
        });
    </script>
@endpush
