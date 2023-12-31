@extends('Backend.Admin.Layout.app')

@section('main')

    <form action="{{ route('admin.province.store') }}" enctype="multipart/form-data" method="post">
        @csrf
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_content row">

                    <div class="form-group col-md-4">
                        <label for="name">Country:</label>
                        <select class="form-control" name="country_id">
                            <option value="">Select Country</option>
                            @foreach($countries as $country)
                                <option
                                    {{isSelected(old("country_id"), $country->id)}}
                                    value="{{$country->id}}">{{$country->name}}</option>
                            @endforeach
                        </select>
                        @if ($errors->has('country_id'))
                            <p style="color:red;">{{ $errors->first('country_id') }}</p>
                        @endif
                    </div>

                    <div class="form-group col-md-8">
                    </div>

                    <div class="form-group col-md-4">
                        <label for="name">Name: *</label>
                        <input class="form-control" type="text" name="name" value="{{ old('name') }}" required />
                        @if ($errors->has('name'))
                            <p style="color:red;">{{ $errors->first('name') }}</p>
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
            $(".module-title").text("Add Country");
        });
    </script>
@endpush
