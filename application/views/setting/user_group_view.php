<h3 class="heading_b uk-margin-bottom">User Group</h3>
<div class="md-card uk-margin-medium-bottom">
    <div class="md-card-content">
        <table id="dt_default" class="uk-table" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>Action</th>
                    <th>User Group Name</th>
                    <th>Status</th>
                    <th>Modified Date</th>
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
            <input type="hidden" class="md-input" id="id_group" name="id_group"/>
            <div class="uk-form-row">
                <label for="group_name">Group Name</label>
                <input id="group_name" name="group_name" type="text" class="k-textbox" style="width: 100%;" />
            </div>
            <div class="uk-form-row">
                <label for="status" class="uk-form-label">Status</label>
                <input id="status" name="status" placeholder="Pilih Status" class="uk-form-width-medium" />
            </div>            
        </form>
            <br>
            <h3 class="heading_b uk-margin-bottom">List Menu</h3>
            <form id="form_auth" name="form_auth" enctype="multipart/form-data">
            <table id="list_menu" class="uk-table" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th></th>
                        <th align="center">Menu Name</th>
                        <th align="center">Addable</th>
                        <th align="center">Updateable</th>
                        <th align="center">Deleteable</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>  
            </form>
            <div class="uk-modal-footer uk-text-right">
                <button type="button" class="md-btn md-btn-flat uk-modal-close">Tutup</button><button type="button" class="md-btn md-btn-flat md-btn-flat-primary" id="snippet_new_save" onclick="simpan()">Simpan</button>
            </div>
    </div>
</div>

<script type="text/javascript" src="{base_url}asset/js/helper/status.js"></script>

<script>
    select_status('#status');

    var save_method;
    var table;
    
    
    $(document).ready(function () {        
        table = $('#dt_default').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: {
                url:"{base_url}setting/user_group/ajax_list/{id_auth}",
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
        $("#id_group").val('');
        $('#list_menu tbody').html('');
        getListMenu('');
    }

    function simpan() {
        var url;
        var id_group;
        
        if (save_method == 'add') {
            url = "{base_url}setting/user_group/add";
        } else {
            url = "{base_url}setting/user_group/update";
        }
        
        $.ajax({
            url: url,
            type: "POST",
            //async : false,
            data: {
                id_group: $("#id_group").val(),
                group_name: $("#group_name").val(), 
                status: $("#status").val(),
                modified_date: '',
                modified_user: '{user_id}',
                method: save_method
            },
            dataType: "JSON",
            success: function (data)
            {
                if (data.success) {
                    if(save_method == 'add'){
                        id_group = data.kode;
                    }else{
                        id_group = $("#id_group").val();
                    }
                    //console.log(id_group);
                    simpan_auth(id_group);
                    
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
    
    function simpan_auth(id_group){
        //var url;       
        //var data = new FormData($('form#form_auth')[0]);
        var data = $('form#form_auth').serialize();
        $.ajax({
            url : '{base_url}setting/authority/add_auth/'+id_group,
            type : 'POST',
            data : data,
            async : false,
            success : function(r){
                console.log(r);
            },
            error : function(r){
                console.log(r);
            }
        });
    }

    function edit(id) {
        save_method = 'update';
        $('#form')[0].reset();

        $.ajax({
            url: "{base_url}setting/user_group/edit/" + id,
            type: "GET",
            dataType: "JSON",
            success: function (data) {
                $("#id_group").val(data.id_group);
                $("#group_name").val(data.group_name);
                $("#status").data("kendoComboBox").value(data.status);                
                $('#list_menu tbody').html('');
                getListMenu(data.id_group);
                UIkit.modal('#modal_form').show();
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                console.log(errorThrown);
            }
        });
    }

    function getListMenu(id){
        var url;
        if(id==''){
            url = '{base_url}setting/authority/get_list';
        }else{
            url = '{base_url}setting/authority/get_list/'+id;
        }
        $.ajax({
            url : url,
            type: 'POST',
            async: false,
            success : function(r){
                //if(r!=''){
                $('#list_menu tbody').html(r);
                //}
            },
            error: function (r){
                console.log(r);
            }
        });
    }

    function hapus(id) {
        UIkit.modal.confirm('Yakin ingin menghapus data ini?', function () {
           
            $.ajax({
                url: "{base_url}setting/user_group/delete/" + id,
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
	
    function setcek(id){
		console.log(id);
        $('#text'+id).val(document.getElementById(id).checked == true ? 1 : 0);
    }

    

</script>