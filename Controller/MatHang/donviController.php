<?php
$table ="donvi";
$data = $db->getAllData($table);
if (isset($_POST['submit'])) {
    if (isset($_POST['tenDV'])) {
        $tenDVAdd= $_POST['tenDV'];
    }
    $sql = "select * from thamso where MaTS = 3";
    $assoc = mysqli_fetch_assoc($db->execute($sql));
    $num_row = $db->num_rows($table);
    if ($num_row<$assoc['GiaTri']) {
        $sql3 = "select * from donvi where DeleteFlag =0 and TenDonVi = '$tenDVAdd'";
        $num_row2 = mysqli_num_rows($db->execute($sql3));
        $array = array(
            "tenDV" => $tenDVAdd
        );
        $url = "https://0fjxt2m5xk.execute-api.us-east-2.amazonaws.com/dev/insertDonVi";
        $content = json_encode($array);
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $content);
        if ($num_row2!=0) {
            echo "<script>alert('Đơn vị này đã có trong danh sách, vui lòng kiểm tra lại!');</script>";
            header("Refresh:0");
        } else {
            if (curl_exec($curl));
            {
                echo "<script>alert('Đã thêm!');</script>";
                header("Refresh:0");
            }
        }
    } else {
        echo "<script>alert('Đơn vị này chỉ có tối đa là {$assoc['GiaTri']}');</script>";
        header("Refresh:0");
    }
}
if (isset($_POST['submitDelete'])) {
    $idDelete = $_POST['idDelete'];
    $url = "https://0fjxt2m5xk.execute-api.us-east-2.amazonaws.com/dev/deleteDonVi/{$idDelete}";
    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "DELETE");
    if (curl_exec($curl));
    {
        echo "<script>alert('Đã xóa!');</script>";
        header('refresh: 0');
    }
}
if (isset($_POST['submitEdit'])) {
    $idEdit = $_POST['idEdit'];
    $tenDVEdit = $_POST['tenDVEdit'];
    $sql3 = "select * from donvi where DeleteFlag =0 and TenDonVi = '$tenDVEdit'";
    $num_row2 = mysqli_num_rows($db->execute($sql3));
    $array = array(
        "tenDV" => $tenDVEdit
    );
    $url = "https://0fjxt2m5xk.execute-api.us-east-2.amazonaws.com/dev/updateDonVi/{$idEdit}";
    $content = json_encode($array);
    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
    curl_setopt($curl, CURLOPT_POSTFIELDS, $content);
    if ($num_row2!=0) {
        echo "<script>alert('Đơn vị này đã có trong danh sách, vui lòng kiểm tra lại!');</script>";
        header("Refresh:0");
    } else {
        if (curl_exec($curl));
        {
            echo "<script>alert('Đã sửa!');</script>";
            header("Refresh:0");
        }
    }
}
require_once 'View/donvitinh.php';
?>
<style type="text/css">
.error{
color: red;
}
</style>
<script type="text/javascript">
$(document).ready( function (){
    $('#myTable').DataTable({
		"order":[[0,"desc"]]
	});
    $("#themForm").validate({
        rules:{
            tenDV:{
                required: true,
                minlength: 2,
                maxlength: 20,
                alphanumeric:true
            }
        },
        messages:{
            tenDV: {
                required: "<span class='error'>Tên đơn vị không được để trống!</span>",
                minlength: "<span class='error'>Độ dài tối thiểu: 2 ký tự!</span>",
                maxlength: "<span class='error'>Độ dài tối đa: 20 ký tự!</span>",
                alphanumeric: "<span class='error'>Không được phép nhập ký tự đặc biệt!</span>"
            }
        }
    });
});
</script>