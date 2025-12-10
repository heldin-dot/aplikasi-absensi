function select_wilayah(base_url, element, dt) {
    $(element).empty();
    $.ajax({
        url: base_url + "wilayah/get",
        type: 'POST',
        datatype: 'json',
        success: function (data) {
            var data = JSON.parse(data);
            var options;
            for (var i = 0; i < data['length']; i++) {
                if (dt == data[i]['id_wilayah']) {
                    options += "<option value='" + data[i]['id_wilayah'] + "' selected='selected'>" + data[i]['nama_wilayah'] + "</option>";
                } else {
                    options += "<option value='" + data[i]['id_wilayah'] + "'>" + data[i]['nama_wilayah'] + "</option>";
                }
            }
            $(element).append(options);
            $('.selectpicker').selectpicker("refresh");
        }
    });
}

function select_area(base_url, element, dt) {
    $(element).empty();
    $.ajax({
        url: base_url + "area/get",
        type: 'POST',
        datatype: 'json',
        success: function (data) {
            var data = JSON.parse(data);
            var options;
            for (var i = 0; i < data['length']; i++) {
                if (dt == data[i]['id_area']) {
                    options += "<option value='" + data[i]['id_area'] + "' selected='selected'>" + data[i]['nama_area'] + "</option>";
                } else {
                    options += "<option value='" + data[i]['id_area'] + "'>" + data[i]['nama_area'] + "</option>";
                }
            }
            $(element).append(options);
            $('.selectpicker').selectpicker("refresh");
        }
    });
}

function select_unit(base_url, element, val, dt, id_area) {
    $(element).empty();
    $.ajax({
        url: base_url + "unit/get",
        data: {id_area: id_area},
        type: 'POST',
        datatype: 'json',
        success: function (data) {
            var data = JSON.parse(data);
            var options;
            for (var i = 0; i < data['length']; i++) {
                if (val == "nama") {
                    options += "<option value='" + data[i]['nama_unit'] + "'>" + data[i]['nama_unit'] + "</option>";
                } else {
                    if (dt == data[i]['id_unit']) {
                        options += "<option value='" + data[i]['id_unit'] + "' selected='selected'>" + data[i]['nama_unit'] + "</option>";
                    } else {
                        options += "<option value='" + data[i]['id_unit'] + "'>" + data[i]['nama_unit'] + "</option>";
                    }
                }
            }
            $(element).append(options);
            $('.selectpicker').selectpicker("refresh");
        }
    });
}

function select_barang(base_url, element) {
    $(element).empty();

    var m;
    $.ajax({
        url: base_url + "kupon/get",
        data: {aktif: 1},
        type: 'POST',
        datatype: 'json',
        success: function (dta) {
            m = JSON.parse(dta);
        }
    })
            .fail(function () {

            })
            .then(function () {
                $.ajax({
                    url: base_url + "barang/get",
                    data: {aktif: 1},
                    type: 'POST',
                    datatype: 'json',
                    success: function (dt) {
                        var data = JSON.parse(dt);
                        var options;
                        for (var g = 0; g < m.length; g++) {
                            options += '<optgroup label="' + m[g]["nama_kupon"] + '">';
                            for (var i = 0; i < data.length; i++) {
                                if (m[g]["id_kupon"] == data[i]['id_kupon']) {
                                    options += "<option value='" + data[i]['id_barang'] + "'>" + data[i]['nama_barang'] + "</option>";
                                }
                            }
                            options += "</optgroup>";
                        }

                        $(element).append(options);
                        $('.selectpicker').selectpicker("refresh");
                    }
                });
            })
            .fail(function () {

            })
            .done(function () {

            });

}

function select_hadiah(base_url, element) {
    $(element).empty();
    $.ajax({
        url: base_url + "hadiah/get",
        data: {aktif: 1},
        type: 'POST',
        datatype: 'json',
        success: function (dt) {
            var data = JSON.parse(dt);
            var options;
            for (var i = 0; i < data['length']; i++) {
                options += "<option value='" + data[i]['id_hadiah'] + "'>" + data[i]['nama_hadiah'] + "</option>";
            }
            $(element).append(options);
            $('.selectpicker').selectpicker("refresh");
        }
    });
}

function select_kupon(base_url, element) {
    $(element).empty();
    $.ajax({
        url: base_url + "kupon/get",
        data: {aktif: 1},
        type: 'POST',
        datatype: 'json',
        success: function (dt) {
            var data = JSON.parse(dt);
            var options;
            for (var i = 0; i < data['length']; i++) {
                options += "<option value='" + data[i]['id_kupon'] + "' data-subtext='" + data[i]['nama_hadiah'] + "'>" + data[i]['nama_kupon'] + "</option>";
            }
            $(element).append(options);
            $('.selectpicker').selectpicker("refresh");
        }
    });
}

function select_level(base_url, element) {
    $(element).empty();
    $.ajax({
        url: base_url + "level/get",
        data: {aktif: 1},
        type: 'POST',
        datatype: 'json',
        success: function (data) {
            var data = JSON.parse(data);
            var options;
            for (var i = 0; i < data['length']; i++) {
                options += "<option value='" + data[i]['id_level'] + "'>" + data[i]['nama_level'] + "</option>";
            }
            $(element).append(options);
            $('.selectpicker').selectpicker("refresh");
        }
    });
}

function select_bulan(base_url, element) {
    $(element).empty();

    var data = {"bulan": [
            {"id_bulan": 1, "nama_bulan": "JANUARI"},
            {"id_bulan": 2, "nama_bulan": "FEBRUARI"},
            {"id_bulan": 3, "nama_bulan": "MARET"},
            {"id_bulan": 4, "nama_bulan": "APRIL"},
            {"id_bulan": 5, "nama_bulan": "MEI"},
            {"id_bulan": 6, "nama_bulan": "JUNI"},
            {"id_bulan": 7, "nama_bulan": "JULI"},
            {"id_bulan": 8, "nama_bulan": "AGUSTUS"},
            {"id_bulan": 9, "nama_bulan": "SEPTEMBER"},
            {"id_bulan": 10, "nama_bulan": "OKTOBER"},
            {"id_bulan": 11, "nama_bulan": "NOPEMBER"},
            {"id_bulan": 12, "nama_bulan": "DESEMBER"}
        ]
    };
    var options;
    for (var i = 0; i < data.bulan.length; i++) {
        options += "<option value='" + data.bulan[i]['id_bulan'] + "'>" + data.bulan[i]['nama_bulan'] + "</option>";
    }
    $(element).append(options);
    $('.selectpicker').selectpicker("refresh");

}
