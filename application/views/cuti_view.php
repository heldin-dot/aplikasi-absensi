

  
  <h3 class="heading_b uk-margin-bottom">IZIN CUTI</h3>
<div class="md-card uk-margin-medium-bottom">
    <div class="md-card-content">
        <div>
            Keterangan : 
            <label style="background-color: #D3D3D3; border: 1px solid; width: 100px;"> &nbsp;&nbsp;&nbsp;&nbsp; </label> &nbsp; Pending &nbsp; &nbsp;
            <label style="background-color: #CD5C5C; border: 1px solid; width: 100px;"> &nbsp;&nbsp;&nbsp;&nbsp; </label> &nbsp; Di Tolak &nbsp; &nbsp;
            <label style="background-color: #228B22; border: 1px solid; width: 100px;"> &nbsp;&nbsp;&nbsp;&nbsp; </label> &nbsp; Di Terima
        </div><hr>
        <table id="dt_default" class="uk-table" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>Status</th>
                    <th>User</th>
                    <th>Tujuan</th>
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
            <input type="hidden" class="md-input" id="id_cuti" name="id_cuti"/>
            <input type="hidden" class="md-input" id="datafoto" name="datafoto"/>
            <input type="hidden" class="md-input" id="imagefoto" name="imagefoto"/>
            <div class="uk-form-row">
                <div class="uk-grid">
                <div class="uk-width-medium-3-6">
                    <div class="uk-width-medium-4-4">
                        <div class="uk-grid" style="margin-top: 5px">
                            <div class="uk-width-medium-1-4">
                                <label for="tujuan" class="uk-form-label">Tujuan</label>
                            </div>
                            <div class="uk-width-medium-3-4">
                                <input id="tujuan" name="tujuan" class="k-textbox" style="width: 70%;" />
                            </div>
                        </div>
                    </div>
                    <div class="uk-width-medium-4-4">
                        <div class="uk-grid" style="margin-top: 5px">
                            <div class="uk-width-medium-1-4">
                                <label for="darurat" class="uk-form-label">No Telp Darurat di Tujuan</label>
                            </div>
                            <div class="uk-width-medium-3-4">
                                <input id="darurat" name="darurat" class="k-textbox" style="width: 70%;" />
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
                    <div class="uk-width-medium-4-4">
                        <div class="uk-grid" style="margin-top: 5px">
                            <div class="uk-width-medium-1-4">
                                <label for="atasan1" class="uk-form-label">Approve Atasan 1</label>
                            </div>
                            <div class="uk-width-medium-3-4">
                                <input id="atasan1" name="atasan1" class="k-textbox" style="width: 70%;" />
                            </div>
                        </div>
                    </div>
                    <div class="uk-width-medium-4-4">
                        <div class="uk-grid" style="margin-top: 5px">
                            <div class="uk-width-medium-1-4">
                                <label for="telp1" class="uk-form-label">Telp Atasan 1</label>
                            </div>
                            <div class="uk-width-medium-3-4">
                                <input id="telp1" name="telp1" class="k-textbox" style="width: 70%;" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="uk-width-medium-3-6">
                    <div class="uk-width-medium-4-4">
                        <div class="uk-grid" style="margin-top: 5px">
                            <div class="uk-width-medium-1-4">
                                <label for="atasan2" class="uk-form-label">Approve Atasan 2</label>
                            </div>
                            <div class="uk-width-medium-3-4">
                                <input id="atasan2" name="atasan2" class="k-textbox" style="width: 70%;" />
                            </div>
                        </div>
                    </div>
                    <div class="uk-width-medium-4-4">
                        <div class="uk-grid" style="margin-top: 5px">
                            <div class="uk-width-medium-1-4">
                                <label for="telp2" class="uk-form-label">Telp Atasan 2</label>
                            </div>
                            <div class="uk-width-medium-3-4">
                                <input id="telp2" name="telp2" class="k-textbox" style="width: 70%;" />
                            </div>
                        </div>
                    </div>
                    <div class="uk-width-medium-4-4">
                        <div class="uk-grid" style="margin-top: 5px">
                            <div class="uk-width-medium-1-4">
                                <label for="handle" class="uk-form-label">Selama Cuti di handle oleh </label>
                            </div>
                            <div class="uk-width-medium-3-4">
                                <input id="handle" name="handle" class="k-textbox" style="width: 70%;" />
                            </div>
                        </div>
                    </div>
                    <!--<div class="uk-grid" style="margin-top: 5px">-->
<!--                        <div class="uk-width-medium-2-6">
                            <div align="center"><img id="foto_img" src="#" width="100%" alt="Foto"><br>Tanda Tangan</div>
                        </div>-->
<!--                        <div class="uk-width-medium-4-6">
                            <div id="canvas" style="border-style: solid">
                                    Canvas is not supported.
                            </div><hr>
                            <button type="button" onclick="zkSignature.clear()" class="md-btn md-btn-info">
                                    Clear TTD
                            </button>
                            <button type="button" onclick="zkSignature.save()" class="md-btn md-btn-info">
                                    SAVE TTD
                            </button>

                            <script>
                                    zkSignature.capture();
                            </script>-->
                            
