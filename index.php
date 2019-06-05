<?php
session_start();
if (isset($_SESSION['loaiUser'])) {
    $id = $_SESSION['loaiUser'];
} else {
    header('location: login.php');
}
include 'Model/DBquanlydaily.php';
$db = new database();
$db->connect();
$sql = "select MaLoaiUser, Role, TenLoaiUser from loaiuser where DeleteFlag = 0 and MaLoaiUser = $id";
$checkrol_row = mysqli_fetch_assoc($db->execute($sql));
$current_url = $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
$current_tach = explode('/', $current_url);
$tm = count($current_tach);
$dem_mt = 1;
$mangthaythe = array();
foreach ($current_tach as $current_tach2) {
    if ($dem_mt == $tm) {
        if (isset($_GET['id'])) {
            $current_tach2_id = explode('&', $current_tach2);
        }
        $current_tach2;
        $tachcheckrole = explode(',', $checkrol_row['Role']);
        $count = count($tachcheckrole);
        $demthay = 1;
        foreach ($tachcheckrole as $tach) {
            if ($demthay < $count) {
                $tach2 = explode('/', $tach);
                $mangthaythe[] = $tach2[1];
            }
            $demthay++;
        }
        if (isset($_GET['controller']) && isset($current_tach2_id[0]) && in_array($current_tach2_id[0], $mangthaythe)) {
            $controller = $_GET['controller'];
        } elseif (isset($_GET['controller']) && in_array($current_tach2, $mangthaythe)) {
            $controller = $_GET['controller'];
        } else {
            $controller = 'error';
        }
    }
    $dem_mt++;
}
switch ($controller) {
    case 'dai-ly':
        require_once('Controller/DaiLy/index.php');
        break;
    case 'ph-dai-ly':
        require_once('Controller/DaiLy/phDaiLy.php');
        break;
    case 'ph-mat-hang':
        require_once('Controller/MatHang/phmathangController.php');
        break;
    case 'ph-phieu-xuat':
        require_once('Controller/Phieu/phphieuxuatController.php');
        break;
    case 'ph-phieu-thu':
        require_once('Controller/Phieu/phphieuthuController.php');
        break;
    case 'loai-dai-ly':
        require_once('Controller/LoaiDaiLy/index.php');
        break;
    case 'mat-hang':
        require_once('Controller/MatHang/mathangController.php');
        break;
    case 'don-vi':
        require_once('Controller/MatHang/donviController.php');
        break;
    case 'phieu-xuat':
        require_once('Controller/Phieu/phieuxuatController.php');
        break;
    case 'them-mat-hang':
        require_once('Controller/Phieu/addmathangvaophieu.php');
        break;
    case 'phieu-da-xuat':
        require_once('Controller/Phieu/phieudaxuatController.php');
        break;
    case 'ct-phieu-da-xuat':
        require_once('Controller/Phieu/ctphieudaxuatController.php');
        break;
    case 'phieu-thu':
        require_once('Controller/Phieu/phieuThuController.php');
        break;
    case 'phieu-thu-da-lap':
        require_once('Controller/Phieu/phieuthudalapController.php');
        break;
    case 'qui-dinh':
        require_once('Controller/quidinhController.php');
        break;
    case 'bao-cao-doanh-so':
        require_once('Controller/BaoCao/baocaodoanhso.php');
        break;
    case 'bao-cao-cong-no':
        require_once('Controller/BaoCao/baocaocongno.php');
        break;
    case 'tai-khoan':
        require_once('Controller/TaiKhoan/taikhoanController.php');
        break;
    case 'loai-tai-khoan':
        require_once('Controller/TaiKhoan/loaitaikhoanController.php');
        break;
    case 'sua-loaitk':
        require_once('Controller/TaiKhoan/sualoaitkController.php');
        break;
    case 'lich-su':
        require_once('Controller/TaiKhoan/lichsuDNController.php');
        break;
    case 'error':
        require_once('Controller/thongbao.php');
}
