function select_menu(base_url, element) {
    $(element).empty();
    $.ajax({
        url: base_url + "setting/menu/get",
        type: 'POST',
        datatype: 'json',
        success: function (data) {
            var dt = JSON.parse(data);
            $(element).kendoComboBox({
                dataTextField: "menu_name",
                dataValueField: "id_menu",
                dataSource: dt,
                filter: "contains",
                suggest: true,
                index: 3
            });
        }
    });
    
//    $("#menu").kendoDropDownList({
//                dataTextField: "menu_name",
//                dataValueField: "id_menu",
//                height:400,
//                dataSource: {
//                    type: "odata",
//                    transport: {
//                        read: "{base_url}setting/menu/get",
//                    },
//                    group : {field: "parent_name"}
//                    transport : {
//                        read:{
//                            url : "{base_url}setting/menu/get",
//                            dataType : 'jsonp'
//                        }
//                    },
//                    group : {field : "parent_name"}
//                }
//                ,
//                filter: "contains",
//                suggest: true,
//                index: 3
//        });
}