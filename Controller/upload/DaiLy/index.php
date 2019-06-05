<?php
$table = 'daily';
$sql = "select d.*,TenLoaiDL, q.DeleteFlag, l.DeleteFlag, TenQuan from daily d, loaidaily l, quan q where d.MaLoaiDL = l.MaLoaiDL and q.MaQuan = d.MaQuan and d.DeleteFlag =0";
$table2="loaidaily";
$data2 = $db->getAllData($table2);
$tb = "quan";
$dt = $db->getAllData($tb);
$data = $db->execute($sql);
if (isset($_POST['submit'])) {
    $tenDL = $_POST['tenDL'];
    $sdt = $_POST['sdt'];
    $diaChi = $_POST['diaChi'];
    if (isset($_POST['ngayTN'])) {
        $ngayTN= $_POST['ngayTN'];
    }
    $loai= $_POST['loai'];
    $quan= $_POST['quan'];
    $sql2 = "select d.*,TenLoaiDL, TenQuan from daily d, loaidaily l, quan q where d.MaLoaiDL = l.MaLoaiDL and q.MaQuan = d.MaQuan and d.DeleteFlag =0 and q.MaQuan=$quan";
    $sql = "select * from thamso where MaTS = 7";
    $assoc = mysqli_fetch_assoc($db->execute($sql));
    $num_row = mysqli_num_rows($db->execute($sql2));
    if ($num_row<$assoc['GiaTri']) {
        $sql3 = "select d.*,TenLoaiDL, TenQuan from daily d, loaidaily l, quan q where d.MaLoaiDL = l.MaLoaiDL and q.MaQuan = d.MaQuan and d.DeleteFlag =0 and q.MaQuan=$quan and l.MaLoaiDL = $loai and d.TenDL ='$tenDL' and d.DienThoai = '$sdt' and d.DiaChi = '$diaChi'";
        $num_row2 = mysqli_num_rows($db->execute($sql3));
        $array = array(
            "tenDL" => $tenDL,
            "sdt" =>$sdt,
            "diaChi" => $diaChi,
            "loaiDL" => $loai,
            "quan" => $quan
        );
        $url = "https://0fjxt2m5xk.execute-api.us-east-2.amazonaws.com/dev/insertDaiLy";
        $content = json_encode($array);
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $content);
        if ($num_row2!=0) {
            echo "<script>alert('Đại lý này đã có trong danh sách, vui lòng kiểm tra lại!');</script>";
            header("Refresh:0");
        } else {
            if (curl_exec($curl));
            {
                echo "<script>alert('Đã thêm!');</script>";
                header("Refresh:0");
            }
        }
    } else {
        echo "<script>alert('Mỗi quận chỉ có tối đa: {$assoc['GiaTri']} đại lý');</script>";
        header("Refresh:0");
    }
}
if (isset($_POST['submit2'])) {
    $maDL2=$_POST['maDL2'];
    $tenDL2 = $_POST['tenDL2'];
    $sdt2 = $_POST['sdt2'];
    $diaChi2 = $_POST['diaChi2'];
    if (isset($_POST['ngayTN2'])) {
        $ngayTN2= $_POST['ngayTN2'];
    }
    $loai2= $_POST['loai2'];
    $quan2= $_POST['quan2'];
    $sql2 = "select d.*,TenLoaiDL, TenQuan from daily d, loaidaily l, quan q where d.MaLoaiDL = l.MaLoaiDL and q.MaQuan = d.MaQuan and d.DeleteFlag =0 and q.MaQuan=$quan2";
    $sql = "select * from thamso where MaTS = 7";
    $assoc = mysqli_fetch_assoc($db->execute($sql));
    $num_row = mysqli_num_rows($db->execute($sql2));
    if ($num_row<$assoc['GiaTri']) {
        $sql3 = "select d.*,TenLoaiDL, TenQuan from daily d, loaidaily l, quan q where d.MaLoaiDL = l.MaLoaiDL and q.MaQuan = d.MaQuan and d.DeleteFlag =0 and q.MaQuan=$quan2 and l.MaLoaiDL = $loai2 and d.TenDL ='$tenDL2' and d.DienThoai = '$sdt2' and d.DiaChi = '$diaChi2'";
        $num_row2 = mysqli_num_rows($db->execute($sql3));
        $array = array(
            "tenDL" => $tenDL2,
            "sdt" =>$sdt2,
            "diaChi" => $diaChi2,
            "loaiDL" => $loai2,
            "quan" => $quan2
        );
        $url = "https://0fjxt2m5xk.execute-api.us-east-2.amazonaws.com/dev/updateDaiLy/{$maDL2}";
        $content = json_encode($array);
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
        curl_setopt($curl, CURLOPT_POSTFIELDS, $content);
        if ($num_row2!=0) {
            echo "<script>alert('Đại lý này đã có trong danh sách, vui lòng kiểm tra lại!');</script>";
            header("Refresh:0");
        } else {
            if (curl_exec($curl));
            {
                echo "<script>alert('Đã sửa!');</script>";
                header("Refresh:0");
            }
        }
    } else {
        echo "<script>alert('Mỗi quận chỉ có tối đa: {$assoc['GiaTri']} đại lý');</script>";
        header("Refresh:0");
    }
}
if (isset($_POST['submit3'])) {
    $maDL3=$_POST['maDL3'];
    $url = "https://0fjxt2m5xk.execute-api.us-east-2.amazonaws.com/dev/deleteDaiLy/{$maDL3}";
    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "DELETE");
    if (curl_exec($curl));
    {
        echo "<script>alert('Đã xóa!');</script>";
        header('refresh: 0');
    }
}
require_once('View/daily.php');
?>
<style type="text/css">
.error{
color: red;
}
input[type=number]::-webkit-inner-spin-button, 
input[type=number]::-webkit-outer-spin-button { 
  -webkit-appearance: none; 
  margin: 0; 
}
</style>
<script type="text/javascript">
$(document).ready( function (){
    $('#myTable').DataTable({
        "order":[[0,"desc"]],
        scrollY: 400,
        scrollCollapse:true,
        paging:false
	});
    $("#addForm").validate({
        rules:{
        	tenDL:{
                required: true,
                minlength: 5,
                maxlength: 50,
                alphanumeric:true
            },
            sdt: {
                required: true,
                minlength: 5,
                maxlength: 11,
            }, 
            diaChi:{
				required: true,
				minlength: 5,
                maxlength: 50,
                alphanumeric:true
            },
            loai:{
				required: true
            }
        },
        messages:{
            tenDL: {
                required: "<span class='error'>Tên mặt hàng không được để trống!</span>",
                minlength: "<span class='error'>Độ dài tối thiểu: 5 ký tự!</span>",
                maxlength: "<span class='error'>Độ dài tối đa: 50 ký tự!</span>",
                alphanumeric:"<span class='error'>Không được phép nhập ký tự đặc biệt!</span>"
            },
            sdt: {
            	required: "<span class='error'>Số điện thoại không được để trống!</span>",
            	minlength: "<span class='error'>Độ dài tối thiểu: 10 ký tự!</span>",
                maxlength: "<span class='error'>Độ dài tối đa: 11 ký tự!</span>"
            }, 
            diaChi:{
            	required: "<span class='error'>Địa chỉ không được để trống!</span>",
            	minlength: "<span class='error'>Độ dài tối thiểu: 10 ký tự!</span>",
                maxlength: "<span class='error'>Độ dài tối đa: 100 ký tự!</span>",
                alphanumeric:"<span class='error'>Không được phép nhập ký tự đặc biệt!</span>"
            },
            loai:{
            	required: "<span class='error'>Vui lòng chọn loại đại lý!</span>"
            }
        }
    });

});
</script>