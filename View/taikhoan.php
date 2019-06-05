<!DOCTYPE html>
<html>

<head>
	<meta charset="ISO-8859-1">
	<meta content="text/html; charset=utf-8" http-equiv="Content-Type">
	<title>Quản Lý Tài Khoản</title>
	<link rel="shortcut icon" href="asset/img/logomi.png">
	<?php
    require 'cdn.php';
    ?>
</head>

<body>
	<div class="container-fluid mimin-wrapper">
		<form action="<?php $_SERVER['PHP_SELF'] ?>" id="formTaoTK" method="post">
			<!-- Modal content -->
			<div class="row">
				<div class="col-md-3">
					<div class="panel panel-info">
						<div class="panel-heading">
							<h3 class="panel-title">Thêm Tài Khoản</h3>
						</div>
						<div class="panel-body">
							<form method="post" id="formTaoTK">
								<div class="form-group">
									<?php

                                    ?>
									<div class="form-group">
										<label for="taikhoan">Tài Khoản: </label><br>
										<input type="text" id="taikhoan" name="taikhoan" class="form-control" autofocus /><br>
										<label for="taikhoan">Mật Khẩu: </label><br>
										<input type="password" id="matkhau" name="matkhau" class="form-control" /><br>
										<label for="taikhoan">Tên Hiển Thị: </label><br>
										<input type="text" id="tenhienthi" name="tenhienthi" class="form-control" /><br>
									</div>
									<label for="daily">Loại Tài Khoản: </label>
									<select id="myOptions" class="form-control" name="loaitk">
										<?php
                                        if (!empty($data2)) {
                                            foreach ($data2 as $value) {
                                                ?>
												<option value="<?php echo $value['MaLoaiUser'] ?>"><?php echo $value['TenLoaiUser'] ?></option>
											<?php
                                            }
                                        }
                                    ?>
									</select>
								</div>
								<button name="submit" class="btn btn-primary form-control" type="submit">Xác Nhận</button>
							</form>
						</div>
					</div>
				</div>
				<div class="col-md-9">
					<div class="panel panel-info">
						<div class="panel-heading">
							<h3 class="panel-title">Danh Sách Tài Khoản</h3>
						</div>
						<div class="panel-body">
							<div class="row">
								<div class="col-md-12 col-lg-12 col-xs-12 col-sm-12">
									<table id="myTable" class="table table-striped table-bordered">
										<thead>
											<tr>
												<th>Tài Khoản</th>
												<th>Mật Khẩu</th>
												<th>Tên Hiển Thị</th>
												<th>Loại Tài Khoản</th>
												<th>Sửa</th>
												<th>Xóa</th>
												<th>Reset</th>
											</tr>
										</thead>
										<tbody>
											<?php
                                            $query = "select t.*, l.TenLoaiUser from taikhoan t, loaiuser l where t.MaLoaiUser = l.MaLoaiUser and t.DeleteFlag =0";
                                            $data = $db->execute($query);
                                            if (!empty($getAll)) {
                                                foreach ($getAll as $value) {
                                                    $taikhoan = $value['taikhoan'];
                                                    $tenhienthi = $value['tenhienthi'];
                                                    $loaitk = $value['tenloaitk'];
                                                    if (isset($value['matkhau'])) {
                                                        $matkhau = $value['matkhau'];
                                                    } else {
                                                        $matkhau = "";
                                                    } ?>
													<tr>
														<td><?php echo $taikhoan ?></td>
														<td><?php if (isset($matkhau)) {
                                                        echo $matkhau;
                                                    } ?></td>
														<td><?php echo $tenhienthi ?></td>
														<td><?php echo $loaitk ?></td>
														<td><a class="glyphicon glyphicon-plus" data-toggle="modal" data-target="#edit<?php echo $taikhoan; ?>">Sửa</a></td>
														<td><a class="glyphicon glyphicon-trash" data-toggle="modal" data-target="#delete<?php echo $taikhoan; ?>">Xóa</a></td>
														<td><a data-toggle="modal" data-target="#reset<?php echo $taikhoan; ?>">Reset</a></td>
														<div id="edit<?php echo $taikhoan; ?>" class="modal fade" role="dialog">
															<form method="post" id="formTaoTK">
																<div id="ModalThem" class="modal-content" style="width:30%; margin: 0 auto">
																	<div class="modal-header">
																		<button type="button" class="close" data-dismiss="modal">&times;</button>
																		<h4 class="modal-title">Đổi Thông Tin Tài Khoản</h4>
																	</div>
																	<!-- Modal content -->
																	<div class="modal-body">
																		<input type="hidden" name="idEdit" value="<?php echo $taikhoan; ?>">
																		<label for="taikhoan">Tài Khoản: </label><br>
																		<input type="text" id="taikhoanEdit" name="taikhoanEdit" class="form-control" autofocus value="<?php echo $taikhoan ?>" /><br>
																		<label for="taikhoan">Mật Khẩu: </label><br>
																		<input type="password" id="matkhauEdit" name="matkhauEdit" class="form-control" /><br>
																		<label for="taikhoan">Tên Hiển Thị: </label><br>
																		<input type="text" id="tenhienthiEdit" name="tenhienthiEdit" class="form-control" value="<?php echo $tenhienthi ?>" /><br>
																		<label for="daily">Loại Tài Khoản: </label>
																		<select id="myOptions" class="form-control" name="loaitkEdit">
																			<?php
                                                                            if (!empty($data2)) {
                                                                                foreach ($data2 as $value) {
                                                                                    ?>
																					<option value="<?php echo $value['MaLoaiUser'] ?>"><?php echo $value['TenLoaiUser'] ?></option>
																				<?php
                                                                                }
                                                                            } ?>
																		</select>
																	</div>
																	<!-- Modal footer -->
																	<div class="modal-footer">
																		<button type="submit" name="submitEdit" class="btn btn-success">Lưu</button>
																		<button type="button" class="btn btn-success" data-dismiss="modal">Thoát</button>
																	</div>
																</div>

														</div>
				</form>
			</div>
			<div id="delete<?php echo $taikhoan; ?>" class="modal fade" role="dialog">
				<div class="modal-dialog">
					<form method="post">
						<!-- Modal content-->
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal">&times;</button>
								<h4 class="modal-title">Delete</h4>
							</div>
							<div class="modal-body">
								<input type="hidden" name="idDelete" value="<?php echo $taikhoan; ?>">
								<div class="alert alert-danger">Bạn có chắc muốn xóa tài khoản: <strong>
										<?php echo $taikhoan; ?>?</strong> </div>
								<div class="modal-footer">
									<button type="submit" name="submitDelete" class="btn btn-danger"><span class="glyphicon glyphicon-trash"></span> YES</button>
									<button type="button" class="btn btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-remove-circle"></span> NO</button>
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
			<div id="reset<?php echo $taikhoan; ?>" class="modal fade" role="dialog">
				<div class="modal-dialog">
					<form method="post">
						<!-- Modal content-->
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal">&times;</button>
								<h4 class="modal-title">Reset</h4>
							</div>
							<div class="modal-body">
								<input type="hidden" name="idReset" value="<?php echo $taikhoan; ?>">
								<div class="alert alert-danger">Bạn có chắc muốn reset mật khẩu cho tài khoản: <strong>
										<?php echo $taikhoan; ?>?</strong> </div>
								<div class="modal-footer">
									<button type="submit" name="submitReset" class="btn btn-danger"><span class="glyphicon glyphicon-trash"></span> YES</button>
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

</body>

</html>