<!DOCTYPE html>
<html>

<head>
    <meta charset="ISO-8859-1">
    <meta content="text/html; charset=utf-8" http-equiv="Content-Type">
    <title>Danh Sách Phiếu Thu</title>
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
                                <div class="col-md-12">
                                    <h3>Danh Sách Phiếu Thu</h3>
                                </div>
                            </div>
                        </div>
                        <div class="panel-body">

                            <table width="900" id="myTable" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th width="40">Mã Phiếu</th>
                                        <th width="120">Đại Lý</th>
                                        <th width="70">Ngày Thu Tiền</th>
                                        <th width="70">Số Tiền Thu</th>
                                        <th width="30">Chi Tiết</th>
                                        <th>Ngày Xóa</th>
                                        <th>Recovery</th>
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
                                            $nocu = $value['TienNo'] + $tien;
                                            $date2 = date_create($value['deleteTime']); ?>
                                            <tr>
                                                <td><?php echo $id ?></td>
                                                <td><?php echo $ten ?></td>
                                                <td><?php echo date_format($ngay, 'H:i:s d/m/Y') ?></td>
                                                <td><?php echo $tien ?></td>
                                                <td><a data-toggle="modal" data-target="#chitiet<?php echo $id; ?>">Chi Tiết</a></td>
                                                <td><?php echo date_format($date2, 'H:i:s d/m/Y') ?></td>
                                                <td><a class="glyphicon glyphicon-trash" data-toggle="modal" data-target="#delete<?php echo $id; ?>">Recovery</a></td>
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
                                                <div id="delete<?php echo $id; ?>" class="modal fade" role="dialog">
                                                    <div class="modal-dialog">
                                                        <form method="post">
                                                            <!-- Modal content-->
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                                    <h4 class="modal-title">Phục Hồi</h4>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <input type="hidden" name="maDL3" value="<?php echo $id; ?>">
                                                                    <input type="hidden" name="maDL2" value="<?php echo $idDL; ?>">
                                                                    <div class="alert alert-danger">Bạn có chắc muốn phục hồi phiếu thu: <strong>
                                                                            <?php echo $id; ?>?</strong> </div>
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
    </div>
    <!-- End danh sach -->
    <script src="asset/js/main.js"></script>
</body>

</html>