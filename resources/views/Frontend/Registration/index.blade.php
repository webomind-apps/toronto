@extends('Frontend.Layout.app')
@push('style')
    <style>

    </style>
@endpush
@section('main')
    <section class="listing_section no-search package_page">
        <div class="container-fluid page-title">
            <div class="col-12 text-center">
                <h2>REGISTER YOUR BUSINESS</h2>
            </div>
        </div>
    </section>
    <section class="package_page register">
        <div class="container">
            <div class="row">
                @include('Frontend.Registration.header')
                {{-- @if ($errors->any())
                    {{ implode('', $errors->all('<div>:message</div>')) }}
                @endif --}}
                @csrf
                <div class="col-md-12">
                    <div class="tab-content">
                        @if (Route::currentRouteName() == 'registration.step1')
                            @include('Frontend.Registration.step1')
                        @elseif(Route::currentRouteName()=='registration.step2')
                            @include('Frontend.Registration.step2')
                        @elseif(Route::currentRouteName()=='registration.step3')
                            @include('Frontend.Registration.step3')
                        @elseif(Route::currentRouteName()=='registration.step4')
                            @include('Frontend.Registration.step4')
                        @endif
                    </div>
                    @if (Route::currentRouteName() != 'registration.step4')
                        <div class="stepButton text-center">
                            <button type="button" class="nextTab btn btn-success btn-next">Next</button>
                        </div>
                    @endif
                </div>

                <div class="clearfix"></div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {

            province_collection($("#country_id").val());

            $("#country_id").change(function(e) {
                e.preventDefault();
                country_id = $(this).val();
                if (country_id == "") {
                    $("#province_id").html('<option value="">First select country</option>');
                } else {
                    province_collection(country_id);
                }
            });

            $("#province_id").change(function(e) {
                e.preventDefault();
                province_id = $(this).val();
                if (province_id == "") {
                    $("#city_id").html('<option value="">First select province</option>');
                } else {
                    city_collection(province_id);
                }
            });

            $("#category_id").change(function(e) {
                e.preventDefault();
                category_id = $(this).val();

                if (category_id == "") {
                    $("#sub_category_ids").html('<option value="">First select category</option>');
                } else {
                    sub_category_collection(category_id);
                }

                setTimeout(function() {
                    $("#sub_category_ids").multiselect('destroy');
                    $('#sub_category_ids').attr('multiple', 'multiple');
                    $('#sub_category_ids option').prop('selected', false);
                    $("#sub_category_ids").multiselect({
                            numberDisplayed: 1,
                            allSelectedText: 'All',
                            includeSelectAllOption: true
                        })
                        .multiselect('selectAll', true)
                        .multiselect('updateButtonText')
                        .multiselect('rebuild');
                }, 2000);
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

        function city_collection(province_id = null) {
            $.ajax({
                type: "get",
                url: "{{ route('common.city.collection') }}",
                data: {
                    "province_id": province_id,
                },
                dataType: "JSON",
                success: function(response) {
                    content = '<option value="">Select City</option>';
                    for (i = 0; response.length > i; i++) {
                        content += '<option value="' + response[i].id + '">' + response[i].name + '</option>';
                    }
                    $("#city_id").html(content);
                }
            });
        }

        function sub_category_collection(category_id = null) {
            $.ajax({
                type: "get",
                url: "{{ route('common.subCategory.collection') }}",
                data: {
                    "category_id": category_id,
                },
                dataType: "JSON",
                success: function(response) {
                    // content = '<option value="" disabled>Select Sub Category</option>';
                    content = '';
                    for (i = 0; response.length > i; i++) {
                        content += '<option value="' + response[i].id + '">' + response[i].name + '</option>';
                    }
                    $("#sub_category_ids").html(content);
                }
            });
        }
    </script>
@endpush
