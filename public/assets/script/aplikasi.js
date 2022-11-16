$(document).ready(function () {
    var key = localStorage.getItem("npr_token");
    var user = 1;
    if (!key) {
        //var token = "{{ csrf_token() }}";
        $.ajax({
            url: APP_URL + "/logout",
            type: "POST",
            dataType: "json",
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            data: { id: user },
        })
            .done(function (resp) {
                if (resp.success) {
                    localStorage.removeItem("npr_name");
                    localStorage.removeItem("npr_token");
                    localStorage.removeItem("npr_id_user");
                    window.location.href = APP_URL;
                } else $("#error").html("<div class='alert alert-danger'><div>Error</div></div>");
            })
            .fail(function () {
                $("#error").html(
                    "<div class='alert alert-danger'><div>Tidak dapat terhubung ke server !!!</div></div>"
                );
                //toastr['warning']('Tidak dapat terhubung ke server !!!');
            });
    }
});
