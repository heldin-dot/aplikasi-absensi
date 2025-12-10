
<h2>Welcome to E-Absen</h2><hr>


<div class="uk-form-row">
<div class="uk-grid">
    <div class="uk-width-xlarge-4-6">
<!--        <div class="md-card">
            <div class="md-card-toolbar">
                <h3 class="md-card-toolbar-heading-text">HISTORY ACTIVITY</h3>
            </div>
            <div class="md-card-content">
                <div class="uk-grid" data-uk-grid-margin="">
                    <div class="uk-width-medium-1-3">
                        <div class="md-card md-card-primary">
                            <div class="md-card-content" style="text-align:center">
                                <label style="font-size: 20px;"> This Month </label><hr>
                                <b><label id="bulanini" style="font-size: 40px;">  </label></b>
                            </div>
                        </div>
                    </div>
                    <div class="uk-width-medium-1-3">
                        <div class="md-card md-card-danger">
                            <div class="md-card-content" style="text-align:center">
                                <label style="font-size: 20px;"> This Year </label><hr>
                                <b><label id="tahunini" style="font-size: 40px;">  </label></b>
                            </div>
                        </div>
                    </div>
                    <div class="uk-width-medium-1-3">
                        <div class="md-card md-card-success">
                            <div class="md-card-content" style="text-align:center">
                                <label style="font-size: 20px;"> All Time </label><hr>
                                <b><label id="semua" style="font-size: 40px;">  </label></b>
                            </div>
                        </div>
                    </div>
                </div>\
            </div>
        </div>-->
    </div>
    <div class="uk-width-xlarge-2-6">
        <div class="md-card">
            <div class="md-card-toolbar">
                <h3 class="md-card-toolbar-heading-text">PENGUMUMAN</h3>
            </div>
            <div class="md-card-content" style="height: 500px;overflow-x: scroll;">
                <div id="contenLogToday">
                    
                </div>
            </div>
        </div><br>
    </div>
</div>
</div>


<script>
    
    $.ajax({
        url: "{base_url}pengumuman/get",
        type: "POST",
        data: {
        },
        dataType: "JSON",
        success: function (data)
        {
            var listData = ''; 
            
            for(var i=0; i<data.length;i++){
                listData = listData + '<b>'+data[i].judul+'</b><br>'+
                                    data[i].isi+'<br><br>'+
                                    '<div style="text-align:right"><i><font size="1">'+data[i].modified_date+'</font></i></div><hr>';
            }
//            $('div#contenLogToday').append(data);
            document.getElementById("contenLogToday").innerHTML = listData;
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            console.log(errorThrown);
        }
    });
    
</script>