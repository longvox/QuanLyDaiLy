<?php
if (isset($_POST['submit'])) {
    $date = $_POST['pickDate'];
    $tach = explode('-', $date);
    $nam = $tach[0];
    $thang = $tach[1];
    $sql = "call BaoCao_DoanhSo($thang,@tong,$nam);";
    $sum = 0;
}
require_once 'View/bcdoanhso.php';
?>
<script>
	$(document).ready( function () {
	    $('#myTable').DataTable();
	} );
 </script>