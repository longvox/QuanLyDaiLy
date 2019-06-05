<!DOCTYPE html>
<html>

<head>
	<meta charset="ISO-8859-1">
	<meta content="text/html; charset=utf-8" http-equiv="Content-Type">
	<title>Danh Sách Đơn Vị Tính</title>
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
									<h3>Danh Sách Đơn Vị Tính</h3>
								</div>
								<div class="col-md-5">
									<button class="btn ripple btn-3d btn-success" data-toggle="modal" data-target="#modalThemDV" style="margin-top: 10px">
										<div>
											<span>Thêm Đơn Vị</span>
										</div>
									</button>
								</div>
							</div>
						</div>
						<div class="panel-body">

							<table id="myTable" class="table table-striped table-bordered">
								<thead>
									<tr>
										<th>Mã Đơn Vị</th>
										<th>Giá Trị</th>
										<th>Sửa</th>
										<th>Xóa</th>
									</tr>
								</thead>
								<tbody>
									<?php
                                    if (!empty($data)) {
                                        foreach ($data as $value) {
                                            $id = $value['MaDonVi'];
                                            $tenDV = $value['TenDonVi']
                                            ?>
											<tr>
												<td><?php echo $id; ?></td>
												<td><?php echo $tenDV; ?></td>
												<td><a class="glyphicon glyphicon-edit" data-toggle="modal" data-target="#edit<?php echo $id; ?>">Sửa</a></td>
												<td><a class="glyphicon glyphicon-trash" data-toggle="modal" data-target="#delete<?php echo $id; ?>">Xóa</a></td>
												<div class="modal fade" id="edit<?php echo $id; ?>" role="dialog">
													<form id="editForm" method="post" class="modal-dialog">
														<div id="ModalThem" class="modal-content" style="width:20%; margin: 0 auto">
															<div class="modal-header">
																<button type="button" class="close" data-dismiss="modal">&times;</button>
																<h4 class="modal-title">Sửa Đơn Vị</h4>
															</div>
															<!-- Modal content -->
															<div class="modal-body">
																<input type="hidden" name="idEdit" value="<?php echo $id ?>" />
																<div class="form-group">
																	<label for="tenDVEdit">Tên đơn vị</label>
																	<input autofocus type="text" class="form-control" id="tenDVEdit" name="tenDVEdit" value="<?php echo $tenDV; ?>" required />
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
																	<div class="alert alert-danger">Bạn có chắc muốn xóa đơn vị: <strong>
																			<?php echo $tenDV; ?>?</strong> </div>
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
	<div class="modal fade" id="modalThemDV" role="dialog">
		<form id="themForm" method="post" class="modal-dialog">
			<div id="ModalThem" class="modal-content" style="width:50%; margin: 0 auto">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Thêm Đơn Vị</h4>
				</div>
				<!-- Modal content -->
				<div class="modal-body">
					<div class="form-group">
						<label for="tenDV">Tên đơn vị</label>
						<input autofocus type="text" class="form-control" id="tenDV" name="tenDV" placeholder="Nhập giá trị"><br>
					</div>
				</div>
				<!-- Modal footer -->
				<div class="modal-footer">
					<button id="submit" type="submit" name="submit" class="btn btn-success">Lưu</button>
					<button type="button" class="btn btn-success" data-dismiss="modal">Thoát</button>
				</div>
			</div>
		</form>
	</div>
	<!-- End Modal -->
</body>

</html>