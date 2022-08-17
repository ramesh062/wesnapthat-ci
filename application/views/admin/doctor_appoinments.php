<?php
    $dataTable="test";
	include("includes/header.php");
?>
<div class="doctor_appo_detail main_div ">
	<div class="new_apponment">
		<div class="all_appoinment">
			<div class="left_heading">
				<?php echo "Dr. ". $doctor->fullname; ?>
			</div>
            <div class="right_option">
                <div class="search_bar">        
                    <select onchange="window.location = '<?php echo base_url('admin/appointments/doctor_apptmnt/'.$doctor->id.'?type=');?>' + $(this).val()">
                        <option value="all" <?php if($type == 'all') echo "selected"; ?> >All</option>
                        <option value="upcoming" <?php if($type == 'upcoming') echo "selected"; ?>>Upcoming</option>
                        <option value="completed" <?php if($type == 'completed') echo "selected"; ?>>Completed</option>
                    </select>
                </div>
                <?php if($doctor->status == 'active'){ ?>
                    
                    <a href="<?php echo base_url('appointment_booking/new_appointment/'.$doctor->id); ?>" class="common_button" target="_blank" >
                        <span>New Appoinment</span>
                    </a>
                    
                <?php } ?>
            </div>
		</div>
		<table id="table_id" class="display">
    <thead>
        <tr>
            <th>Date</th>
            <th>Time</th>
            <th>Patient Name</th>
            <th>Doctor</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($appointments as $appointment) { ?>
        <tr>    
            <td><?php echo date('d M,Y',strtotime($appointment['date']));?></td>
            <td><?php echo date('h:i A',strtotime($appointment['time']));?></td>
            <td><?php if($appointment['patient_photo'] != ""){ ?><img src="<?php echo base_url('uploads/patients_profile_images/'. $appointment['patient_photo']); ?>" style="width: 20px; height: 20px; border-radius: 50%;"> <?php }else{ ?><img src="<?php echo SITE_IMAGES ?>default_user.jpg" style="width: 20px; height: 20px; border-radius: 50%;"><?php } ?><?php echo $appointment['patient_name'];?></td>
            <td>Dr. <?php echo $appointment['doctor_name'];?></td>
            <td class="next_color"><?php echo $appointment['status'];?></td>
        </tr>
        <?php } ?>    
    </tbody>
</table>
	</div>
</div>

<?php include("includes/footer.php"); ?>
 	<script>
	$(document).ready( function () {
	    $('#table_id').DataTable();
	} );
    $('#table_id').DataTable( {
        responsive: true
    } );

    </script>