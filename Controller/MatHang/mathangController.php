<?php
$query = "select m.*,TenDonVi from mathang m ,donvi d where m.MaDonVi = d.MaDonVi and m.DeleteFlag =0";
$data = $db->execute($query);
$table2 = "donvi";
$data2 = $db->getAllData($table2);
if (isset($_POST['submit'])) {
    if (isset($_POST['tenMH'])&& isset($_POST['donvi']) && isset($_POST['gia'])) {
        $tenMH = $_POST['tenMH'];
        $donvi = $_POST['donvi'];
        $gia = $_POST['gia'];
        $anh = $_FILES['anh']['name'];
        $link_anh = "upload/".$anh;
        $sql = "select * from thamso where MaTS = 2";
        $assoc = mysqli_fetch_assoc($db->execute($sql));
        $num_row = $db->num_rows('mathang');
        if ($num_row<$assoc['GiaTri']) {
            $sql3 = "select m.*,TenDonVi from mathang m ,donvi d where m.MaDonVi = d.MaDonVi and m.DeleteFlag =0 and m.TenMH = '$tenMH'";
            $num_row2 = mysqli_num_rows($db->execute($sql3));
            move_uploaded_file($_FILES['anh']['tmp_name'], "upload/".$anh);
            $array = array(
                "tenMH" => $tenMH,
                "donVi" =>$donvi,
                "gia"=>$gia,
                "anh"=>$link_anh
            );
            $url = "https://0fjxt2m5xk.execute-api.us-east-2.amazonaws.com/dev/insertMatHang";
            $content = json_encode($array);
            $curl = curl_init($url);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $content);
            if ($num_row2!=0) {
                echo "<script>alert('Mặt hàng đã có trong danh sách, vui lòng kiểm tra lại!');</script>";
                header("Refresh:0");
            } elseif ($gia <0) {
                echo "<script>alert('Giá không được phép nhỏ hơn hoặc bằng 0!');</script>";
                header("Refresh:0");
            } else {
                if (curl_exec($curl));
                {
                    echo "<script>alert('Đã thêm!');</script>";
                    header("Refresh:0");
                }
            }
        } else {
            echo "<script>alert('Mặt hàng chỉ có tối đa là: {$assoc['GiaTri']}');</script>";
            header("Refresh:0");
        }
    }
}
if (isset($_POST['submit2'])) {
    $maMH2 = $_POST['maMH2'];
    $tenMH2 = $_POST['tenMH2'];
    $anhMH2 = $_FILES['anhMH2']['name'];
    $link = "img/".$anhMH2;
    move_uploaded_file($_FILES['anhMH2']['tmp_name'], "upload/".$anhMH2);
    $donvi2 = $_POST['donvi2'];
    $gia2 = $_POST['gia2'];
    $current = $_POST['current'];
    $sql3 = "select TenMH from mathang where DeleteFlag = 0 and TenMH <> '$current'";
    $rs = $db->execute($sql3);
    $arr = [];
    foreach ($rs as $dt) {
        $arr[] = $dt['TenMH'];
    }
    $num_row2 = mysqli_num_rows($db->execute($sql3));
    $array = array(
        "tenMH" => $tenMH2,
        "donVi" =>$donvi2,
        "gia"=>$gia2,
        "anh"=>$link
    );
    $url = "https://0fjxt2m5xk.execute-api.us-east-2.amazonaws.com/dev/updateMatHang/{$maMH2}";
    $content = json_encode($array);
    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
    curl_setopt($curl, CURLOPT_POSTFIELDS, $content);
    if (in_array($tenMH2, $arr)) {
        echo "<script>alert('Mặt hàng đã có trong danh sách, vui lòng kiểm tra lại!');</script>";
        header("Refresh:0");
    } elseif ($gia2 <0) {
        echo "<script>alert('Giá không được phép nhỏ hơn hoặc bằng 0!');</script>";
        header("Refresh:0");
    } else {
        if (curl_exec($curl));
        {
            echo "<script>alert('Đã sửa!');</script>";
            header("Refresh:0");
        }
    }
}
if (isset($_POST['submitDelete'])) {
    $idDelete = $_POST['maMHDeLete'];
    $url = "https://0fjxt2m5xk.execute-api.us-east-2.amazonaws.com/dev/deleteMatHang/{$idDelete}";
    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "DELETE");
    if (curl_exec($curl));
    {
        echo "<script>alert('Đã xóa!');</script>";
        header('refresh: 0');
    }
}
require_once 'View/mathang.php';
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
    $("#addDLForm").validate({
        rules:{
            tenMH:{
                required: true,
                minlength: 3,
                maxlength: 30,
                alphanumeric:true
            },
            anh: {
                required: false,
                extension: "jpg|jpeg|gif|png"
            }, 
            donvi:{
				required: true
            }
        },
        messages:{
            tenMH: {
                required: "<span class='error'>Tên mặt hàng không được để trống!</span>",
                minlength: "<span class='error'>Độ dài tối thiểu: 3 ký tự!</span>",
                maxlength: "<span class='error'>Độ dài tối đa: 30 ký tự!</span>",
                alphanumeric:"<span class='error'>Không được phép nhập ký tự đặc biệt!</span>"
            },
            anh: {
            	extention: "<span class='error'>Vui lòng chọn ảnh đúng định dạng!</span>"
            }
        }
    });

});
</script>