let base_url = $("#base_url").val();
$(document).on("click", ".place_delete", function() {
    if (confirm('Are you sure? The place that deleted can not restore!'))
        $(this).parent().submit();
});

$(document).on("change", ".place_status", function() {
    let place_id = $(this).attr('data-id');
    let status = $(this).is(':checked');
    status = status ? 1 : 0;
    updateStatusPlace(place_id, status);
});

$(document).on("change", ".place_is_feature", function() {
    let place_id = $(this).attr('data-id');
    let feature = $(this).is(':checked');
    feature = feature ? 1 : 0;
    updateFeaturePlace(place_id, feature);
});

$(document).on("click", ".place_approve", function() {
    let place_id = $(this).attr('data-id');
    if (confirm('Are you sure?')) {
        updateStatusPlace(place_id, 1);
        location.reload();
    }
});

$(document).on("change", ".priority_change", function() {
    let place_id = $(this).attr('data-id');

    let priority = $(this).val();
    let data_resp = callAPI({
        url: base_url + "/api/places/priority",
        method: "put",
        body: {
            "place_id": place_id,
            "priority": priority
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

function updateStatusPlace(place_id, status) {
    let data_resp = callAPI({
        url: base_url + "/api/places/status",
        method: "put",
        body: {
            "place_id": place_id,
            "status": status
        }
    });
    data_resp.then(res => {
        if (res.code === 200) {
            notify(res.message);
        } else {
            console.log(res);
            notify('Error!', 'error');
        }
        location.reload();
    });
}

function updateFeaturePlace(place_id, feature) {
    let data_resp = callAPI({
        url: base_url + "/api/places/is-feature",
        method: "put",
        body: {
            "place_id": place_id,
            "is_feature": feature,
            _token: $('meta[name="csrf-token"]').attr('content')
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
}