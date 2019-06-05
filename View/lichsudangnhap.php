<!DOCTYPE html>
<html>
<head>
<meta charset="ISO-8859-1">
<meta content="text/html; charset=utf-8" http-equiv="Content-Type">
<title>Lịch Sử Đăng Nhập</title>
<link rel="shortcut icon" href="asset/img/logomi.png">
<?php
require 'cdn.php';
?>
</head>
<body>
	<div class="container-fluid mimin-wrapper">
    <form action ="<?php $_SERVER['PHP_SELF']?>" id="mainForm" method="post" >
			<!-- Modal content -->
			<div class="row">
				<div class="col-md-12">
				<div class="panel panel-info">
                  <div class="panel-heading">
                    <h3 class="panel-title">Lịch Sử Đăng Nhập</h3>
                  </div>
                  <div class="panel-body">
				<div class="row">
					<div class="col-md-3">
														<input style="margin-top: 10px" type="submit" class="btn ripple btn-3d btn-success" name="submitDelete" value="Xóa Lịch Sử"/
										
					</div>
				</div>
				<div class="row">
					<div class="col-md-12 col-lg-12 col-xs-12 col-sm-12">
						<table width="500" id="myTable"
									class="table table-striped table-bordered">
									<thead>
										<tr>
											<th>Tài Khoản</th>
											<th>Tên Người Dùng</th>
											<th>Loại Người Dùng</th>
											<th>Ngày Đăng Nhập</th>
										</tr>
									</thead>
									<tbody>
									<?php

                                    if (!empty($getAll)) {
                                        foreach ($getAll as $value) {
                                            $taikhoan = $value['taiKhoan'];
                                            $tenhienthi = $value['disPlayName'];
                                            $loaitk = $value['tenLoaiUser'];
                                            $ngayDN = $value['dangNhapVaoLuc']; ?>
										<tr>
											<td><?php echo $taikhoan?></td>
											<td><?php echo $tenhienthi?></td>
											<td><?php echo $loaitk?></td>
											<td><?php echo $ngayDN?></td>
              								</tr>
									<?php
                                        }
                                    }?>
									</tbody>
								</table>
					</div>
				</div>
				</div>
			</div>
					</div>
                  </div>
				  </form>

						
	
	<script src="asset/js/main.js"></script>
	<script type="text/javascript">
    $('#myTable').DataTable({
		"order":[[3,"desc"]],
				scrollY: 400,
				scrollX:true,
        scrollCollapse:true,
        paging:false
	});
 </script>
 <script>

  $.validate({
    modules : 'location, date, security, file',
    onModulesLoaded : function() {
      //$('#country').suggestCountry();
    }
  });


</script>

</body>
</html>
