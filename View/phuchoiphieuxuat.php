<!DOCTYPE html>
<html>

<head>
    <meta charset="ISO-8859-1">
    <meta content="text/html; charset=utf-8" http-equiv="Content-Type">
    <title>Danh Sách Phiếu Xuất</title>
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
                                    <h3>Danh Sách Phiếu Xuất</h3>
                                </div>
                            </div>
                        </div>
                        <div class="panel-body">

                            <table width="900" id="myTable" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th width="40">Mã Phiếu</th>
                                        <th width="120">Đại Lý</th>
                                        <th width="80">Ngày Lập Phiếu</th>
                                        <th width="70">Tổng Tiền</th>
                                        <th width="70">Tiền Trả</th>
                                        <th width="70">Còn Lại</th>
                                        <th>Ngày Xóa</th>
                                        <th>Recovery</th>
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
                                            $iddl = $value['MaDL'];
                                            $date2 = date_create($value['deleteTime']); ?>
                                            <tr>
                                                <td><?php echo $id ?></td>
                                                <td><?php echo $ten ?></td>
                                                <td><?php echo date_format($ngay, 'H:i:s d/m/Y') ?></td>
                                                <td><?php echo number_format($tong) . ' VNĐ' ?></td>
                                                <td><?php echo number_format($tra) . ' VNĐ' ?></td>
                                                <td><?php echo number_format($con) . ' VNĐ' ?></td>
                                                <td><?php echo date_format($date2, 'H:i:s d/m/Y') ?></td>
                                                <td><a class="glyphicon glyphicon-trash" data-toggle="modal" data-target="#delete<?php echo $id; ?>">Recovery</a></td>

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
                                                                    <div class="alert alert-danger">Bạn có chắc muốn phục hồi phiếu xuất: <strong>
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