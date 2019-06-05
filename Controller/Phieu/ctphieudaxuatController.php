<?php
if (isset($_GET['id'])) {
    $id = $_GET['id'];
}
$sql="select * from phieuxuat p, daily d where MaPX=$id and p.MaDL = d.MaDL and p.DeleteFlag=0";
$assoc = mysqli_fetch_assoc($db->execute($sql));
$nocu = $assoc['TienNo'] - $assoc['ConLai'];
$query = "select c.*, TenMH,m.Gia,c.SoLuong,p.MaDL  from phieuxuat p, ctphieuxuat c, mathang m where p.MaPX = c.MaPX and m.MaMH = c.MaMH and c.MaPX=$id";
$data = $db->execute($query);
require_once('View/ctphieudaxuat.php');
