function select_status(element) {
        $(element).empty();            
        $(element).kendoComboBox({
            dataTextField: "text",
            dataValueField: "value",
            dataSource: [
                        { text: "Active", value: "1" },
                        { text: "Non Active", value: "0" }
                      ],
            filter: "contains",
            suggest: true,
            index: 3
        });
                
    }

