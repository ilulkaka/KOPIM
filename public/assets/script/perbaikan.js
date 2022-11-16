$(document).ready(function() {
    $("#no_induk_mesin").change(function() {
        var nama_mesin = $(this)
            .children("option:selected")
            .val();
        var no_mesin = $(this)
            .children("option:selected")
            .html();
        $("#no_induk").val(no_mesin);
        $("#mesin").val(nama_mesin);
    });

    $("#operator").change(function() {
        var nama_operator = $(this)
            .children("option:selected")
            .val();
        $("#nama_operator").val(nama_operator);
    });

    //ambil nomer perbaikan ketika pilih departemen
    $("select.departemen").change(function() {
        var _tgl = $("#tanggal_rusak").val();
        var dept = $("#departemen").val();
        var nama_dept = $("#departemen option:selected").text();
        var tgl = _tgl.split("T")[0];
        var key = localStorage.getItem("npr_token");
        $("#nama_departemen").val(nama_dept);
        $.ajax({
            type: "POST",
            url: APP_URL + "/api/nomer_perbaikan",
            headers: { token_req: key },
            data: { dept: dept, tanggal: tgl },
            dataType: "json",

            success: function(response) {
                var nomer = response.no_perbaikan;

                $("#nopermintaan").val(nomer);
            }
        });
    });
});
