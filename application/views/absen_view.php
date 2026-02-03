
<!--<h2>Welcome to E-Absen</h2><hr>-->


<div class="uk-form-row">
<div class="uk-grid">
    <div class="uk-width-xlarge-4-6">
        <div class="md-card">
            <div class="md-card-toolbar">
                <h3 class="md-card-toolbar-heading-text">
                    Absensi
                </h3>
            </div>
            <div class="md-card-content">
                <div style="text-align:center">
                    <button type="button" class="md-btn md-btn-primary md-btn-large md-btn-block" href="javascript:void(0)" onclick="simpan()">Absen Masuk</button><br><br>
                    Waktu Sekarang : <br> 
                    <b><label id="tglSekarang" style="font-size: 20px;"> - </label></b><br>
                    <b><label id="waktuSekarang" style="font-size: 40px;"> - </label></b><br>
                    <b><label id="tempatSekarang" style="font-size: 20px;"> - </label></b><br><br>					
                    <button type="button" class="md-btn md-btn-warning md-btn-large md-btn-block" href="javascript:void(0)" onclick="update()">Absen Pulang</button>
<!--                    <form id="formIn">
                        <input type="file" id="in_capture" name="in_capture" accept="image/*" capture="camera" onchange="simpan()" style="visibility: hidden;"/>
                    </form>
                    <button type="button" class="md-btn md-btn-primary md-btn-block" href="javascript:void(0)" onclick="cekFotoCekin()">Checkin</button>
                    <form id="formOut">
                        <input type="file" id="out_capture" name="out_capture" accept="image/*" capture="camera" onchange="update()" style="visibility: hidden;"/>
                    </form>
                    <button type="button" class="md-btn md-btn-warning md-btn-block" href="javascript:void(0)" onclick="cekFotoCekout()">Checkout</button>-->
                </div>
            </div>
        </div><br>
    </div>
    <div class="uk-width-xlarge-2-6">
        <div class="md-card">
            <div class="md-card-toolbar">
                <h3 class="md-card-toolbar-heading-text">
                    Log Today
                </h3>
            </div>
            <div class="md-card-content"><b>
                <div style="text-align:center">
                    ABSEN MASUK : <br><label id="masuk" style="font-size: 20px;"></label><br><br>
                    ABSEN PULANG : <br><label id="keluar" style="font-size: 20px;"></label><br><br></b>
                </div>
            </div>
        </div>
    </div>
</div>
</div>



