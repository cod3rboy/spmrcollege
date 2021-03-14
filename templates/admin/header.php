<?php
    session_start();
    if(!isset($_SESSION['user'])){
        // If user did not logged in then redirect to login page
        header('Location: index.php');
    }
    // Import Database Connectivity File
    require('../database.php');
    $alumni_records_pending = 0; // stores pending alumni verification records
    $new_grievances = 0; // stores new grievances submitted
    $clgdb = new CollegeDatabase(); // Create College Database Object
    $clgdb->connect(); // Connect to Database
    if($clgdb->isConnected()){
        // Pending Alumni Records Query
        $alumni_pending_query = "SELECT * FROM tbl_alumni WHERE is_verified = 0;";
        // New Grievances Query
        $new_grievances_query = "SELECT * FROM tbl_feedback WHERE is_read = 0";
        $alumni_records_pending = $clgdb->executeSql($alumni_pending_query)->num_rows;
        $new_grievances = $clgdb->executeSql($new_grievances_query)->num_rows;
        $clgdb->disconnect();
    }
?>
<!DOCTYPE html>
<html>
<!--Header-->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Admin Dashboard</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.6 -->
    <link rel="stylesheet" href="../css/bootstrap.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="../css/font-awesome.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../css/admin/AdminLTE.min.css">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="../css/admin/skins/_all-skins.min.css">
    <?php
        // Load LightBox css
        if(isset($load_light_box)){
            if($load_light_box){
                echo "<link rel=\"stylesheet\" href=\"../css/ekko-lightbox.css\">";
            }
        }
    ?>
    <!-- Admin Panel Custom Theme -->
    <link rel="stylesheet" href="../css/admin/AdminTheme.css">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<!--End Header-->
<!--Body-->
<body class="hold-transition skin-blue sidebar-mini">
<!--Wrapper-->
<div class="wrapper">
    <!--main-header contains Text Admin Dash, main-siderbar toggle button and a logout button-->
    <header class="main-header">
        <!-- Logo -->
        <a href="dashboard.php" class="logo">
            <!-- mini logo for sidebar mini 50x50 pixels --><span class="logo-mini"><b><i class="fa fa-user" aria-hidden="true"></i></b></span>
            <!-- logo for regular state and mobile devices --><span class="logo-lg"><b>Admin</b>Dash</span> </a>
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top">
            <!-- Sidebar toggle button-->
            <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button"><span class="sr-only">Toggle navigation</span> </a>
            <!-- Navbar Right Menu -->
            <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">
                    <li><a href="logout.php"><i class="fa fa-sign-out" aria-hidden="hidden"></i> Logout</a></li>
                </ul>
            </div>
        </nav>
    </header>
    <!--End main-header-->
    <!-- main-sidebar Left side column. contains the logo and sidebar -->
    <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
            <!-- Sidebar user panel -->
            <div class="user-panel">
                <div class="pull-left image"> <img src="../images/admin_photo.png" class="img-circle" alt="Admin Image"> </div>
                <div class="pull-left info">
                    <p><?php echo $_SESSION['user']; ?></p> <i class="fa fa-circle text-success"></i> Logged in </div>
            </div>
            <!-- sidebar menu: : style can be found in sidebar.less -->
            <ul class="sidebar-menu">
                <li class="header">MENU</li>
                <li class="treeview">
                    <a href="dashboard.php"> <i class="fa fa-dashboard"></i> <span>Dashboard</span> </a>
                </li>
                <li class="treeview">
                    <a href="notifications.php"> <i class="fa fa-info-circle"></i> <span>Notifications</span> </a>
                </li>
                <li class="treeview">
                    <a href="results.php"> <i class="fa fa-bullhorn"></i> <span>Results</span> </a>
                </li>
                <li class="treeview">
                    <a href="updates.php"> <i class="fa fa-bell"></i> <span>Updates</span> </a>
                </li>
                <li class="treeview">
                    <a href="downloads.php"> <i class="fa fa-download"></i> <span>Downloads</span> </a>
                </li>
                <li class="treeview">
                    <a href="gallery.php"> <i class="fa fa-photo"></i> <span>Gallery</span> </a>
                </li>
                <li class="treeview">
                    <a href="principal.php"> <i class="fa fa-user-circle"></i> <span>Principal Info</span> </a>
                </li>
                <li class="treeview">
                    <a href="admission.php"> <i class="fa fa-user-plus"></i> <span>Admission Link</span> </a>
                </li>
                <li class="treeview">
                    <a href="alumni.php"> <i class="fa fa-graduation-cap"></i> <span>Alumni</span>
                        <?php if($alumni_records_pending) {?>
                        <span class="pull-right-container"><small class="label pull-right bg-blue"><?php echo $alumni_records_pending; ?> Pending</small></span>
                        <?php }?>
                    </a>
                </li>
                <li class="treeview">
                    <a href="committee.php"> <i class="fa fa-address-card"></i> <span>Committee</span> </a>
                </li>
                <li class="treeview">
                    <a href="faculty.php"> <i class="fa fa-users"></i> <span>Faculty</span> </a>
                </li>
                <li class="treeview">
                    <a href="feestructure.php"> <i class="fa fa-money"></i> <span>Fee Structure</span> </a>
                </li>
                <li class="treeview">
                    <a href="grievances.php"> <i class="fa fa-envelope"></i> <span>Grievances</span>
                        <?php if($new_grievances){ ?>
                        <span class="pull-right-container"><small class="label pull-right bg-green"><?php echo $new_grievances; ?> Unread</small></span>
                        <?php }?>
                    </a>
                </li>
                <li class="treeview">
                    <a href="publication.php"> <i class="fa fa-newspaper-o"></i> <span>Publication</span> </a>
                </li>
                <li class="header">ACCOUNT INFORMATION</li>
                <li class="treeview">
                    <a href="account.php"> <i class="fa fa-gear"></i> <span>Account Settings</span> </a>
                </li>
                <li class="treeview">
                    <a href="logs.php"> <i class="fa fa-list-alt"></i> <span>Admin Logs</span> </a>
                </li>
            </ul>
        </section>
        <!-- /.sidebar -->
    </aside>
    <!--End main-sidebar-->
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <!-- Page Title -->
            <h1>
                <?php
                    // Page title is set before including this header file
                    if (isset($page_title)) {echo $page_title;} else {echo "No Title";}
                ?>
            </h1>
            <!--Breadcrumb Hierarchy -->
            <ol class="breadcrumb">
                <li><a href="dashboard.php"><i class="fa fa-dashboard"></i> Home</a></li>
                <li class="active"><?php
                    if (isset($page_title)) {echo $page_title;} else {echo "No Title";} ?>
                </li>
            </ol>
        </section>
