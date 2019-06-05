<?php
$table = 'daily';
$sql = "select d.*,TenLoaiDL, TenQuan from daily d, loaidaily l, quan q where d.MaLoaiDL = l.MaLoaiDL and q.MaQuan = d.MaQuan and d.DeleteFlag =1";
$data = $db->execute($sql);
if (isset($_POST['submit3'])) {
    $maDL3=$_POST['maDL3'];
    $url = "https://0fjxt2m5xk.execute-api.us-east-2.amazonaws.com/dev/phuchoiDaiLy/{$maDL3}";
    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
    if (curl_exec($curl));
    {
        echo "<script>alert('Đã phục hồi!');</script>";
        header('refresh: 0');
    }
}
require_once 'View/phuchoidaily.php';
?>
<style type="text/css">
.error{
color: red;
}
input[type=number]::-webkit-inner-spin-button, 
input[type=number]::-webkit-outer-spin-button { 
  -webkit-appearance: none; 
  margin: 0; 
}
</style>
<script type="text/javascript">
$(document).ready( function (){
    $('#myTable').DataTable({
		"order":[[0,"desc"]]
	});
});
</script>