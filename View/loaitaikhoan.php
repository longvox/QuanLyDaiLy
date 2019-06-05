<!DOCTYPE html>
<html>

<head>
	<meta charset="ISO-8859-1">
	<meta content="text/html; charset=utf-8" http-equiv="Content-Type">
	<title>Quản Lý Loại Tài Khoản</title>
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
						<h3 class="panel-title"><strong>Nhập Thông Tin</strong></h3>
					</div>
					<div class="panel-body">
						<div class="form-group">
							<form method="post" id="addForm">
								<div class="form-group">
									<label><strong>
											<h4>Tên Loại Tài Khoản</h4>
										</strong></label>
									<input class="form-control" type="text" name="tenLoai" autofocus /><br>
									<label><strong>
											<h4>Chọn Quyền</h4>
										</strong></label><br>
									<input name="fullquyen" type="checkbox" onclick="checkall('chrole',this)" /><strong>Full Quyền</strong><br><br>
									<?php foreach ($role as $key => $value) { ?>
										<input name="chrole[]" class="chrole" type="checkbox" value="<?php
                                                                                                                                                                    echo $value['title'] . "/" . $value['link'];
                                                                                                                                                                    ?>" />
										<label><strong><?php echo $value['title'] ?></strong></label><br>
									<?php } ?>
									<input type="submit" name="submit" class="btn btn-success form-control" value="Thêm" />
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-9 col-lg-7 col-xs-7 col-sm-7">
				<div class="content">
					<!-- Start Danh sach loai dai ly -->
					<div class="panel">
						<div class="panel-heading">
							<div class=row>
								<div class="col-md-7">
									<h3>Thông Tin Loại Tài Khoản </h3>
								</div>
								<div class="col-md-5">
								</div>
							</div>
						</div>
						<div class="panel-body">

							<table id="myTable" class="table table-striped table-bordered">
								<thead>
									<tr>
										<th style="width: 70px;">Mã Loại Tài Khoản</th>
										<th style="width: 160px;">Tên Loại Tài Khoản</th>
										<th>Quyền</th>
										<th style="width: 70px;">Sửa</th>
									</tr>
								</thead>
								<tbody>
									<?php
                                    $sql = "select * from loaiuser where DeleteFlag=0";
                                    $result = $db->execute($sql);
                                    if (!empty($result)) {
                                        while ($value = mysqli_fetch_array($result)) {
                                            $maLoaiTK = $value['MaLoaiUser'];
                                            $tenLoaiTK = $value['TenLoaiUser'];
                                            $quyen = $value['Role']; ?>
											<tr>
												<td><?php echo $maLoaiTK; ?></td>
												<td><?php echo $tenLoaiTK; ?></td>
												<td><?php
                                                        $tach = explode(',', $quyen);
                                            $dem = 1;
                                            foreach ($tach as $tach2) {
                                                if ($dem < count($tach)) {
                                                    $tach3 = explode('/', $tach2);
                                                    echo $tach3[0] . "<br>";
                                                }
                                                $dem++;
                                            } ?></td>
												<td><a class="glyphicon glyphicon-edit" href="index.php?controller=sua-loaitk&id=<?php echo $maLoaiTK; ?>">Sửa</a></td>
											</tr>
										<?php
                                        }
                                    } ?>
								</tbody>
							</table>
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