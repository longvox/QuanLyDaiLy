<!DOCTYPE html>
<html>

<head>
	<meta charset="ISO-8859-1">
	<meta content="text/html; charset=utf-8" http-equiv="Content-Type">
	<title>Danh Sách Loại Đại Lý - Quận</title>
	<link rel="shortcut icon" href="asset/img/logomi.png">
	<?php
    require 'cdn.php';
    ?>
</head>

<body>
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-6">
				<div class="content">
					<!-- Start Danh sach loai dai ly -->
					<div class="panel">
						<div class="panel-heading">
							<div class=row>
								<div class="col-md-7">
									<h3>Danh Sách Loại Đại Lý</h3>
								</div>
								<div class="col-md-5">
									<button class="btn ripple btn-3d btn-success" data-toggle="modal" data-target="#modalThemDL" style="margin-top: 10px">
										<div>
											<span>Thêm Loại Đại Lý</span>
										</div>
									</button>
								</div>
							</div>
						</div>
						<div class="panel-body">

							<table id="myTable" class="table table-striped table-bordered">
								<thead>
									<tr>
										<th>Mã Loại ĐL</th>
										<th>Tên Loại ĐL</th>
										<th>Được Phép Nợ</th>
										<th>Sửa</th>
										<th>Xóa</th>
									</tr>
								</thead>
								<tbody>
									<?php
                                    if (!empty($data)) {
                                        foreach ($data as $value) {
                                            $idLoaiDL = $value['MaLoaiDL'];
                                            $tenLoai = $value['TenLoaiDL'];
                                            $duocphep = $value['TienNoToiDa']; ?>
											<tr>
												<td><?php echo $idLoaiDL; ?></td>
												<td><?php echo $tenLoai; ?></td>
												<td><?php echo $duocphep; ?></td>
												<td><a class="glyphicon glyphicon-edit" data-toggle="modal" data-target="#editLoaiDL<?php echo $idLoaiDL; ?>">Sửa</a></td>
												<td><a class="glyphicon glyphicon-trash" data-toggle="modal" data-target="#deleteLoai<?php echo $idLoaiDL; ?>">Xóa</a></td>
												<div class="modal fade" id="editLoaiDL<?php echo $idLoaiDL; ?>" role="dialog">
													<form action="<?php $_SERVER['PHP_SELF'] ?>" method="post" class="modal-dialog">
														<div id="ModalThem" class="modal-content" style="width:30%;margin-left:100px">
															<div class="modal-header">
																<button type="button" class="close" data-dismiss="modal">&times;</button>
																<h4 class="modal-title">Sửa Loại Đại Lý</h4>
															</div>
															<!-- Modal content -->
															<div class="modal-body">
																<input type="hidden" name="idLoaiDL" value="<?php echo $idLoaiDL ?>" />
																<input type="hidden" name="idtenLoaiDL" value="<?php echo $tenLoai ?>" />
																<div class="form-group">
																	<label for="tenLoaiDL">Tên loại đại lý</label>
																	<input type="text" autofocus class="form-control" id="tenLoaiDL" name="tenLoaiDL2" value="<?php echo $tenLoai; ?>" />
																	<label for="tenLoaiDL">Tiền nợ tối đa</label>
																	<input type="number" required autofocus class="form-control" id="duocPhep2" name="duocPhep2" value="<?php echo $duocphep; ?>" />
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
												<div id="deleteLoai<?php echo $idLoaiDL; ?>" class="modal fade" role="dialog">
													<div class="modal-dialog">
														<form method="post">
															<!-- Modal content-->
															<div class="modal-content">
																<div class="modal-header">
																	<button type="button" class="close" data-dismiss="modal">&times;</button>
																	<h4 class="modal-title">Delete</h4>
																</div>
																<div class="modal-body">
																	<input type="hidden" name="maDLDeLete" value="<?php echo $idLoaiDL; ?>">
																	<div class="alert alert-danger">Bạn có chắc muốn xóa loại đại lý: <strong>
																			<?php echo $tenLoai; ?>?</strong> </div>
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
			<!-- End danh sach -->

			<!-- Start Modal -->
			<div class="modal fade" id="modalThemDL" role="dialog">
				<form id="loaiDLForm" action="<?php $_SERVER['PHP_SELF'] ?>" method="post" class="modal-dialog">
					<div id="ModalThem" class="modal-content" style="width:50%;">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal">&times;</button>
							<h4 class="modal-title">Thêm Loại Đại Lý</h4>
						</div>
						<!-- Modal content -->
						<div class="modal-body">
							<div class="form-group">
								<label for="tenLoaiDL">Tên loại đại lý</label>
								<input autofocus type="text" class="form-control" id="tenLoaiDL" name="tenLoaiDL" placeholder="Nhập tên loại dl">
								<label for="tenLoaiDL">Tiền nợ tối đa</label>
								<input type="number" required autofocus class="form-control" id="duocPhep" name="duocPhep" placeholder="Nhập tiền nợ tối đa" />
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
			<div class="col-md-6">
				<div class="content">
					<!-- Start Danh sach loai dai ly -->
					<div class="panel">
						<div class="panel-heading">
							<div class=row>
								<div class="col-md-7">
									<h3>Danh Sách Quận</h3>
								</div>
								<div class="col-md-5">
									<button class="btn ripple btn-3d btn-success" data-toggle="modal" data-target="#modalThemQuan" style="margin-top: 10px">
										<div>
											<span>Thêm Quận</span>
										</div>
									</button>
								</div>
							</div>
						</div>
						<div class="panel-body">

							<table id="myTable2" class="table table-striped table-bordered">
								<thead>
									<tr>
										<th>Mã Quận</th>
										<th>Tên Quận</th>
										<th>Sửa</th>
										<th>Xóa</th>
									</tr>
								</thead>
								<tbody>
									<?php
                                    if (!empty($data2)) {
                                        foreach ($data2 as $value) {
                                            $idQuan = $value['MaQuan'];
                                            $ten = $value['TenQuan']; ?>
											<tr>
												<td><?php echo $value['MaQuan']; ?></td>
												<td><?php echo $value['TenQuan']; ?></td>
												<td><a class="glyphicon glyphicon-edit" data-toggle="modal" data-target="#editQuan<?php echo $idQuan; ?>">Sửa</a></td>
												<td><a class="glyphicon glyphicon-trash" data-toggle="modal" data-target="#deleteQuan<?php echo $idQuan; ?>">Xóa</a></td>
												<div class="modal fade" id="editQuan<?php echo $idQuan; ?>" role="dialog">
													<form action="<?php $_SERVER['PHP_SELF'] ?>" method="post" class="modal-dialog">
														<div id="editQuan" class="modal-content" style="width:30%;margin-left:650px">
															<div class="modal-header">
																<button type="button" class="close" data-dismiss="modal">&times;</button>
																<h4 class="modal-title">Sửa Quận</h4>
															</div>
															<!-- Modal content -->

															<div class="modal-body">
																<input type="hidden" name="idQuan" value="<?php echo $idQuan; ?>">
																<div class="form-group">
																	<label for="tenQuan">Tên quận</label>
																	<input type="text" autofocus class="form-control" id="tenQuan2" name="tenQuan2" value="<?php echo $ten; ?>">
																</div>
															</div>
															<!-- Modal footer -->
															<div class="modal-footer">
																<button type="submit" name="submitEditQuan" class="btn btn-success">Lưu</button>
																<button type="button" class="btn btn-success" data-dismiss="modal">Thoát</button>
															</div>
														</div>
													</form>
												</div>
												<div id="deleteQuan<?php echo $idQuan; ?>" class="modal fade" role="dialog">
													<div class="modal-dialog">
														<form method="post">
															<!-- Modal content-->
															<div class="modal-content">
																<div class="modal-header">
																	<button type="button" class="close" data-dismiss="modal">&times;</button>
																	<h4 class="modal-title">Delete</h4>
																</div>
																<div class="modal-body">
																	<input type="hidden" name="maDLDeLeteQuan" value="<?php echo $idQuan; ?>">
																	<div class="alert alert-danger">Bạn có chắc muốn xóa quận: <strong>
																			<?php echo $ten; ?>?</strong> </div>
																	<div class="modal-footer">
																		<button type="submit" name="submitDeleteQuan" class="btn btn-danger"><span class="glyphicon glyphicon-trash"></span> YES</button>
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
			<!-- End danh sach -->

			<!-- Start Modal -->
			<div class="modal fade" id="modalThemQuan" role="dialog">
				<form id="quanForm" action="<?php $_SERVER['PHP_SELF'] ?>" method="post" class="modal-dialog">
					<div id="ModalThem" class="modal-content" style="width:50%; margin-left:450px;">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal">&times;</button>
							<h4 class="modal-title">Thêm Quận</h4>
						</div>
						<!-- Modal content -->
						<div class="modal-body">
							<div class="form-group">
								<label for="tenQuan">Tên quận</label>
								<input autofocus type="text" class="form-control" id="tenQuan" name="tenQuan" placeholder="Nhập tên quận">
							</div>
						</div>
						<!-- Modal footer -->
						<div class="modal-footer">
							<button type="submit" name="submit2" class="btn btn-success">Lưu</button>
							<button type="button" class="btn btn-success" data-dismiss="modal">Thoát</button>
						</div>
					</div>
				</form>
			</div>
			<!-- End Modal -->
		</div>
	</div>
	</div>
	<!-- custom -->
</body>

</html>