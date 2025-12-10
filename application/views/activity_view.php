<h3 class="heading_b uk-margin-bottom">Tugas Luar</h3>
<div class="md-card uk-margin-medium-bottom">
    <div class="md-card-content">
        <table id="dt_default" class="uk-table" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>User</th>
                    <th>Tanggal</th>
                    <th>Judul</th>
                    <th>Jam Keluar</th>
                    <th>Jam Kembali</th>
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
            <input type="hidden" class="md-input" id="id_activity" name="id_activity"/>
            <div class="uk-form-row">
                <div class="uk-grid">
                    <div class="uk-width-medium-4-4">
                        <div class="uk-grid" style="margin-top: 5px">
                            <div class="uk-width-medium-1-4">
                                <label for="judul" class="uk-form-label">Judul</label>
                            </div>
                            <div class="uk-width-medium-3-4">
                                <input id="judul" name="judul" class="k-textbox" style="width: 70%;" />
                            </div>
                        </div>
                    </div>
                    <div class="uk-width-medium-4-4">
                        <div class="uk-grid" style="margin-top: 5px">
                            <div class="uk-width-medium-1-4">
                                <label for="isi" class="uk-form-label">Aktifitas</label>
                            </div>
                            <div class="uk-width-medium-3-4">
                                <textarea id="isi" name="isi" class="k-textbox" rows="4" style="width: 70%;" ></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="uk-width-medium-4-4">
                        <div class="uk-grid" style="margin-top: 5px">
                            <div class="uk-width-medium-1-4">
                                <label for="keluar" class="uk-form-label">Jam Keluar</label>
                            </div>
                            <div class="uk-width-medium-3-4">
                                <input id="keluar" name="keluar" class="" style="width: 70%;" />
                            </div>
                        </div>
                    </div>
                    <div class="uk-width-medium-4-4">
                        <div class="uk-grid" style="margin-top: 5px">
                            <div class="uk-width-medium-1-4">
                                <label for="kembali" class="uk-form-label">Jam Masuk</label>
                            </div>
                            <div class="uk-width-medium-3-4">
                                <input id="kembali" name="kembali" class="" style="width: 70%;" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="uk-modal-footer uk-text-right">
                <button type="button" class="md-btn md-btn-flat uk-modal-close">Tutup</button><button type="button" class="md-btn md-btn-flat md-btn-flat-primary" id="snippet_new_save" onclick="simpan()">Simpan</button>
            </div>
        </form>
    </div>
</div>


<!--<script type="text/javascript" src="{base_url}asset/js/helper/menu.js"></script>
<script type="text/javascript" src="{base_url}asset/js/helper/status.js"></script>-->

<script>
//    select_menu('{base_url}', '#parent');
//    select_status('#status');
//    select_menu_type('#type');

    var save_method;
    var table;
    
    
    $(document).ready(function () { 
        
        $('#keluar').kendoTimePicker({
            format: "HH:mm:ss",
            min:'08:00:00',
            max:'20:00:00'
        });
        $('#kembali').kendoTimePicker({
            format: "H:mm:ss",
            min:'08:00:00',
            max:'20:00:00'
        });
        
        console.log({user_tipe});
        var url;
        if('{user_tipe}' == 1){
            url = "{base_url}activity/ajax_list/{id_auth}?key=id_user&val={user_id}";
        }else{
            url = "{base_url}activity/ajax_list/{id_auth}";
        }
        table = $('#dt_default').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: {
                url: url,
                type: "POST"
            },
            columnDefs: [
                {
                    targets: [-1],
                    orderable: false
                },
                {width: "50px", targets: -1},
                {width: "50px", targets: -2},
            ],
        });
    });
    

//    function select_menu_type(element) {        
//        $(element).empty();            
//        $(element).kendoComboBox({
//            dataTextField: "text",
//            dataValueField: "value",
//            dataSource: [
//                        { text: "Parent", value: "0" },
//                        { text: "Child", value: "1" },
//                        { text: "Sub Child", value: "2" },
//                        { text: "Sub Child 2", value: "3" }
//                      ],
//            filter: "contains",
//            suggest: true,
//            index: 3,
//            select:function(e){
//                var item = this.dataItem(e.item.index()).value;
//                if(item == 0 || item == ''){
//                    $('#parentHide').css("display","none");
//                }else{
//                    $('#parentHide').css("display","block");
//                }
//            }
//        });
//    }
    
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
//        showHide('');
        save_method = 'add';
        $('#form')[0].reset();
        $("#id_activity").val('');
    }

    function simpan() {
        var url;
        if (save_method == 'add') {
            url = "{base_url}activity/add";
        } else {
            url = "{base_url}activity/update";
        }
        
        $.ajax({
            url: url,
            type: "POST",
            data: {
                id_activity: $("#id_activity").val(),
                judul: $("#judul").val(), 
                isi: $("#isi").val(),
                keluar: $("#keluar").val(),
                kembali: $("#kembali").val(),
                tanggal: '',
                id_branch: '{user_branch}',
                id_user: '{user_id}',
                modified_user: '{user_id}',
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
            url: "{base_url}activity/edit/" + id,
            type: "GET",
            dataType: "JSON",
            success: function (data) {
                $("#id_activity").val(data.id_activity);
                $("#judul").val(data.judul);
                $("#isi").val(data.isi);
                $("#keluar").val(data.keluar);
                $("#kembali").val(data.kembali);
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
                url: "{base_url}activity/delete/" + id,
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
