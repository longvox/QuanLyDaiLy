<?php
$query = "select p.*, d.TenDL, b.deleteTime from phieuxuat p, daily d, bk_phieuxuat b where d.MaDL = p.MaDL and p.MaPX = b.MaPX and p.DeleteFlag = 1 and p.TinhTrang =1 ";
$data = $db->execute($query);
if (isset($_POST['submit3'])) {
    $ma3=$_POST['maDL3'];
    $db->execute("call PhucHoi_PhieuXuat($ma3)");
    header('refresh: 0');
}
require_once 'View/phuchoiphieuxuat.php';
?>
<script type="text/javascript">
$(document).ready( function (){
    $('#myTable').DataTable({
		"order":[[6,"desc"]]
	});
});
</script>