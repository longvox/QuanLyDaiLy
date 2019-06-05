<!DOCTYPE html>
<html>

<head>
    <meta charset="ISO-8859-1">
    <meta content="text/html; charset=utf-8*" http-equiv="Content-Type">
    <meta name="google-site-verification" content="yu3oCBVUB1G-6exmipMba-wkQOoSecHx9Bx7p2spoLo" />
    <title>Quản Lý Đại Lý</title>
    <link rel="stylesheet" type="text/css" href="asset/css/plugins/font-awesome.min.css" />
    <link rel="stylesheet" type="text/css" href="asset/css/simple-sidebar.css" />
    <link rel="stylesheet" type="text/css" href="asset/css/css.css" />
    <!-- plugins -->
    <link rel="stylesheet" type="text/css" href="asset/css/plugins/font-awesome.min.css" />
    <link rel="stylesheet" type="text/css" href="asset/css/plugins/animate.min.css" />
    <link href="asset/css/style.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="asset/css/bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" href="asset/css/plugins/font-awesome.min.css" />
    <link rel="stylesheet" type="text/css" href="asset/css/plugins/datatables.bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" href="asset/css/plugins/animate.min.css" />
    <link href="asset/css/style.css" rel="stylesheet">
    <link href="//cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css" rel="stylesheet">
    <link rel="manifest" href="appmanifest.json" />
    <link rel="apple-touch-icon" sizes="48x48" href="favicon.png">
    <link rel="manifest" href="/manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">
    <script src="asset/js/jquery.min.js"></script>
    <script src="asset/js/jquery.ui.min.js"></script>
    <script src="asset/js/bootstrap.min.js"></script>
    <script src="asset/js/plugins/jquery.datatables.min.js"></script>
    <!-- plugins -->
    <script src="asset/js/plugins/moment.min.js"></script>
    <script src="asset/js/plugins/jquery.nicescroll.js"></script>
    <!-- custom -->
    <script src="asset/js/validate.js"></script>
    <script src="asset/js/main.js"></script>
    <style type="text/css">
    </style>
</head>

