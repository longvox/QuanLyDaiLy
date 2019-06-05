<?php
$table = "loaidaily";
$data = $db->getAllData($table);
$num_row = $db->num_rows($table);
if (isset($_POST['submit'])) {
    if (isset($_POST['tenLoaiDL'])) {
        $tenLoaiDL = $_POST['tenLoaiDL'];
        $duocphep = $_POST['duocPhep'];
    }
    $sql = "select GiaTri from thamso where MaTS = 1";
    $result = $db->execute($sql);
    $assoc = mysqli_fetch_assoc($result);
    if ($num_row < $assoc['GiaTri']) {
        $sql3 = "select * from loaidaily where DeleteFlag =0 and TenLoaiDL = '$tenLoaiDL'";
        $num_row2 = mysqli_num_rows($db->execute($sql3));
        $array = array(
            "tenLoaiDL" => $tenLoaiDL,
            "duocPhep" => $duocphep
        );
        $url = "https://0fjxt2m5xk.execute-api.us-east-2.amazonaws.com/dev/insertLoaiDaiLy";
        $content = json_encode($array);
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $content);
        if ($num_row2 != 0) {
            echo "<script>alert('Loại đại lý này đã có trong danh sách, vui lòng kiểm tra lại!');</script>";
            header("Refresh:0");
        } else {
            if (curl_exec($curl));
            {
                echo "<script>alert('Đã thêm!');</script>";
                header("Refresh:0");
            }
        }
    } else {
        echo "<script>alert('Loại đại lý chỉ có tối đa là {$assoc['GiaTri']}');</script>";
        header("Refresh:0");
    }
}
if (isset($_POST['submitEdit'])) {
    $id = $_POST['idLoaiDL'];
    $tenLoaiDL2 = $_POST['tenLoaiDL2'];
    $ten_current = $_POST['idtenLoaiDL'];
    $duocphep2 = $_POST['duocPhep2'];
    $array = array(
        "tenLoaiDL" => $tenLoaiDL2,
        "duocPhep"=>$duocphep2
    );
    $sql3 = "select TenLoaiDL from loaidaily where DeleteFlag =0 and TenLoaiDL not in (select TenLoaiDL from loaidaily where DeleteFlag = 0 and TenLoaiDL = '$ten_current')";
    $result = $db->execute($sql3);
    $url = "https://0fjxt2m5xk.execute-api.us-east-2.amazonaws.com/dev/updateLoaiDaiLy/{$id}";
    $content = json_encode($array);
    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
    curl_setopt($curl, CURLOPT_POSTFIELDS, $content);
    $arr=[];
    foreach ($result as $dt) {
        $arr[] = $dt['TenLoaiDL'];
    }
    if (in_array("$tenLoaiDL2", $arr, true)) {
        echo "<script>alert('Loại đại lý này trùng với loại đại lý đã có trong danh sách, vui lòng kiểm tra lại!');</script>";
        header("Refresh:0");
    } else {
        if (curl_exec($curl));
        {
            echo "<script>alert('Đã sửa!');</script>";
            header("Refresh:0");
        }
    }
}
if (isset($_POST['submitDelete'])) {
    $id = $_POST['maDLDeLete'];
    $url = "https://0fjxt2m5xk.execute-api.us-east-2.amazonaws.com/dev/deleteLoaiDaiLy/{$id}";
    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "DELETE");
    if (curl_exec($curl));
    {
        echo "<script>alert('Đã xóa!');</script>";
        header("Refresh:0");
    }
}
$table2 = "quan";
$data2 = $db->getAllData($table2);
$num_row2 = $db->num_rows($table2);
if (isset($_POST['submit2'])) {
    if (isset($_POST['tenQuan'])) {
        $tenQuan = $_POST['tenQuan'];
    }
    $sql2 = "select GiaTri from thamso where MaTS = 4";
    $result2 = $db->execute($sql2);
    $assoc2 = mysqli_fetch_assoc($result2);
    if ($num_row2 < $assoc2['GiaTri']) {
        $sql3 = "select * from quan where DeleteFlag =0 and TenQuan = '$tenQuan'";
        $num_row2 = mysqli_num_rows($db->execute($sql3));
        $array = array(
            "tenQuan" => $tenQuan
        );
        $url = "https://0fjxt2m5xk.execute-api.us-east-2.amazonaws.com/dev/insertQuan";
        $content = json_encode($array);
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $content);
        if ($num_row2 != 0) {
            echo "<script>alert('Quận này đã có trong danh sách, vui lòng kiểm tra lại!');</script>";
            header("Refresh:0");
        } else {
            if (curl_exec($curl));
            {
                echo "<script>alert('Đã thêm!');</script>";
                header("Refresh:0");
            }
        }
    } else {
        echo "<script>alert('Quận chỉ có tối đa là {$assoc2['GiaTri']}');</script>";
        header("Refresh:0");
    }
}
if (isset($_POST['submitEditQuan'])) {
    $id2 = $_POST['idQuan'];
    $tenQuan2 = $_POST['tenQuan2'];
    $sql3 = "select * from quan where DeleteFlag =0 and TenQuan = '$tenQuan2'";
    $num_row2 = mysqli_num_rows($db->execute($sql3));
    $array = array(
        "tenQuan" => $tenQuan2
    );
    $url = "https://0fjxt2m5xk.execute-api.us-east-2.amazonaws.com/dev/updateQuan/{$id2}";
    $content = json_encode($array);
    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
    curl_setopt($curl, CURLOPT_POSTFIELDS, $content);
    if ($num_row2 != 0) {
        echo "<script>alert('Loại đại lý này đã có trong danh sách, vui lòng kiểm tra lại!');</script>";
        header("Refresh:0");
    } else {
        if (curl_exec($curl));
        {
            echo "<script>alert('Đã sửa!');</script>";
            header("Refresh:0");
        }
    }
}
if (isset($_POST['submitDeleteQuan'])) {
    $id2 = $_POST['maDLDeLeteQuan'];
    $url = "https://0fjxt2m5xk.execute-api.us-east-2.amazonaws.com/dev/deleteQuan/{$id2}";
    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "DELETE");
    if (curl_exec($curl));
    {
        echo "<script>alert('Đã xóa!');</script>";
        header("Refresh:0");
    }
}
require_once 'View/loaidaily-quan.php';
?>
<style type="text/css">
    .error {
        color: red;
    }
