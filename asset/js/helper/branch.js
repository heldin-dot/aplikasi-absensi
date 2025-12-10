function select_branch(base_url, element) {
    $(element).empty();
    $.ajax({
        url: base_url + "master/branch/get",
        type: 'POST',
        datatype: 'json',
        success: function (data) {
            var dt = JSON.parse(data);
            $(element).kendoComboBox({
                dataTextField: "nama",
                dataValueField: "id_branch",
                dataSource: dt,
                filter: "contains",
                suggest: true,
//                index: 3
            });
        }
    });
    
}