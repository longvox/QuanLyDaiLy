<!DOCTYPE html>
<html>

<head>
	<meta charset="ISO-8859-1">
	<meta content="text/html; charset=utf-8" http-equiv="Content-Type">
	<title>Danh Sách Qui Định</title>
	<link rel="shortcut icon" href="asset/img/logomi.png">
	<?php
    require 'cdn.php';
    ?>
</head>

<body>
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-2"></div>
			<div class="col-md-8 col-lg-6 col-xs-6 col-sm-6">
				<div class="content">
					<!-- Start Danh sach loai dai ly -->
					<div class="panel">
						<div class="panel-heading">
							<div class=row>
								<div class="col-md-7">
									<h3>Danh Sách Qui Định</h3>
								</div>
								<div class="col-md-5">
								</div>
							</div>
						</div>
						<div class="panel-body">

							<table id="myTable" class="table table-striped table-bordered">
								<thead>
									<tr>
										<th>Mã Qui Định</th>
										<th>Giá Trị</th>
										<th>Ghi Chú</th>
										<th>Sửa</th>
									</tr>
								</thead>
								<tbody>
									<?php
                                    $sql = "select * from thamso";
                                    $result = $db->execute($sql);
                                    while ($value = mysqli_fetch_array($result)) {
                                        $id = $value['MaTS'];
                                        $giatri = $value['GiaTri'];
                                        $ghichu = $value['GhiChu']; ?>
										<tr>
											<td><?php echo $id; ?></td>
											<td><?php echo $giatri; ?></td>
											<td><?php echo $ghichu; ?></td>
											<td><a class="glyphicon glyphicon-edit" data-toggle="modal" data-target="#edit<?php echo $id; ?>">Sửa</a></td>
											<div class="modal fade" id="edit<?php echo $id; ?>" role="dialog">
												<form action="<?php $_SERVER['PHP_SELF'] ?>" method="post" class="modal-dialog">
													<div id="ModalThem" class="modal-content" style="width:30%;margin:0 auto">
														<div class="modal-header">
															<button type="button" class="close" data-dismiss="modal">&times;</button>
															<h4 class="modal-title">Thay Đổi Qui Định</h4>
														</div>
														<!-- Modal content -->
														<div class="modal-body">
															<input type="hidden" name="idEdit" value="<?php echo $id ?>" />
															<div class="form-group">
																<label for="giatriEdit">Giá Trị</label>
																<input autofocus type="text" class="form-control" id="giatriEdit" name="giatriEdit" value="<?php echo $giatri; ?>" />
															</div>
														</div>
														<!-- Modal footer -->
														<div class="modal-footer">
															<button type="submit" name="submitEdit" class="btn btn-success">Lưu</button>
															<button type="button" class="btn btn-success" data-dismiss="modal">Thoát</button>
														</div>
													</div>
												</form>
											</div>
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
																<div class="alert alert-danger">Bạn có chắc muốn xóa qui định: <strong>
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
                                ?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-2"></div>
	</div>
	</div>
	<!-- End danh sach -->

	<!-- Start Modal -->
	<div class="modal fade" id="modalThemQD" role="dialog">
		<form action="<?php $_SERVER['PHP_SELF'] ?>" method="post" class="modal-dialog">
			<div id="ModalThem" class="modal-content" style="width:50%;">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Thêm Qui Định</h4>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<label for="tenLoaiDL">Giá trị</label>
						<input type="text" class="form-control" id="tenLoaiDL" name="giatri" placeholder="Nhập giá trị">
						<label for="tenLoaiDL">Ghi chú</label>
						<input type="text" class="form-control" id="tenLoaiDL" name="ghichu" placeholder="Nhập ghi chú">
					</div>
				</div>
				<!-- Modal footer -->
				<div class="modal-footer">
					<button type="submit" name="submit" class="btn btn-success">Lưu</button>
					<button type="button" class="btn btn-success" data-dismiss="modal">Thoát</button>
				</div>
			</div>
		</form>
	</div>
	<!-- End Modal -->
	<script src="asset/js/main.js"></script>
	<script type="text/javascript">
		$(document).ready(function() {
			$('#myTable').DataTable();
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