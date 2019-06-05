<?php
if (isset($_POST['submit'])) {
    if (isset($_POST['giatri'])&&isset($_POST['ghichu'])) {
        $ghichu = $_POST['ghichu'];
        $giatri = $_POST['giatri'];
    }
    $query = "insert into thamso(GiaTri,GhiChu) values('{$giatri}','{$ghichu}')";
    if ($db->execute($query)) {
        header('Refresh:0');
    }
}
if (isset($_POST['submitDelete'])) {
    $idDelete = $_POST['idDelete'];
    $query = "delete from thamso where MaTS = $idDelete";
    $db->execute($query);
    header('Refresh:0');
}
if (isset($_POST['submitEdit'])) {
    $idEdit = $_POST['idEdit'];
    $giatriEdit = $_POST['giatriEdit'];
    $array = array(
        "giaTri" => $giatriEdit
    );
    $url = "https://0fjxt2m5xk.execute-api.us-east-2.amazonaws.com/dev/updateThamSo/{$idEdit}";
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
require_once 'View/quidinh.php';
