<?php
//=======  : Alibaba
define('validSession', 1);
if (!file_exists('config.php')) {
    exit();
}
require_once( 'config.php' );
require_once('./class/c_user.php');
session_name("alibaba");
session_start();
require_once('./function/fungsi_menu.php');
require_once('./function/getUserPrivilege.php');
require_once('./function/pagedresults.php');
require_once('./function/secureParam.php');
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Admin</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="stylesheet" href="font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="dist/css/AdminLTE.css">
    <link rel="stylesheet" href="dist/css/skins/skin-blue-light.css">
    <link rel="stylesheet" href="plugins/iCheck/all.css">
    <link rel="stylesheet" href="plugins/morris/morris.css">
    <link rel="stylesheet" href="plugins/jvectormap/jquery-jvectormap-1.2.2.css">
    <link rel="stylesheet" href="plugins/datepicker/datepicker3.css">
    <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker.css">
    <link rel="stylesheet" href="plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
    <link rel="stylesheet" href="plugins/select2/select2.min.css">
    <link rel="stylesheet" href="plugins/colorpicker/bootstrap-colorpicker.min.css">
    <link rel="stylesheet" href="css/searchInput1.css">
    <link rel="icon" href="dist/img/logo-qoobah.png" type="image/png"/>
    <link rel="stylesheet" href="dist/css/bootstrap.min.css"> 
    <link rel="stylesheet" href="plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
    <link rel="stylesheet" href="plugins/toastr/toastr.min.css">

</head>
<?php
if ((isset($_SESSION["my"]) === false) || (isset($_GET["page"]) === "login_detail")) {
    echo '<body class="hold-transition login-page">';
} else {
    ?>
    <body class="hold-transition skin-blue-light sidebar-mini fixed">
        <?php
    }
    ?>
    <div class="wrapper">
        <header class="main-header">
            <?php
            if ((isset($_SESSION["my"]) !== false) && (isset($_GET["page"]) !== "login_detail")) {
                ?>
                <a href="index.php" class="logo">
                    
                </a>
                <nav class="navbar navbar-static-top">
                    <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                        <span class="sr-only">Toggle navigation</span>
                        <span style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif;">Admin</span>
                    </a>
                    <div class="navbar-custom-menu">
                        <ul class="nav navbar-nav">
                            <li>
                                <a href="logout.php?page=login_detail&eventCode=20">Logout&nbsp;&nbsp;<i class="fa fa-sign-out" aria-hidden="true" title="Logout"></i></a>
                            </li>
                        </ul>
                    </div>
                <?php
                }
                ?>
                </nav>
        </header>
    <?php
    if (isset($_SESSION["my"]) == false || isset($_GET["page"]) === "login_detail") {
        require_once('login_detail.php' );
    } else {
        $t = isset($_SESSION["my"]->timeout);
        if((time() - $_SESSION["my"]->timeout) > 18000) { 
            $result=mysql_query("UPDATE `aki_user` SET `ip`='0' where kodeUser='".$_SESSION["my"]->id."'" , $dbLink);
            $_SESSION["my"] = false;
            unset($_SESSION['my']);
            require_once('login_detail.php' );
            exit;
        }
        ?>   
        <aside class="main-sidebar">
            <section class="sidebar">
                <div class="user-panel">
                    <div class="pull-left image">
                        <?php echo '<img src="dist/img/sikubah.png" class="img-rounded" alt="User Image">'; ?>
                    </div>
                    <div class="pull-left info">
                        <p style="font-size: 17px;"><?php echo $_SESSION["my"]->name; ?></p>
                        <a href="#"><i class="fa fa-circle text-success"></i> <?php echo $_SESSION["my"]->privilege; ?></a>
                    </div>
                </div>
                <ul class="sidebar-menu">
                    <li class="treeview">
                        <?php echo menu(); ?>
                    </li>
                </ul>
            </section>
        </aside>
        <div class="content-wrapper">
            <?php
            if (isset($_GET["page"])) {
                require_once('view/' . substr($_GET["page"] . ".php", 5, strlen($_GET["page"] . '.php') - 5));
            } else {
                require_once('view/dashboard.php');
            }
            ?>
        </div>
        <?php
    }
    ?>
    <?php
    if (isset($_SESSION["my"]) != false && isset($_GET["page"]) != "login_detail") {
        ?>
        <footer class="main-footer">
            <div class="pull-right hidden-xs">
                <b>Admin </b> 2.0.0 &nbsp;&nbsp;<strong>Created by: <a href="http://instagram.com/baihaqial">alibaba</a>.
                </div>
                <strong>.</strong>
        </footer>
    <?php
    }
    ?>
    </div>
    <script src="plugins/jQuery/jquery-2.2.3.min.js"></script>
    <script src="dist/js/jquery-ui.min.js"></script>
    <script src="plugins/select2/select2.full.min.js"></script>
    <script src="dist/js/raphael-min.js"></script>
    <script src="plugins/sparkline/jquery.sparkline.min.js"></script>
    <script src="plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
    <script src="plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
    <script src="plugins/knob/jquery.knob.js"></script>
    <script src="dist/js/moment.min.js"></script>
    <script src="plugins/daterangepicker/daterangepicker.js"></script>
    <script src="plugins/datepicker/bootstrap-datepicker.js"></script>
    <script src="plugins/datepicker/locales/bootstrap-datepicker.id.js"></script>
    <script src="plugins/iCheck/icheck.min.js"></script>
    <script src="plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
    <script src="plugins/slimScroll/jquery.slimscroll.min.js"></script>
    <script src="plugins/fastclick/fastclick.js"></script>
    <script src="plugins/morris/morris.min.js"></script>
    <script src="dist/js/app.min.js"></script>
    <script src="dist/js/demo.js"></script>
    <script src="plugins/input-mask/jquery.inputmask.js"></script>
    <script src="plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
    <script src="plugins/input-mask/jquery.inputmask.extensions.js"></script>
    <script src="plugins/colorpicker/bootstrap-colorpicker.min.js"></script>
    <script src="plugins/sweetalert2/sweetalert2.min.js"></script>
    <script src="plugins/toastr/toastr.min.js"></script>
</body>
</html>
