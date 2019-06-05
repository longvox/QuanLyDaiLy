<?php
$query = "select p.*,d.TenDL, d.DeleteFlag from daily d, phieuxuat p where d.MaDL = p.MaDL and p.tinhtrang=0 and p.DeleteFlag=0 and d.DeleteFlag =0";
$data = $db->execute($query);
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql="select * from daily where MaDL='$id'";
    $assoc = mysqli_fetch_assoc($db->execute($sql));
}
if (isset($_POST['submit'])) {
    $daily = $_POST['daily'];
    date_default_timezone_set("Asia/Bangkok");
    $time = date('Y/m/d H:i:s');
    $array = array(
        "maDL" => $daily,
        "ngayLapPX"=>$time
    );
    $url = "https://0fjxt2m5xk.execute-api.us-east-2.amazonaws.com/dev/insertPhieuXuat";
    $content = json_encode($array);
    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $content);
    if (curl_exec($curl));
    {
        $query2 = "select * from phieuxuat where DeleteFlag= 0 and NgayLapPX ='$time'";
        $result = mysqli_fetch_assoc($db->execute($query2));
        $maPX = $result['MaPX'];
        header("Location: index.php?controller=them-mat-hang&id='$maPX'");
    }
}
if (isset($_POST['submitDelete'])) {
    $idDelete = $_POST['idDelete'];
    $url = "https://0fjxt2m5xk.execute-api.us-east-2.amazonaws.com/dev/deletePhieuXuat/{$idDelete}";
    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "DELETE");
    if (curl_exec($curl));
    {
        echo "<script>alert('Đã xóa!');</script>";
        header('refresh: 0');
    }
}
require_once 'View/lapphieuxuat.php';
