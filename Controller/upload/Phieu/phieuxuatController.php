<?php
$table2="daily";
$data2 = $db->getAllData($table2);
if (isset($_POST['submit'])) {
    $daily = $_POST['daily'];
    $array = array(
        "maDL" => $daily
    );
    $url = "https://0fjxt2m5xk.execute-api.us-east-2.amazonaws.com/dev/insertPhieuXuat";
    $content = json_encode($array);
    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $content);
    if (curl_exec($curl));
    {
        echo "<script>alert('Đã tạo!');</script>";
        header('refresh: 0');
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
