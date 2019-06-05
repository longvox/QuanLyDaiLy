<!DOCTYPE html>
<html>

<head>
	<meta charset="ISO-8859-1">
	<meta content="text/html; charset=utf-8" http-equiv="Content-Type">
	<title>Danh Sách Đại Lý</title>
	<link rel="shortcut icon" href="asset/img/logomi.png">
	<?php
    require 'cdn.php';
    ?>
</head>

<body>
	<div class="container-fluid mimin-wrapper">
		<div class="content">
			<!-- Start Danh sach dai ly -->
			<div class="col-md-12 top-20 padding-0">
				<div class="col-md-12">
					<div class="panel">
						<div class="panel-heading">
							<div class=row>
								<div class="col-md-10">
									<h3>Danh Sách Đại Lý</h3>
								</div>
								<div class="col-md-2">
									<button class="btn ripple btn-3d btn-success" data-toggle="modal" data-target="#modalThemDL" style="margin-top: 10px">
										<div>
											<span>Thêm Đại Lý</span>
										</div>
									</button>
								</div>
							</div>
						</div>
						<div class="panel-body">
							<table width="1000" id="myTable" class="table table-striped table-bordered">
								<thead>
									<tr>
										<th width="120">Tên ĐL</th>
										<th width="55">Loại ĐL</th>
										<th width="55">Quận</th>
										<th width="100">Tiền Nợ</th>
										<th width="40">Chi Tiết</th>
										<th width="60">Lập Phiếu Xuất</th>
										<th width="60">Lập Phiếu Thu</th>
										<th width="40">Edit</th>
										<th width="40">Delete</th>
									</tr>
								</thead>
								<tbody>
									<?php
                                    if (!empty($data)) {
                                        foreach ($data as $value) {
                                            $id = $value['MaDL'];
                                            $ten = $value['TenDL'];
                                            $duocphep = $value['TienNoToiDa'];
                                            $date = date_create($value['NgayTiepNhan']); ?>
											<tr>
												<td><?php echo $value['TenDL'] ?></td>
												<td><?php echo $value['TenLoaiDL'] ?></td>
												<td><?php echo $value['TenQuan'] ?></td>
												<td><?php echo number_format($value['TienNo']) . " VNĐ"; ?></td>
												<td><a data-toggle="modal" data-target="#chitiet<?php echo $id; ?>">Chi Tiết</a></td>
												<td><a href="index.php?controller=phieu-xuat&id=<?php echo $id ?>">Lập Phiếu</a></td>
												<td><a href="index.php?controller=phieu-thu&id=<?php echo $id ?>">Lập Phiếu</a></td>

												<td><a class="glyphicon glyphicon-edit" data-toggle="modal" data-target="#edit<?php echo $id; ?>">Sửa</a></td>
												<td><a class="glyphicon glyphicon-trash" data-toggle="modal" data-target="#delete<?php echo $id; ?>">Xóa</a></td>
												<div id="chitiet<?php echo $id; ?>" class="modal fade" id="chitiet" role="dialog" style="width:50%;margin: 0 auto">
													<form action="<?php $_SERVER['PHP_SELF'] ?>" method="post" class="modal-dialog">
														<div id="chitiet" class="modal-content">
															<div class="modal-header">
																<button type="button" class="close" data-dismiss="modal">&times;</button>
																<h4 class="modal-title">Chi Tiết Đại Lý</h4>
															</div>
															<!-- Modal content -->
															<div class="modal-body" style="font-size:120%">
																<div class="row">
																		<div class="col-md-6">
																			<label style="font-weight: bold;">Mã đại lý: </label>
																			<?php echo $id ?>
																		</div>
																		<div class="col-md-6">
																			<label style="font-weight: bold;">Được phép nợ: </label>
																			<?php echo number_format($duocphep)." VNĐ"; ?>
																		</div>
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
																			<label style="font-weight: bold;">Ngày Tiếp Nhận: </label>
																			<?php echo $value['NgayTiepNhan']; ?>
																		</div>
																	</div>
																</div>
																<div class="row">
																	<div class="col-md-12">
																		<div class=" col-md-6 ">
																			<label style="font-weight: bold;">Loại: </label>
																			<?php
                                                                            echo $value['TenLoaiDL']; ?>
																		</div>

																		<div class="col-md-6 ">
																			<label style="font-weight: bold;">Quận: </label>
																				<?php echo $value['TenQuan'] ?>
																		</div>
																	</div>
																</div>
																<button style="margin-left: 230px;" type="button" class="btn btn-success" data-dismiss="modal">Thoát</button>
															</div>
														</div>

												</div>
												</form>
								</div>
								<div id="edit<?php echo $id; ?>" class="modal fade" id="modalSuaDL" role="dialog" style="width:50%;margin: 0 auto">
									<form action="<?php $_SERVER['PHP_SELF'] ?>" method="post" class="modal-dialog editForm">
										<div id="ModalSua" class="modal-content">
											<div class="modal-header">
												<button type="button" class="close" data-dismiss="modal">&times;</button>
												<h4 class="modal-title">Sửa Đại Lý</h4>
											</div>
											<!-- Modal content -->
											<div class="modal-body">
												<input type="hidden" id="ma" name="maDL2" value="<?php echo $id; ?>" readonly="readonly" required>
												<div class="row">
													<div class="col-md-12">
														<div class="col-md-6">
															<label>Tên đại lý: </label>
															<div class="col-sm-10">
																<input autofocus type="text" id="ten" name="tenDL2" value="<?php echo $value['TenDL']; ?>" required>
															</div>
														</div>

														<div class="col-md-6">
															<label>Số điện thoại: </label>
															<div class="col-sm-10">
																<input type="number" value="<?php echo $value['DienThoai'] ?>" name="sdt2" required>
															</div>
														</div>
													</div>

													<div class="col-md-12">
														<div class="col-md-6 ">
															<label>Địa chỉ: </label>
															<div class="col-sm-10">
																<input type="text" id="diachi" name="diaChi2" value="<?php echo $value['DiaChi'] ?>" required>
															</div>
														</div>

														<div class="col-md-6 ">
															<label>Ngày Tiếp Nhận: </label>
															<div class="col-sm-10">
																<input type="date" id="ngaytn" name="ngayTN2" disabled value="<?php echo date("Y-m-d"); ?>"><br>
															</div>
														</div>
													</div>
													<div class="col-md-12">
														<div class=" col-md-6 ">
															<label>Loại: </label><br>
															<div class="col-sm-10">
																<?php
                                                                if (!empty($data2)) {
                                                                    echo "<div class='col-sm-5 padding-0'><input type='radio' name='loai2' value='{$value['MaLoaiDL']}' checked>{$value['TenLoaiDL']}</input></div>";
                                                                    foreach ($data2 as $value2) {
                                                                        if ($value2['MaLoaiDL'] != $value['MaLoaiDL']) {
                                                                            echo "<div class='col-sm-5 padding-0'><input type='radio' name='loai2' value='{$value2['MaLoaiDL']}'>{$value2['TenLoaiDL']}</input></div>";
                                                                        }
                                                                    }
                                                                } ?>
															</div>
														</div>

														<div class="col-md-6 ">
															<label>Quận: </label><br>
															<div class="col-sm-10">
																<div class="col-sm-6 padding-0">
																	<select name="quan2">
																		<?php

                                                                        if (!empty($dt)) {
                                                                            foreach ($dt as $value) {
                                                                                ?>
																				<option value="<?php echo $value['MaQuan']; ?>"><?php echo $value['TenQuan'] ?></option>
																			<?php
                                                                            }
                                                                        } ?>
																	</select>
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>

											<!-- Modal footer -->
											<div class="modal-footer" style="margin-right:35%">
												<button type="submit" name="submit2" class="btn btn-success">Cập Nhật</button>
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
													<input type="hidden" name="maDL3" value="<?php echo $id; ?>">
													<div class="alert alert-danger">Bạn có chắc muốn xóa đại lý: <strong>
															<?php echo $ten; ?>?</strong> </div>
													<div class="modal-footer">
														<button type="submit" name="submit3" class="btn btn-danger"><span class="glyphicon glyphicon-trash"></span> YES</button>
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
	<!-- End danh sach -->

	<!-- Start Modal -->
	<div class="modal fade" id="modalThemDL" role="dialog">
		<form id="addForm" action="<?php $_SERVER['PHP_SELF'] ?>" method="post" class="modal-dialog">
			<div id="ModalThem" class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Thêm Đại Lý</h4>
				</div>
				<!-- Modal content -->
				<div class="modal-body">
					<div class="row">
						<div class="col-md-12">
							<div class="col-md-6">
								<label>Tên Đại Lý: </label>
								<div class="col-sm-10">
									<input autofocus type="text" name="tenDL" required>
								</div>
							</div>

							<div class="col-md-6">
								<label>Số Điện Thoại: </label>
								<div class="col-sm-10">
									<input type="number" name="sdt">
								</div>
							</div>
						</div>

						<div class="col-md-12">
							<div class="col-md-6 ">
								<label>Địa chỉ: </label>
								<div class="col-sm-10">
									<input type="text" name="diaChi" required>
								</div>
							</div>

							<div class="col-md-6 ">
								<label>Ngày tiếp nhận: </label>
								<div class="col-sm-10">
									<input type="date" id="ngaytn" name="ngayTN" disabled value="<?php echo date("Y-m-d"); ?>">
								</div>
							</div>
						</div>
						<div class="col-md-12">
							<div class=" col-md-6 ">
								<label>Loại: </label><br>
								<div class="col-sm-10">
									<?php
                                    if (!empty($data2)) {
                                        foreach ($data2 as $value) {
                                            echo "<div class='col-sm-5 padding-0'><input type='radio' name='loai' value='{$value['MaLoaiDL']}'>{$value['TenLoaiDL']}</input></div>";
                                        }
                                    }
                                    ?>
								</div>
							</div>
							<div class="col-md-6 ">
								<label>Quận: </label><br>
								<div class="col-sm-10">
									<div class="col-sm-6 padding-0">
										<select name="quan">
											<?php
                                            if (!empty($dt)) {
                                                foreach ($dt as $value) {
                                                    ?>
													<option value="<?php echo $value['MaQuan']; ?>"><?php echo $value['TenQuan'] ?></option>
												<?php
                                                }
                                            } ?>
										</select>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>

				<!-- Modal footer -->
				<div class="modal-footer" style="margin-right:35%">
					<button type="submit" name="submit" class="btn btn-success">Lưu</button>
					<button type="button" class="btn btn-success" data-dismiss="modal">Thoát</button>
				</div>

			</div>
		</form>
	</div>
	<!-- End Modal -->
	<!-- Start Modal -->

	<!-- End Modal -->
	</div>

	<!-- custom -->
	<script src="asset/js/main.js"></script>
</body>

</html>