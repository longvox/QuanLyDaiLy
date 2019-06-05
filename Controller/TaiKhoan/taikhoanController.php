<?php
$table2="loaiuser";
$data2 = $db->getAllData($table2);
$url = "https://0fjxt2m5xk.execute-api.us-east-2.amazonaws.com/dev/getallTaiKhoan";
$curl = curl_init($url);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "GET");
$get =  json_decode(curl_exec($curl), true);
$getAll = $get["item"];
if (isset($_POST['submit'])) {
    if (isset($_POST['taikhoan'])&&isset($_POST['matkhau'])&&isset($_POST['tenhienthi'])) {
        $taikhoan= $_POST['taikhoan'];
        $matkhau = $_POST['matkhau'];
        $tenhienthi = $_POST['tenhienthi'];
        $loaitk = $_POST['loaitk'];
        $assoc = mysqli_fetch_assoc($db->execute("select TenLoaiUser from loaiuser where MaLoaiUser = $loaitk"));
    }
    $array = array(
            "taikhoan" => $taikhoan,
            "matkhau" => $matkhau,
            "tenhienthi" =>$tenhienthi,
            "loaitk" =>$loaitk,
            "tenloaitk"=>$assoc['TenLoaiUser']
        );
    $url = "https://0fjxt2m5xk.execute-api.us-east-2.amazonaws.com/dev/insertTaiKhoan";
    $content = json_encode($array);
    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $content);
    if (curl_exec($curl)) {
        echo "<script>alert('Đã thêm!');</script>";
    }
    header('refresh: 2');
}
if (isset($_POST['submitDelete'])) {
    $idDelete = $_POST['idDelete'];
    $url = "https://0fjxt2m5xk.execute-api.us-east-2.amazonaws.com/dev/deleteTaiKhoan/{$idDelete}";
    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "DELETE");
    if (curl_exec($curl)) {
        echo "<script>alert('Đã xóa!');</script>";
    }
    header('refresh: 0');
}
if (isset($_POST['submitEdit'])) {
    if (isset($_POST['taikhoanEdit'])&&isset($_POST['matkhauEdit'])&&isset($_POST['tenhienthiEdit'])&&isset($_POST['idEdit'])) {
        $idEdit= $_POST['idEdit'];
        $taikhoan= $_POST['taikhoanEdit'];
        $matkhau = $_POST['matkhauEdit'];
        $tenhienthi = $_POST['tenhienthiEdit'];
        $loaitk = $_POST['loaitkEdit'];
        $assoc = mysqli_fetch_assoc($db->execute("select TenLoaiUser from loaiuser where MaLoaiUser = $loaitk"));
    }
    $array = array(
        "matkhau" => $matkhau,
        "tenhienthi" =>$tenhienthi,
        "loaitk" =>$loaitk,
        "tenloaitk"=>$assoc['TenLoaiUser']
    );
    $url = "https://0fjxt2m5xk.execute-api.us-east-2.amazonaws.com/dev/updateTaiKhoan/{$idEdit}";
    $content = json_encode($array);
    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
    curl_setopt($curl, CURLOPT_POSTFIELDS, $content);
    if (curl_exec($curl)) {
        echo "<script>alert('Đã sửa!');</script>";
    }
    header('refresh: 0');
}
if (isset($_POST['submitReset'])) {
    if (isset($_POST["idReset"])) {
        $idReset= $_POST["idReset"];
    }
    $array = array(
        "matkhau" => ""
    );
    $url = "https://0fjxt2m5xk.execute-api.us-east-2.amazonaws.com/dev/resetTaiKhoan/{$idReset}";
    $content = json_encode($array);
    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
    curl_setopt($curl, CURLOPT_POSTFIELDS, $content);
    if (curl_exec($curl)) {
        echo "<script>alert('Đã reset!');</script>";
        header('refresh:0');
    }
}
require_once 'View/taikhoan.php';
?>
<style type="text/css">
.error{
    color: red;
}
</style>
<script type="text/javascript">
$(document).ready( function () {
    $('#myTable').DataTable({
        "order":[[0,"desc"]]
    });
} );
$("#formTaoTK").validate({
    rules:{
        taikhoan:{
            required: true,
            minlength: 6,
            maxlength: 128,
            alphanumeric:true
        },
        matkhau:{
            required: true,
            minlength: 6,
            maxlength: 128,
            alphanumeric:true
        },
        tenhienthi:{
            required: true,
            minlength: 3,
            maxlength: 50,
            alphanumeric:true
        }
    },
    messages:{
        taikhoan: {
            required: "<span class='error'>Vui lòng nhập tài khoản!</span>",
            minlength: "<span class='error'>Độ dài tối thiểu: 6 ký tự!</span>",
            maxlength: "<span class='error'>Độ dài tối đa: 128 ký tự!</span>",
            alphanumeric: "<span class='error'>Không được phép nhập ký tự đặc biệt!</span>"
        },
        matkhau: {
            required: "<span class='error'>Vui lòng nhập mật khẩu!</span>",
            minlength: "<span class='error'>Độ dài tối thiểu: 6 ký tự!</span>",
            maxlength: "<span class='error'>Độ dài tối đa: 128 ký tự!</span>",
            alphanumeric: "<span class='error'>Không được phép nhập ký tự đặc biệt!</span>"
        },
        tenhienthi: {
            required: "<span class='error'>Vui lòng nhập tên hiển thị!</span>",
            minlength: "<span class='error'>Độ dài tối thiểu: 3 ký tự!</span>",
            maxlength: "<span class='error'>Độ dài tối đa: 50 ký tự!</span>",
            alphanumeric: "<span class='error'>Không được phép nhập ký tự đặc biệt!</span>"
        }
    }
});
</script>