<style>
    .container {
        max-width: 1325 !important;
    }
</style>
<h3>Select Advertising Packages</h3>
<div class="row">

    <div class="col-md-3 p-2">
        <div class="pack-box">
            <div class="pack-title blue-1 text-center">
                <h4>Free Listing</h4>
                <span class="price">$0.00</span>
            </div>

            <ul class="pack-options">
                <li>Business Name</li>
                <li>Website URL</li>
                <li>Telephone</li>
                <li>Fax</li>
                <li>Email</li>
                <li>Province</li>
                <li>City</li>
                <li>Category</li>
                <li>Sub Category</li>
                <li>Business Address </li>
                <li>Business Description</li>
                <li>Business Hours</li>
                <li>Map Location</li>
                <li>Add Reviews</li>
            </ul>

            <div class="text-center">
                <label class="checkContainer">
                    <input type="checkbox" class="checkbox" data-pack="2">
                    Select Package
                </label>
            </div>
        </div>
    </div>

    <div class="col-md-3 p-2">
        <div class="pack-box">
            <div class="pack-title text-center">
                <h4>Premium Listing</h4>
                <span class="price">${{$package->price??99}}</span>
            </div>
            <ul class="pack-options">
                <li>Business Name</li>
                <li>Business Logo</li>
                <li>Website URL</li>
                <li>Telephone</li>
                <li>Fax</li>
                <li>Email</li>
                <li>Business Address</li>
                <li>Business Description</li>
                <li>Category</li>
                <li>Sub Category</li>
                <li>Areas of Practice</li>
                <li>Products and Services</li>
                <li>Languages</li>
                <li>Business Hours</li>
                <li>Social Media Links</li>
                <li>Gallery</li>
                <li>Payment Methods</li>
                <li>Video Link</li>
                <li>Map Location</li>
                <li>Add Reviews</li>
            </ul>
            <div class="text-center">
                <label class="checkContainer">
                    <input type="checkbox" checked class="checkbox" data-pack="1">
                    Select Package
                </label>
            </div>
        </div>
    </div>

    <div class="col-md-3 p-2">

        <div class="pack-box">

            <div class="pack-title text-center">
                <h4>Banner</h4>
                <h4>Advertising</h4>
                <span class="price"></span>
            </div>

            <img src="{{asset('webo/images/300/300x300_5.jpg')}}" class="full-width"/>

            <div class="text-center mt-10">
                <label class="checkContainer">
                    <input type="checkbox" class="optional-checkbox" data-id="optional1" data-value="1">
                    Select Banner
                </label>
            </div>
        </div>

        <div class="pack-box">

            <div class="pack-title text-center">
                <h4>Banner</h4>
                <h4>Advertising</h4>
                <span class="price"></span>
            </div>

            <img src="{{asset('webo/images/300/300x600_5.jpg')}}" class="full-width"/>

            <div class="text-center mt-10">
                <label class="checkContainer">
                    <input type="checkbox" class="optional-checkbox" data-id="optional2" data-value="2">
                    Select Banner
                </label>
            </div>

        </div>

    </div>

    <div class="col-md-3">

        <div class="pack-box">

            <div class="pack-title text-center">
                <h4>Feature listing</h4>
                <h4>Advertising</h4>
                <span class="price"></span>
            </div>

            <img src="{{asset('webo/images/300/featured_banner.png')}}" class=""/>

            <div class="text-center mt-10">
                <label class="checkContainer">
                    <input type="checkbox" class="optional-checkbox" data-id="optional3" data-value="3">
                    Select Banner
                </label>
            </div>


        </div>

    </div>

</div>
<div class="row">
    @if ($errors->has('package_id'))
        <p style="color:red;">{{ $errors->first('package_id') }}</p>
    @endif
</div>

<form action="{{ route('registration.submit.step2') }}" id="step2_pack_form" method="post">
    @csrf
    <input type="hidden" name="package_id" id="package_id" value="1" required>
    <input type="hidden" id="register_button_name" value="register_button_step2"/>
    <input style="display:none;" type="submit" id="register_button_step2" value=""/>
</form>
@push('scripts')
    <script>
        $(document).ready(function() {

            $(".checkbox").change(function() {
                $(".checkbox").prop("checked", false);
                $(".checkbox").parent().closest(".pack-box").removeClass("package-select-active");
                $(this).parent().closest(".pack-box").addClass("package-select-active");
                $(this).prop("checked", true);
                $("#package_id").val($(this).attr("data-pack"))
            });

            $(".optional-checkbox").change(function() {
                id = $(this).attr("data-id");
                $(this).parent().closest(".pack-box").removeClass("package-select-active");
                if($(this).prop("checked")== true){
                    $(this).parent().closest(".pack-box").addClass("package-select-active");
                    value = $(this).attr("data-value");
                    $("#step2_pack_form").append('<input type="hidden" name="optional_featured[]" id="'+id+'" value="'+value+'">')
                }else{
                    $("#"+id).remove();
                }
            });

            $(".btn-next").click(function(e) {
                e.preventDefault();
                btn = $("#register_button_name").val();
                $('#' + btn).click();

            });

        });
    </script>
@endpush
