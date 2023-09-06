(function($) {
    'use strict';
    let base_url = $("#base_url").val();
    $(document).on("click", ".category_edit", function() {
        let category_id = $(this).attr('data-id');

        let category_name = $(this).attr('data-name');
        let category_feature_title = $(this).attr('data-featuretitle');
        let category_priority = $(this).attr('data-priority');
        let category_popular_priority = $(this).attr('data-popular-priority');
        let category_is_feature = $(this).attr('data-isfeature');
        // let category_feature_title = $(this).attr('data-featuretitle');
        let category_color_code = $(this).attr('data-colorcode');
        let category_icon_map_marker = $(this).attr('data-icon');
        let seo_title = $(this).attr('data-seotitle');
        let seo_description = $(this).attr('data-seodescription');

        $('#submit_add_category').hide();
        $('#submit_edit_category').show();
        $('#add_category_method').val('PUT');
        $('#category_id').val(category_id);
        $('#category_name').val(category_name);
        $('#category_priority').val(category_priority);
        $('#popular_priority').val(category_popular_priority);
        $('#category_is_feature').val(category_is_feature);
        $('#category_color_code').val(category_color_code);
        $('#category_feature_title').val(category_feature_title);
        $('#preview_icon').attr('src', `${base_url}/uploads/${category_icon_map_marker}`);
        $('#seo_title').val(seo_title);
        $('#seo_description').val(seo_description);

        $('#modal_add_category').modal('show');
    });

    $(document).on("click", ".category_delete", function() {
        if (confirm('Are you sure? The category that deleted can not restore!')) {
            $(this).parent().submit();
        }
    });

    $(document).on("click", "#btn_add_category", function() {
        $('#submit_add_category').show();
        $('#submit_edit_category').hide();
        $('#add_category_method').val('POST');
        $('#modal_add_category').modal('show');
    });
    $(document).on("change", ".category_status", function() {
        let category_id = $(this).attr('data-id');
        let status = $(this).is(':checked');

        let data_resp = callAPI({
            url: base_url + "/api/category/status",
            method: "put",
            body: {
                "category_id": category_id,
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

    $(document).on("change", ".sub_category_status", function() {
        let category_id = $(this).attr('data-id');
        let status = $(this).is(':checked');
        let data_resp = callAPI({
            url: base_url + "/api/sub_category/status",
            method: "put",
            body: {
                "category_id": category_id,
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

    $(document).on("change", ".category_is_feature", function() {
        let category_id = $(this).attr('data-id');
        let is_feature = $(this).is(':checked');

        let data_resp = callAPI({
            url: base_url + "/api/category/is-feature",
            method: "put",
            body: {
                "category_id": category_id,
                "is_feature": is_feature ? 1 : 0
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


    $('#category_name').keyup(function() {
        let category_name = $(this).val();

    });

    $('#icon_map_marker').change(function() {
        previewUploadImage(this, 'preview_icon')
    });

})(jQuery);