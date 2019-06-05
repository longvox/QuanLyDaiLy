<!DOCTYPE html>
<html>

<head>
	<meta charset="ISO-8859-1">
	<meta content="text/html; charset=utf-8" http-equiv="Content-Type">
	<title>Danh Sách Phiếu Đã Xuất</title>
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
				<div class="col-md-12">
					<div class="panel panel-info">
						<div class="panel-heading">
							<h3 class="panel-title">Danh Sách Phiếu Đã Xuất</h3>
						</div>
						<div class="panel-body">
							<div class="row">
								<div class="col-md-12 col-lg-12 col-xs-12 col-sm-12">
									<table width="1000" id="myTable" class="table table-striped table-bordered">
										<thead>
											<tr>
												<th width="40">Mã Phiếu</th>
												<th width="120">Đại Lý</th>
												<th width="80">Ngày Lập Phiếu</th>
												<th width="70">Tổng Tiền</th>
												<th width="70">Tiền Trả</th>
												<th width="70">Còn Lại</th>
												<th width="30">Chi Tiết</th>
												<th width="30">Tạo Mới</th>
												<th width="25">Sửa</th>
												<th width="25">Xóa</th>
											</tr>
										</thead>
										<tbody>
											<?php

                                            if (!empty($data)) {
                                                foreach ($data as $value) {
                                                    $id = $value['MaPX'];
                                                    $ten = $value['TenDL'];
                                                    $ngay = date_create($value['NgayLapPX']);
                                                    $tong = $value['TongTien'];
                                                    $tra = $value['TienTra'];
                                                    $con = $value['ConLai'];
                                                    $iddl = $value['MaDL']; ?>
													<tr>
														<td><?php echo $id ?></td>
														<td><?php echo $ten ?></td>
														<td><?php echo date_format($ngay, 'H:i:s d/m/Y') ?></td>
														<td><?php echo number_format($tong) . ' VNĐ' ?></td>
														<td><?php echo number_format($tra) . ' VNĐ' ?></td>
														<td><?php echo number_format($con) . ' VNĐ' ?></td>
														<td><a href="index.php?controller=ct-phieu-da-xuat&id=<?php echo $id; ?>">Chi Tiết</a></td>
														<td><a class="glyphicon glyphicon-plus" href="index.php?controller=phieu-xuat&id=<?php echo $iddl; ?>">Tạo</a></td>
														<td><a class="glyphicon glyphicon-plus" data-toggle="modal" data-target="#edit<?php echo $id; ?>">Sửa</a></td>
														<td><a class="glyphicon glyphicon-trash" data-toggle="modal" data-target="#delete<?php echo $id; ?>">Xóa</a></td>
														<div class="modal fade" id="edit<?php echo $id; ?>" role="dialog">
															<form action="<?php $_SERVER['PHP_SELF'] ?>" method="post" class="modal-dialog">
																<div id="ModalEdit" class="modal-content" style="width:30%; margin-left:700px; margin-top:100px">
																	<div class="form-group">
																		<input type="hidden" name="idEdit" value="<?php echo $id; ?>">
																		<input type="hidden" name="iddl" value="<?php echo $iddl; ?>">
																		<label for="tinhtrang" class="form-control">Tình trạng: </label>
																		<input checked="checked" type="radio" name="tinhtrang" value="0" /> Chưa Xuất
																		<input type="radio" name="tinhtrang" value="1" /> Đã Xuất<br>
																		<input class="form-control btn btn-success" type="submit" name="submitEdit" value="Lưu" />
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
		$('#myTable').DataTable({
			"order": [
				[0, "desc"]
			],
			scrollY: 400,
			scrollCollapse: true,
			paging: false
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