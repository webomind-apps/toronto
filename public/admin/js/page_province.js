(function($) {
    'use strict';
    let base_url = $("#base_url").val();
    $(document).on("click", ".province_edit", function() {
        let province_id = $(this).attr('data-id');
        let province_name = $(this).attr('data-name');
        let province_country = $(this).attr('data-country');
        let province_tax = $(this).attr('data-tax');
        // let province_slug = $(this).attr('data-slug');
        $('#submit_add_province').hide();
        $('#submit_edit_province').show();
        $('#add_province_method').val('PUT');
        $('#province_id').val(province_id);
        $('#province_name').val(province_name);
        $('#province_country').val(province_country);
        $('#province_tax').val(province_tax);
        // $('#province_slug').val(province_slug);

        $('#modal_add_province').modal('show');
    });

    $(document).on("click", ".province_delete", function() {
        if (confirm('Are you sure? The province that deleted can not restore!')) {
            $(this).parent().submit();
        }
    });

    $(document).on("click", "#btn_add_province", function() {
        $('#submit_add_province').show();
        $('#submit_edit_province').hide();
        $('#add_province_method').val('POST');
        $('#modal_add_province').modal('show');
    });


    $(document).on("change", ".province_status", function() {
        let province_id = $(this).attr('data-id');
        let status = $(this).is(':checked');

        let data_resp = callAPI({
            url: base_url + "/api/province/status",
            method: "put",
            body: {
                "province_id": province_id,
                "status": status ? 1 : 0
            }
        });
        data_resp.then(res => {
            if (res.code === 200) {
                notify(res.message);
            } else {
                console.log(res);
                notify('Error!', 'error');
            }
        });
    });
})(jQuery);