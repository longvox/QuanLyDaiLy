<!DOCTYPE html>
<html>

<head>
    <meta charset="ISO-8859-1">
    <title>Login pages | thelastteam | login here</title>
    <meta name="google-site-verification" content="yu3oCBVUB1G-6exmipMba-wkQOoSecHx9Bx7p2spoLo" />
    <link rel="shortcut icon" href="asset/img/logomi.png">
    <link rel="stylesheet" type="text/css" href="asset/css/plugins/font-awesome.min.css" />
    <link rel="stylesheet" type="text/css" href="asset/css/simple-sidebar.css" />
    <link rel="stylesheet" type="text/css" href="asset/css/css.css" />
    <link rel="stylesheet" type="text/css" href="asset/css/plugins/font-awesome.min.css" />
    <link rel="stylesheet" type="text/css" href="asset/css/plugins/animate.min.css" />
    <link href="asset/css/style.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="asset/css/bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" href="asset/css/plugins/font-awesome.min.css" />
    <link rel="stylesheet" type="text/css" href="asset/css/plugins/datatables.bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" href="asset/css/plugins/animate.min.css" />
    <link href="asset/css/style.css" rel="stylesheet">
    <link href="//cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css" rel="stylesheet">
    <script src="asset/js/jquery.min.js"></script>
    <script src="asset/js/jquery.ui.min.js"></script>
    <script src="asset/js/bootstrap.min.js"></script>
    <script src="asset/js/plugins/jquery.datatables.min.js"></script>
    <!-- plugins -->
    <script src="asset/js/plugins/moment.min.js"></script>
    <script src="asset/js/plugins/jquery.nicescroll.js"></script>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
    <script src="//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <!-- custom -->
    <script src="asset/js/validate.js"></script>
    <script src="asset/js/validation-add.js"></script>

</head>
<style type="text/css">
body {
    padding-top: 120px;
    padding-bottom: 40px;
    background-color: #eee;

}

.btn {
    outline: 0;
    border: none;
    border-top: none;
    border-bottom: none;
    border-left: none;
    border-right: none;
    box-shadow: inset 2px -3px rgba(0, 0, 0, 0.15);
}

.btn:focus {
    outline: 0;
    -webkit-outline: 0;
    -moz-outline: 0;
}

.fullscreen_bg {
    position: fixed;
    top: 0;
    right: 0;
    bottom: 0;
    left: 0;
    background-size: cover;
    background-position: 50% 50%;
    background-image: url('http://cleancanvas.herokuapp.com/img/backgrounds/color-splash.jpg');
    background-repeat: repeat;
}

.form-signin {
    max-width: 280px;
    padding: 15px;
    margin: 0 auto;
    margin-top: 50px;
}

.form-signin .form-signin-heading,
.form-signin {
    margin-bottom: 10px;
}

.form-signin .form-control {
    position: relative;
    font-size: 16px;
    height: auto;
    padding: 10px;
    -webkit-box-sizing: border-box;
    -moz-box-sizing: border-box;
    box-sizing: border-box;
}

.form-signin .form-control:focus {
    z-index: 2;
}

.form-signin input[type="text"] {
    margin-bottom: -1px;
    border-bottom-left-radius: 0;
    border-bottom-right-radius: 0;
    border-top-style: solid;
    border-right-style: solid;
    border-bottom-style: none;
    border-left-style: solid;
    border-color: #000;
}

.form-signin input[type="password"] {
    margin-bottom: 10px;
    border-top-left-radius: 0;
    border-top-right-radius: 0;
    border-top-style: none;
    border-right-style: solid;
    border-bottom-style: solid;
    border-left-style: solid;
    border-color: rgb(0, 0, 0);
    border-top: 1px solid rgba(0, 0, 0, 0.08);
}

.form-signin-heading {
    color: #fff;
    text-align: center;
    text-shadow: 0 2px 2px rgba(0, 0, 0, 0.5);
}

.error {
    color: red;
}
</style>
<?php
require 'Model/DBquanlydaily.php';
$error = "";
$success = "";
$db = new database();
$db->connect();
$url = "https://0fjxt2m5xk.execute-api.us-east-2.amazonaws.com/dev/getallTaiKhoan";
$curl = curl_init($url);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "GET");
if (!empty(curl_exec($curl))) {
    $get =  json_decode(curl_exec($curl), true);
    $getAll = $get["item"];
}
session_start();
if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $ok = 0;
    foreach ($getAll as $key => $value) {
        if ($value['taikhoan'] == $username && $value['matkhau'] == $password) {
            $ok = 1;
        }
    };
    if ($ok == 1) {
        $error = "";
        $url2 = "https://0fjxt2m5xk.execute-api.us-east-2.amazonaws.com/dev/getTaiKhoan/$username";
        $curl2 = curl_init($url2);
        curl_setopt($curl2, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl2, CURLOPT_CUSTOMREQUEST, "GET");
        curl_exec($curl2);
        $get2 =  json_decode(curl_exec($curl2), true);
        $get3 = $get2["tkhoan"];
        setcookie('username', $get3["tenhienthi"], time() + 3600);
        $_SESSION['loaiUser'] = $get3["loaitk"];
        date_default_timezone_set("Asia/Bangkok");
        $time = date("H:i:s d/m/Y");
        $array = array(
      "taiKhoan" => $get3["taikhoan"],
      "displayName" => $get3["tenhienthi"],
      "tenLoaiUser" => $get3["tenloaitk"],
      "dangNhapVaoLuc" => $time
    );
        $url = "https://0fjxt2m5xk.execute-api.us-east-2.amazonaws.com/dev/insertDangNhap";
        $content = json_encode($array);
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $content);
        if (curl_exec($curl)) {
            header("Location:mainpage.php");
        }
    } else {
        $error = "Tài khoản hoặc mật khẩu không đúng!";
    }
}
?>

<body id="LoginForm">
    <div class="container">
        <form class="form-signin" method="post" id="mainform">
            <h1 class="form-signin-heading text-muted">Đăng Nhập</h1>
            <input name="username" type="text" class="form-control" placeholder="Tài Khoản" autofocus>
            <input name="password" type="password" class="form-control" placeholder="Mật Khẩu">
            <span class='error'>
                <h4><?php if (isset($error)) {
    echo $error;
} ?></h4>
            </span>
            <button class="btn btn-lg btn-primary btn-block" name="submit" type="submit">
                Đăng Nhập thelastteam
            </button>
        </form>
    </div>
</body>
<script type="text/javascript">
$(document).ready(function() {
    $("#mainform").validate({
        rules: {
            username: {
                required: true,
                minlength: 3,
                maxlength: 128,
                alphanumeric: true
            },
            password: {
                required: true,
                minlength: 3,
                maxlength: 128,
                alphanumeric: true
            }
        },
        messages: {
            username: {
                required: "<span class='error'>Vui lòng nhập tài khoản!</span>",
                minlength: "<span class='error'>Tài khoản tối thiểu phải 3 ký tự!</span>",
                maxlength: "<span class='error'>Tài khoản tối đa 128 ký tự!</span>",
                alphanumeric: "<span class='error'>Không cho phép nhập ký tự đặc biệt!</span>"
            },
            password: {
                required: "<span class='error'>Vui lòng nhập mật khẩu!</span>",
                minlength: "<span class='error'>Tài khoản tối thiểu phải 3 ký tự!</span>",
                alphanumeric: "<span class='error'>Không cho phép nhập ký tự đặc biệt!</span>"
            }
        }
    });
});
</script>