<body>
    <?php
    require 'Model/DBquanlydaily.php';
    $db = new database();
    $db->connect();
    ?>
    <nav class="navbar navbar-default header navbar-fixed-top">
        <div class="col-md-12 nav-wrapper">
            <div class="navbar-header" style="width: 100%;">
                <div class="opener-left-menu is-open">
                    <span class="top"></span> <span class="middle"></span> <span class="bottom"></span>
                </div>
                <a href="mainpage.php" class="navbar-brand"> <b>Home</b>
                </a>
                <ul class="nav navbar-nav navbar-right user-nav">
                    <li class="user-name"><span><?php if (isset($_COOKIE['username'])) {
        echo $_COOKIE['username'];
    } else {
        header('location:login.php');
    } ?></span></li>
                    <li><img src="asset/img/avatar.jpg" class="img-circle avatar" alt="user name" data-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="true" />
                    <li><a href="logout.php"><span class="fa fa-sign-out "></span></a></li>


                </ul>
            </div>
        </div>
    </nav>
    <!-- end: Header -->

    <div class="container-fluid mimin-wrapper">

        <!-- start:Left Menu -->
        <div id="left-menu">
            <div class="sub-left-menu scroll">
                <ul class="nav nav-list">
                    <li>
                        <div class="left-bg"><a class="add-button"
                                style="color:white; margin:50px; padding-top:150px;">Cài Đặt Ứng Dụng</a></div>
                    </li>
                    <li class="active ripple"><a class="tree-toggle nav-header"><span class="fa-home fa"></span>Đại
                            Lý<span class="fa-angle-right fa right-arrow text-right"></span> </a>
                        <ul class="nav nav-list tree">
                            <li><a class="ajax active" data-href="index.php?controller=dai-ly">Danh Mục Đại Lý</a></li>
                            <li><a class="ajax" data-href="index.php?controller=loai-dai-ly">DM Loại Đại Lý - Quận</a>
                            </li>
                        </ul>
                    </li>
                    <li class="active ripple"><a class="tree-toggle nav-header"><span class="fa-home fa"></span>Mặt
                            Hàng<span class="fa-angle-right fa right-arrow text-right"></span> </a>
                        <ul class="nav nav-list tree">
                            <li><a class="ajax" data-href="index.php?controller=mat-hang">Danh Mục Mặt Hàng</a></li>
                            <li><a class="ajax" data-href="index.php?controller=don-vi">Danh Mục Đơn Vị Tính</a></li>
                        </ul>
                    </li>
                    <li class="active ripple"><a class="tree-toggle nav-header"><span
                                class="fa-home fa"></span>Phiếu<span
                                class="fa-angle-right fa right-arrow text-right"></span> </a>
                        <ul class="nav nav-list tree">
                            <li><a class="ajax" data-href="index.php?controller=phieu-da-xuat">Danh Mục Phiếu Đã
                                    Xuất</a></li>
                            <li><a class="ajax" data-href="index.php?controller=phieu-thu-da-lap">Danh Mục Phiếu Thu Đã
                                    Tạo</a></li>
                        </ul>
                    </li>
                    <li class="ripple"><a class="tree-toggle nav-header"> <span class="fa-diamond fa"></span> Báo
                            Cáo<span class="fa-angle-right fa right-arrow text-right"></span>
                        </a>
                        <ul class="nav nav-list tree">
                            <li><a class="ajax" data-href="index.php?controller=bao-cao-doanh-so">Báo Cáo Doanh Số</a>
                            </li>
                            <li><a class="ajax" data-href="index.php?controller=bao-cao-cong-no">Báo Cáo Công Nợ</a>
                            </li>
                        </ul>
                    </li>
                    <li class="active ripple"><a class="tree-toggle nav-header"><span class="fa-home fa"></span>Phục Hồi
                            Dữ Liệu<span class="fa-angle-right fa right-arrow text-right"></span> </a>
                        <ul class="nav nav-list tree">
                            <li><a class="ajax" data-href="index.php?controller=ph-dai-ly">Phục Hồi Đại Lý</a></li>
                            <li><a class="ajax" data-href="index.php?controller=ph-mat-hang">Phục Hồi Mặt Hàng</a></li>
                            <li><a class="ajax" data-href="index.php?controller=ph-phieu-xuat">Phục Hồi Phiếu Xuất</a>
                            </li>
                            <li><a class="ajax" data-href="index.php?controller=ph-phieu-thu">Phục Hồi Phiếu Thu</a>
                            </li>
                        </ul>
                    </li>
                    <li class="active ripple"><a class="tree-toggle nav-header"><span class="fa-home fa"></span>Tài
                            Khoản<span class="fa-angle-right fa right-arrow text-right"></span> </a>
                        <ul class="nav nav-list tree">
                            <li><a class="ajax" data-href="index.php?controller=tai-khoan">Quản Lý Tài Khoản</a></li>
                            <li><a class="ajax" data-href="index.php?controller=lich-su">Lịch Sử Đăng Nhập</a></li>
                            <li><a class="ajax" data-href="index.php?controller=loai-tai-khoan">Quản Lý Loại Tài
                                    Khoản</a></li>
                        </ul>
                    </li>
                    <li class="ripple"><a class="ajax" data-href="index.php?controller=qui-dinh"><span
                                class="fa fa-book"></span>Qui Định</a></li>
                </ul>
            </div>
        </div>
        <div id="right-content">
            <iframe style="width:100%; height: 89vh; border: none;"></iframe>
        </div>
    </div>
    <script>
    $(document).ready(function() {
        $(".ajax").click(function() {
            var href = $(this)[0].getAttribute("data-href");
            document.querySelector("#right-content iframe").src = href;
        });
        setTimeout(function() {
            $(".ajax.active").click();
        }, 50);
    });
    </script>
    <script src="asset/js/main.js"></script>
    <script type="text/javascript">
    let deferredPrompt;
    const addBtn = document.querySelector('.add-button');
    addBtn.style.display = 'none';

    window.addEventListener('beforeinstallprompt', (e) => {
        // Prevent Chrome 67 and earlier from automatically showing the prompt
        e.preventDefault();
        // Stash the event so it can be triggered later.
        deferredPrompt = e;
        // Update UI to notify the user they can add to home screen
        addBtn.style.display = 'inline';

        addBtn.addEventListener('click', (e) => {
            // hide our user interface that shows our A2HS button
            addBtn.style.display = 'none';
            // Show the prompt
            deferredPrompt.prompt();
            // Wait for the user to respond to the prompt
            deferredPrompt.userChoice.then((choiceResult) => {
                if (choiceResult.outcome === 'accepted') {
                    console.log('User accepted the A2HS prompt');
                } else {
                    console.log('User dismissed the A2HS prompt');
                }
                deferredPrompt = null;
            });
        });
    });

    $(document).ready(function() {
        $('#datatables-example').DataTable();
    });
    if ("serviceWorker" in navigator) {
        if (navigator.serviceWorker.controller) {
            console.log("[PWA Builder] active service worker found, no need to register");
        } else {
            // Register the service worker
            navigator.serviceWorker
                .register("sw.js", {
                    scope: "./"
                })
                .then(function(reg) {
                    console.log("[PWA Builder] Service worker has been registered for scope: " + reg.scope);
                });
        }
    }
    self.addEventListener('activate', function() {
        console.log('SW Activated');
    });

    self.addEventListener('fetch', function(event) {
        event.respondWith(
            caches.match(event.request)
            .then(function(res) {
                if (res) {
                    return res;
                } else {
                    return fetch(event.request);
                }
            })
        );
    });
    </script>
</body>

</html>