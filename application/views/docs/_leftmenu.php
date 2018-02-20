<!doctype html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<meta name="description" content="">
		<meta name="author" content="">
		
		<title>API DOCS</title>
		
		<link href="<?php echo base_url();?>assets/css/bootstrap1.min.css" rel="stylesheet">
		<link href="<?php echo base_url();?>assets/css/dashboard.css" rel="stylesheet">
		<link href="<?php echo base_url();?>assets/css/main.css" rel="stylesheet">
		
		<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
		
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>
	
	</head>
	
	<body>
		
		<header>
			<nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
				<a class="navbar-brand" href="#">[ Back-end API ] Base url : </a>
				<h4 class="text-white"><?php echo base_url();?>index.php/mobile</h4>
			</nav>
		</header>
		
		<div class="container-fluid">
			<div class="row">
				<nav class="col-sm-3 col-md-3 d-none d-sm-block bg-light sidebar">
					<ul class="nav nav-pills flex-column">
						<li class="nav-item">
						  <a class="nav-link <?php echo ($menu=='signIn') ? 'active' : ''; ?>" href="<?php echo base_url();?>index.php/docs/signInView">POST /signIn </a>
						</li>
						<li class="nav-item">
						  <a class="nav-link <?php echo ($menu=='signUp') ? 'active' : ''; ?>" href="<?php echo base_url();?>index.php/docs/signUpView">POST /signUp </a>
						</li>
						<li class="nav-item">
						  <a class="nav-link <?php echo ($menu=='goalList') ? 'active' : ''; ?>" href="<?php echo base_url();?>index.php/docs/goalListView">POST /getGoalList</a>
						</li>
						<li class="nav-item">
						  <a class="nav-link <?php echo ($menu=='courseList') ? 'active' : ''; ?>" href="<?php echo base_url();?>index.php/docs/courseListView">POST /getCourseList</a>
						</li>
						<li class="nav-item">
						  <a class="nav-link <?php echo ($menu=='courseDetail') ? 'active' : ''; ?>" href="<?php echo base_url();?>index.php/docs/courseDetailView">POST /getCourseDetail</a>
						</li>
						<li class="nav-item">
						  <a class="nav-link <?php echo ($menu=='moduleList') ? 'active' : ''; ?>" href="<?php echo base_url();?>index.php/docs/moduleListView">POST /getModuleList</a>
						</li>
						<li class="nav-item">
						  <a class="nav-link <?php echo ($menu=='moduleDetail') ? 'active' : ''; ?>" href="<?php echo base_url();?>index.php/docs/moduleDetailView">POST /getModuleDetail</a>
						</li>
						<li class="nav-item">
						  <a class="nav-link <?php echo ($menu=='setModuleState') ? 'active' : ''; ?>" href="<?php echo base_url();?>index.php/docs/setModuleStateView">POST /setModuleState</a>
						</li>

						<li class="nav-item">
						  <a class="nav-link <?php echo ($menu=='coursePay') ? 'active' : ''; ?>" href="<?php echo base_url();?>index.php/docs/coursePayView">POST /setCoursePay</a>
						</li>
						<li class="nav-item">
						  <a class="nav-link <?php echo ($menu=='userFirstName') ? 'active' : ''; ?>" href="<?php echo base_url();?>index.php/docs/userFirstNameView">POST /setUserFirstName</a>
						</li>
						<li class="nav-item">
						  <a class="nav-link <?php echo ($menu=='userLastName') ? 'active' : ''; ?>" href="<?php echo base_url();?>index.php/docs/userLastNameView">POST /setUserLastName</a>
						</li>
						<li class="nav-item">
						  <a class="nav-link <?php echo ($menu=='userEmail') ? 'active' : ''; ?>" href="<?php echo base_url();?>index.php/docs/userEmailView">POST /setUserEmail</a>
						</li>
						<li class="nav-item">
						  <a class="nav-link <?php echo ($menu=='userPhoto') ? 'active' : ''; ?>" href="<?php echo base_url();?>index.php/docs/userPhotoView">POST /setUserPhoto</a>
						</li>
						<li class="nav-item">
						  <a class="nav-link <?php echo ($menu=='userBanner') ? 'active' : ''; ?>" href="<?php echo base_url();?>index.php/docs/userBannerView">POST /setUserBanner</a>
						</li>
						<li class="nav-item">
						  <a class="nav-link <?php echo ($menu=='userDescription') ? 'active' : ''; ?>" href="<?php echo base_url();?>index.php/docs/userDescriptionView">POST /setUserDescription</a>
						</li>
						
						<!------>
						<li class="nav-item">
						  <a class="nav-link <?php echo ($menu=='addHistory') ? 'active' : ''; ?>" href="<?php echo base_url();?>index.php/docs/addHistoryView">POST /addHistory</a>
						</li>
						<li class="nav-item">
						  <a class="nav-link <?php echo ($menu=='getHistoryList') ? 'active' : ''; ?>" href="<?php echo base_url();?>index.php/docs/getHistoryListView">POST /getHistoryList</a>
						</li>
						<li class="nav-item">
						  <a class="nav-link <?php echo ($menu=='addGroup') ? 'active' : ''; ?>" href="<?php echo base_url();?>index.php/docs/addGroupView">POST /addGroup</a>
						</li>
						<li class="nav-item">
						  <a class="nav-link <?php echo ($menu=='getGroupList') ? 'active' : ''; ?>" href="<?php echo base_url();?>index.php/docs/getGroupListView">POST /getGroupList</a>
						</li>
						<li class="nav-item">
						  <a class="nav-link <?php echo ($menu=='searchUser') ? 'active' : ''; ?>" href="<?php echo base_url();?>index.php/docs/searchUserView">POST /searchUser</a>
						</li>
						<li class="nav-item">
						  <a class="nav-link <?php echo ($menu=='addGroupFriend') ? 'active' : ''; ?>" href="<?php echo base_url();?>index.php/docs/addGroupFriendView">POST /addGroupFriend</a>
						</li>
						<li class="nav-item">
						  <a class="nav-link <?php echo ($menu=='setGroupFriendAccept') ? 'active' : ''; ?>" href="<?php echo base_url();?>index.php/docs/setGroupFriendAcceptView">POST /setGroupFriendAccept</a>
						</li>
						<li class="nav-item">
						  <a class="nav-link <?php echo ($menu=='setGroupFriendDecline') ? 'active' : ''; ?>" href="<?php echo base_url();?>index.php/docs/setGroupFriendDeclineView">POST /setGroupFriendDecline</a>
						</li>
						<li class="nav-item">
						  <a class="nav-link <?php echo ($menu=='removeGroupFriend') ? 'active' : ''; ?>" href="<?php echo base_url();?>index.php/docs/removeGroupFriendView">POST /removeGroupFriend</a>
						</li>
						<li class="nav-item">
						  <a class="nav-link <?php echo ($menu=='getGroupFriend') ? 'active' : ''; ?>" href="<?php echo base_url();?>index.php/docs/getGroupFriendView">POST /getGroupFriend</a>
						</li>
						<li class="nav-item">
						  <a class="nav-link <?php echo ($menu=='addFriend') ? 'active' : ''; ?>" href="<?php echo base_url();?>index.php/docs/addFriendView">POST /addFriend</a>
						</li>
						<li class="nav-item">
						  <a class="nav-link <?php echo ($menu=='setFriendAccept') ? 'active' : ''; ?>" href="<?php echo base_url();?>index.php/docs/setFriendAcceptView">POST /setFriendAccept</a>
						</li>
						<li class="nav-item">
						  <a class="nav-link <?php echo ($menu=='setFriendDecline') ? 'active' : ''; ?>" href="<?php echo base_url();?>index.php/docs/setFriendDeclineView">POST /setFriendDecline</a>
						</li>
						<li class="nav-item">
						  <a class="nav-link <?php echo ($menu=='removeFriend') ? 'active' : ''; ?>" href="<?php echo base_url();?>index.php/docs/removeFriendView">POST /removeFriend</a>
						</li>
						<li class="nav-item">
						  <a class="nav-link <?php echo ($menu=='getFriendList') ? 'active' : ''; ?>" href="<?php echo base_url();?>index.php/docs/getFriendListView">POST /getFriendList</a>
						</li>
						<li class="nav-item">
						  <a class="nav-link <?php echo ($menu=='getActivityList') ? 'active' : ''; ?>" href="<?php echo base_url();?>index.php/docs/getActivityListView">POST /getActivityList</a>
						</li>
					</ul>
				</nav>