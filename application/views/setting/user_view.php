<h3 class="heading_b uk-margin-bottom">Master User</h3>
<div class="md-card uk-margin-medium-bottom">
    <div class="md-card-content">
        <table id="dt_default" class="uk-table" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>Username</th>
                    <th>Branch</th>
                    <th>Name</th>
                    <th>User Group</th>
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
            <input type="hidden" class="md-input" id="id_user" name="id_user"/>
            <div class="uk-form-row">
                <div class="uk-grid">
                    <div class="uk-width-medium-1-4">
                        <label for="name">Name</label>
                    </div>
                    <div class="uk-width-medium-3-4">
                        <input id="name" name="name" type="text" class="k-textbox" style="width: 100%;" />
                    </div>
                </div>
            </div>
            <div class="uk-form-row">
                <div class="uk-grid">
                    <div class="uk-width-medium-1-4">
                        <label for="username" class="uk-form-label">Username</label>
                    </div>
                    <div class="uk-width-medium-3-4">
                        <input id="username" name="username" class="k-textbox" style="width: 100%;" />
                    </div>
                </div>
            </div>
            <div class="uk-form-row">
                <div class="uk-grid">
                    <div class="uk-width-medium-1-4">
                        <label for="password" class="uk-form-label">Password</label>
                    </div>
                    <div class="uk-width-medium-3-4">
                        <input id="password" name="password" type="password" class="k-textbox" style="width: 100%;" />
                    </div>
                </div>
            </div>
            <div class="uk-form-row">
                <div class="uk-grid">
                    <div class="uk-width-medium-1-4">
                        <label for="id_branch" class="uk-form-label">Branch</label>  
                    </div>
                    <div class="uk-width-medium-3-4">
                        <input id="id_branch" name="id_branch" placeholder="Pilih Branch" class="uk-form-width-medium" />
                    </div>
                </div>
            </div>
            <div class="uk-form-row">
                <div class="uk-grid">
                    <div class="uk-width-medium-1-4">
                        <label for="user_group" class="uk-form-label">User Group</label>  
                    </div>
                    <div class="uk-width-medium-3-4">
                        <input id="user_group" name="user_group" placeholder="Pilih User Group" class="uk-form-width-medium" />
                    </div>
                </div>
            </div>
            <div class="uk-form-row">
                <div class="uk-grid">
                    <div class="uk-width-medium-1-4">
                        <label for="status" class="uk-form-label">Menu</label>
                    </div>
                    <div class="uk-width-medium-3-4">
                        <input id="menu" name="menu" placeholder="Pilih Menu" class="uk-form-width-medium" />
                    </div>
                </div>
            </div>
            <div class="uk-form-row">
                <div class="uk-grid">
                    <div class="uk-width-medium-1-4">
                        <label for="tipeuser" class="uk-form-label">Tipe User</label>
                    </div>
                    <div class="uk-width-medium-3-4">
                        <input id="tipeuser" name="tipeuser" placeholder="Pilih Tipe User" class="uk-form-width-medium" />
                    </div>
                </div>
            </div>
            <div class="uk-form-row">
                <div class="uk-grid">
                    <div class="uk-width-medium-1-4">
                        <label for="status" class="uk-form-label">Status</label>
                    </div>
                    <div class="uk-width-medium-3-4">
                        <input id="status" name="status" placeholder="Pilih Status" class="uk-form-width-medium" />
                    </div>
                </div>
            </div>
            
        </form>
            <div class="uk-modal-footer uk-text-right">
                <button type="button" class="md-btn md-btn-flat uk-modal-close">Tutup</button><button type="button" class="md-btn md-btn-flat md-btn-flat-primary" id="snippet_new_save" onclick="simpan()">Simpan</button>
            </div>
    </div>
</div>

<script type="text/javascript" src="{base_url}asset/js/helper/status.js"></script>
<script type="text/javascript" src="{base_url}asset/js/helper/user_group.js"></script>
<script type="text/javascript" src="{base_url}asset/js/helper/branch.js"></script>

<script>
    select_status('#status');
    select_tipeuser('#tipeuser');
    select_menu('#menu');
    select_group('{base_url}','#user_group');
    select_branch('{base_url}','#id_branch');

    var save_method;
    var table;
    
    
    $(document).ready(function () {        
        table = $('#dt_default').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: {
                url:"{base_url}setting/user/ajax_list/{id_auth}",
                type: "POST"
            },
            columnDefs: [
                {
                    targets: [-1],
                    orderable: false
                },
                {width: "50px", targets: 0}
            ],
        });
    });
    

    function select_tipeuser(element) {        
        $(element).empty();            
        $(element).kendoComboBox({
            dataTextField: "text",
            dataValueField: "value",
            dataSource: [
                        { text: "Admin", value: "0" },
                        { text: "User", value: "1" }
                      ],
            filter: "contains",
            suggest: true,
            index: 3
        });
    }

    function select_menu(element) {        
        $(element).empty();            
        $(element).kendoComboBox({
            dataTextField: "text",
            dataValueField: "value",
            dataSource: [
                        { text: "Atas", value: "0" },
                        { text: "Samping", value: "1" }
                      ],
            filter: "contains",
            suggest: true,
            index: 3
        });
    }
