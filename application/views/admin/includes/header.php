<?php
	$compression = false;
	include("functions.php");
?>
<!DOCTYPE HTML>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="initial-scale=1,maximum-scale=1,user-scalable=no" />
	<meta http-equiv="Cache-control" content="public">
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name="format-detection" content="telephone=no" />
	<meta name="distribution" content="global">
	<meta name="revisit-after" content="1 days">
	<meta name="robots" content="index, follow" />
	<title><?php echo $PageTitle; ?></title>
	<meta name="description" content="">
	<meta name="author" content="">
	<meta name="keyword" content="">
	<link rel="alternate" href="<?php echo BASE_URL; ?>" />
	<link rel=canonical href="<?php echo BASE_URL; ?>">
	<!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous"> -->
	<link rel="stylesheet" type="text/css" href="<?php echo SITE_CSS ?>style.css<?php echo VER ?>" />
	<link rel="stylesheet" type="text/css" href="<?php echo SITE_CALENDAR ?>core/main.min.css">
	<link rel="stylesheet" type="text/css" href="<?php echo SITE_CALENDAR ?>daygrid/main.min.css">
	<link rel="stylesheet" type="text/css" href="<?php echo SITE_CSS?>responsive.dataTables.min.css">
	<link href='<?php echo SITE_CALENDAR ?>daygrid/main.min.css' rel='stylesheet' />

	<link href='<?php echo SITE_CALENDAR ?>timegrid/main.min.css' rel='stylesheet' />
	<script type="" src="<?php echo SITE_CALENDAR ?>core/main.min.js"></script>
	<script src="<?php echo SITE_CALENDAR ?>daygrid/main.min.js"></script>
	<!-- 17-02-2021 -->
	<script src="<?php echo SITE_JS?>jquery.min.js"></script>
	<script src="<?php echo SITE_JS?>popper.min.js"></script>
	<script src='<?php echo SITE_JS?>tooltip.min.js'></script>
	<script src="<?php echo SITE_JS?>bootstrap.min.js"></script>
	
	<!-- <link rel="stylesheet" type="text/css" href="/jquery.datetimepicker.css"/ >
	<script src="/jquery.js"></script>
	<script src="/build/jquery.datetimepicker.full.min.js"></script> -->
	
	<script src='<?php echo SITE_CALENDAR ?>fullcalendar/moment.min.js'></script>
	<script src='<?php echo SITE_CALENDAR ?>fullcalendar/fullcalendar.min.js'></script>

	<link rel="stylesheet" href="<?php echo SITE_CSS?>bootstrap.css">

	<script src='<?php echo SITE_CALENDAR?>timegrid/main.min.js'></script>

	  <script src='<?php echo SITE_CALENDAR?>core/resource-common-main.min.js'></script>

	  <script src='<?php echo SITE_CALENDAR?>daygrid/resource-daygrid-main.min.js'></script>

	  <script src='<?php echo SITE_CALENDAR?>timegrid/resource-timegrid-main.min.js'></script>
	 <link rel="stylesheet" type="text/css" href="<?php echo SITE_CSS?>jquery.dataTables.min.css">
	
	<script src="<?php echo SITE_JS?>sweetalert.min.js"></script>
	<meta name="theme-color" content="<?php echo SITE_THEME ?>">
	<meta name="msapplication-navbutton-color" content="<?php echo SITE_THEME ?>">
	<meta name="msapplication-TileColor" content="<?php echo SITE_THEME ?>">
