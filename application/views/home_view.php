<!doctype html>
<!--[if lte IE 9]> <html class="lte-ie9" lang="en"> <![endif]-->
<!--[if gt IE 9]><!--> <html lang="en"> <!--<![endif]-->
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="initial-scale=1.0,maximum-scale=1.0,user-scalable=no">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <!-- Remove Tap Highlight on Windows Phone IE -->
        <meta name="msapplication-tap-highlight" content="no"/>

        <!--<link rel="icon" href="{base_url}asset/image/logo-1.png">-->
<!--        <link rel="icon" type="image/png" href="{base_url}asset/altair/assets/img/favicon-16x16.png" sizes="16x16">
        <link rel="icon" type="image/png" href="{base_url}asset/altair/assets/img/favicon-32x32.png" sizes="32x32">-->
    <link rel="icon" type="image/png" href="{base_url}files/image/logo2.png" sizes="16x16">

        <title>Admin</title>

    <!--<link rel="stylesheet" href="{base_url}asset/js/signatur/signature-pad.css">-->
    
        <!-- additional styles for plugins -->
        <!-- weather icons -->
        <!--<link rel="stylesheet" href="{base_url}asset/altair/bower_components/weather-icons/css/weather-icons.min.css" media="all">-->
        <!-- metrics graphics (charts) -->
        <!--<link rel="stylesheet" href="{base_url}asset/altair/bower_components/metrics-graphics/dist/metricsgraphics.css">-->
        <!-- chartist -->
        <!--<link rel="stylesheet" href="{base_url}asset/altair/bower_components/chartist/dist/chartist.min.css">-->
        
        <link rel="stylesheet" href="{base_url}asset/altair/bower_components/codemirror/lib/codemirror.css">
        
        <!-- uikit -->
        <link rel="stylesheet" href="{base_url}asset/altair/bower_components/uikit/css/uikit.almost-flat.min.css" media="all">

        <!-- flag icons -->
        <link rel="stylesheet" href="{base_url}asset/altair/assets/icons/flags/flags.min.css" media="all">

        <!-- altair admin -->
        <link rel="stylesheet" href="{base_url}asset/altair/assets/css/main.min.css" media="all">

            <!-- kendo UI -->
        <link rel="stylesheet" href="{base_url}asset/altair/bower_components/kendo-ui/styles/kendo.common-material.min.css"/>
        <link rel="stylesheet" href="{base_url}asset/altair/bower_components/kendo-ui/styles/kendo.material.min.css"/>

    <script type="text/javascript" src="{base_url}asset/js/signatur/signature.js"></script>
    <!-- Ignite UI Required Combined CSS Files 
    <link href="http://cdn-na.infragistics.com/igniteui/2016.2/latest/css/themes/infragistics/infragistics.theme.css" rel="stylesheet" />
    <link href="http://cdn-na.infragistics.com/igniteui/2016.2/latest/css/structure/infragistics.css" rel="stylesheet" />
	-->

      <script type="text/javascript">
        var _gaq = _gaq || [];
        _gaq.push(['_setAccount', 'UA-39365077-1']);
        _gaq.push(['_trackPageview']);

        (function() {
          var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
          ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
          var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
        })();
      </script>

	
        <!-- matchMedia polyfill for testing media queries in JS -->
        <!--[if lte IE 9]>
            <script type="text/javascript" src="{base_url}asset/altair/bower_components/matchMedia/matchMedia.js"></script>
            <script type="text/javascript" src="{base_url}asset/altair/bower_components/matchMedia/matchMedia.addListener.js"></script>
        <![endif]-->
        <style>
            .rootfolder { background-position: 0 0; }
            .folder { background-position: 0 -16px; }
            .pdf { background-position: 0 -32px; }
            .html { background-position: 0 -48px; }
            .image { background-position: 0 -64px; }
        </style>

    </head>
    <?php
        $menu=$user_menu;
        
        if ($menu=="0"){
            $classbody="top_menu header_full";
            $menutop='
                            {menu_list}
                            ';
            $menuleft='';
            $menuswitch='';
        }else{
            $classbody="sidebar_main_open sidebar_main_swipe";
            $menutop='';
            $menuleft='
                        <aside id="sidebar_main">

                            <div class="sidebar_main_header">
                                <div class="sidebar_logo">
                                    <img id="profile_img" class="" src="{base_url}files/image/logo.png" alt="" width="170px"/>
                                </div>
                            </div>

                            <div class="menu_section">{menu_list}</div>
                        </aside> ';
            $menuswitch='<a href="#" id="sidebar_main_toggle" class="sSwitch sSwitch_left">
                            <span class="sSwitchIcon"></span>
                        </a>

                        <a href="#" id="sidebar_secondary_toggle" class="sSwitch sSwitch_right sidebar_secondary_check">
                            <span class="sSwitchIcon"></span>
                        </a>';
        }
    ?>
    
    <body class="<?php echo $classbody ?>" onclick="checkSession()">
        <!-- main header -->
        <header id="header_main">
            <div class="header_main_content">
                <nav class="uk-navbar">
                        
                <!-- main sidebar switch -->
                
                <?php echo $menuswitch; ?>
                    <div id="menu_top_dropdown" class="uk-float-left uk-hidden-small">
                <?php echo $menutop; ?>
                    </div>
                    <div class="uk-navbar-flip">
                        <ul class="uk-navbar-nav user_actions">
                            <li><a href="#" id="full_screen_toggle" class="user_action_icon uk-visible-large"><i class="material-icons md-24 md-light">&#xE5D0;</i></a></li>
                            <!--<li><a href="#" id="main_search_btn" class="user_action_icon"><i class="material-icons md-24 md-light">&#xE8B6;</i></a></li>-->
                            
                            <!--<li data-uk-dropdown="{mode:'click',pos:'bottom-right'}">
                                <a href="#" class="user_action_icon"><i class="material-icons md-24 md-light">&#xE7F4;</i><span id="totNotif" class="uk-badge">-</span></a>
                                <div class="uk-dropdown uk-dropdown-xlarge">
                                    <div class="md-card-content">
                                        <ul class="uk-tab uk-tab-grid" data-uk-tab="{connect:'#header_alerts',animation:'slide-horizontal'}">
                                            <li class="uk-width-1-1 uk-active"><a href="#" class="js-uk-prevent uk-text-small">INVOICE JATUH TEMPO</a></li>
                                            <li class="uk-width-1-2"><a href="#" class="js-uk-prevent uk-text-small">Alerts (4)</a></li>
                                        </ul>
                                        <ul id="header_alerts" class="uk-switcher uk-margin">
                                            <li id="notif">
                                                <ul class="md-list md-list-addon">
                                                </ul>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </li>-->
                            <li data-uk-dropdown="{mode:'click',pos:'bottom-right'}">
                                <a href="#" class="user_action_image"><img id="profile_img" class="md-user-image" src="" alt=""/></a>
                                <div class="uk-dropdown uk-dropdown-small">
                                    <ul class="uk-nav js-uk-prevent">
                                        <li><a href="#modal_form_edituser" data-uk-modal="{center:true;}" onclick="showProfile()">Hi, <b>{user_nama}</b></a></li>
                                        <li><a href="login/keluar">Logout</a></li>
                                    </ul>
                                </div>
                            </li>
                        </ul>
                    </div>
                </nav>
            </div>
            <div class="header_main_search_form">
                <i class="md-icon header_main_search_close material-icons">&#xE5CD;</i>
                <form class="uk-form">
                    <input type="text" class="header_main_search_input" />
                    <button class="header_main_search_btn uk-button-link"><i class="md-icon material-icons">&#xE8B6;</i></button>
                </form>
            </div>
        </header><!-- main header end -->
        
        <!-- MENU KIRI -->
        <?php echo $menuleft; ?>
