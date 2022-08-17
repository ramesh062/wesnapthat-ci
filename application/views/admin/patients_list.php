<?php
    $dataTable="test";
	include("includes/header.php");
?>
<div class="doctor_appo_detail main_div extra_padd">
	<div class="new_apponment">
		<div class="all_appoinment">
			<div class="left_heading">
				Patients
			</div>
			<div class="right_option">
				<a href="<?php echo base_url('admin/patients/add_patient'); ?>" class="common_button">
					<span>Add Patient</span>
				</a>
			</div>
		</div>
		<?php 
			if(!empty($_SESSION['success_message'])){
				echo "<div class='text-success'>".$_SESSION['success_message']."</div>";
				unset($_SESSION['success_message']);
			}
		?>
		<table id="table_id" class="display responsive nowrap" style="width:100%">
    <thead>
        <tr>
            <th>Patient Name</th>
            <th>Email</th>
			<th>Mobile</th> 
            <th>Status</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($patients as $patient) { ?>
        <tr>    
            <td><?php if($patient['profile_photo'] != ""){ ?><img src="<?php echo base_url('uploads/patients_profile_images/'. $patient['profile_photo']); ?>" style="width: 20px; height: 20px; border-radius: 50%;"> <?php }else{ ?><img src="<?php echo SITE_IMAGES ?>default_user.jpg" style="width: 20px; height: 20px; border-radius: 50%;"><?php }  echo $patient['fullname'];?></td>
             
            <td><?php echo $patient['email'];?></td>
			<td><?php echo preg_match("/\+/",$patient['countrycode'],$count)?$patient['countrycode'].$patient['mobile']:"+".trim($patient['countrycode']).$patient['mobile'];?></td>
            <td><?php echo $patient['type'];?></td> 
            <td>
                <a href="#" class="edit_link" onclick="view_patient(<?php echo $patient['id']; ?>);return false;" >View</a>
                <a href="<?php echo base_url('admin/patients/patient_apptmnts/'.$patient['id']); ?>" class="edit_link">Appointments</a>
                <a href="javascript:;" class="cancle_link" onclick="delete_patient(<?php echo $patient['id']; ?>)">Delete</a>
            </td>
        </tr>
        <?php } ?>
    </tbody>
</table>
	</div>
</div>
<?php 
    $this->load->view('admin/view_patient');
    include("includes/footer.php"); 
?>

<script>
    function delete_patient(id){
       swal({
             title: "Are you sure?",
             icon: "warning",
             buttons: [
               'No, cancel it!',
               'Yes, I am sure!'
             ],
             dangerMode: true,
           }).then(function(isConfirm) {
             if (isConfirm) {
               window.location = "<?php echo base_url('admin/patients/change_patient_status/'); ?>" + id;
             }
           })
    }

    function view_patient(id){
        $.ajax({
            url: "<?php echo base_url('admin/patients/view_patient/'); ?>" + id,
            type: "POST",
            dataType: "JSON",
            success: function(response){
                 
                 res = response.data;
                
                 $('#email').text(res['patient'].email);
                 $('h5').text(res['patient'].fullname);
                 $('#age').text(res['patient'].age);
                 $('#gender').text(res['patient'].gender);
				 if(res['patient'].countrycode.indexOf("+")>0)
				 	$('#mobile').text(res['patient'].countrycode+res['patient'].mobile);
				else
					$('#mobile').text(res['patient'].countrycode.replace(/^\s+|\s+$/gm,'+')+res['patient'].mobile);
				
                 $('#status').text(res['patient'].type);

                 if(res['patient'].profile_photo != ""){
                    $('#patient_profile_image').attr("src", "<?php echo base_url('uploads/patients_profile_images/'); ?>" + res['patient'].profile_photo);
                 }else{
                    $('#patient_profile_image').attr("src", "<?php echo SITE_IMAGES ?>default_user.jpg");
                 }

                 $('#exampleModalLong').modal('show');
            }
        })
    }
</script>

