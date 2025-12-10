function select_kota(base_url, element, from) {
    $(element).empty();

    $.ajax({
        url: base_url + "setting/daerah/kota/get",
        type: 'POST',
        datatype: 'json',
        autoBind: false,
        success: function (data) {
            var dt = JSON.parse(data);
            $(element).kendoComboBox({
                dataTextField: "nama",
                dataValueField: "id_kota",
                dataSource: dt,
                filter: "contains",
                suggest: true,
                index: 3,
                cascadeFrom: from
            });
        }
    });
}