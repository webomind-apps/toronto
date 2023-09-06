@extends('Backend.Admin.Layout.app')

@section('main')

    <form action="{{ route('admin.city.store') }}" enctype="multipart/form-data" method="post">
        @csrf
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_content row">

                    <div class="form-group col-md-4">
                        <label for="name">Country:</label>
                        <select class="form-control" name="country_id" id="country_id">
                            {{-- <option value="">Select Country</option> --}}
                            @foreach ($countries as $key => $country)
                                <option {{ $key == 0 ? 'selected' : '' }}
                                    {{ $country->id == old('country_id') ? 'selected' : '' }} value="{{ $country->id }}">
                                    {{ $country->name }}</option>
                            @endforeach
                        </select>
                        @if ($errors->has('country_id'))
                            <p style="color:red;">{{ $errors->first('country_id') }}</p>
                        @endif
                    </div>

                    <div class="form-group col-md-8">
                    </div>

                    <div class="form-group col-md-4">
                        <label for="name">Province:</label>
                        <select class="form-control" name="province_id" id="province_id">
                            <option value="">First Select Country</option>

                        </select>
                        @if ($errors->has('province_id'))
                            <p style="color:red;">{{ $errors->first('province_id') }}</p>
                        @endif
                    </div>

                    <div class="form-group col-md-8">
                    </div>

                    <div class="form-group col-md-4">
                        <label for="name">City: *</label>
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

            province_collection($("#country_id").val());
            $("#country_id").change(function(e) {
                province_collection($(this).val());
            });
        });

        function province_collection(country_id = null) {
            $.ajax({
                type: "get",
                url: "{{ route('common.province.collection') }}",
                data: {
                    "country_id": country_id,
                },
                dataType: "JSON",
                success: function(response) {
                    content = '<option value="">Select Province</option>';
                    for (i = 0; response.length > i; i++) {
                        content += '<option value="' + response[i].id + '">' + response[i].name + '</option>';
                    }
                    $("#province_id").html(content);
                }
            });
        }
    </script>
@endpush
