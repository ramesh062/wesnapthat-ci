<?php include 'includes/header.php';?>

<section class="appoinment_part">
	<div class="new_appoinment">
		<div class="common_text">
			<div class="common_text_form">Add Page</div>
			<div class="right_img"><img src="<?php echo SITE_IMAGES ?>building.svg"></div>
		</div>
		<div class="appoinment_form">
			<?php echo form_open(base_url('admin/cms/save_cms'),array("id" => "cms_form","name" => "cms_form")); ?>
			<div class="custom_input_main">
				<div class="custom_input_box">
					<label class="input_label">Page title</label>
					<div class="input_box">
						<input type="text" name="page_name" id="page_name" value="<?php echo !empty($cms->page_name)?$cms->page_name:"" ?>" placeholder="Page title" class="custom_input">
					</div>
				</div>
				<input type="hidden" name="slug" id="slug" value="<?php echo !empty($cms->slug)?$cms->slug:"" ?>" class="custom_input">
				<input type="hidden" name="id" id="id" value="<?php echo !empty($cms->id)?$cms->id:"" ?>" class="custom_input">
				<div class="custom_input_box w_full">
					<div class="custom_input_box">
						<label class="input_label">Content</label>
						
					</div>
					<div class="">
							<textarea name="content" id="content" placeholder="Content" class="form-control"><?php echo !empty($cms->content)?$cms->content:""?></textarea>
						</div>
				</div>
				<div class="btn_book">
					<button type="submit" class="common_button"><span>Submit</span></button>
				</div>
			<?php echo form_close(); ?>
		</div>
	</div>
	
</section>
<?php include 'includes/footer.php';?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/6.0.2/tinymce.min.js" integrity="sha512-Cwez4r594AFwCqWzXklkW90mGiJCKJBhcFb8GsWWtb0coKuR9uv1ozODWidI/8Lr9iKunYaXLPf6VJtL3rXzyQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
 	tinymce.init({
			selector: 'textarea#content',
	});
</script>