<body>
	<?php if($PageName == 'login' || $PageName == 'new appoinments') { } else { ?>
	<header>
		<div class="header_link">
			<a href="javascript:;" class="menu_icon">
				<img src="<?php echo SITE_IMAGES ?>menu.svg">
			</a>
			<a href="javascript:;" class="logo_link"><?php echo $admin->hospital_name; ?></a>
		</div>
		<div class="menu_option">
			<?php $class = "active"; ?>
			<ul class="menu_link">
				<li><a href="<?php echo base_url('admin/dashboard'); ?>" class="menu_name <?php if($PageName == "index"){ echo $class; } ?>" >
						<img src="<?php echo SITE_IMAGES ?>dashboard.svg">
						<span>Dashboard</span>
				</a></li>
				<li><a href="<?php echo base_url('admin/calendar');?>" class="menu_name <?php if($PageName == "calendar"){ echo $class; } ?>">
						<img src="<?php echo SITE_IMAGES ?>calendar.svg">
						<span>Calendar</span>
				</a></li>
				<li><a href="<?php echo base_url('admin/appointments/get_appt/all');?>" class="menu_name <?php if($PageName == "all" || $PageName == 'upcoming' || $PageName == 'completed' || $PageName=='add_appointment'){ echo $class; } ?>">
						<img src="<?php echo SITE_IMAGES ?>appointment.svg">
						<span>Appointments</span>
					</a>
					<!-- <?php if($PageName == "all" || $PageName == 'upcoming' || $PageName == 'completed') { $display = "block"; } else { $display = "none"; } ?>
					
					<ul class="sub_menu" style="display: <?php echo $display; ?>">
						<li><a href="<?php echo base_url('admin/appointments/get_appt/upcoming');?>" class="sub_menu_link <?php if($PageName == "upcoming"){ echo $class; } ?>"> - Upcoming Appointments </a></li>
						<li><a href="<?php echo base_url('admin/appointments/get_appt/completed');?>" class="sub_menu_link <?php if($PageName == "completed"){ echo $class; } ?>"> - Completed Appointments </a></li>
					</ul> -->
				</li>
				<li><a href="<?php echo base_url('admin/doctors'); ?>" class="menu_name <?php if($PageName == "manage_doctors"){ echo $class; } ?>">
						<img src="<?php echo SITE_IMAGES ?>phonendoscope.svg">
						<span>Manage Doctors</span>
				</a></li>
				<li><a href="<?php echo base_url('admin/patients'); ?>" class="menu_name <?php if($PageName == "patients"){ echo $class; } ?>">
						<img src="<?php echo SITE_IMAGES ?>phonendoscope.svg">
						<span>Patients</span>
				</a></li>
				<li><a href="<?php echo base_url('admin/dashboard/time_management'); ?>" class="menu_name <?php if($PageName == "timing"){ echo $class; } ?>">
						<img src="<?php echo SITE_IMAGES ?>clock.svg">
						<span>Time Management</span>
				</a></li>
				<li><a href="<?php echo base_url('admin/dashboard/developers'); ?>" class="menu_name <?php if($PageName == "developers"){ echo $class; } ?>">
						<img src="<?php echo SITE_IMAGES ?>settings.svg">
						<span>Developers</span>
				</a></li>
				<li><a href="<?php echo base_url('admin/dashboard/settings'); ?>" class="menu_name <?php if($PageName == "settings"){ echo $class; } ?>">
						<img src="<?php echo SITE_IMAGES ?>settings.svg">
						<span>Settings</span>
				</a></li>
				<li><a href="<?php echo base_url('admin/cms'); ?>" class="menu_name <?php if($PageName == "cms"){ echo $class; } ?>">
						<img src="<?php echo SITE_IMAGES ?>settings.svg">
						<span>Pages</span>
				</a></li>
				<li><a href="javascript:do_logout();" class="menu_name">
						<img src="<?php echo SITE_IMAGES ?>settings.svg">
						<span>Logout</span>
				</a></li>
			</ul>
			<div class="common_bottom">
				<div class="bottom_link">
					<div class="version">Version 1.0.0</div>
					<div class="terms_policy">
						<a href="javascript:;" class="terms">Terms & Conditions</a>
						<a href="javascript:;" class="terms policy">Privacy Policy</a>
					</div>
				</div>
				<span>Powered By</span>
				<div class="common_part">
					<img src="<?php echo SITE_IMAGES ?>bottom_part.svg">
					<span><?php echo $admin->hospital_name; ?></span>
				</div>
			</div>
		</div>
		<?php if($PageName == 'all' || $PageName == 'upcoming' || $PageName == 'completed') { ?>
		<div class="sub_menu_option">
			<?php
				$active   = "";
				$h_active = "";
				if($doctor_id != ""){
					if(isset($doctor->id) && $doctor->id != ""){
						$active = 'active';
					}else{
						$h_active = 'active';
					}
				}else{
					$h_active = 'active';
				}
				 
			?>
			<ul class="menu_link">
				<li><a href="<?php echo base_url('admin/appointments/get_appt/all'); ?>" class="menu_name <?php echo $h_active; ?>">
						<span class="name next_color">All Doctors</span>
						<span class="turn "><?php echo $appt_count->count;?> Appointments</span>
				</a></li>
				<?php foreach ($doctors_appt as $key => $doctors) { ?>
				<li><a href="<?php echo base_url('admin/appointments/doctor_apptmnt/'.$doctors['id']); ?>" class="menu_name <?php if(isset($doctor_id) && 
				$doctor_id == $doctors['id']) echo $active; ?>">
						<?php if($doctors['status'] == "deleted"){ ?>
							<span class="name">Dr. <?php echo $doctors['fullname']." (".$doctors['status'].")";?></span>
						<?php }else{ ?>
							<span class="name">Dr. <?php echo $doctors['fullname'];?></span>	
						<?php } ?>
						<span class="turn "><?php echo $doctors['appt_count'];?> Appointments</span>
				</a></li>
				<?php } ?>
			</ul>
		</div>	
		<?php } ?>
		<?php if($PageName == 'timing'){ ?> 
		<div class="timing_option sub_menu_option">
			<ul class="menu_link">
				<?php
					$active   = "";
					$h_active = "";
					if(isset($doctor_id) && $doctor_id != ""){
						$active = 'active';
					}else{
						$h_active = 'active';
					} 
				?>
				<li><a href="<?php echo base_url('admin/dashboard/time_management');?>" class="menu_name <?php echo $h_active; ?>">
						<span class="name next_color">Hospital Timing</span>
						
				</a></li>
				<?php foreach ($doctors as $doctor) { ?>
					<li><a href="<?php echo base_url('admin/dashboard/time_management/'.$doctor['id']);?>" class="menu_name <?php if($doctor_id == $doctor['id']) echo $active; ?>">
							<span class="name">Dr. <?php echo $doctor['fullname']; ?></span>
							
					</a></li>	
				<?php } ?>
			</ul>
		</div>	
		<?php } ?>
	</header>
	<?php } ?> 

	<script>
		function do_logout(){
			swal({
			      title: "Are you sure, you want to logout?",
			      icon: "warning",
			      buttons: [
			        'Cancel',
			        'Logout'
			      ],
			      dangerMode: true,
			    }).then(function(isConfirm) {
			      if (isConfirm) {
			      	window.location = "<?php echo base_url('admin/Authentication/do_logout'); ?>";
			      }
			    })
		}
	</script>
