<!DOCTYPE html>
<html>

<head>
	<meta charset="ISO-8859-1">
	<meta content="text/html; charset=utf-8" http-equiv="Content-Type">
	<title>Danh Sách Mặt Hàng</title>
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
									<h3>Danh Sách Mặt Hàng</h3>
								</div>
								<div class="col-md-2">
									<button class="btn ripple btn-3d btn-success" data-toggle="modal" data-target="#modalThemDL" style="margin-top: 10px">
										<div>
											<span>Thêm Mặt Hàng</span>
										</div>
									</button>
								</div>
							</div>
						</div>
						<div class="panel-body">

							<table id="myTable" class="table table-striped table-bordered">
								<thead>
									<tr>
										<th width="55">Mã MH</th>
										<th width="120">Tên MH</th>
										<th width="55">Đơn Vị</th>
										<th width="155">Ảnh MH</th>
										<th width="120">Giá</th>
										<th width="40">Sửa</th>
										<th width="40">Xóa</th>
									</tr>
								</thead>
								<tbody>
									<?php
                                    if (!empty($data)) {
                                        foreach ($data   as $value) {
                                            $id = $value['MaMH'];
                                            $ten = $value['TenMH'];
                                            $img = $value['AnhMH'];
                                            $gia = $value['Gia']; ?>
											<tr>
												<td><?php echo $id ?></td>
												<td><?php echo $ten ?></td>
												<td><?php echo $value['TenDonVi'] ?></td>
												<td><img style="witdh: 150px; height: 150px;" src="<?php echo $img ?>"></img></td>
												<td><?php echo number_format($gia) . " VNĐ" ?></td>
												<td><a class="glyphicon glyphicon-edit" data-toggle="modal" data-target="#edit<?php echo $id; ?>">Sửa</a></td>
												<td><a class="glyphicon glyphicon-trash" data-toggle="modal" data-target="#delete<?php echo $id; ?>">Xóa</a></td>
												<div class="modal fade" id="edit<?php echo $id; ?>" role="dialog" style="width:50%; margin:0 auto">
													<form id="editForm" method="post" enctype="multipart/form-data" class="modal-dialog">
														<div id="ModalThem" class="modal-content">
															<div class="modal-header">
																<button type="button" class="close" data-dismiss="modal">&times;</button>
																<h4 class="modal-title">Sửa Mặt Hàng</h4>
															</div>
															<!-- Modal content -->
															<div class="modal-body">
																<div class="row">
																	<div class="col-md-12">
																		<input type="hidden" name="maMH2" value="<?php echo $id; ?>" />
																		<input type="hidden" name="current" value="<?php echo $ten; ?>" />
																		<div class="col-md-6 form-group">
																			<label class="col-sm-2 control-label text-right">Tên mặt hàng: </label>
																			<div class="col-sm-10" style="padding-bottom: 10px">
																				<input type="text" id="tenMH2" name="tenMH2" required value="<?php echo $ten ?>">
																			</div>
																		</div>

																		<div class="col-md-6 form-group">
																			<label class="col-sm-2 control-label text-right">Ảnh mặt hàng: </label>
																			<div class="col-sm-10" style="padding-bottom: 10px">
																				<input class="form-control" type="file" name="anhMH2">
																			</div>
																		</div>
																	</div>

																	<div class="col-md-12">
																		<div class="col-md-6 ">
																			<label class="col-sm-2 control-label text-right">Đơn vị: </label>
																			<div class="col-sm-10" style="padding-bottom: 10px">
																				<div class="col-sm-6 padding-0">
																					<select name="donvi2">
																						<?php
                                                                                        foreach ($data2 as $value) {
                                                                                            ?>
																							<option value="<?php echo $value['MaDonVi']; ?>"><?php echo $value['TenDonVi'] ?></option>
																						<?php
                                                                                        } ?>
																					</select>
																				</div>
																			</div>
																		</div>

																		<div class="col-md-6 ">
																			<label class="col-sm-2 control-label text-right">Giá: </label>
																			<div class="col-sm-10" style="padding-bottom: 10px">
																				<input type="text" name="gia2" value="<?php echo $gia ?>" required>
																			</div>
																		</div>
																	</div>
																</div>
															</div>

															<!-- Modal footer -->
															<div class="modal-footer" style="margin-right:35%">
																<button type="submit" name="submit2" class="btn btn-success">Lưu</button>
																<button type="button" class="btn btn-success" data-dismiss="modal">Thoát</button>
															</div>

														</div>
													</form>
												</div>
												<!-- End Modal -->
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
																	<input type="hidden" name="maMHDeLete" value="<?php echo $id; ?>">
																	<div class="alert alert-danger">Bạn có chắc muốn xóa mặt hàng này không: <strong>
																			<?php echo $ten; ?>?</strong> </div>
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
	<!-- End danh sach -->

	<!-- Start Modal -->
	<div class="modal fade" id="modalThemDL" role="dialog">
		<form id="addDLForm" method="post" enctype="multipart/form-data" class="modal-dialog">
			<div id="ModalThem" class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Thêm Mặt Hàng</h4>
				</div>
				<!-- Modal content -->
				<div class="modal-body">
					<div class="row">
						<div class="col-md-12">
							<div class="col-md-6 form-group">
								<label class="col-sm-2 control-label text-right">Tên mặt hàng: </label>
								<div class="col-sm-10" style="padding-bottom: 10px">
									<input type="text" name="tenMH" required>
								</div>
							</div>

							<div class="col-md-6 form-group">
								<label class="col-sm-2 control-label text-right">Ảnh mặt hàng: </label>
								<div class="col-sm-10" style="padding-bottom: 10px">
									<input class="form-control" type="file" name="anh">
								</div>
							</div>
						</div>

						<div class="col-md-12">
							<div class="col-md-6 ">
								<label class="col-sm-2 control-label text-right">Đơn vị: </label>
								<div class="col-sm-10" style="padding-bottom: 10px">
									<div class="col-sm-6 padding-0">
										<select name="donvi" id="donVi">
											<?php
                                            $table = "donvi";
                                            $data = $db->getAllData($table);
                                            foreach ($data as $value) {
                                                ?>
												<option value="<?php echo $value['MaDonVi']; ?>"><?php echo $value['TenDonVi'] ?></option>
											<?php
                                            }
                                        ?>
										</select>
									</div>
								</div>
							</div>

							<div class="col-md-6 ">
								<label class="col-sm-2 control-label text-right">Giá: </label>
								<div class="col-sm-10" style="padding-bottom: 10px">
									<input type="number" name="gia" required>
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
	</div>

	<!-- custom -->
	<script src="asset/js/main.js"></script>

</body>

</html>