</style>
<script type="text/javascript">
    $(document).ready(function() {
        $('#myTable').DataTable();
        $('#myTable2').DataTable();
        $("#quanForm").validate({
            rules: {
                tenQuan: {
                    required: true,
                    minlength: 3,
                    maxlength: 20,
                    alphanumeric: true
                }
            },
            messages: {
                tenQuan: {
                    required: "<span class='error'>Tên quận không được để trống!</span>",
                    minlength: "<span class='error'>Độ dài tối thiểu: 3 ký tự!</span>",
                    maxlength: "<span class='error'>Độ dài tối đa: 20 ký tự!</span>",
                    alphanumeric: "<span class='error'>Không được phép nhập ký tự đặc biệt!</span>"
                }
            }
        });
        $("#loaiDLForm").validate({
            rules: {
                tenLoaiDL: {
                    required: true,
                    minlength: 3,
                    maxlength: 20,
                    alphanumeric: true
                }
            },
            messages: {
                tenLoaiDL: {
                    required: "<span class='error'>Tên loại đại lý không được để trống!</span>",
                    minlength: "<span class='error'>Độ dài tối thiểu: 3 ký tự!</span>",
                    maxlength: "<span class='error'>Độ dài tối đa: 20 ký tự!</span>",
                    alphanumeric: "<span class='error'>Không được phép nhập ký tự đặc biệt!</span>"
                }
            }
        });
    });
</script>