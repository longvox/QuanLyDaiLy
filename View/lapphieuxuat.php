<!DOCTYPE html>
<html>

<head>
	<meta charset="ISO-8859-1">
	<meta content="text/html; charset=utf-8" http-equiv="Content-Type">
	<title>Danh Sách Phiếu Xuất</title>
	<link rel="shortcut icon" href="asset/img/logomi.png">
	<?php
    require 'cdn.php';
    ?>
</head>

<body>
	<div class="container-fluid mimin-wrapper">
		<form action="<?php $_SERVER['PHP_SELF'] ?>" id="mainForm" method="post">
			<!-- Modal content -->
			<div class="row">
				<div class="col-md-4">
					<div class="panel panel-info">
						<div class="panel-heading">
							<h3 class="panel-title">Thông Tin Đại Lý</h3>
						</div>
						<div class="panel-body">
							<form method="post">
								<div class="form-group">
									<?php
                                    if (!empty($assoc)) {
                                        ?>
										<label for="daily">Mã Đại Lý: </label>
										<input class="form-control" value="<?php echo $assoc['MaDL'] ?>" disabled />
										<input type="hidden" name="daily" class="form-control" value="<?php echo $assoc['MaDL'] ?>" />
										<label for="daily">Tên Đại Lý: </label>
										<input class="form-control" value="<?php echo $assoc['TenDL'] ?>" disabled />
										<label for="daily">Tiền Nợ: </label>
										<input class="form-control" value="<?php echo $assoc['TienNo'] ?>" disabled />
									<?php
                                    } ?>
								</div>
								<div class="form-group">
									<label for="ngayTN">Ngày Lập Phiếu: </label>
									<input type="date" id="ngaytn" name="ngayLapPhieu" disabled value="<?php echo date("Y-m-d"); ?>">
								</div>

								<button name="submit" class="btn btn-primary form-control" type="submit">Tạo Phiếu </button>
							</form>
						</div>
					</div>
				</div>
				<div class="col-md-8">
					<div class="panel panel-info">
						<div class="panel-heading">
							<h3 class="panel-title">Danh Sách Phiếu Xuất</h3>
						</div>
						<div class="panel-body">
							<div class="row">
								<div class="col-md-12 col-lg-12 col-xs-12 col-sm-12">
									<table width="800" id="myTable" class="table table-striped table-bordered">
										<thead>
											<tr>
												<th width="40">Mã Phiếu</th>
												<th width="120">Đại Lý</th>
												<th width="120">Ngày Lập Phiếu</th>
												<th width="40">Thêm Hàng Vào Phiếu</th>
												<th width="40">Xóa</th>
											</tr>
										</thead>
										<tbody>
											<?php
                                            if (!empty($data)) {
                                                foreach ($data as $value) {
                                                    $id = $value['MaPX'];
                                                    $ten = $value['TenDL'];
                                                    $ngay = date_create($value['NgayLapPX']); ?>
													<tr>
														<td width="40"><?php echo $id ?></td>
														<td width="120"><?php echo $ten?></td>
														<td width="120"><?php echo date_format($ngay, 'H:i:s d/m/Y') ?></td>
														<td width="40"><a class="glyphicon glyphicon-plus" data-toggle="modal" href="index.php?controller=them-mat-hang&id=<?php echo $id; ?>">Thêm</a></td>
														<td width="40"><a class="glyphicon glyphicon-trash" data-toggle="modal" data-target="#delete<?php echo $id; ?>">Xóa</a></td>
														<div id="delete<?php echo $id; ?>" class="modal fade" role="dialog">
															<div class="modal-dialog">
																<form method="post">
																	<!-- Modal content-->
																	<div class="modal-content">
																		<div class="modal-header">
																			<button type="button" class="close" data-dismiss="modal">&times;</button>
																			<h4 class="modal-title">Delete</h4>
																		</div>
																		<div class="modal-body">
																			<input type="hidden" name="idDelete" value="<?php echo $id; ?>">
																			<div class="alert alert-danger">Bạn có chắc muốn xóa phiếu xuất: <strong>
																					<?php echo $id; ?>?</strong> </div>
																			<div class="modal-footer">
																				<button type="submit" name="submitDelete" class="btn btn-danger"><span class="glyphicon glyphicon-trash"></span> YES</button>
																				<button type="button" class="btn btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-remove-circle"></span> NO</button>
																			</div>
																		</div>
																	</div>
																</form>
															</div>
														</div>
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
				</div>
			</div>
		</form>
	</div>

	<script src="asset/js/main.js"></script>
	<script type="text/javascript">
		$(document).ready(function() {
			$('#myTable').DataTable({
				"order": [
					[0, "desc"],
				],
				scrollY: 360,
				scrollX: true,
				paging: false
			});
		});
	</script>
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