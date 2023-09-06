(function($) {
    'use strict';
    let base_url = $("#base_url").val();
    $(document).on("change", ".post_status", function() {
        let post_id = $(this).attr('data-id');
        let status = $(this).is(':checked');

        let data_resp = callAPI({
            url: base_url + "/api/posts/status",
            method: "put",
            body: {
                "post_id": post_id,
                "status": status ? 1 : 0
            }
        });
        data_resp.then(res => {
            if (res.code === 200) {
                notify(res.message);
            } else {
                console.log(res);
                notify('Error! Please check console.', 'error');
            }
        });
    });

    $('#post_thumb').change(function() {
        previewUploadImage(this, 'preview_thumb')
    });

})(jQuery);