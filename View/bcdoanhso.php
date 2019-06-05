<!DOCTYPE html>
<html>

<head>
	<meta charset="ISO-8859-1">
	<meta content="text/html; charset=utf-8" http-equiv="Content-Type">
	<title>Báo Cáo Doanh Số</title>
	<link rel="shortcut icon" href="asset/img/logomi.png">
	<?php
    require 'cdn.php';
    ?>
</head>

<body>
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-3">
				<div class="panel panel-info">
					<div class="panel-heading">
						<h3 class="panel-title"><strong>Chọn tháng và năm</strong></h3>
					</div>
					<div class="panel-body">
						<div class="form-group">
							<form method="post">
								<input name="pickDate" class="form-control" type="date" value="<?php echo date("Y-m-d"); ?>" /><br>
								<input type="submit" name="submit" class="btn btn-success form-control" value="Lọc" />
							</form>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-9 col-lg-6 col-xs-6 col-sm-6">
				<div class="content">
					<!-- Start Danh sach loai dai ly -->
					<div class="panel">
						<div class="panel-heading">
							<div class=row>
								<div class="col-md-7">
									<h3>Báo Cáo Doanh Số</h3>
								</div>
								<div class="col-md-5">
								</div>
							</div>
						</div>
						<div class="panel-body">

							<table id="myTable" class="table table-striped table-bordered">
								<thead>
									<tr>
										<th>Tên Đại Lý</th>
										<th>Số Phiếu Xuất</th>
										<th>Tổng Trị Giá</th>
										<th>Tỉ Lệ</th>
									</tr>
								</thead>
								<tbody>
									<?php
                                    if (isset($sql)) {
                                        $result = $db->execute($sql);
                                    }
                                    if (!empty($result) && isset($_POST['submit'])) {
                                        while ($value = mysqli_fetch_array($result)) {
                                            $tenDL = $value['TenDL'];
                                            $soPhieuXuat = $value['soPhieuXuat'];
                                            $tongTriGia = $value['tongTriGia'];
                                            $tile = $value['tiLe'] * 100;
                                            $sum += $tongTriGia; ?>
											<tr>
												<td><?php echo $tenDL; ?></td>
												<td><?php echo $soPhieuXuat; ?></td>
												<td><?php echo number_format($tongTriGia) . " VNĐ"; ?></td>
												<td><?php echo number_format($tile, 1) . "%" ?></td>
											</tr>
										<?php
                                        }
                                    } ?>
								</tbody>
							</table>
							<div class="row">
								<div class="col-md-6">
									<?php if (isset($thang) && (isset($sum))) {
                                        echo "<h3 style='border: 2px solid blue'>Tổng Thu Nhập Trong Tháng " . $thang . ": " . number_format($sum) . " VNĐ" . "</h3>";
                                    }
                                    ?>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-2"></div>
		</div>
	</div>
	<script>
		$.validate({
			modules: 'location, date, security, file',
			onModulesLoaded: function() {
				//$('#country').suggestCountry();
			}
		});
	</script>

</body>

</html>