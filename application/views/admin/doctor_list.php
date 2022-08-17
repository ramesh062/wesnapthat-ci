<?php
    $dataTable="test";
	include("includes/header.php");
?>
<div class="doctor_appo_detail main_div extra_padd">
	<div class="new_apponment">
		<div class="all_appoinment">
			<div class="left_heading">
				Doctors
			</div>
			<div class="right_option">
				<!-- <div class="search_bar">
					<img src="<?php echo SITE_IMAGES ?>search.svg">
					<input type="search" name="">
				</div> -->
				<a href="<?php echo base_url('admin/doctors/add_doctor'); ?>" class="common_button">
					<span>Add Doctor</span>
				</a>
			</div>
		</div>
		<table id="table_id" class="display responsive nowrap" style="width:100%">
    <thead>
        <tr>
            <th>Doctor Name</th>
            <th>Speciality</th> 
           <!--  <th>Status</th> -->
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($doctors as $doctor) { ?>
        <tr>    
            <td><?php if($doctor['profile_photo'] != ""){ ?><img src="<?php echo base_url('uploads/doctors_profile_images/'. $doctor['profile_photo']); ?>" style="width: 20px; height: 20px; border-radius: 50%;"> <?php }else{ ?><img src="<?php echo SITE_IMAGES ?>default_user.jpg" style="width: 20px; height: 20px; border-radius: 50%;"><?php } ?> Dr.<?php echo $doctor['fullname'];?></td>
             
            <td><?php echo $doctor['speciality'];?></td>
            <!-- <td><?php echo $doctor['status'];?></td> -->
            <td>
                <a href="#" class="edit_link" onclick="view_doctor(<?php echo $doctor['id']; ?>);return false;" >View</a>
                <a href="<?php echo base_url('admin/doctors/edit_doctor/'.$doctor['id']); ?>" class="edit_link">Edit</a>
                <a href="javascript:;" class="cancle_link" onclick="delete_doctor(<?php echo $doctor['id']; ?>)">Delete</a>
            </td>
        </tr>
        <?php } ?>
    </tbody>
</table>
	</div>
</div>
<?php 
    $this->load->view('admin/view_doctor',$doctor);
    include("includes/footer.php"); 
?>

<script>
    function delete_doctor(id){
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
               window.location = "<?php echo base_url('admin/doctors/change_doctor_status/'); ?>" + id;
             }
           })
    }

    function view_doctor(id){
        $.ajax({
            url: "<?php echo base_url('admin/doctors/view_doctor/'); ?>" + id,
            type: "POST",
            dataType: "JSON",
            success: function(response){
                 
                 res = response.data;
                
                 $('#email').text(res['doctor'].email);
                 $('h5').text("Dr. " + res['doctor'].fullname);
                 $('#speciality').text(res['doctor'].speciality);
                 $('#qualification').text(res['doctor'].qualification);
                 $('#experience').text(res['doctor'].experience + " years");
                 $('#gender').text(res['doctor'].gender);
                 $('#consl_charges').text(res['doctor'].consultation_charges);
                 $('#weekly_off_days').text(res.days);
                 $('#consl_hours').text(res.hours);

                 if(res['doctor'].profile_photo != ""){
                    $('#doctors_profile_image').attr("src", "<?php echo base_url('uploads/doctors_profile_images/'); ?>" + res['doctor'].profile_photo);
                 }else{
                    $('#doctors_profile_image').attr("src", "<?php echo SITE_IMAGES ?>default_user.jpg");
                 }

                 $('#exampleModalLong').modal('show');
            }
        })
    }
</script>

