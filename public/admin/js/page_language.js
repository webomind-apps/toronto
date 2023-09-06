(function($) {
    'use strict';
    let base_url = $("#base_url").val();

    $(document).on("click", ".language_edit", function() {
        let language_id = $(this).attr('data-id');

        let language_name = $(this).attr('data-name');
        // let language_feature_title = $(this).attr('data-featuretitle');
        // let language_priority = $(this).attr('data-priority');
        // let language_is_feature = $(this).attr('data-isfeature');
        // // let language_feature_title = $(this).attr('data-featuretitle');
        // let language_color_code = $(this).attr('data-colorcode');
        // let language_icon_map_marker = $(this).attr('data-icon');
        // let seo_title = $(this).attr('data-seotitle');
        // let seo_description = $(this).attr('data-seodescription');

        $('#submit_add_language').hide();
        $('#submit_edit_language').show();
        $('#add_language_method').val('PUT');
        $('#language_id').val(language_id);
        $('#language_name').val(language_name);
        // $('#language_priority').val(language_priority);
        // $('#language_is_feature').val(language_is_feature);
        // $('#language_color_code').val(language_color_code);
        // $('#language_feature_title').val(language_feature_title);
        // $('#preview_icon').attr('src', `/uploads/${language_icon_map_marker}`);
        // $('#seo_title').val(seo_title);
        // $('#seo_description').val(seo_description);

        $('#modal_add_language').modal('show');
    });

    $(document).on("click", ".language_delete", function() {
        if (confirm('Are you sure? The language that deleted can not restore!')) {
            $(this).parent().submit();
        }
    });

    $(document).on("click", "#btn_add_language", function() {
        $('#submit_add_language').show();
        $('#submit_edit_language').hide();
        $('#add_language_method').val('POST');
        $('#modal_add_language').modal('show');
    });
    $(document).on("change", ".language_status", function() {
        let language_id = $(this).attr('data-id');
        let status = $(this).is(':checked');

        let data_resp = callAPI({
            url: base_url + "/api/language/status",
            method: "put",
            body: {
                "language_id": language_id,
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


    $('#language_name').keyup(function() {
        let language_name = $(this).val();

    });


})(jQuery);