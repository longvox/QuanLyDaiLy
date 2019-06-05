<?php
$url = "https://0fjxt2m5xk.execute-api.us-east-2.amazonaws.com/dev/getallDangNhap";
$curl = curl_init($url);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "GET");
$get =  json_decode(curl_exec($curl), true);
$getAll = $get["item"];
if (isset($_POST['submitDelete'])) {
    foreach ($getAll as $key =>$value) {
        $url = "https://0fjxt2m5xk.execute-api.us-east-2.amazonaws.com/dev/deleteDangNhap/{$value['id']}";
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "DELETE");
        curl_exec($curl);
    }
    echo "<script>alert('Đã xóa!');</script>";
    header('refresh: 3');
}
require_once 'View/lichsudangnhap.php';
