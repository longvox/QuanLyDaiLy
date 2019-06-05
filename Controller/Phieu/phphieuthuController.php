<?php
$query = "select p.*,d.MaDL, d.TienNo, TenDL,DienThoai,DiaChi, b.deleteTime from daily d, phieuthu p, bk_phieuthu b  where d.MaDL = p.MaDL and p.DeleteFlag =1 and b.MaPT = p.MaPT";
$data = $db->execute($query);
if (isset($_POST['submit3'])) {
    $ma3=$_POST['maDL3'];
    $ma2=$_POST['maDL2'];
    $db->execute("call PhucHoi_PhieuThu($ma3,'$ma2')");
    header('refresh: 0');
}
require_once 'View/phuchoiphieuthu.php';
?>
<script type="text/javascript">
$(document).ready( function (){
    $('#myTable').DataTable({
		"order":[[5,"desc"]]
	});
});
</script>