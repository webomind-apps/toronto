(function($) {
    'use strict';
    let base_url = $("#base_url").val();
    $(document).on("change", ".user_status", function() {
        let user_id = $(this).attr('data-id');
        let status = $(this).is(':checked');

        let data_resp = callAPI({
            url: base_url + "/api/users/status",
            method: "put",
            body: {
                "user_id": user_id,
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

    $(document).on("change", ".user_admin", function() {
        let user_id = $(this).attr('data-id');
        let is_admin = $(this).is(':checked');

        let data_resp = callAPI({
            url: base_url + "/api/users/role",
            method: "put",
            body: {
                "user_id": user_id,
                "is_admin": is_admin ? 1 : 0
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