<script>
    var in_capture = '';
    var out_capture = '';
    var lon = null;
    var lat = null;
    var id = '';
    var in_date = '';
    var out_date = '';
    
    function cekFotoCekin(){
        document.getElementById("in_capture").click();
    }
    function cekFotoCekout(){
        document.getElementById("out_capture").click();
    }
    function cek(callback){
        var url = "<?php echo base_url('absen/getAbsen/'); ?>" + "<?php echo $user_id; ?>";
        $.ajax({
            url: url,
            type: "POST",
            data: {},
            dataType: "JSON",
            success: function (data)
            {
                if(data != null && typeof data === 'object'){
                    if(data.id_absen) {
                        id = data.id_absen;
                        in_date = data.in_date ? data.in_date : '';
                        out_date = data.out_date ? data.out_date : '';
                        
                        if(in_date && in_date.length > 10) {
                            var masukTime = in_date.substring(11, 19);
                            document.getElementById('masuk').innerHTML = masukTime;
                        }
                        
                        if(out_date && out_date !== '0000-00-00 00:00:00' && out_date.length > 10) {
                            var keluarTime = out_date.substring(11, 19);
                            document.getElementById('keluar').innerHTML = keluarTime;
                        }
                        
                        in_capture = data.in_capture ? data.in_capture : '';					
                        out_capture = data.out_capture ? data.out_capture : '';
                    }
                }
                if(callback) callback();
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                if(callback) callback();
            }
        });
    }
    
    function startTime() {
        // Ambil waktu dari server sesuai timezone branch user (bukan dari browser)
        $.ajax({
            url: "<?php echo base_url('absen/getWaktuServer'); ?>",
            type: "GET",
            dataType: "text",
            success: function(serverTime) {
                // serverTime format: "Y-m-d H:i:s" (misal: "2026-02-03 14:30:45")
                if(serverTime && serverTime.length > 10) {
                    var monthNames = [ "Jan", "Feb", "Mar", "Apr", "May", "Jun", 
                                       "Jul", "Aug", "Sep", "Oct", "Nov", "Dec" ];
                    var days = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
                    
                    // Parse server time
                    var datePart = serverTime.substring(0, 10); // "2026-02-03"
                    var timePart = serverTime.substring(11, 19); // "14:30:45"
                    
                    var parts = datePart.split('-');
                    var year = parseInt(parts[0]);
                    var month = parseInt(parts[1]) - 1;
                    var day = parseInt(parts[2]);
                    
                    var timeParts = timePart.split(':');
                    var h = timeParts[0];
                    var m = timeParts[1];
                    var s = timeParts[2];
                    
                    var serverDate = new Date(year, month, day);
                    var dayName = days[serverDate.getDay()];
                    var month_Name = monthNames[month];
                    
                    document.getElementById('tglSekarang').innerHTML = dayName + ", " + day + " " + month_Name + " " + year;
                    document.getElementById('waktuSekarang').innerHTML = h + ":" + m + ":" + s;
                }
            },
            error: function() {
            }
        });
        
        // Update every 1000ms (1 detik)
        var t = setTimeout(startTime, 1000);
    }
    function getLocation() {
		lon = null;
		lat = null;
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(showPosition, showError, {timeout: 10000, enableHighAccuracy: true});
        } else { 
            document.getElementById('tempatSekarang').innerHTML = "<span style='color:red'>Geolocation not supported</span>";
            UIkit.modal.alert("Geolocation tidak didukung oleh browser ini.");
        }
        function showPosition(position) {
            lon = position.coords.longitude;
            lat = position.coords.latitude;
            document.getElementById('tempatSekarang').innerHTML = "Lat: " + lat.toFixed(6) + "<br>Lon: " + lon.toFixed(6);
        }
        function showError(error) {
            document.getElementById('tempatSekarang').innerHTML = "<span style='color:red'>Lokasi tidak ditemukan</span>";
            UIkit.modal.alert("Gagal mengakses lokasi. Pastikan izin lokasi sudah diberikan.");
        }

    }
 

    function simpan() {
        if(!id || id === ''){
            var stat = 'add';
        }else{
            var stat = 'update';
        }
			var waktu = '0000-00-00 00:00:00';
			$.ajax({
				url: "<?php echo base_url('absen/getWaktuServer'); ?>",
				type: "POST",
				async: false,
				//dataType: "JSON",
				success: function (data)
				{
					waktu = data;
				},
				error: function (jqXHR, textStatus, errorThrown)
				{
				}
			});
            var today = new Date();
            var y = today.getYear() + 1900;
            var d = today.getDate();
            var m = today.getMonth()+1;
            var h = today.getHours();
            var i = today.getMinutes();
            var s = today.getSeconds();
            
            if(!lon || lon === 'null' || !lat || lat === 'null' || lon === null || lat === null){
                UIkit.modal.alert("Lokasi tidak ditemukan.");
            }else{
                if(!in_date || in_date === '0000-00-00 00:00:00' || in_date === '' || in_date === null){
                    $.ajax({
                            url: "<?php echo base_url('absen/'); ?>"+stat,
                            type: "POST",
                            data: {
                                    id_absen: id,
//                                    in_capture: in_capture,
                                    id_user: '<?php echo $user_id; ?>', 
                                    in_date: waktu,
                                    in_long: lon,
                                    in_lat: lat,
                                    id_branch: '<?php echo $user_branch; ?>',
                                    status: '0',
                                    method: stat
                            },
                            dataType: "JSON",
                            success: function (data)
                            {
                                    if (data.success) {
                                            // Gunakan callback untuk tunggu cek() selesai
                                            cek(function() {
                                                var masukTime = document.getElementById('masuk').innerHTML;
                                                if(masukTime && masukTime.trim() !== '') {
                                                    UIkit.modal.alert("Waktu masuk anda : " + masukTime);
                                                } else {
                                                    UIkit.modal.alert("Absen masuk berhasil. Waktu: " + waktu);
                                                }
                                            });
                                    } else {
                                            UIkit.modal.alert(data.msg);
                                    }
                                    modal.hide();
                            },
                            beforeSend: function(){                
                                    modal = UIkit.modal.blockUI("<img src='<?php echo base_url('asset/altair/assets/img/spinners/spinner.gif'); ?>'> Proses...");
                            },
                            error: function (jqXHR, textStatus, errorThrown)
                            {
                                    modal.hide();
                            }
                        });
                }else{
                        UIkit.modal.alert("Anda telah melakukan Absen Masuk pada hari ini. ");
                }
            }
//            $("#in_capture").val('');
    }
    function update() {
        if(id && id !== ''){
			
			var waktu = '0000-00-00 00:00:00';
			$.ajax({
				url: "<?php echo base_url('absen/getWaktuServer'); ?>",
				type: "POST",
				async: false,
				//dataType: "JSON",
				success: function (data)
				{
					waktu = data;
				},
				error: function (jqXHR, textStatus, errorThrown)
				{
				}
			});
            var today = new Date();
            var y = today.getYear() + 1900;
            var d = today.getDate();
            var m = today.getMonth()+1;
            var h = today.getHours();
            var i = today.getMinutes();
            var s = today.getSeconds();
        
            if(!lon || lon === 'null' || !lat || lat === 'null' || lon === null || lat === null){
                UIkit.modal.alert("Lokasi tidak ditemukan.");
            }else{
//                if(out_date=='0000-00-00 00:00:00' || out_date==''){
                    $.ajax({
                            url: "<?php echo base_url('absen/update'); ?>",
                            type: "POST",
                            data: {
                                    id_absen: id,
    //                                out_capture: out_capture,
                                    id_user: '<?php echo $user_id; ?>', 
                                    out_date: waktu,
                                    out_long: lon,
                                    out_lat: lat,
                                    status: '1',
                                    method: 'update'
                            },
                            dataType: "JSON",
                            success: function (data)
                            {
                                if (data.success) {
                                    // Gunakan callback untuk tunggu cek() selesai
                                    cek(function() {
                                        var keluarTime = document.getElementById('keluar').innerHTML;
                                        if(keluarTime && keluarTime.trim() !== '') {
                                            UIkit.modal.alert("Waktu cekout anda : " + keluarTime);
                                        } else {
                                            UIkit.modal.alert("Absen pulang berhasil. Waktu: " + waktu);
                                        }
                                    });
                                } else {
                                    UIkit.modal.alert(data.msg);
                                }
                                modal.hide();
                            },
                            beforeSend: function(){                
                                modal = UIkit.modal.blockUI("<img src='<?php echo base_url('asset/altair/assets/img/spinners/spinner.gif'); ?>'> Proses...");
                            },
                            error: function (jqXHR, textStatus, errorThrown)
                            {
                                modal.hide();
                            }
                    });	
//                }else{
//                        UIkit.modal.alert("Anda telah melakukan Absen Pulang pada hari ini. ");
//                }
            }
        }
//        $("#out_capture").val('');
    }
    
    // Initialize on page load
    startTime();
    getLocation();
    cek();
</script>