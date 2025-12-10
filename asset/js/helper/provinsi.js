
function select_provinsi(base_url, element) {
    $(element).empty();

    $.ajax({
        url: base_url + "setting/daerah/provinsi/get",
        type: 'POST',
        datatype: 'json',
        autoBind: false,
        success: function (data) {
            var dt = JSON.parse(data);
            $(element).kendoComboBox({
                dataTextField: "nama",
                dataValueField: "id_provinsi",
                dataSource: dt,
                filter: "contains",
                suggest: true,
                index: 3
            });
        }
    });
}