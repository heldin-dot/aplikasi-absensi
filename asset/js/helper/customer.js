function select_customer(base_url, element) {
    $(element).empty();
    $.ajax({
        url: base_url + "cdr/customer/get",
        type: 'POST',
        datatype: 'json',
        success: function (data) {
            var dt = JSON.parse(data);
            $(element).kendoComboBox({
                dataTextField: "nama",
                dataValueField: "id",
                dataSource: dt,
                filter: "contains",
                suggest: true,
                index: 3
            });
        }
    });
}