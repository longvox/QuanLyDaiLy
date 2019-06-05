<?php
$table = 'daily';
$sql = "select d.*, b.deleteTime, q.MaQuan, TenLoaiDL, TenQuan from daily d, loaidaily l, quan q, bk_daily b where d.MaLoaiDL = l.MaLoaiDL and q.MaQuan = d.MaQuan and b.MaDL = d.MaDL and d.DeleteFlag =1";
$data = $db->execute($sql);
if (isset($_POST['submit3'])) {
    $quan2 = $_POST['maDL2'];
    $sql2 = "select d.*,TenLoaiDL, TenQuan from daily d, loaidaily l, quan q where d.MaLoaiDL = l.MaLoaiDL and q.MaQuan = d.MaQuan and d.DeleteFlag =0 and q.MaQuan=$quan2";
    $sql = "select * from thamso where MaTS = 7";
    $assoc = mysqli_fetch_assoc($db->execute($sql));
    $num_row = mysqli_num_rows($db->execute($sql2));
    if ($num_row < $assoc['GiaTri']) {
        $maDL3 = $_POST['maDL3'];
        $url = "https://0fjxt2m5xk.execute-api.us-east-2.amazonaws.com/dev/phuchoiDaiLy/{$maDL3}";
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
        if (curl_exec($curl));
        {
      echo "<script>alert('Đã phục hồi!');</script>";
      header('refresh: 0');
    }
    } else {
        echo "<script>alert('Mỗi quận chỉ có tối đa: {$assoc['GiaTri']} đại lý');</script>";
        header("Refresh:0");
    }
}
require_once 'View/phuchoidaily.php';
?>
<style type="text/css">
  .error {
    color: red;
  }

  input[type=number]::-webkit-inner-spin-button,
  input[type=number]::-webkit-outer-spin-button {
    -webkit-appearance: none;
    margin: 0;
  }
</style>
<script type="text/javascript">
  $(document).ready(function() {
    $('#myTable').DataTable({
      "order": [
        [6, "desc"]
      ]
    });
  });
</script>