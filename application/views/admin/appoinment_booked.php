<?php
	$PageTitle="Website Name :: Webstie";
	$PageName="new appoinments";
	include("includes/header.php");
?>
<section class="appoinment_part ">
	<div class="new_appoinment ">
		<div class="confirm_img">
			<img src="<?php echo SITE_IMAGES ?>booked_img.svg">
		</div>
		<div class="common_text justify-content-center">
			<div class="common_text_form m_0">Appointment Booked</div>
		</div>
		<div class="sub_text__msg text-center">The details have been send you on email. </div>
		<div class="date_time">
			<div class="date">
				<span class="text-right">Date</span>
				<span class="fsbold"><?php echo date('d M Y',strtotime($apptmt->date)); ?></span>
			</div>
			<div class="date">
				<span class="text-right">Time</span>
				<span class="fsbold"><?php echo date('h:i A',strtotime($apptmt->time)); ?></span>
			</div>
		</div>
		<div class="attend_by">
			<span class="sub_text__msg text-center block" >You will be attended by</span>
			<span class="title_text_name text-center block">Dr. <?php echo $apptmt->fullname; ?></span>
		</div>
		<div class="bottom_part">
			<div class="title_text_name text-center fbold"><?php echo $admin->hospital_name; ?></div>
			<div class="sub_text__msg text-center pt-0" ><?php echo $admin->address; ?></div>
			<div class="contact_number d-flex align-items-center justify-content-center">
				<img src="<?php echo SITE_IMAGES ?>call_icon.svg">
				<span><?php echo $admin->phone; ?></span>
			</div>
		</div>
	</div>
</section>

<?php include("includes/footer.php"); ?>