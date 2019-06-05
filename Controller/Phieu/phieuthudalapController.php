<?php
$table2="daily";
$data2 = $db->getAllData($table2);
$query = "select p.*,d.MaDL, d.TienNo, TenDL,DienThoai,DiaChi from daily d, phieuthu p  where d.MaDL = p.MaDL and p.DeleteFlag =0 order by p.MaPT DESC";
$data = $db->execute($query);
if (isset($_POST['submitEdit'])) {
    $idEdit = $_POST['idEdit'];
    $idEditMaDL = $_POST['idEditMaDL'];
    $thu = $_POST['tienthuEdit'];
    $array = array(
        "maDL" => $idEditMaDL,
        "tienThu"=>$thu
    );
    $url = "https://0fjxt2m5xk.execute-api.us-east-2.amazonaws.com/dev/updatePhieuThu/{$idEdit}";
    $content = json_encode($array);
    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
    curl_setopt($curl, CURLOPT_POSTFIELDS, $content);
    if (curl_exec($curl));
    {
        echo "<script>alert('Đã sửa!');</script>";
        header('refresh: 0');
    }
}
if (isset($_POST['submitDelete'])) {
    $idDelete = $_POST['idDelete'];
    $idDLDelete = $_POST['idDeleteMaDL'];
    $array = array(
        "maDL" => $idDLDelete
    );
    $url = "https://0fjxt2m5xk.execute-api.us-east-2.amazonaws.com/dev/deletePhieuThu/{$idDelete}";
    $content = json_encode($array);
    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "DELETE");
    curl_setopt($curl, CURLOPT_POSTFIELDS, $content);
    if (curl_exec($curl));
    {
        echo "<script>alert('Đã xóa!');</script>";
        header('refresh: 0');
    }
}
require_once('View/phieuthudalap.php');
