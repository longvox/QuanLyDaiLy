<!DOCTYPE html>
<html>

<head>
	<meta charset="ISO-8859-1">
	<meta content="text/html; charset=utf-8" http-equiv="Content-Type">
	<title>Danh Mục Phiếu Thu</title>
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
				<div class="col-md-3">
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
										<label for="tendaily">Tên Đại Lý: </label>
										<input class="form-control" value="<?php echo $assoc['TenDL'] ?>" disabled />
										<label for="tienno">Tiền Nợ: </label>
										<input class="form-control" value="<?php echo $assoc['TienNo'] ?>" disabled />
									<?php
                                    } ?>
								</div>
								<div class="form-group">
									<label for="ngayTN">Ngày Lập Phiếu: </label>
									<input type="date" id="ngaytn" name="ngayLapPhieu" disabled value="<?php echo date("Y-m-d"); ?>">
								</div>

								<div class="form-group">
									<label for="tienThuAddPT">Tiền Thu: </label>
									<input type="number" id="tienThuAddPT" name="tienThuAddPT" required>
								</div>
								<button name="submitAddPT" class="btn btn-primary form-control" type="submit">Tạo Phiếu</button>
							</form>
						</div>
					</div>
				</div>
				<div class="col-md-9">
					<div class="panel panel-info">
						<div class="panel-heading">
							<h3 class="panel-title">Danh Sách Phiếu Thu</h3>
						</div>
						<div class="panel-body">
							<div class="row">
								<div class="col-md-12 col-lg-12 col-xs-12 col-sm-12">
									<table width="500" id="myTable" class="table table-striped table-bordered">
										<thead>
											<tr>
												<th width="40">Mã Phiếu</th>
												<th width="120">Đại Lý</th>
												<th width="70">Ngày Thu Tiền</th>
												<th width="70">Số Tiền Thu</th>
												<th width="30">Chi Tiết</th>
												<th width="30">Sửa</th>
												<th width="30">Xóa</th>
											</tr>
										</thead>
										<tbody>
											<?php
                                            if (!empty($data)) {
                                                foreach ($data as $value) {
                                                    $id = $value['MaPT'];
                                                    $idDL = $value['MaDL'];
                                                    $ten = $value['TenDL'];
                                                    $ngay = date_create($value['NgayThuTien']);
                                                    $dt = $value['DienThoai'];
                                                    $dc = $value['DiaChi'];
                                                    $tien = $value['SoTienThu'];
                                                    $nocu = $value['TienNo'] + $tien; ?>
													<tr>
														<td><?php echo $id ?></td>
														<td><?php echo $ten ?></td>
														<td><?php echo date_format($ngay, 'H:i:s d/m/Y') ?></td>
														<td><?php echo $tien ?></td>
														<td><a data-toggle="modal" data-target="#chitiet<?php echo $id; ?>">Chi Tiết</a></td>
														<td><a class="glyphicon glyphicon-plus" data-toggle="modal" href="#edit<?php echo $id; ?>">Sửa</a></td>
														<td><a class="glyphicon glyphicon-trash" data-toggle="modal" data-target="#delete<?php echo $id; ?>">Xóa</a></td>
														<div id="chitiet<?php echo $id; ?>" class="modal fade" id="chitiet" role="dialog" style="width:50%;margin: 0 auto">
															<form action="<?php $_SERVER['PHP_SELF'] ?>" method="post" class="modal-dialog">
																<div id="chitiet" class="modal-content">
																	<div class="modal-header">
																		<button type="button" class="close" data-dismiss="modal">&times;</button>
																		<h4 class="modal-title">Chi Tiết Phiếu Thu</h4>
																	</div>
																	<!-- Modal content -->
																	<div class="modal-body" style="font-size:120%">
																		<div class="row">
																			<div class="col-md-6">
																				<label style="font-weight: bold;">Mã đại lý: </label>
																				<?php echo $idDL ?>
																			</div>
																			<div class="row">
																				<div class="col-md-12">
																					<div class="col-md-6">
																						<label style="font-weight: bold;">Tên đại lý: </label>
																						<?php echo $value['TenDL']; ?>
																					</div>

																					<div class="col-md-6">
																						<label style="font-weight: bold;">Số điện thoại: </label>
																						<?php echo $value['DienThoai'] ?>
																					</div>
																				</div>
																			</div>
																			<div class="row">
																				<div class="col-md-12">
																					<div class="col-md-6 ">
																						<label style="font-weight: bold;">Địa chỉ: </label>
																						<?php echo $value['DiaChi'] ?>
																					</div>

																					<div class="col-md-6 ">
																						<label style="font-weight: bold;">Ngày Thu Tiền: </label>
																						<?php echo $value['NgayThuTien']; ?>
																					</div>
																				</div>
																			</div>
																			<div class="row">
																				<div class="col-md-12">
																					<div class="col-md-6 ">
																						<label style="font-weight: bold;">Tiền Nợ Cũ: </label>
																						<?php echo $nocu ?>
																					</div>

																					<div class="col-md-6 ">
																						<label style="font-weight: bold;">Tiền Nợ Sau Khi Thu: </label>
																						<?php echo $value['TienNo']; ?>
																					</div>
																				</div>
																			</div>
																			<div class="row">
																				<div class="col-md-12">
																				</div>
																			</div>
																			<button style="margin-left: 230px;" type="button" class="btn btn-success" data-dismiss="modal">Thoát</button>
																		</div>
																	</div>

																</div>
															</form>
														</div>
														<div class="modal fade" id="edit<?php echo $id; ?>" role="dialog">
															<form action="<?php $_SERVER['PHP_SELF'] ?>" method="post" class="modal-dialog">
																<div id="ModalEdit" class="modal-content" style="width:30%; margin-left:700px; margin-top:100px">
																	<div class="form-group">
																		<input type="hidden" name="idEdit" value="<?php echo $id; ?>">
																		<input type="hidden" name="idEditMaDL" value="<?php echo $idDL; ?>">
																		<label for="tienthuEdit" class="form-control">Số tiền thu: </label>
																		<input class="form-control" autofocus type="text" name="tienthuEdit" required />
																		<input class="form-control btn btn-success" type="submit" name="submitEdit" value="Lưu" /><br>
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
																			<input type="hidden" name="idDeleteMaDL" value="<?php echo $idDL; ?>">
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
					[0, "desc"]
				],
				scrollX: true,
				scrollY: 400,
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