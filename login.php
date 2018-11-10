<?php
session_start();
require_once('includes/functions.php');
if (isset($_SESSION['user_id'])) {
    header('Location: dashboard.php');
    exit;
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="icon" href="https://www.watters.com/assets/favicon/apple-touch-icon-60x60.png">

    <title>Login | WATREX</title>

    <!-- Bootstrap core CSS -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="assets/css/floating-labels.css" rel="stylesheet">
</head>

<body>
<form class="form-signin" id="loginForm">
    <div class="text-center mb-4">
        <img class="mb-4" src="https://www.watters.com/assets/img/icons/watters.svg" alt="watters-logo">
    </div>

    <div class="form-label-group">
        <input type="email" id="login_email" name="login_email" class="form-control" placeholder="Email address" required autofocus>
        <label for="login_email">Email address</label>
    </div>

    <div class="form-label-group">
        <input type="password" id="login_password" name="login_password" class="form-control" placeholder="Password" required>
        <label for="login_password">Password</label>
    </div>

    <div class="checkbox mb-3">
        <label>
            <input type="checkbox" value="remember-me"> Remember me
        </label>
    </div>
    <button class="btn btn-lg btn-primary btn-block" type="submit" id="loginBtn">Sign in</button>
    <p class="mt-5 mb-3 text-muted text-center">&copy; WATTERS <?php echo date('Y'); ?> All Rights Reserved
    </p>
</form>
<script src="assets/js/jquery.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
<script src="assets/js/jquery.validate.min.js"></script>
<script src="assets/js/jquery.validate.additional-methods.min.js"></script>

<script type="text/javascript">
    $('document').ready(function(){

        $("#loginForm").validate({
            rules: {
                loginEmail: {
                    required: true,
                    email: true
                },
                loginPassword: {
                    required: true
                }
            },
            messages: {
                loginEmail: {
                    required: "Enter valid Email",
                    email: "Invalid Email or Password"
                },
                loginPassword: {
                    required: "Enter valid Password"
                }
            }
        });

        $('#loginBtn').click(function(e) {
            e.preventDefault();
            if($("#loginForm").valid()) {
                var loginData = $('#loginForm').serialize()+'&operation=login';
                $.ajax({
                    type: "POST",
                    url: "ajax_authentication.php",
                    dataType : 'json',
                    data: loginData,
                    beforeSend: function() {
                        $('.error').text('');
                    },
                    success: function(data) {
                        if (data.status) {
                            window.location = "dashboard.php";
                        }else{
                            alert(data.response);
                            $('#loginEmail').focus();
                        }
                    }
                });
            }
        });
    });
</script>
</body>
</html>
