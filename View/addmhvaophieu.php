<!DOCTYPE html>
<html>

<head>
	<meta charset="ISO-8859-1">
	<meta content="text/html; charset=utf-8" http-equiv="Content-Type">
	<title>Thêm Mặt Hàng</title>
	<link rel="shortcut icon" href="asset/img/logomi.png">
	<?php
    require 'cdn.php';
    ?>
</head>

<body>
	<div class="container-fluid mimin-wrapper">
		<?php
        if (isset($_GET['id'])) {
            $idGet = $_GET['id'];
        }
        $db = new database();
        $db->connect();
        if (isset($_POST['submitaddMH'])) {
            $maMH = $_POST['checkitem'];
            $sl = $_POST['soLuong'];
            $count = count($maMH);
            $sl_new = [];
            for ($i = 0; $i < count($sl); $i++) {
                if ($sl[$i] != null) {
                    $sl_new[] = $sl[$i];
                }
            }
            for ($i = 0; $i < $count; $i++) {
                $query2 = "select * from ctphieuxuat where MaPX = $idGet and MaMH = '$maMH[$i]'";
                $result = $db->execute($query2);
                $num = mysqli_num_rows($result);
                $assoc = mysqli_fetch_assoc($result);
                $slCu = $assoc['SoLuong'];
                if ($num != 0) {
                    if ($sl_new[$i] + $slCu <= 0) {
                        echo "<script>alert('Số lượng phải lớn hơn 0!');</script>";
                    } elseif ($sl_new[$i] + $slCu == 0) {
                        $array = array(
                            "maMH" => $maMH[$i]
                        );
                        $url = "https://0fjxt2m5xk.execute-api.us-east-2.amazonaws.com/dev/deleteCTPhieuXuat/$idGet";
                        $content = json_encode($array);
                        $curl = curl_init($url);
                        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "DELETE");
                        curl_setopt($curl, CURLOPT_POSTFIELDS, $content);
                        curl_exec($curl);
                    } else {
                        $array = array(
                            "sl" => $sl_new[$i],
                            "maMH" => $maMH[$i]
                        );
                        $url = "https://0fjxt2m5xk.execute-api.us-east-2.amazonaws.com/dev/updateCTPhieuXuat/$idGet";
                        $content = json_encode($array);
                        $curl = curl_init($url);
                        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
                        curl_setopt($curl, CURLOPT_POSTFIELDS, $content);
                        curl_exec($curl);
                    }
                } elseif ($num == 0) {
                    if ($sl_new[$i] + $slCu <= 0) {
                        echo "<script>alert('Số lượng phải lớn hơn 0!');</script>";
                    } else {
                        $array = array(
                            "sl" => $sl_new[$i],
                            "maPX" => $idGet,
                            "maMH" => $maMH[$i]
                        );
                        $url = "https://0fjxt2m5xk.execute-api.us-east-2.amazonaws.com/dev/insertCTPhieuXuat";
                        $content = json_encode($array);
                        $curl = curl_init($url);
                        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                        curl_setopt($curl, CURLOPT_POSTFIELDS, $content);
                        curl_exec($curl);
                    }
                }
            }
        }
        if (isset($_POST['submitDelete'])) {
            $idDelete = $_POST['idDelete'];
            $array = array(
                "maMH" => $idDelete
            );
            $url = "https://0fjxt2m5xk.execute-api.us-east-2.amazonaws.com/dev/deleteCTPhieuXuat/$idGet";
            $content = json_encode($array);
            $curl = curl_init($url);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "DELETE");
            curl_setopt($curl, CURLOPT_POSTFIELDS, $content);
            curl_exec($curl);
        }
        if (isset($_POST['submitXuatPhieu'])) {
            $id = $_POST['idPXXuatPhieu'];
            $tra = $_POST['tienTra'];
            $tongtien = $_POST['tongtien'];
            $madl = $_POST['madl'];
            $sql = "select * from daily d, phieuxuat p, loaidaily l where d.MaDL = p.MaDL and d.MaLoaiDL = l.MaLoaiDL and p.MaPX = $id";
            $assoc = mysqli_fetch_assoc($db->execute($sql));
            $sqlQuiDinh = "select * from daily d, loaidaily l where MaDL = '$madl' and d.MaLoaiDL = l.MaLoaiDL;";
            $assocQuiDinh = mysqli_fetch_assoc($db->execute($sqlQuiDinh));
            $query4 = "update phieuxuat set tinhtrang = 1, NgayLapPX = NOW(),TienTra=$tra,TongTien = $tongtien, ConLai = $tongtien - $tra where MaPX=$id";
            $sql3 = "select * from daily where MaDL='$madl'";
            $assocDL = mysqli_fetch_assoc($db->execute($sql3));
            $query5 = "update daily set TienNo = {$assocDL['TienNo']} + $tongtien- $tra where MaDL='$madl'";
            $qd1 = number_format($assocQuiDinh['TienNoToiDa']);
            $no1 = number_format($assocDL['TienNo']);
            if ($tongtien - $tra + $assocDL['TienNo'] > $assocQuiDinh['TienNoToiDa']) {
                echo "<script>alert('Tiền nợ của đại lý này không được vượt quá: $qd1 VNĐ. Nợ hiện tại của đại lý: $no1 VNĐ')</script>";
            } elseif ($tra <= 0) {
                echo "<script>alert('Vui lòng nhập số tiền trả lớn hơn 0!')</script>";
            } else {
                if ($tongtien >= $tra) {
                    $db->execute($query4);
                    $db->execute($query5);
                    header('location:index.php?controller=phieu-da-xuat');
                } else {
                    echo "<script>alert('Tiền trả không được nhiều hơn tổng tiền của phiếu!')</script>";
                }
            }
        }
        ?>
		<!-- Modal content -->
		<div class="row">
			<div class="col-md-6">
				<form id="test" method="post">
					<div class="panel panel-info">
						<div class="panel-heading">
							<h3 class="panel-title">Thêm Mặt Hàng Vào Phiếu</h3>
						</div>
						<div class="panel-body">
							<table width="400" id="myTable2" class="table table-striped table-bordered">
								<thead>
									<tr>
										<th width="25" height="20">Chọn</th>
										<th width="100">Mặt Hàng</th>
										<th width="50">Giá</th>
										<th width="50">Số Lượng</th>
									</tr>
								</thead>
								<tbody>
									<?php
                                    $mh = "select * from mathang where DeleteFlag=0";
                                    $data5 = $db->execute($mh);
                                    if (!empty($data5)) {
                                        foreach ($data5 as $value) {
                                            $idMH = $value['MaMH'];
                                            $tenMH = $value['TenMH'];
                                            $dongia = $value['Gia']; ?>
											<tr>
												<td><input class="form-control checkitem" value="<?php echo $idMH; ?>" onclick="clickitem('checkitem')" type="checkbox" name="checkitem[]" /></td>
												<td><?php echo $tenMH ?></td>
												<td><?php echo number_format($dongia) ?></td>
												<td><input class="form-control soLuong" type="number" id="soLuong" name="soLuong[]" required autofocus></td>
											</tr>
										<?php
                                        }
                                    } ?>
								</tbody>
							</table>
							<button name="submitaddMH" class="btn btn-primary form-control" type="submit">Thêm</button>
						</div>
					</div>
				</form>
			</div>
			<div class="col-md-6">
				<div class="panel panel-info">
					<div class="panel-heading">
						<h3 class="panel-title">Mặt Hàng Đang Có Trong Phiếu</h3>
					</div>
					<div class="panel-body">
						<div class="row">
							<div class="col-md-12 col-lg-12 col-xs-12 col-sm-12">
								<table width="400" id="myTable" class="table table-striped table-bordered">
									<thead>
										<tr>
											<th>Mặt Hàng</th>
											<th>Số Lượng</th>
											<th>Giá</th>
											<th>Thành Tiền</th>
											<th>Xóa</th>
										</tr>
									</thead>
									<tbody>
										<?php
                                        $query = "select c.*, TenMH,m.Gia,c.SoLuong,p.MaDL  from phieuxuat p, ctphieuxuat c, mathang m where p.MaPX = c.MaPX and m.MaMH = c.MaMH and c.MaPX=$idGet";
                                        $data = $db->execute($query);
                                        $tongtien = 0;
                                        if (!empty($data)) {
                                            foreach ($data as $value) {
                                                $idMH = $value['MaMH'];
                                                $tenMH = $value['TenMH'];
                                                $soluong = $value['SoLuong'];
                                                $dongia = $value['Gia'];
                                                $thanhtien = $dongia * $soluong;
                                                $tongtien += $thanhtien;
                                                $maDL = $value['MaDL']; ?>
												<tr>
													<td><?php echo $tenMH ?></td>
													<td><?php echo $soluong ?></td>
													<td><?php echo number_format($dongia) ?></td>
													<td><?php echo number_format($thanhtien) ?></td>
													<td><a class="glyphicon glyphicon-trash" data-toggle="modal" data-target="#delete<?php echo $idMH; ?>">Xóa</a></td>
													<div id="delete<?php echo $idMH; ?>" class="modal fade" role="dialog">
														<div class="modal-dialog">
															<form method="post">
																<!-- Modal content-->
																<div class="modal-content">
																	<div class="modal-header">
																		<button type="button" class="close" data-dismiss="modal">&times;</button>
																		<h4 class="modal-title">Delete</h4>
																	</div>
																	<div class="modal-body">
																		<input type="hidden" name="idDelete" value="<?php echo $idMH; ?>">
																		<div class="alert alert-danger">Bạn có chắc muốn xóa mặt hàng: <strong>
																				<?php echo $tenMH; ?> ra khỏi phiếu?</strong> </div>
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
								<div class="row">
									<div class="col-md-6">
										<h3>Tổng Tiền: <?php if (isset($tongtien)) {
                                            echo number_format($tongtien) . " VNĐ";
                                        } ?></h3>
									</div>
									<div class="col-md-6">
										<div style="margin-left:50px;margin-top: 10px;">
											<?php
                                            $as = mysqli_fetch_assoc($db->execute("select d.MaDL from phieuxuat p, daily d where d.MaDL = p .MaDL and d.DeleteFlag = 0 and p.MaPX = $idGet"))
                                            ?>
											<a class="btn btn-success" href="index.php?controller=phieu-xuat&id=<?php echo $as['MaDL'] ?>">Back</a>
											<a class="glyphicon glyphicon-plus btn btn-primary" id="xuat" data-toggle="modal" data-target="#xuatPhieu<?php echo $idGet; ?>">Xuất</a>
										</div>
										<div class="modal fade" id="xuatPhieu<?php echo $idGet; ?>" role="dialog">
											<form action="<?php $_SERVER['PHP_SELF'] ?>" method="post" class="modal-dialog">
												<div id="ModalThem" class="modal-content" style="width:50%; margin:0 auto">
													<div class="modal-header">
														<button type="button" class="close" data-dismiss="modal">&times;</button>
														<h4 class="modal-title">Xuất Phiếu Thu</h4>
													</div>
													<!-- Modal content -->
													<div class="modal-body">
														<input type="hidden" name="idPXXuatPhieu" value="<?php echo $idGet ?>" />
														<input type="hidden" name="tongtien" value="<?php if (isset($tongtien)) {
                                                echo $tongtien;
                                            } ?>" />
														<input type="hidden" name="madl" value="<?php if (isset($maDL)) {
                                                echo $maDL;
                                            } ?>" />
														<div class="form-group">
															<label for="tienThuAdd">Số Tiền Trả</label>
															<input type="number" Autofocus class="form-control" id="tienTra" name="tienTra" required />
														</div>
													</div>
													<!-- Modal footer -->
													<div class="modal-footer">
														<button type="submit" name="submitXuatPhieu" class="btn btn-success">Xuất</button>
														<button type="button" class="btn btn-success" data-dismiss="modal">Thoát</button>
													</div>
												</div>
											</form>
										</div>
									</div>
								</div>
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
			$('#xuat').css('display', 'none');
			<?php
            $query2 = "select * from ctphieuxuat where MaPX= $idGet";
            $result = $db->execute($query2);
            $num = mysqli_num_rows($result);
            if ($num != 0) {
                echo "$('#xuat').css('display', 'inline');";
            } else {
                echo "$('#xuat').css('display','none');";
            }
            ?>
			var soluongs = document.getElementsByClassName("soLuong");
			for (i = 0; i < soluongs.length; i++) {
				soluongs[i].setAttribute("type", "hidden");
			}
			$('#myTable').DataTable({
				"scrollY": 320,
				paging: false
			});
			$('#myTable2').DataTable({
				"scrollY": 355,
				paging: false
			});
			$("#submitaddMH").click(function() {
				$("#test").submit();
			});
		});

		function clickitem(obj) {
			var checkitems = document.getElementsByClassName(obj);
			var soluongs = document.getElementsByClassName("soLuong");
			for (i = 0; i < checkitems.length; i++) {
				if (checkitems[i].checked == true) {
					soluongs[i].removeAttribute("type", "hidden");
				} else {
					soluongs[i].setAttribute("type", "hidden");
				}
			}
		}
	</script>

</body>

</html>