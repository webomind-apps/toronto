(function($) {
    'use strict';
    let base_url = $("#base_url").val();
    $(document).on("click", ".country_edit", function() {
        let country_id = $(this).attr('data-id');
        let country_name = $(this).attr('data-name');
        // let country_slug = $(this).attr('data-slug');

        $('#submit_add_country').hide();
        $('#submit_edit_country').show();
        $('#add_country_method').val('PUT');
        $('#country_id').val(country_id);
        $('#country_name').val(country_name);
        // $('#country_slug').val(country_slug);

        $('#modal_add_country').modal('show');
    });

    $(document).on("click", ".country_delete", function() {
        if (confirm('Are you sure? The country that deleted can not restore!')) {
            $(this).parent().submit();
        }
    });

    $(document).on("click", "#btn_add_country", function() {
        $('#submit_add_country').show();
        $('#submit_edit_country').hide();
        $('#add_country_method').val('POST');
        $('#modal_add_country').modal('show');
    });


    $(document).on("change", ".country_status", function() {
        let country_id = $(this).attr('data-id');
        let status = $(this).is(':checked');

        let data_resp = callAPI({
            url: base_url + "/api/country/status",
            method: "put",
            body: {
                "country_id": country_id,
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