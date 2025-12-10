<!doctype html>
<!--[if lte IE 9]> <html class="lte-ie9" lang="en"> <![endif]-->
<!--[if gt IE 9]><!--> <html lang="en"> <!--<![endif]-->
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="initial-scale=1.0,maximum-scale=1.0,user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Remove Tap Highlight on Windows Phone IE -->
    <meta name="msapplication-tap-highlight" content="no"/>
<!--
    <link rel="icon" type="image/png" href="{base_url}asset/altair/assets/img/favicon-16x16.png" sizes="16x16">
    <link rel="icon" type="image/png" href="{base_url}asset/altair/assets/img/favicon-32x32.png" sizes="32x32">-->
    <link rel="icon" type="image/png" href="{base_url}files/image/logo2.png" sizes="16x16">

    <title>Login Page</title>

    <link href='http://fonts.googleapis.com/css?family=Roboto:300,400,500' rel='stylesheet' type='text/css'>

    <!-- uikit -->
    <link rel="stylesheet" href="{base_url}asset/altair/bower_components/uikit/css/uikit.almost-flat.min.css"/>

    <!-- altair admin login page -->
    <link rel="stylesheet" href="{base_url}asset/altair/assets/css/login_page.min.css" />

</head>
<body class="login_page">

    <div class="login_page_wrapper">
        <div class="md-card" id="login_card">
            <div class="md-card-content large-padding" id="login_form">
                <div class="login_heading">
                    <!-- <div class="user_avatar"></div> --> <img id="profile_img" class="" src="{base_url}files/image/logo.png" alt=""/> <h1>- LOGIN -</h1>
                </div>
                <form id="form_login">
                    <div id="username-group" class="uk-form-row">
                        <label for="login_username">Username</label>
                        <input class="md-input" type="text" id="login_username" name="login_username" />
                    </div>
                    <div id="password-group" class="uk-form-row">
                        <label for="login_password">Password</label>
                        <input class="md-input" type="password" id="login_password" name="login_password" />
                    </div>
                    <div class="uk-margin-medium-top">
                        <button type="submit" href="javascript:void(0)" class="md-btn md-btn-primary md-btn-block md-btn-large">Sign In</button>
                    </div>
                    <!--
                    <div class="uk-margin-top">
                        <a href="#" id="login_help_show" class="uk-float-right">Need help?</a>
                        <span class="icheck-inline">
                            <input type="checkbox" name="login_page_stay_signed" id="login_page_stay_signed" data-md-icheck />
                            <label for="login_page_stay_signed" class="inline-label">Stay signed in</label>
                        </span>
                    </div>
                    -->
                </form>
            </div>
            <div class="md-card-content large-padding uk-position-relative" id="login_help" style="display: none">
                <button type="button" class="uk-position-top-right uk-close uk-margin-right uk-margin-top back_to_login"></button>
                <h2 class="heading_b uk-text-success">Can't log in?</h2>
                <p>Here’s the info to get you back in to your account as quickly as possible.</p>
                <p>First, try the easiest thing: if you remember your password but it isn’t working, make sure that Caps Lock is turned off, and that your username is spelled correctly, and then try again.</p>
                <p>If your password still isn’t working, it’s time to <a href="#" id="password_reset_show">reset your password</a>.</p>
            </div>
            <div class="md-card-content large-padding" id="login_password_reset" style="display: none">
                <button type="button" class="uk-position-top-right uk-close uk-margin-right uk-margin-top back_to_login"></button>
                <h2 class="heading_a uk-margin-large-bottom">Reset password</h2>
                <form id="form_reset">
                    <div class="uk-form-row">
                        <label for="login_email_reset">Your email address</label>
                        <input class="md-input" type="text" id="login_email_reset" name="login_email_reset" />
                    </div>
                    <div class="uk-margin-medium-top">
                        <a href="index.html" class="md-btn md-btn-primary md-btn-block">Reset password</a>
                    </div>
                </form>
            </div>
            <div class="md-card-content large-padding" id="register_form" style="display: none">
                <button type="button" class="uk-position-top-right uk-close uk-margin-right uk-margin-top back_to_login"></button>
                <h2 class="heading_a uk-margin-medium-bottom">Create an account</h2>
                <form id="form_create">
                    <div class="uk-form-row">
                        <label for="register_username">Username</label>
                        <input class="md-input" type="text" id="register_username" name="register_username" />
                    </div>
                    <div class="uk-form-row">
                        <label for="register_password">Password</label>
                        <input class="md-input" type="password" id="register_password" name="register_password" />
                    </div>
                    <div class="uk-form-row">
                        <label for="register_password_repeat">Repeat Password</label>
                        <input class="md-input" type="password" id="register_password_repeat" name="register_password_repeat" />
                    </div>
                    <div class="uk-form-row">
                        <label for="register_email">E-mail</label>
                        <input class="md-input" type="text" id="register_email" name="register_email" />
                    </div>
                    <div class="uk-margin-medium-top">
                        <a href="index.html" class="md-btn md-btn-primary md-btn-block md-btn-large">Sign Up</a>
                    </div>
                </form>
            </div>
        </div>
        <!-- <div class="uk-margin-top uk-text-center">
            <a href="#" id="signup_form_show">Create an account</a>
        </div> -->
    </div>

    <!-- common functions -->
    <script src="{base_url}asset/altair/assets/js/common.min.js"></script>
    <!-- altair core functions -->
    <script src="{base_url}asset/altair/assets/js/altair_admin_common.min.js"></script>

    <!-- altair login page functions -->
    <script src="{base_url}asset/altair/assets/js/pages/login.min.js"></script>

    <script type="text/javascript">

            $( "#form_login" ).submit(function( event ) {

                $('.form-group').removeClass('has-error');
                $('.help-block').remove();

                if($('input[name=login_username]').val() == "") {
                    $('#username-group').addClass('has-error');
                }
                if($('input[name=login_password]').val() == "") {
                    $('#password-group').addClass('has-error');
                }

                var formData = {
                    'login_username' : $('input[name=login_username]').val(),
                    'login_password' : $('input[name=login_password]').val()
                    };

                $.post( "{base_url}login/masuk", formData)
                    .done(function( data ) {
                        
                    var result = eval('(' + data + ')');

                    if (!result.success) {

                        if (result.errors.username) {
                            $('#username-group').addClass('has-error');
                            $('#username-group').append('<div class="help-block"><font color="red">' + result.errors.username + '</font></div>');
                        }
                        if (result.errors.password) {
                            $('#password-group').addClass('has-error');
                            $('#password-group').append('<div class="help-block"><font color="red">' + result.errors.password + '</font></div>');
                        }
                    } else {
                        window.location = '{base_url}home';
                    }
                });

                event.preventDefault();
            });


        </script>
        
</body>
</html>