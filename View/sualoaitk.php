<!DOCTYPE html>
<html>

<head>
	<meta charset="ISO-8859-1">
	<meta content="text/html; charset=utf-8" http-equiv="Content-Type">
	<title>Sửa Loại Tài Khoản</title>
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
						<h3 class="panel-title"><strong>Sửa Loại Tài Khoản</strong></h3>
					</div>
					<div class="panel-body">
						<div class="form-group">
							<form method="post">
								<div class="form-group">
									<input type="hidden" name="idLoaiTK" /><br>
									<label><strong>
											<h4>Tên Loại Tài Khoản</h4>
										</strong></label>
									<input class="form-control" type="text" name="tenLoai" autofocus" /><br>
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
									<input type="submit" name="submit" class="btn btn-success form-control" value="Cập Nhật" />
								</div>
							</form>
						</div>
					</div>
				</div>
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