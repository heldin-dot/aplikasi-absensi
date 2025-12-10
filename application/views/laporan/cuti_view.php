<div style="text-align:center"> 
    <h1>LAPORAN CUTI</h1>
</div>
<hr>
<div class="uk-form-row">
    <div class="uk-grid">
        <div class="uk-width-medium-4-4"> 
            <div class="md-card uk-margin-medium-bottom">
                <div class="md-card-content" style="height: 350px;">
                    <form id="form" class="uk-form-stacked"><br>
                        <table>
                            <tr>
                                <td width="150px"></td>
                                <td width="300px"></td>
                                <td width="50px"></td>
                                <td width="300px"></td>
                                <td width="50px"></td>
                            </tr>
                            <tr>
                                <td>Tanggal</td>
                                <td><input id="tanggal1" name="tanggal1" class="uk-form-width-medium" style="width: 100%;" /></td>
                                <td align="center">s/d</td>
                                <td><input id="tanggal2" name="tanggal2" class="uk-form-width-medium" style="width: 100%;" /></td>
                                <td align="center"><input id="tanggal" name="tanggal" type="checkbox" checked="true" onclick="rubahKondisi(this.id, 'kendoDatePicker')"></td>
                            </tr>
                            <tr><td colspan="5"></td></tr>
                            <tr>
                                <td>User </td>
                                <td colspan="3"><input id="user" name="user" style="width: 100%;" /></td>
                                <td></td>
                            </tr>
                            <tr><td colspan="5"></td></tr>
                            <tr>
                                <td>Branch </td>
                                <td colspan="3"><input id="branch" name="branch" style="width: 100%;" /></td>
                                <td></td>
                            </tr>
                            <tr><td colspan="5"></td></tr>
                            <tr>
                                <td>Status </td>
                                <td colspan="3"><input id="status" name="status" style="width: 100%;" /></td>
                                <td></td>
                            </tr>
                        </table>
                        <br><br><br><br><hr>
                        <div class="uk-text-right">
                            <button type="button" class="md-btn md-btn-primary" id="a" onclick="getData()">P R E V I E W</button>
                            <!--<button type="button" class="md-btn md-btn-primary" id="snippet_new_save" onclick="syncData()">SYNC FROM SIMRS</button>-->
                            <button type="button" class="md-btn md-btn-primary" onclick="printData()"> E X P O R T </button>
                            <!--<button type="button" class="md-btn md-btn-primary" id="snippet_new_save" onclick="getData()"> P R E V I E W </button>-->
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


<hr>


<div class="md-card uk-margin-medium-bottom">
    <div class="md-card-content">
        <table id="dt_default" class="uk-table" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>User</th>
                    <th>Branch</th>
                    <th>Tujuan</th>
                    <th>No Darurat</th>
                    <th>Atasan 1</th>
                    <th>Telp 1</th>
                    <th>Atasan 2</th>
                    <th>Telp 2</th>
                    <th>di Handle oleh</th>
                    <th>Tgl Izin</th>
                    <th>Sampai</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</div>






<script type="text/javascript" src="{base_url}asset/js/helper/branch.js"></script>
<script type="text/javascript" src="{base_url}asset/js/helper/user.js"></script>
<script>
    select_branch('{base_url}', '#branch');
    select_user('{base_url}', '#user');
    select_status('#status');
    
    var table ;
    var filter='';
    
    
    $(document).ready(function () {
        $('#tanggal1').kendoDatePicker({format: "dd/MM/yyyy"});
        $('#tanggal2').kendoDatePicker({format: "dd/MM/yyyy"});
        $("#tanggal1").data("kendoDatePicker").value(new Date());
        $("#tanggal2").data("kendoDatePicker").value(new Date());
        $('#tanggal1').data('kendoDatePicker').enable(true);
        $('#tanggal2').data('kendoDatePicker').enable(true);
    });
    
    function select_status(element) {
        $(element).empty();            
        $(element).kendoComboBox({
            dataTextField: "text",
            dataValueField: "value",
            dataSource: [
                        { text: "TERIMA", value: "2" },
                        { text: "TOLAK", value: "1" },
                        { text: "PENDING", value: "0" }
                      ],
            filter: "contains",
            suggest: true,
            index: 3
        });
                
    }
	
    function isi(text, tipe,kondisi){
            $("#"+text+"1").data(tipe).enable(kondisi);
            $("#"+text+"2").data(tipe).enable(kondisi);
    }

    function rubahKondisi(text, tipe){
        console.log(document.getElementById(text).checked);
        if(document.getElementById(text).checked==true){
            isi(text, tipe, true);
        }else{
            isi(text, tipe, false);
        }
    }
    
    function getData(){
        $('#dt_default').dataTable().fnDestroy();
        filterData();
        table = $('#dt_default').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            searching: false,
            ajax: {
                url:'{base_url}laporan/cuti/ajax_list/{id_auth}'+filter,
                type: "POST"
            },
            columnDefs: [
                {width: "100px", targets: -1},
                {width: "100px", targets: -2},
                {width: "100px", targets: -3},
            ],
        });     
    }
	
    function filterData(){
        filter='';

        //GET TANGGAL
        if(document.getElementById('tanggal').checked==true){
                filter = filter + "?tanggal_awal="+encode_tanggal(document.getElementById('tanggal1').value)+"&tanggal_akhir="+encode_tanggal(document.getElementById('tanggal2').value);
        }else{
                filter = filter + "?tanggal_awal=&tanggal_akhir=";
        }
        //GET USER
        if(document.getElementById('user').value!=''){
                filter = filter + "&user="+document.getElementById('user').value;
        }else{
                filter = filter + "&user=";
        }
        //GET BRANCH
        if(document.getElementById('branch').value!=''){
                filter = filter + "&branch="+document.getElementById('branch').value;
        }else{
                filter = filter + "&branch=";
        }
        //GET STATUS
        if(document.getElementById('status').value!=''){
                filter = filter + "&status="+document.getElementById('status').value;
        }else{
                filter = filter + "&status=";
        }
    }
    
    function printData(){
        filterData();
        window.open('{base_url}laporan/cuti/printData'+filter);
    }
</script>