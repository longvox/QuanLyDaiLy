<?php
$sql = "select m.*, t.TenDonVi, b.deleteTime from mathang m, donvi t, bk_mathang b where m.MaMH = b.MaMH and t.MaDonVi = b.MaDonVi and m.DeleteFlag = 1";
$data = $db->execute($sql);
if (isset($_POST['submit3'])) {
    $ma3 = $_POST['maDL3'];
    $sql = "select * from thamso where MaTS = 2";
    $assoc = mysqli_fetch_assoc($db->execute($sql));
    $num_row = $db->num_rows('mathang');
    if ($num_row < $assoc['GiaTri']) {
        $db->execute("call PhucHoi_MatHang('$ma3')");
        header('refresh: 0');
    } else {
        echo "<script>alert('Mặt hàng chỉ có tối đa là: {$assoc['GiaTri']}');</script>";
        header("Refresh:0");
    }
}
require_once 'View/phuchoimathang.php';
?>
<script type="text/javascript">
	$(document).ready(function() {
		$('#myTable').DataTable({
			"order": [
				[5, "desc"]
			]
		});
	});
</script>