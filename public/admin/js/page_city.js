(function($) {
    'use strict';
    let base_url = $("#base_url").val();
    $(document).on("click", ".city_edit", function() {
        let city_id = $(this).attr('data-id');
        let country = $(this).attr('data-country');
        let province = $(this).attr('data-province');
        let city_name = $(this).attr('data-name');
        $('#submit_add_city').hide();
        $('#submit_edit_city').show();
        $('#city_id').val(city_id);
        $('#city').val(city_name);
        $('#country').val(country);
        $('#province').val(province);

        $('#modal_add_city').modal('show');
    });

    $(document).on("click", ".city_delete", function() {
        if (confirm('Are you sure? The city that deleted can not restore!'))
            $(this).parent().submit();
    });

    $(document).on("click", "#btn_add_city", function() {
        let selected_country_id = $('#select_country_id').val();
        $('#submit_add_city').show();
        $('#submit_edit_city').hide();
        $('#country_id').val(selected_country_id);
        $('#modal_add_city').modal('show');
    });

    $(document).on("change", ".city_status", function() {
        let city_id = $(this).attr('data-id');
        let status = $(this).is(':checked');

        let data_resp = callAPI({
            url: base_url + "/api/city/status",
            method: "put",
            body: {
                "city_id": city_id,
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