<!--                            <div class="uk-form-file md-btn md-btn-primary md-btn-block">
                                Pilih Foto
                                <input id="foto" name="foto" type="file" accept="image/*" onchange="PreviewImage(this,'foto')">
                            </div>-->
                        <!--</div>-->
                    <!--</div>-->
                </div>
                </div>
            </div>
            <div class="uk-modal-footer uk-text-right">
                <button type="button" class="md-btn md-btn-primary" id="approve" onclick="terima('2')">Terima</button>
                <button type="button" class="md-btn md-btn-danger" id="reject" onclick="terima('1')">Tolak</button>
                <button type="button" class="md-btn md-btn-flat uk-modal-close">Tutup</button>
                <button type="button" class="md-btn md-btn-flat md-btn-flat-primary" id="snippet_new_save" onclick="simpan()">Simpan</button>
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
            url = "{base_url}cuti/ajax_list/{id_auth}?key=id_user&val={user_id}";
        }else{
            url = "{base_url}cuti/ajax_list/{id_auth}";
        }
        table = $('#dt_default').DataTable({
            "fnRowCallback" : function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
                if (aData[0]=="0"){
                        $(nRow).css('background-color', '#D3D3D3');
                        $(nRow).css('color', '#FFFFFF');
                } 
                if (aData[0]=="1"){
                        $(nRow).css('background-color', '#CD5C5C');
                        $(nRow).css('color', '#FFFFFF');
                } 
                if (aData[0]=="2"){
                        $(nRow).css('background-color', '#228B22');
                        $(nRow).css('color', '#FFFFFF');
                } 
            },
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
                {
                    targets: [ 0 ],
                    visible: false,
                    searchable: false
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
//        zkSignature.clear()
        save_method = 'add';
        $('#form')[0].reset();
        $("#id_cuti").val('');
        $('#foto_img').attr('src', '{base_url}files/image/user/no_photo.png');
        $('#approve').css('visibility','hidden');
        $('#reject').css('visibility','hidden');
        $('#snippet_new_save').css('visibility','visible');
    }

    function simpan() {
        var url;
//        var foto = '';
        if (save_method == 'add') {
            url = "{base_url}cuti/add";
        } else {
            url = "{base_url}cuti/update";
        }
        if ($("#datafoto").val() != '') {
            $.ajax({
                url: "{base_url}cuti/upload_file",
                type: "POST",
                async: false,
                data: {
                    image: $("#datafoto").val()
                },
                dataType: "JSON",
                success: function (data)
                {
                    console.log(data.image);
                    $("#imagefoto").val(data.image);
                },
                error: function (jqXHR, textStatus, errorThrown)
                {
                    console.log(errorThrown);
                }
            });
        }
//        if (document.getElementById('foto').files.length !== 0) {
//            var formDataF = new FormData($('#form')[0]);
//            $.ajax({
//                url: "{base_url}cuti/upload_file/foto",
//                type: "POST",
//                data: formDataF,
//                async: false,
//                success: function (data) {
//                    console.log(data);
//                    var result = eval('(' + data + ')');
//
//                    if (result.success) {
//                        $("#datafoto").val(result.foto);
//                    } else {
//                        $("#datafoto").val('no_photo.png');
//                        $success = false;
//                    }
//                },
//                cache: false,
//                contentType: false,
//                processData: false
//            });
//        }
        
        $.ajax({
            url: url,
            type: "POST",
            data: {
                id_cuti: $("#id_cuti").val(),
                tujuan: $("#tujuan").val(), 
                tgl_mulai: $("#tgl_mulai").val(),
                tgl_akhir: $("#tgl_akhir").val(),
                atasan1: $("#atasan1").val(),
                telp1: $("#telp1").val(),
                atasan2: $("#atasan2").val(),
                telp2: $("#telp2").val(),
                darurat: $("#darurat").val(),
                handle: $("#handle").val(),
                foto: $("#imagefoto").val(),
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
//        zkSignature.clear()

        $.ajax({
            url: "{base_url}cuti/edit/" + id,
            type: "GET",
            dataType: "JSON",
            success: function (data) {
                $("#id_cuti").val(data.id_cuti);
                $("#imagefoto").val(data.foto);
                $("#tujuan").val(data.tujuan);
                $("#tgl_mulai").val(decode_tanggal(data.tgl_mulai));
                $("#tgl_akhir").val(decode_tanggal(data.tgl_akhir));
                $("#atasan1").val(data.atasan1);
                $("#telp1").val(data.telp1);
                $("#atasan2").val(data.atasan2);
                $("#telp2").val(data.telp2);
                $("#darurat").val(data.darurat);
                $("#handle").val(data.handle);
                if(data.status=='0'){
                    $('#approve').css('visibility','visible');
                    $('#reject').css('visibility','visible');
                    $('#snippet_new_save').css('visibility','visible');
                }else{
                    $('#approve').css('visibility','hidden');
                    $('#reject').css('visibility','hidden');
                    $('#snippet_new_save').css('visibility','hidden');
                }
                if('{user_tipe}'=='1'){
                    $('#approve').css('visibility','hidden');
                    $('#reject').css('visibility','hidden');
                }
                
//                foto = data.foto === '' ? 'no_photo.png' : data.foto;
//                image_url = '{base_url}files/image/ttd/' + foto;
//                $.get(image_url)
//                        .done(function () {
//                            $('#foto_img').attr('src', image_url);
//                        })
//                        .fail(function () {
//                            $('#foto_img').attr('src', '{base_url}files/image/user/no_photo.png');
//                        });
                        
                        
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
                url: "{base_url}cuti/delete/" + id,
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

    function terima(status) {
        $.ajax({
            url: '{base_url}cuti/update',
            type: "POST",
            data: {
                id_cuti: $("#id_cuti").val(),
                tujuan: $("#tujuan").val(), 
                tgl_mulai: $("#tgl_mulai").val(),
                tgl_akhir: $("#tgl_akhir").val(),
                status: status,
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
