<h3 class="heading_b uk-margin-bottom">Master Menu</h3>
<div class="md-card uk-margin-medium-bottom">
    <div class="md-card-content">
        <table id="dt_default" class="uk-table" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>Menu Name</th>
                    <th>Sub Menu</th>
                    <th>URL</th>
                    <th>Sort</th>
                    <th>Status</th>
                    <th>Type</th>
                    <th>Icon</th>
                    <th>Modified Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</div>


<?php if ($addable == "1") {?>
<div class="md-fab-wrapper">
    <a class="md-fab md-fab-accent" href="#modal_form" onclick="tambah()" data-uk-modal="{ center:true }">
        <i class="material-icons">&#xE145;</i>
    </a>
</div>
<?php } ?>

<div class="uk-modal" id="modal_form">
    <div class="uk-modal-dialog">
        <form id="form" class="uk-form-stacked">
            <input type="hidden" class="md-input" id="id_menu" name="id_menu"/>
            <div class="uk-form-row">
                <label for="menu_name">Menu Name</label>
                <input id="menu_name" name="menu_name" type="text" class="md-input" style="width: 100%;" />
            </div>
            <div class="uk-form-row">
                <label for="type" class="uk-form-label">Menu Type</label>
                <input id="type" name="type" placeholder="Pilih Menu Type" class="uk-form-width-medium" />
            </div>
            <div class="uk-form-row" id="parentHide" style="display:none;">
                <label for="parent" class="uk-form-label">Menu Parent</label>
                <input id="parent" name="parent" placeholder="Pilih Menu Parent" class="uk-form-width-medium" />
            </div>
            <div class="uk-form-row">
                <label for="url">URL</label>
                <input id="url" name="url" type="text" class="md-input" style="width: 100%;" />
            </div>
            <div class="uk-form-row">
                <label for="status" class="uk-form-label">Status</label>
                <input id="status" name="status" placeholder="Pilih Status" class="uk-form-width-medium" />
            </div>
            <div class="uk-form-row">
                <label for="sort">Sort</label>
                <input id="sort" name="sort" type="text" class="md-input" style="width: 100%;" />
            </div>
            <div class="uk-form-row">
                <label for="icon">Icon</label>
                <input id="icon" name="icon" type="text" class="md-input" style="width: 100%;" />
            </div>
            <div class="uk-modal-footer uk-text-right">
                <button type="button" class="md-btn md-btn-flat uk-modal-close">Tutup</button><button type="button" class="md-btn md-btn-flat md-btn-flat-primary" id="snippet_new_save" onclick="simpan()">Simpan</button>
            </div>
        </form>
    </div>
</div>


<script type="text/javascript" src="{base_url}asset/js/helper/menu.js"></script>
<script type="text/javascript" src="{base_url}asset/js/helper/status.js"></script>

<script>
    select_menu('{base_url}', '#parent');
    select_status('#status');
    select_menu_type('#type');

    var save_method;
    var table;
    
    
    $(document).ready(function () {        
        table = $('#dt_default').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: {
                url:"{base_url}setting/menu/ajax_list/{id_auth}",
                type: "POST"
            },
            columnDefs: [
                {
                    targets: [-1],
                    orderable: true
                },
                {width: "50px", targets: 0}
            ],
            aoColumns: [
                {"sClass": "center"},
                {"sClass": "center"},
                {"sClass": "center"},
                {"sClass": "center"},
                {"sClass": "center"},
                {"sClass": "center"},
                {"sClass": "center"},
                {"sClass": "center"},
                {"sClass": "center"}
            ]
        });
    });
    

    function select_menu_type(element) {        
        $(element).empty();            
        $(element).kendoComboBox({
            dataTextField: "text",
            dataValueField: "value",
            dataSource: [
                        { text: "Parent", value: "0" },
                        { text: "Child", value: "1" },
                        { text: "Sub Child", value: "2" },
                        { text: "Sub Child 2", value: "3" }
                      ],
            filter: "contains",
            suggest: true,
            index: 3,
            select:function(e){
                var item = this.dataItem(e.item.index()).value;
                if(item == 0 || item == ''){
                    $('#parentHide').css("display","none");
                }else{
                    $('#parentHide').css("display","block");
                }
            }
        });
    }
    
    function showHide(item){
        if(item == 0 || item == ''){
            $('#parentHide').css("display","none");
        }else{
            $('#parentHide').css("display","block");
        }
    }
    
    function reload_table() {
        table.ajax.reload(null, false);
    }

    $('#modal_form').on('hide.uk.modal', function (e) {
        reload_table();
    });

    function tambah() {
        showHide('');
        save_method = 'add';
        $('#form')[0].reset();
        $("#id_menu").val('');
    }

    function simpan() {
        var url;
        if (save_method == 'add') {
            url = "{base_url}setting/menu/add";
        } else {
            url = "{base_url}setting/menu/update";
        }
        
        $.ajax({
            url: url,
            type: "POST",
            data: {
                id_menu: $("#id_menu").val(),
                menu_name: $("#menu_name").val(), 
                parent: $("#parent").val(),
                url: $("#url").val(),
                type: $("#type").val(),
                status: $("#status").val(),
                sort: $("#sort").val(),
                icon: $("#icon").val(),
                modified_date: '',
                method: save_method
            },
            dataType: "JSON",
            success: function (data)
            {
                if (data.success) {
                    reload_table();
                    UIkit.modal.alert("Data tersimpan.");
                    UIkit.modal("#modal_form").hide();
                } else {
                    UIkit.modal.alert(data.msg);
                }
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                console.log(errorThrown);
            }
        });
    }

    function edit(id) {
        save_method = 'update';
        $('#form')[0].reset();

        $.ajax({
            url: "{base_url}setting/menu/edit/" + id,
            type: "GET",
            dataType: "JSON",
            success: function (data) {
                $("#id_menu").val(data.id_menu);
                $("#menu_name").val(data.menu_name);
                $("#type").data("kendoComboBox").value(data.type);
                $("#parent").data("kendoComboBox").value(data.parent);
                $('#url').val(data.url);
                $("#status").data("kendoComboBox").value(data.status);
                $('#sort').val(data.sort);
                $('#icon').val(data.icon);
                showHide(data.type);
                UIkit.modal('#modal_form').show();
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                console.log(errorThrown);
            }
        });
    }

    

    function hapus(id) {
        UIkit.modal.confirm('Yakin ingin menghapus data ini?', function () {
           
            $.ajax({
                url: "{base_url}setting/menu/delete/" + id,
                type: "POST",
                dataType: "JSON",
                success: function (data)
                {
                    if (data.success) {
                        reload_table();
                    } else {
                        UIkit.modal.alert(data.msg);
                    }
                },
                error: function (jqXHR, textStatus, errorThrown)
                {
                    console.log(errorThrown);
                }
            });
        });
    }

    function clearFileInput(id) {
        $('#' + id).html($('#' + id).html());
    }

    

</script>