//    
//    function showHide(item){
//        if(item == 0 || item == ''){
//            $('#parentHide').css("display","none");
//        }else{
//            $('#parentHide').css("display","block");
//        }
//    }
    
    function reload_table() {
        table.ajax.reload(null, false);
    }

    $('#modal_form').on('hide.uk.modal', function (e) {
        reload_table();
    });

    function tambah() {
        save_method = 'add';
        $('#form')[0].reset();
        $("#id_user").val('');
//        getListTps('');
    }

    function simpan() {
        var url;
        var id_calon;
        if (save_method == 'add') {
            url = "{base_url}setting/user/add";
        } else {
            url = "{base_url}setting/user/update";
        }
        
        $.ajax({
            url: url,
            type: "POST",
            data: {
                id_user: $("#id_user").val(),
                name: $("#name").val(), 
                username: $("#username").val(),
                password: $("#password").val(),
                id_group: $("#user_group").val(),
                id_branch: $("#id_branch").val(),
                status: $("#status").val(),
                menu: $("#menu").val(),
                tipeuser: $("#tipeuser").val(),
                modified_date: '',
                method: save_method
            },
            dataType: "JSON",
            success: function (data)
            {
                if (data.success) {
                    if(save_method == 'add'){
                        id_calon = data.id_user;
                    }else{
                        id_calon = $("#id_user").val();
                    }
                    //console.log(id_group);
//                    simpan_tps(id_calon);
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
            url: "{base_url}setting/user/edit/" + id,
            type: "GET",
            dataType: "JSON",
            success: function (data) {
                $("#id_user").val(data.id_user);
                $("#name").val(data.name);
                $("#username").val(data.username);
                $("#password").val();
                $("#user_group").data("kendoComboBox").value(data.id_group);
                $("#id_branch").data("kendoComboBox").value(data.id_branch);
                $("#status").data("kendoComboBox").value(data.status);
                $("#menu").data("kendoComboBox").value(data.menu);
                $("#tipeuser").data("kendoComboBox").value(data.tipeuser);
//                getListTps(data.id_user);
//                showHide(data.type);
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
                url: "{base_url}setting/user/delete/" + id,
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
    
//    function getListTps(id){
//        var url;
//        document.getElementById("list_menu").innerHTML = "";
//        
//        if(id==''){
//            url = '{base_url}master/tps/getTps';
//        }else{
//            url = '{base_url}master/tps/getTps/'+id;
//        }
//        $.ajax({
//            url : url,
//            type: 'GET',
//            dataType: "JSON",
//            success : function(r){
//                //if(r!=''){
//                var tps='<tr>'+
//                              '<td width="10%"></td>'+
//                              '<td width="30%"><b>Nama TPS</b></td>'+
//                              '<td width="60%"><b>Alamat</b></td>'+
//                          '</tr>'
//                if(r.dataTps!=''){
//                    
//                    for(var i=0; i<r.dataTps.length;i++){
//                        console.log(r.dataTps[i].nama);
//                        var user=$("#id_user").val();
//                        var status='0';
//                        var chek='';
//                        var auth='';
//                        if(r.dataTps[i].id_user!=null){
//                            user=r.dataTps[i].id_user;
//                        }
//                        if(r.dataTps[i].status!=null){
//                            status=r.dataTps[i].status;
//                            if(status==1){
//                                chek='checked="checked"';
//                            }
//                        }
//                        if(r.dataTps[i].id_auth!=null){
//                            auth=r.dataTps[i].id_auth;
//                        }
//                        tps=tps+'<tr>'+
//                                  '<td><input type="hidden" id="id_tps'+[i]+'" name="id_tps[]" class="k-textbox" style="width: 100%;" value="'+r.dataTps[i].id_tps+'" />'+
//                                        '<input type="hidden" id="id_auth'+[i]+'" name="id_auth[]" class="k-textbox" style="width: 100%;" value="'+auth+'" />'+
//                                        '<input type="hidden" id="id_user'+[i]+'" name="id_user[]" class="k-textbox" style="width: 100%;" value="'+user+'" />'+
//                                        '<input type="hidden" id="textstatus'+[i]+'" name="textstatus[]" class="k-textbox" style="width: 100%;" value="'+status+'" />'+
//                                        '<input type="checkbox" id="status'+[i]+'" name="status[]" '+chek+' value="'+status+'" onclick="setcek(this.id)" /></td>'+
//                                  '<td>'+r.dataTps[i].nama+'</td>'+
//                                  '<td>'+r.dataTps[i].alamat+'</td>'+
//                              '</tr>'
//                    }
//                    $('table#list_menu').append(tps);
//                }
//                //}
//            },
//            error: function (r){
//                console.log(r);
//            }
//        });
//    }
    
//    function simpan_tps(id_calon){
//        //var url;       
//        //var data = new FormData($('form#form_tps')[0]);
//        var data = $('form#form_tps').serialize();
//        console.log(data);
//        $.ajax({
//            url : '{base_url}master/tps/auth_tps/'+id_calon,
//            type : 'POST',
//            data : data,
//            async : false,
//            success : function(r){
//                console.log(r);
//            },
//            error : function(r){
//                console.log(r);
//            }
//        });
//    }
	
    function setcek(id){
		console.log(id);
        $('#text'+id).val(document.getElementById(id).checked == true ? 1 : 0);
    }

    

</script>
