<?php
$role = array(
    "daily"=>array(
        "title" => "Danh Mục Đại Lý",
        "link" =>"index.php?controller=dai-ly"
    ),
    "loaidl"=>array(
        "title" => " Loại Đại Lý - Quận",
        "link" =>"index.php?controller=loai-dai-ly"
    ),
    "mathang"=>array(
        "title" => "Danh Mục Mặt Hàng",
        "link" =>"index.php?controller=mat-hang"
    ),
    "phieuxuat"=>array(
        "title" => "Danh Mục Phiếu Xuất",
        "link" =>"index.php?controller=phieu-xuat"
    ),
    "phieuthu"=>array(
        "title" => "Danh Mục Phiếu Thu",
        "link" =>"index.php?controller=phieu-thu"
    ),
    "addmathang"=>array(
        "title" => "Thêm Mặt Hàng Vào Phiếu",
        "link" =>"index.php?controller=them-mat-hang"
    ),
    "donvi"=>array(
        "title" => "Danh Mục Đơn Vị Tính",
        "link" =>"index.php?controller=don-vi"
    ),
    "phieudaxuat"=>array(
        "title" => "Danh Mục Phiếu Đã Xuất",
        "link" =>"index.php?controller=phieu-da-xuat"
    ),
    "bcdoanhso"=>array(
        "title" => "Báo Cáo Doanh Số",
        "link" =>"index.php?controller=bao-cao-doanh-so"
    ),
    "bccongno"=>array(
        "title" => "Báo Cáo Công Nợ",
        "link" =>"index.php?controller=bao-cao-cong-no"
    ),
    "phdaily"=>array(
        "title" => "Phục Hồi Đại Lý",
        "link" =>"index.php?controller=ph-dai-ly"
    ),
    "taikhoan"=>array(
        "title" => "Quản Lý Tài Khoản",
        "link" =>"index.php?controller=tai-khoan"
    ),
    "themloaitk"=>array(
        "title" => "Thêm Loại Tài Khoản",
        "link" =>"index.php?controller=loai-tai-khoan"
    ),
    "sualoaitk"=>array(
        "title" => "Sửa Loại Tài Khoản",
        "link" =>"index.php?controller=sua-loaitk"
    ),
    "lichsudn"=>array(
        "title" => "Lịch Sử Đăng Nhập",
        "link" =>"index.php?controller=lich-su"
    ),
    "quidinh"=>array(
        "title" => "Qui Định",
        "link" =>"index.php?controller=qui-dinh"
    )
);
if (isset($_POST['submit'])) {
    $chrole =$_POST['chrole'];
    $tenLoai = $_POST['tenLoai'];
    $countcheckrole=count($chrole);
    $del_role ='';
    for ($i=0;$i<$countcheckrole;$i++) {
        $del_role .= $chrole[$i].",";
    }
    $sql = "insert into loaiuser(TenLoaiUser,Role) values('{$tenLoai}','$del_role')";
    $db->execute($sql);
}
require_once 'View/loaitaikhoan.php';
?>
<script>
	$(document).ready( function () {
	    $('#myTable').DataTable();
	} );
	function checkall(class_name, obj){
		var items = document.getElementsByClassName(class_name);
		if (obj.checked == true){
			for(i=0;i<items.length;i++){
				items[i].checked = true;
			}
		}
		else{
			for(i=0;i<items.length;i++){
				items[i].checked = false;
			}
		}
	}
 </script>