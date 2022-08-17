<?php
    $dataTable="test";
	include("includes/header.php");
?>
<div class="doctor_appo_detail main_div extra_padd">
	<div class="new_apponment">
		<div class="all_appoinment">
			<div class="left_heading">
				Patient Appointments
			</div>
		</div>
		<table id="table_id" class="display responsive nowrap" style="width:100%">
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
                <?php foreach ($apptmnts as $appointment) { ?>
                <tr>    
                    <td><?php echo date('d M,Y',strtotime($appointment['date']));?></td>
                    <td><?php echo date('h:i A',strtotime($appointment['time']));?></td>
                    <td><a href="javascript:view_appntmnt(<?php echo $appointment['id']; ?>);"><?php if($appointment['patient_photo'] != ""){ ?><img src="<?php echo base_url('uploads/patients_profile_images/'. $appointment['patient_photo']); ?>" style="width: 20px; height: 20px; border-radius: 50%;"> <?php }else{ ?><img src="<?php echo SITE_IMAGES ?>default_user.jpg" style="width: 20px; height: 20px; border-radius: 50%;"><?php } ?><?php echo $appointment['patient_name'];?></a></td>
                    <td>Dr. <?php echo $appointment['doctor_name'];?></td>
                    <?php
					$upcoming  = '';
					$completed = '';
					$not_attended = '';
					$cancel = '';
                        if($appointment['status'] == "upcoming"){
                            $upcoming  = '';
                            $completed = '';
                            $not_attended = '';
                            $cancel = '';
                        }else if($appointment['status'] == "completed"){
                            $upcoming  = 'disabled';
                            $completed = '';
                            $not_attended = 'disabled';
                            $cancel = 'disabled';
                        }else if($appointment['status'] == "not attended"){
                            $upcoming  = 'disabled';
                            $completed = 'disabled';
                            $not_attended = '';
                            $cancel = '';
                        }else if($appointment['status'] == "cancel"){
                            $upcoming  = 'disabled';
                            $completed = 'disabled';
                            $not_attended = 'disabled';
                            $cancel = '';
                        }
                    ?>
                    <td class="next_color">
                        <select onchange="window.location = '<?php echo base_url('admin/patients/change_status?id='.$appointment["id"].'&status=');?>' + $(this).val()">
                            <option value="upcoming" <?php if($appointment['status'] == 'upcoming') echo "selected"; ?> <?php echo $upcoming;?>>Upcoming</option>
                            <option value="completed" <?php if($appointment['status'] == 'completed') echo "selected"; ?> <?php echo $completed;?>>Completed</option>
                            <option value="not attended" <?php if($appointment['status'] == 'not attended') echo "selected"; ?> <?php echo $not_attended;?>>Not attended</option>
                            <option value="cancel" <?php if($appointment['status'] == 'cancel') echo "selected"; ?> <?php echo $cancel;?>>Cancel</option>
                        </select>
                    </td>
                </tr>
                <?php } ?>    
            </tbody>
        </table>
	</div>
</div>
<?php 
    $this->load->view('admin/view_appointment',$doctor); 
    include("includes/footer.php"); 
?>

<script>
    $(document).ready( function () {
        $('#table_id').DataTable();
    } );
    $('#table_id').DataTable( {
        responsive: true
    } );

    function view_appntmnt(id){

       $.ajax({
           url: "<?php echo base_url('admin/appointments/view_appointment/'); ?>" + id,
           type: "POST",
           dataType: "JSON",
           success: function(response){
                
                res = response.data;
               
                $('h5').text(res.patient_name);
                $('#doctor').text(res.doctor_name);
                $('#date').text(res.date);
                $('#time').text(res.time);
                $('#status').text(res.status);
                $('#note').text(res.note);
           
                if(res.patient_photo != ""){
                   $('#patient_profile_image').attr("src", "<?php echo base_url('uploads/patients_profile_images/'); ?>" + res.patient_photo);
                }else{
                   $('#patient_profile_image').attr("src", "<?php echo SITE_IMAGES ?>default_user.jpg");
                }

                $('#view_appointment').modal('show');
           }
       })
    }
</script>
