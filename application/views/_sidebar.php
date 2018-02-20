<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<link rel="icon" href="<?php echo base_url()?>assets/img/logo.png" type="image/x-icon">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	
	<title>ADMIN PANEL</title>

	<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
	<meta name="viewport" content="width=device-width" />
	
	
    	<!-- Bootstrap core CSS     -->
    	<link href="<?php echo base_url()?>assets/css/bootstrap.min.css" rel="stylesheet" />

    	<!-- Animation library for notifications   -->
    	<link href="<?php echo base_url()?>assets/css/animate.min.css" rel="stylesheet"/>

    	<!--  Light Bootstrap Table core CSS    -->
    	<link href="<?php echo base_url()?>assets/css/light-bootstrap-dashboard.css?v=1.4.0" rel="stylesheet"/>

    	<!--  CSS for Demo Purpose  -->
    	<link href="<?php echo base_url()?>assets/css/demo.css" rel="stylesheet" />

    	<!--     Fonts and icons     -->
    	<link href="http://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
    	<link href='http://fonts.googleapis.com/css?family=Roboto:400,700,300' rel='stylesheet' type='text/css'>
    	<link href="<?php echo base_url()?>assets/css/pe-icon-7-stroke.css" rel="stylesheet" />
	
	<!--   Core JS Files   -->
    	<script src="<?php echo base_url()?>assets/js/jquery.3.2.1.min.js" type="text/javascript"></script>
	<script src="<?php echo base_url()?>assets/js/bootstrap.min.js" type="text/javascript"></script>

	<!--  Charts Plugin -->
	<script src="<?php echo base_url()?>assets/js/chartist.min.js"></script>

    	<!--  Notifications Plugin    -->
    	<script src="<?php echo base_url()?>assets/js/bootstrap-notify.js"></script>

    	<!-- Light Bootstrap Table Core javascript and methods for Demo purpose -->
	<script src="<?php echo base_url()?>assets/js/light-bootstrap-dashboard.js?v=1.4.0"></script>

	<!-- Light Bootstrap Table DEMO methods -->
	<script src="<?php echo base_url()?>assets/js/demo.js"></script>
	
	<!-- DataTable -->
	<link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet" />
	<link href="https://cdn.datatables.net/buttons/1.5.0/css/buttons.dataTables.min.css" rel="stylesheet" />
	<link href="https://cdn.datatables.net/select/1.2.4/css/select.dataTables.min.css" rel="stylesheet" />
	<link href="https://editor.datatables.net/extensions/Editor/css/editor.dataTables.min.css" rel="stylesheet" />
	
	<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js" type="text/javascript"></script>
	<script src="https://cdn.datatables.net/buttons/1.5.0/js/dataTables.buttons.min.js" type="text/javascript"></script>
	<script src="https://cdn.datatables.net/select/1.2.4/js/dataTables.select.min.js" type="text/javascript"></script>
	
	<script src="<?php echo base_url()?>assets/js/dataTables.editor.js" type="text/javascript"></script>
	
	<!-- Modal -->
	<link rel="stylesheet" href="https://unpkg.com/animate.css@3.5.2/animate.css" type="text/css" />
	
	<script type="text/javascript" src="https://unpkg.com/rmodal@1.0.26/dist/rmodal.js"></script>
	
	<!-- Form Validation Plugin -->
	<script src="<?php echo base_url()?>assets/plugins/jquery-validation/dist/jquery.validate.min.js"></script>
	
</head>
<body>

<div class="wrapper">
    <div class="sidebar" data-color="purple" data-image="<?php echo base_url()?>assets/img/sidebar-5.jpg">

    	<div class="sidebar-wrapper">
            <div class="logo">
                <a href="<?php echo base_url();?>" class="simple-text">
                    Site Name
                </a>
            </div>

            <ul class="nav">
                <li <?php echo ($menu=='goal') ? 'class="active"' : ''; ?>>
                    <a href="<?php echo base_url();?>index.php/admin/goalView">
                        <i class="pe-7s-graph"></i>
                        <p>Goals</p>
                    </a>
                </li>
                
                <li <?php echo ($menu=='course') ? 'class="active"' : ''; ?>>
                    <a href="<?php echo base_url();?>index.php/admin/courseView">
                        <i class="pe-7s-note2"></i>
                        <p>Courses</p>
                    </a>
                </li>
                <li <?php echo ($menu=='module') ? 'class="active"' : ''; ?>>
                    <a href="<?php echo base_url();?>index.php/admin/moduleView">
                        <i class="pe-7s-news-paper"></i>
                        <p>Modules</p>
                    </a>
                </li>
		<li <?php echo ($menu=='user') ? 'class="active"' : ''; ?>>
                    <a href="<?php echo base_url();?>index.php/admin/userView">
                        <i class="pe-7s-users"></i>
                        <p>Users</p>
                    </a>
                </li>
		<li <?php echo ($menu=='admin') ? 'class="active"' : ''; ?>>
                    <a href="<?php echo base_url();?>index.php/admin/adminView">
                        <i class="pe-7s-user"></i>
                        <p>Admin Profile</p>
                    </a>
                </li>
            </ul>
    	</div>
    </div>

    <div class="main-panel">
		<nav class="navbar navbar-default navbar-fixed">
            <div class="container-fluid">
                <div class="navbar-header">
			<button type="button" class="navbar-toggle" data-toggle="collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="<?php echo base_url();?>index.php/docs/" target="_blank">API DOCS</a>
                </div>
                <div class="collapse navbar-collapse">
                    <ul class="nav navbar-nav navbar-right">
                        <li>
                            <a href="<?php echo base_url();?>index.php/admin/signOut">
                                <p>Log out</p>
                            </a>
                        </li>
			<li class="separator hidden-lg hidden-md"></li>
                    </ul>
                </div>
            </div>
        </nav>
        
        <div class="content">
            <div class="container-fluid">
                <div class="row">