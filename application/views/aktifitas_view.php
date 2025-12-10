<h3 class="heading_b uk-margin-bottom">Aktifitas</h3>
<div class="md-card uk-margin-medium-bottom">
    <div class="md-card-content">
        <table id="dt_default" class="uk-table" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>User</th>
                    <th>Tanggal</th>
                    <th>Kota</th>
                    <th>Tipe Survey</th>
                    <th>Survey</th>
                    <th>Keterangan</th>
                    <th>Tipe Unit</th>
                    <th>No Polisi</th>
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
            <input type="hidden" class="md-input" id="id_aktifitas" name="id_aktifitas"/>
            <div class="uk-form-row">
                <div class="uk-grid">
                    <div class="uk-width-medium-4-4">
                        <div class="uk-grid" style="margin-top: 5px">
                            <div class="uk-width-medium-1-4">
                                <label for="tanggal" class="uk-form-label">Tanggal</label>
                            </div>
                            <div class="uk-width-medium-3-4">
                                <input id="tanggal" name="tanggal" class="" style="width: 70%;" />
                            </div>
                        </div>
                    </div>
                    <div class="uk-width-medium-4-4">
                        <div class="uk-grid" style="margin-top: 5px">
                            <div class="uk-width-medium-1-4">
                                <label for="id_branch" class="uk-form-label">Kota</label>
                            </div>
                            <div class="uk-width-medium-3-4">
                                <input id="id_branch" name="id_branch" class="" placeholder="Select Branch" style="width: 70%;" />
                            </div>
                        </div>
                    </div>
                    <div class="uk-width-medium-4-4">
                        <div class="uk-grid" style="margin-top: 5px">
                            <div class="uk-width-medium-1-4">
                                <label for="tipe" class="uk-form-label">Tipe Survey</label>
                            </div>
                            <div class="uk-width-medium-3-4">
                                <input id="tipe" name="tipe" class="" placeholder="Select Tipe Survey" style="width: 70%;" />
                            </div>
                        </div>
                    </div>
                    <div class="uk-width-medium-4-4">
                        <div class="uk-grid" style="margin-top: 5px">
                            <div class="uk-width-medium-1-4">
                                <label for="survey" class="uk-form-label">Survey</label>
                            </div>
                            <div class="uk-width-medium-3-4">
                                <input id="survey" name="survey" class="" placeholder="Select Survey" style="width: 70%;" />
                            </div>
                        </div>
                    </div>
                    <div class="uk-width-medium-4-4">
                        <div class="uk-grid" style="margin-top: 5px">
                            <div class="uk-width-medium-1-4">
                                <label for="ket" class="uk-form-label">Keterangan</label>
                            </div>
                            <div class="uk-width-medium-3-4">
                                <textarea id="ket" name="ket" class="k-textbox" placeholder="AMCXXXX / Risk" rows="4" style="width: 70%;" ></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="uk-width-medium-4-4">
                        <div class="uk-grid" style="margin-top: 5px">
                            <div class="uk-width-medium-1-4">
                                <label for="unit" class="uk-form-label">Tipe Unit</label>
                            </div>
                            <div class="uk-width-medium-3-4">
                                <input id="unit" name="unit" class="k-textbox" placeholder="Merk Mobil & Type" style="width: 70%;" />
                            </div>
                        </div>
                    </div>
                    <div class="uk-width-medium-4-4">
                        <div class="uk-grid" style="margin-top: 5px">
                            <div class="uk-width-medium-1-4">
                                <label for="nopol" class="uk-form-label">No Polisi</label>
                            </div>
                            <div class="uk-width-medium-3-4">
                                <input id="nopol" name="nopol" class="k-textbox" placeholder="Plat No Mobil" style="width: 70%;" />
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
<script type="text/javascript" src="{base_url}asset/js/helper/branch.js"></script>

<script>
    select_branch('{base_url}', '#id_branch');
    select_tipe_survey('#tipe');
    select_survey('#survey');

    var save_method;
    var table;
    
    
    $(document).ready(function () { 
        
        $('#tanggal').kendoDatePicker({format: "dd/MM/yyyy"});
        $("#tanggal").data("kendoDatePicker").value(new Date());
        if('{user_tipe}'!=0){
            $("#id_branch").kendoComboBox({ enabled: false });
        }else{
            $("#id_branch").kendoComboBox({ enabled: true });
        }
        
        console.log({user_tipe});
        var url;
        if('{user_tipe}' == 1){
            url = "{base_url}aktifitas/ajax_list/{id_auth}?key=id_user&val={user_id}";
        }else{
            url = "{base_url}aktifitas/ajax_list/{id_auth}";
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
    

    function select_tipe_survey(element) {        
        $(element).empty();            
        $(element).kendoComboBox({
            dataTextField: "text",
            dataValueField: "value",
            dataSource: [
                        { text: "Claim Tambahan", value: "Claim Tambahan" },
                        { text: "Monitoring", value: "Monitoring" },
                        { text: "Claim", value: "Claim" },
                        { text: "Risk", value: "Risk" },
                        { text: "Lain-lain", value: "Lain-lain" }
                      ],
            filter: "contains",
            suggest: true,
//            index: 3,
        });
    }
    function select_survey(element) {        
        $(element).empty();            
        $(element).kendoComboBox({
            dataTextField: "text",
            dataValueField: "value",
            dataSource: [
                        { text: "Walk In", value: "Walk In" },
                        { text: "Walk Out", value: "Walk Out" }
                      ],
            filter: "contains",
            suggest: true,
//            index: 3,
        });
    }
    
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
//        $('#form')[0].reset();
        $("#id_aktifitas").val('');
        $("#tipe").val('');
        $("#survey").val('');
        $("#ket").val('');
        $("#unit").val('');
        $("#nopol").val('');
        $("#tanggal").data("kendoDatePicker").value(new Date());
        $("#id_branch").data("kendoComboBox").value('{user_branch}');
    }

    function simpan() {
        var url;
        if (save_method == 'add') {
            url = "{base_url}aktifitas/add";
        } else {
            url = "{base_url}aktifitas/update";
        }
        
        $.ajax({
            url: url,
            type: "POST",
            data: {
                id_aktifitas: $("#id_aktifitas").val(),
                tanggal: $("#tanggal").val(), 
                id_branch: $("#id_branch").val(),
                tipe: $("#tipe").val(),
                survey: $("#survey").val(),
                ket: $("#ket").val(),
                unit: $("#unit").val(),
                nopol: $("#nopol").val(),
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
            url: "{base_url}aktifitas/edit/" + id,
            type: "GET",
            dataType: "JSON",
            success: function (data) {
                $("#id_aktifitas").val(data.id_aktifitas);
                $("#tanggal").val(decode_tanggal(data.tanggal));
//                $("#id_branch").val(data.id_branch);
                $("#id_branch").data("kendoComboBox").value(data.id_branch);
//                console.log(data.id_branch);
                $("#tipe").data("kendoComboBox").value(data.tipe);
//                $("#tipe").val(data.tipe);
                $("#survey").data("kendoComboBox").value(data.survey);
//                $("#survey").val(data.survey);
                $("#ket").val(data.ket);
                $("#unit").val(data.unit);
                $("#nopol").val(data.nopol);
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
                url: "{base_url}aktifitas/delete/" + id,
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
