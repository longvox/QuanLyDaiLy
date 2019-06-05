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
        <div class="row">
        <div class="col-md-4">
					<div class="panel panel-info">
						<div class="panel-heading">
							<h3 class="panel-title">Thông Tin Đại Lý</h3>
						</div>
						<div class="panel-body" style="font-size:120%;">
								<div class="form-group">
									<?php
                                    if (!empty($assoc)) {
                                        ?>
										<label style="font-weight:bold" for="daily">Mã Đại Lý: </label>
										<?php echo $assoc['MaDL'] ?><br>
										<label style="font-weight:bold" for="daily">Tên Đại Lý: </label>
										<?php echo $assoc['TenDL'] ?><br>
										<label style="font-weight:bold" for="daily">Tiền Nợ Cũ: </label>
                                        <?php echo $nocu ?><br>
                                        <label style="font-weight:bold" for="daily">Tiền Nợ Sau Khi Lập Phiếu: </label>
										<?php echo $assoc['TienNo'] ?>
									<?php
                                    } ?>
								</div>
						</div>
                    </div>
                    <a class="btn btn-success" href="index.php?controller=phieu-da-xuat">Back</a>
				</div>
            <div class="col-md-8">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title">Mặt Hàng Có Trong Phiếu</h3>
                    </div>
                    <div class="panel-body">
                        <table width="200" id="myTable" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>Mặt Hàng</th>
                                    <th>Số Lượng</th>
                                    <th>Giá</th>
                                    <th>Thành Tiền</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
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
                                        </tr>
                                    <?php
                                    }
                                } ?>
                            </tbody>
                        </table>
                        <div class="row">
                            <div class="col-md-8">
                                <h3>Tổng Tiền: <?php if (isset($tongtien)) {
                                    echo number_format($tongtien) . " VNĐ";
                                } ?></h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
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