<!--        main sidebar end -->

        <div id="page_content">
            <div id="page_content_inner">
            </div>
        </div>
        
        <div class="uk-modal" id="modal_form_edituser">
            <div class="uk-modal-dialog">
            <div class="uk-width-large-1-1"> 
            <div class="md-card">
            <form id="form" class="uk-form-stacked" enctype="multipart/form-data">
                <!--<div class="user_heading" data-uk-sticky="{ top: 48, media: 960 }">-->
                <div class="user_heading">
                    <div class="user_heading_avatar fileinput fileinput-new" data-provides="fileinput">
                        <div class="fileinput-new thumbnail">
                            <img id="photo_img" src="" alt="user avatar"/>
                            <img id="loading" src="{base_url}files/image/user/loader.gif" alt="loading" style="display:none;"/>
                        </div>
                        <div class="fileinput-preview fileinput-exists thumbnail"></div>
                        <div class="user_avatar_controls">
                            <span class="btn-file">
                                <span class="fileinput-new"><i class="material-icons">&#xE2C6;</i></span>
                                <span class="fileinput-exists"><i class="material-icons">&#xE86A;</i></span>
                                <input type="file" name="photo" id="photo" accept="image/*" onchange="previewFile(this)">
                            </span>
                            <a href="#" class="btn-file fileinput-exists" data-dismiss="fileinput">
                                <i class="material-icons">&#xE5CD;</i>
                            </a>
                        </div>
                    </div>
                    <div class="user_heading_content">
                        <h2 class="heading_b">
                            <span class="uk-text-truncate" id="user_edit_uname">{user_nama}</span>
                            <!--<span class="sub-heading" id="user_edit_position">Land acquisition specialist</span>-->
                        </h2>
                    </div>
                </div> 
                <div class="user_content">
                    <h3>Ubah Password</h3>
                    <input type="hidden" class="md-input" id="id_user" name="id_user" value="{user_id}"/>
                    <div class="uk-form-row">
                        <label for="name">Password Baru</label>
                        <input id="password_1" name="password_1" type="password" class="md-input label-fixed" style="width: 100%;" />
                    </div>
                    <div class="uk-form-row">
                        <label for="name">Ulangi Password Baru</label>
                        <input id="password_2" name="password_2" type="password" class="md-input label-fixed" style="width: 100%;" />
                    </div>
                </div>
                <div class="user_footer uk-text-right" style="padding:10px;">
                    <div class="user_footer_content">
                        <button type="button" class="md-btn md-btn-flat uk-modal-close">Tutup</button>
                        <button type="button" class="md-btn md-btn-flat md-btn-flat-primary" id="snippet_new_save" onclick="simpan_pass()">Simpan</button>
                    </div>
                </div>
            </form> 
            </div>
            </div>
            </div>
        </div>
        <!-- google web fonts -->
        <script>
            WebFontConfig = {
                google: {
                    families: [
                        'Source+Code+Pro:400,700:latin',
                        'Roboto:400,300,500,700,400italic:latin'
                    ]
                }
            };
            (function () {
                var wf = document.createElement('script');
                wf.src = ('https:' == document.location.protocol ? 'https' : 'http') +
                          '://ajax.googleapis.com/ajax/libs/webfont/1/webfont.js';
                wf.type = 'text/javascript';
                wf.async = 'true';
                var s = document.getElementsByTagName('script')[0];
                s.parentNode.insertBefore(wf, s);
            })();
        </script>
        
	<!-- IMPORT -->
    <script src="{base_url}asset/js/import/modernizr-2.8.3.js"></script>
	<!-- END IMPORT -->
	
    <!-- common functions -->
    <script src="{base_url}asset/altair/assets/js/common.min.js"></script>
    <!-- uikit functions -->
    <script src="{base_url}asset/altair/assets/js/uikit_custom.min.js"></script>
    <!-- altair common functions/helpers -->
    <script src="{base_url}asset/altair/assets/js/altair_admin_common.min.js"></script>

    <!--  kendoui functions -->
    <script src="{base_url}asset/altair/assets/js/pages/kendo.all.min.js"></script>
    <!-- kendo UI -->
    <script src="{base_url}asset/altair/assets/js/kendoui_custom.min.js"></script>
    <script src="{base_url}asset/altair/assets/js/pages/kendoui.min.js"></script>

    <!-- page specific plugins -->
    <!-- datatables -->
    <script src="{base_url}asset/altair/bower_components/datatables/media/js/jquery.dataTables.min.js"></script>
    <!-- datatables colVis-->
    <script src="{base_url}asset/altair/bower_components/datatables-colvis/js/dataTables.colVis.js"></script>
    <!-- datatables tableTools-->
    <script src="{base_url}asset/altair/bower_components/datatables-tabletools/js/dataTables.tableTools.js"></script>
    <!-- datatables custom integration -->
    <script src="{base_url}asset/altair/assets/js/custom/datatables_uikit.min.js"></script>

    
    <!--  datatables functions -->
    <script src="{base_url}asset/altair/assets/js/pages/plugins_datatables.min.js"></script>
        
        
    <script src="{base_url}asset/js/tanggal.js"></script>

	
	<!-- IMPORT -->
    <script src="{base_url}asset/js/import/jquery-ui.min.js"></script>

    <script type="text/javascript" src="{base_url}asset/js/import/infragistics.core.js"></script>
    <script type="text/javascript" src="{base_url}asset/js/import/infragistics.lob.js"></script>
	
    <script type="text/javascript" src="{base_url}asset/js/import/infragistics.ext_core.js"></script>
    <script type="text/javascript" src="{base_url}asset/js/import/infragistics.ext_collections.js"></script>
    <script type="text/javascript" src="{base_url}asset/js/import/infragistics.ext_text.js"></script>
    <script type="text/javascript" src="{base_url}asset/js/import/infragistics.ext_io.js"></script>
    <script type="text/javascript" src="{base_url}asset/js/import/infragistics.ext_ui.js"></script>
    <script type="text/javascript" src="{base_url}asset/js/import/infragistics.documents.core_core.js"></script>
    <script type="text/javascript" src="{base_url}asset/js/import/infragistics.ext_collectionsextended.js"></script>
    <script type="text/javascript" src="{base_url}asset/js/import/infragistics.excel_core.js"></script>
    <script type="text/javascript" src="{base_url}asset/js/import/infragistics.ext_threading.js"></script>
    <script type="text/javascript" src="{base_url}asset/js/import/infragistics.ext_web.js"></script>
    <script type="text/javascript" src="{base_url}asset/js/import/infragistics.xml.js"></script>
    <script type="text/javascript" src="{base_url}asset/js/import/infragistics.documents.core_openxml.js"></script>
    <script type="text/javascript" src="{base_url}asset/js/import/infragistics.excel_serialization_openxml.js"></script>
	<!-- END IMPORT -->
        
        
  
        <script>
            var foto='';
            
            $(function () {
                 $("#treeview").kendoTreeView();
                // enable hires images
                altair_helpers.retina_images();
                // fastClick (touch devices)
                if (Modernizr.touch) {
                    FastClick.attach(document.body);
                }
                
                showContent('dashboard');
                tampilGambar('profile','{user_photo}');
            });
            
            function checkSession() {
                $.get('{base_url}login/check_session', function (data) {
                    result = JSON.parse(data);
                    if (result.login == false) {
                        window.location.href = '{base_url}login/keluar';
                    }
                });
            }

            function showContent(item,id,add) {
                $.get('{base_url}home/menu/' + item +'/' + id +'/'+ add , function (resp) {
//                    if (resp == false) {
//                        alert('Anda tidak berhak melakukan transaksi ini.');
//                    } else {
//                        console.log(resp);
                        $('#page_content_inner').html(resp);
//                    }
                });
                
                // NOTIF
//                $('#notif ul').empty();
//                $.ajax({
//                    url: '{base_url}dashboard/get_detail',
//                    type:'POST',
//                    dataType:'json',
//                    success:function(r){
//                        if(r!=null){                
//                            var vendor='';
//                            var jtt='';
//                            var totNotif=0;
//                            
//
//                            for (var i=0; i < r.length ; i++){ 
//                                vendor=r[i].nama_vendor;
//                                jtt=r[i].tgl_jtt;
//                                totNotif++;
//                                
//                                        $('#notif ul').append(
//                                                    '<li>'+
//                                                        '<div class="md-list-addon-element">'+
//                                                            '<i class="md-list-addon-icon material-icons uk-text-danger">&#xE001;</i>'+
//                                                        '</div>'+
//                                                        '<div class="md-list-content">'+
//                                                            '<span class="md-list-heading"><a href="#">'+vendor+'</a></span>'+
//                                                            '<span class="uk-text-small uk-text-muted">Tgl JTT : '+jtt+'</span>'+
//                                                        '</div>'+
//                                                    '</li>'
//                                        );
//                                document.getElementById("totNotif").innerHTML = totNotif;
//                            }
//                        }
//                    },
//                    error:function(r){
//                        console.log(r);
//                    }
//                });
            }
            
            function showProfile(){
                $("#form")[0].reset();
                if($('#photo_img').attr("src")== ''){
                    tampilGambar("photo","{user_photo}");
                }
            }
            
            function simpan_pass(){
                var password='';
                var cond = false;
                if($('#password_1').val()!='' && $('#password_2').val()!=''){
                    if($('#password_1').val() == $('#password_2').val()){
                        password = $('#password_1').val();
                        cond = true;
                    }else{
                        UIkit.modal.alert('Password Tidak Sama');
                    }
                }else{
                    cond=true;
                }
                
                if(cond){
                    $.ajax({
                        url: '{base_url}setting/user/update',
                        type: "POST",
                        data: {
                            id_user: $("#id_user").val(),
                            photo: foto,
                            password: password,
                            modified_date: ''
                        },
                        dataType: "JSON",
                        success: function (data)
                        {
                            if (data.success) {                            
                                if(password != ''){
                                    UIkit.modal.alert("Data tersimpan.");
                                    UIkit.modal("#modal_form_edituser").hide();
                                }
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
            }
            
            function previewFile(input) {  
                var stat;
                if (document.getElementById(input.id).files.length !== 0) {
                    var formData = new FormData($('#form')[0]);
                    $.ajax({
                        url: "{base_url}home/upload/photo",
                        type: "POST",
                        data: formData,
                        async: false,
                        beforeSend: function(){
                            $('#photo_img').css("display","none");
                            $('#loading').css("display","block");
                        },
                        success: function (data) {
                            var result = eval('(' + data + ')');
                            if (result.success) {
                                foto = result.filename;
                                $('#photo_img').css("display","block");
                                $('#loading').css("display","none");                                    
                                stat = true;
                            } else {
                                $('#photo_img').css("display","block");
                                $('#loading').css("display","none");
                                UIkit.modal.alert(data.msg);
                                stat = false;
                            }
                        },
                        cache: false,
                        contentType: false,
                        processData: false
                    });
                }
                
                if(stat){  
                    simpan_pass();
                    if (input.files && input.files[0]) {
                        var reader = new FileReader();

                        reader.onload = function (e) {
                            $('#'+input.id+'_img').attr('src', e.target.result);
                            $('#profile_img').attr('src', e.target.result);
                        };

                        reader.readAsDataURL(input.files[0]);
                    }                    
                    foto = '';                    
                }
            }
            
            function tampilGambar(input,img){
                if (img !== '') {
                    image_url = '{base_url}' + img;
                    $.get(image_url)
                            .done(function () {
                                image_url=image_url;
                            })
                            .fail(function () {
                                image_url="{base_url}files/image/user/blank.png";
                            });
                            $('#'+input+'_img').attr('src', image_url);
                            //console.log("tampilGambar",image_url);
                } else {
                    $('#'+input+'_img').attr('src', '{base_url}files/image/user/blank.png');
                }
            }

        </script>

	

    </body>
</html>