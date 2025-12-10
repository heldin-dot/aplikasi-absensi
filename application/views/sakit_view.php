<h3 class="heading_b uk-margin-bottom">IZIN SAKIT</h3>
<div class="md-card uk-margin-medium-bottom">
    <div class="md-card-content">
        <table id="dt_default" class="uk-table" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>User</th>
                    <th>Diagnosa</th>
                    <th>Tgl Izin</th>
                    <th>Sampai</th>
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
    <div class="uk-modal-dialog" style="width: 70%">
        <form id="form" class="uk-form-stacked">
            <input type="hidden" class="md-input" id="id_sakit" name="id_sakit"/>
            <input type="hidden" class="md-input" id="datafoto" name="datafoto"/>
            <div class="uk-form-row">
                <div class="uk-grid">
                <div class="uk-width-medium-3-6">
                    <div class="uk-width-medium-4-4">
                        <div class="uk-grid" style="margin-top: 5px">
                            <div class="uk-width-medium-1-4">
                                <label for="diagnosa" class="uk-form-label">Diagnosa</label>
                            </div>
                            <div class="uk-width-medium-3-4">
                                <input id="diagnosa" name="diagnosa" class="k-textbox" style="width: 70%;" />
                            </div>
                        </div>
                    </div>
                    <div class="uk-width-medium-4-4">
                        <div class="uk-grid" style="margin-top: 5px">
                            <div class="uk-width-medium-1-4">
                                <label for="tgl_mulai" class="uk-form-label">Tgl Izin</label>
                            </div>
                            <div class="uk-width-medium-3-4">
                                <input id="tgl_mulai" name="tgl_mulai" class="" style="width: 70%;" />
                            </div>
                        </div>
                    </div>
                    <div class="uk-width-medium-4-4">
                        <div class="uk-grid" style="margin-top: 5px">
                            <div class="uk-width-medium-1-4">
                                <label for="tgl_akhir" class="uk-form-label">Sampai</label>
                            </div>
                            <div class="uk-width-medium-3-4">
                                <input id="tgl_akhir" name="tgl_akhir" class="" style="width: 70%;" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="uk-width-medium-3-6">
                    <div class="uk-grid" style="margin-top: 5px">
                        <div class="uk-width-medium-2-6">
                            <label for="bukti" class="uk-form-label">Foto Surat Dokter</label>
                        </div>
                        <div class="uk-width-medium-4-6">
                            <div align="center"><img id="foto_img" src="#" width="60%" alt="Foto"></div>
                            <div class="uk-form-file md-btn md-btn-primary md-btn-block">
                                Pilih Foto
                                <input id="foto" name="foto" type="file" accept="image/*" onchange="PreviewImage(this,'foto')">
                            </div>
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
        
        $('#tgl_mulai').kendoDatePicker({format: "dd/MM/yyyy"});
        $('#tgl_akhir').kendoDatePicker({format: "dd/MM/yyyy"});
        $("#tgl_mulai").data("kendoDatePicker").value(new Date());
        $("#tgl_akhir").data("kendoDatePicker").value(new Date());
        
        console.log({user_tipe});
        var url;
        if('{user_tipe}' == 1){
            url = "{base_url}sakit/ajax_list/{id_auth}?key=id_user&val={user_id}";
        }else{
            url = "{base_url}sakit/ajax_list/{id_auth}";
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
        $("#id_sakit").val('');
        $('#foto_img').attr('src', '{base_url}files/image/user/no_photo.png');
    }

    function simpan() {
        var url;
        var foto = '';
        if (save_method == 'add') {
            url = "{base_url}sakit/add";
        } else {
            url = "{base_url}sakit/update";
        }
        if (document.getElementById('foto').files.length !== 0) {
            var formDataF = new FormData($('#form')[0]);
            $.ajax({
                url: "{base_url}sakit/upload_file/foto",
                type: "POST",
                data: formDataF,
                async: false,
                success: function (data) {
                    console.log(data);
                    var result = eval('(' + data + ')');

                    if (result.success) {
                        $("#datafoto").val(result.foto);
                    } else {
                        $("#datafoto").val('no_photo.png');
                        $success = false;
                    }
                },
                cache: false,
                contentType: false,
                processData: false
            });
        }
        
        $.ajax({
            url: url,
            type: "POST",
            data: {
                id_sakit: $("#id_sakit").val(),
                diagnosa: $("#diagnosa").val(), 
                tgl_mulai: $("#tgl_mulai").val(),
                tgl_akhir: $("#tgl_akhir").val(),
                foto: $("#datafoto").val(),
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
            url: "{base_url}sakit/edit/" + id,
            type: "GET",
            dataType: "JSON",
            success: function (data) {
                $("#id_sakit").val(data.id_sakit);
                $("#datafoto").val(data.foto);
                $("#diagnosa").val(data.diagnosa);
                $("#tgl_mulai").val(decode_tanggal(data.tgl_mulai));
                $("#tgl_akhir").val(decode_tanggal(data.tgl_akhir));
                
                foto = data.foto === '' ? 'no_photo.png' : data.foto;
                image_url = '{base_url}files/image/sakit/' + foto;
                $.get(image_url)
                        .done(function () {
                            $('#foto_img').attr('src', image_url);
                        })
                        .fail(function () {
                            $('#foto_img').attr('src', '{base_url}files/image/user/no_photo.png');
                        });
                        
                        
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
                url: "{base_url}sakit/delete/" + id,
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
    
    function PreviewImage(input,id) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
//            console.log(id);
            reader.onload = function (e) {
                $('#'+id+'_img').attr('src', e.target.result);
            };

            reader.readAsDataURL(input.files[0]);
        }
    }

    

</script>
