(function($) {
    'use strict';
    let base_url = $("#base_url").val();
    $(document).on("click", ".header_background_edit", function() {
        let header_background_id = $(this).attr('data-id');

        $('#submit_add_header_background').hide();
        $('#submit_edit_header_background').show();
        $('#add_header_background_method').val('PUT');
        $('#header_background_id').val(header_background_id);

        $('#modal_add_header_background').modal('show');
    });

    $(document).on("click", ".header_background_delete", function() {
        if (confirm('Are you sure? The header_background that deleted can not restore!')) {
            $(this).parent().submit();
        }
    });

    $(document).on("click", "#btn_add_header_background", function() {
        $('#submit_add_header_background').show();
        $('#submit_edit_header_background').hide();
        $('#add_header_background_method').val('POST');
        $('#modal_add_header_background').modal('show');
    });

    $(document).on("change", ".header_background_status", function() {
        let header_background_id = $(this).attr('data-id');
        let status = $(this).is(':checked');

        let data_resp = callAPI({
            url: base_url + "/api/header_background/status",
            method: "put",
            body: {
                "header_background_id": header_background_id,
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


    $(document).on("click", ".footer_background_edit", function() {
        let footer_background_id = $(this).attr('data-id');

        $('#submit_add_footer_background').hide();
        $('#submit_edit_footer_background').show();
        $('#add_footer_background_method').val('PUT');
        $('#footer_background_id').val(footer_background_id);

        $('#modal_add_footer_background').modal('show');
    });

    $(document).on("click", ".footer_background_delete", function() {
        if (confirm('Are you sure? The footer that deleted can not restore!')) {
            $(this).parent().submit();
        }
    });

    $(document).on("click", "#btn_add_footer_background", function() {
        $('#submit_add_footer_background').show();
        $('#submit_edit_footer_background').hide();
        $('#add_footer_background_method').val('POST');
        $('#modal_add_footer_background').modal('show');
    });

    $(document).on("change", ".footer_background_status", function() {
        let footer_background_id = $(this).attr('data-id');
        let status = $(this).is(':checked');

        let data_resp = callAPI({
            url: base_url + "/api/footer_background/status",
            method: "put",
            body: {
                "footer_background_id": footer_background_id,
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

    $(document).on("click", ".default_logo_edit", function() {
        let default_logo_id = $(this).attr('data-id');

        $('#submit_add_default_logo').hide();
        $('#submit_edit_default_logo').show();
        $('#add_default_logo_method').val('PUT');
        $('#default_logo_id').val(default_logo_id);

        $('#modal_add_default_logo').modal('show');
    });

    $(document).on("click", ".default_logo_delete", function() {
        if (confirm('Are you sure? The footer that deleted can not restore!')) {
            $(this).parent().submit();
        }
    });

    $(document).on("click", "#btn_add_default_logo", function() {
        $('#submit_add_default_logo').show();
        $('#submit_edit_default_logo').hide();
        $('#add_default_logo_method').val('POST');
        $('#modal_add_default_logo').modal('show');
    });

    $(document).on("change", ".default_logo_status", function() {
        let default_logo_id = $(this).attr('data-id');
        let status = $(this).is(':checked');

        let data_resp = callAPI({
            url: base_url + "/api/default_logo/status",
            method: "put",
            body: {
                "default_logo_id": default_logo_id,
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