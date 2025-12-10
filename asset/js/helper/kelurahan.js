function select_kelurahan(base_url, element, from) {
    $(element).empty();

    $.ajax({
        url: base_url + "setting/daerah/kelurahan/get",
        type: 'POST',
        datatype: 'json',
        success: function (data) {
            var dt = JSON.parse(data);
            $(element).kendoComboBox({
                dataTextField: "nama",
                dataValueField: "id_kelurahan",
                dataSource: dt,
                filter: "contains",
                suggest: true,
                index: 3,
                cascadeFrom: from
            });
        }
    });
}