<meta name="google-site-verification" content="yu3oCBVUB1G-6exmipMba-wkQOoSecHx9Bx7p2spoLo" />
<link rel="shortcut icon" href="asset/img/logomi.png">
<link rel="stylesheet" type="text/css" href="asset/css/plugins/font-awesome.min.css" />
<link rel="stylesheet" type="text/css" href="asset/css/simple-sidebar.css" />
<link rel="stylesheet" type="text/css" href="asset/css/css.css" />
<link rel="stylesheet" type="text/css"
	href="asset/css/plugins/font-awesome.min.css" />
<link rel="stylesheet" type="text/css"
	href="asset/css/plugins/animate.min.css" />
<link href="asset/css/style.css" rel="stylesheet">
<link rel="stylesheet" type="text/css"
	href="asset/css/bootstrap.min.css" />
<link rel="stylesheet" type="text/css"
	href="asset/css/plugins/font-awesome.min.css" />
<link rel="stylesheet" type="text/css"
	href="asset/css/plugins/datatables.bootstrap.min.css" />
<link rel="stylesheet" type="text/css"
	href="asset/css/plugins/animate.min.css" />
<link href="asset/css/style.css" rel="stylesheet">
<link href="//cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css" rel="stylesheet">
<script src="asset/js/jquery.min.js"></script>
<script src="asset/js/jquery.ui.min.js"></script>
<script src="asset/js/bootstrap.min.js"></script>
<script src="asset/js/plugins/jquery.datatables.min.js"></script>
<!-- plugins -->
<script src="asset/js/plugins/moment.min.js"></script>
<script src="asset/js/plugins/jquery.nicescroll.js"></script>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script src="//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<!-- custom -->
<script src="asset/js/validate.js"></script>
<script src="asset/js/validation-add.js"></script>
<?php
if (isset($_SESSION['loaiUser'])) {
    $id = $_SESSION['loaiUser'];
} else {
    header('location: ../login.php');
}
?>