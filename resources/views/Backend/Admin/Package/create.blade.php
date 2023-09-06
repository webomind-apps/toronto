@extends('Backend.Admin.Layout.app')

@section('main')

    <form action="{{ route('admin.package.store') }}" enctype="multipart/form-data" method="post">
        @csrf
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_content row">
                    <div class="form-group col-md-4">
                        <label for="name">Name: *</label>
                        <input class="form-control" type="text" name="name" value="{{ old('name') }}" required />
                        @if ($errors->has('name'))
                            <p style="color:red;">{{ $errors->first('name') }}</p>
                        @endif
                    </div>
                    <div class="form-group col-md-8">
                    </div>
                    <div class="form-group col-md-4">
                        <label for="name">Price:</label>
                        <input class="form-control decimal" data-digit="8" type="text" name="price" value="{{ old('price') }}" />
                        @if ($errors->has('price'))
                            <p style="color:red;">{{ $errors->first('price') }}</p>
                        @endif
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
            $(".module-title").text("Add Package");
        });
    </script>
@endpush
