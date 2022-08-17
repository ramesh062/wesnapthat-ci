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
				<a href="<?php echo base_url('admin/cms/add_cms'); ?>" class="common_button">
					<span>Add Page</span>
				</a>
			</div>
		</div>
		<table id="table_id" class="display responsive nowrap" style="width:100%">
			<thead>
				<tr>
				<th>Page</th>
				<th>Action</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($cms as $page) { ?>
				<tr>    
				<td><?php echo $page['page_name']?></td>
				
				<td>
					<a href="<?php echo base_url('pages/'.$page['slug'])?>" class="edit_link" target="_blank">View</a>
					<a href="<?php echo base_url('admin/cms/edit_cms/'.$page['id']); ?>" class="edit_link">Edit</a>
					<!-- <a href="javascript:;" class="cancle_link" onclick="delete_page(<?php echo $page['id']; ?>)">Delete</a> -->
				</td>
				</tr>
				<?php } ?>
			</tbody>
		</table>
		</div>
	</div>
<?php 
    include("includes/footer.php"); 
?>


<script>
    function delete_page(id){
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
               window.location = "<?php echo base_url('admin/cms/delete_cms/'); ?>" + id;
             }
           })
    }
</script>
