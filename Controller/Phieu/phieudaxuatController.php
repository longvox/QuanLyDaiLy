<?php
$query = "select * from daily d, phieuxuat p where d.MaDL = p.MaDL and p.tinhtrang=1 and p.DeleteFlag =0";
$data = $db->execute($query);
if (isset($_POST['submitEdit'])) {
    $maDL =$_POST['iddl'];
    $tinhtrang = $_POST['tinhtrang'];
    $id = $_POST['idEdit'];
    $array = array(
        "maDL" => $maDL,
        "tinhtrang"=>$tinhtrang,
    );
    if ($tinhtrang==0) {
        $url = "https://0fjxt2m5xk.execute-api.us-east-2.amazonaws.com/dev/updatePhieuDaXuat/{$id}";
        $content = json_encode($array);
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
        curl_setopt($curl, CURLOPT_POSTFIELDS, $content);
        if (curl_exec($curl));
        {
            echo "<script>alert('Đã sửa!');</script>";
            header("location:index.php?controller=them-mat-hang&id=$id");
        }
    }
}
if (isset($_POST['submitDelete'])) {
    $idDelete = $_POST['idDelete'];
    $url = "https://0fjxt2m5xk.execute-api.us-east-2.amazonaws.com/dev/deletePhieuDaXuat/{$idDelete}";
    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
    if (curl_exec($curl));
    {
        echo "<script>alert('Đã xóa!');</script>";
        header('refresh:0');
    }
}
require_once 'View/dsphieudaxuat.php';
