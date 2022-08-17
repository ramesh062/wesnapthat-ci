<html>
	<head>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
		<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
		<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
		<script src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>
		<link href="https://cdn.datatables.net/1.10.23/css/jquery.dataTables.min.css" rel="stylesheet">
		
    	<title><?php echo $title;?></title>
	</head>
	<body>
	<div>
		<div>
			<h2>Dr.John's General Hospital</h2>
		</div>
		<?php $bold = 'style="font-weight: bold"';?>
		<a href="<?php echo site_url('admin/dashboard');?>" <?php if($page=="dashboard"){echo $bold;}?>>Dashboard</a>&nbsp
		<a href="<?php echo site_url('admin/dashboard');?>">Calendar</a>&nbsp
		<a href="<?php echo site_url('admin/appointments/get_appt/all');?>" <?php if($page=="appointments" && $type == "all"){echo $bold;}?>>Appointments</a>&nbsp
		<a href="<?php echo site_url('admin/appointments/get_appt/upcoming');?>" <?php if($page=="appointments" && $type == "upcoming"){echo $bold;}?>>Upcoming Appointments</a>&nbsp
		<a href="<?php echo site_url('admin/appointments/get_appt/completed');?>" <?php if($page=="appointments" && $type == "completed"){echo $bold;}?>>Completed Appointments</a>&nbsp
		<a href="<?php echo site_url('admin/doctors');?>" <?php if($page=="manage_doctors"){echo $bold;}?>>Manage Doctors</a>&nbsp
		<a href="">Time Management</a>&nbsp
		<a href="">Settings</a>&nbsp
		<a href="<?php echo site_url();?>admin/Authentication/do_logout">Logout</a>
		<hr>
	</div>	