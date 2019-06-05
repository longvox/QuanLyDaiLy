<?php
if (isset($_POST['submit'])) {
    $date = $_POST['pickDate'];
    $tach = explode('-', $date);
    $nam = $tach[0];
    $thang = $tach[1];
    $sql = "call BaoCao_CongNo($thang,$nam);";
    $sum = 0;
    $sum2=0;
}
require_once 'View/bccongno.php';
?>
<script>
	$(document).ready( function () {
	    $('#myTable').DataTable();
	} );
 </script>