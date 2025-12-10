<h3 class="heading_b uk-margin-bottom">Authority</h3>
<div class="md-card uk-margin-medium-bottom">
    <div class="md-card-content">
        <table id="dt_default" class="uk-table" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>User Group</th>
                    <th>Menu</th>
                    <th>Addable</th>
                    <th>Editable</th>
                    <th>Deleteable</th>
                    <th>Status</th>                    
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
            <input type="hidden" class="md-input" id="id_auth" name="id_auth"/>
            <div class="uk-form-row">
                <label for="group_name" class="uk-form-label">User Group</label>
                <input id="group_name" name="group_name" placeholder="Pilih Group Pengguna" class="uk-form-width-medium" />
            </div>
            <div class="uk-form-row">
                <label for="menu" class="uk-form-label">Menu</label>
                <input id="menu" name="menu" placeholder="Pilih Menu" class="uk-form-width-medium" style="width: 500px;"/>
            </div>
            <div class="uk-form-row">                
                <input id="addable" name="addable" type="checkbox" value="1" class="k-checkbox"/>
                <label for="addable" class="k-checkbox-label" >Addable</label>
            </div>            
            <div class="uk-form-row">                
                <input id="updateable" name="updateable" type="checkbox" value="1" class="k-checkbox"/>
                <label for="updateable" class="k-checkbox-label">Updateable</label>
            </div>           
            <div class="uk-form-row">                
                <input id="deleteable" name="editable" type="checkbox" value="1" class="k-checkbox"/>
                <label for="deleteable" class="k-checkbox-label">Deleteable</label>
            </div>            
            <div class="uk-form-row">
                <label for="status" class="uk-form-label">Status</label>
                <input id="status" name="status" placeholder="Pilih Status" class="uk-form-width-medium" />
            </div>            
            <div class="uk-modal-footer uk-text-right">
                <button type="button" class="md-btn md-btn-flat uk-modal-close">Tutup</button><button type="button" class="md-btn md-btn-flat md-btn-flat-primary" id="snippet_new_save" onclick="simpan()">Simpan</button>
            </div>
        </form>
    </div>
</div>

<script type="text/javascript" src="{base_url}asset/js/helper/status.js"></script>
<script type="text/javascript" src="{base_url}asset/js/helper/menu.js"></script>
<script type="text/javascript" src="{base_url}asset/js/helper/user_group.js"></script>

<script>       
    select_status('#status');
    select_menu('{base_url}','#menu');
    select_group('{base_url}','#group_name');
    
    var save_method;
    var table;
    
    
    $(document).ready(function () { 
        table = $('#dt_default').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: {
                url:"{base_url}setting/authority/ajax_list/{id_auth}",
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
                {"sClass": "center"}
            ]
        });               
    });
    

    function reload_table() {
        table.ajax.reload(null, false);
    }

    $('#modal_form').on('hide.uk.modal', function (e) {
        reload_table();
    });

    function tambah() {
        save_method = 'add';
        $('#form')[0].reset();
        $("#addable").attr("checked",false);
        $("#updateable").attr("checked",false);
        $("#deleteable").attr("checked",false);
        $("#id_auth").val('');
    }

    function simpan() {
        var url;
        if (save_method == 'add') {
            url = "{base_url}setting/authority/add";
        } else {
            url = "{base_url}setting/authority/update";
        }
        
        var addable = 0;
        if($("#addable").is(":checked")){
            addable = 1;
        }
        
        var updateable = 0;
        if($("#updateable").is(":checked")){
            updateable = 1;
        }
        
        var deleteable= 0;
        if($("#deleteable").is(":checked")){
            deleteable = 1;
        }
        $.ajax({
            url: url,
            type: "POST",
            data: {
                id_auth: $("#id_auth").val(),
                id_group: $("#group_name").val(),                
                id_menu: $("#menu").val(),                
                addable: addable,
                updateable: updateable,
                deleteable: deleteable,
                status: $("#status").val(),
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
            url: "{base_url}setting/authority/edit/" + id,
            type: "GET",
            dataType: "JSON",
            success: function (data) {
                $("#id_auth").val(data.id_auth);                
                $("#group_name").data("kendoComboBox").value(data.id_group);                
                $("#menu").data("kendoComboBox").value(data.id_menu);
                if(data.addable == '1'){
                   $("#addable").attr("checked",true); 
                }else{
                   $("#addable").attr("checked",false); 
                }
                if(data.updateable == '1'){
                   $("#updateable").attr("checked",true); 
                }else{
                   $("#updateable").attr("checked",false); 
                }
                if(data.deleteable == '1'){
                   $("#deleteable").attr("checked",true); 
                }else{
                   $("#deleteable").attr("checked",false); 
                }
                $("#status").data("kendoComboBox").value(data.status);
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
                url: "{base_url}setting/authority/delete/" + id,
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
