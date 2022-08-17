<?php
	include("includes/header.php");
?>
<div class="main_div">
	<div class="left_part">
		<div class="book_link">
			<div class="link_heading">BOOKING LINK</div>
			<div class="link_mid_part">
				<a href="<?php echo base_url('appointment_booking/new_appointment'); ?>" class="copy_link" target="_blank" id="booking_link" ><?php echo base_url('appointment_booking/new_appointment'); ?></a>
				<a href="javascript:;" class="link_image"><img src="<?php echo SITE_IMAGES ?>copy.svg"></a>
			</div>
			<div class="link_bottom">Share this with your patient to book the appointment</div>
			<div class="row">
				<div class="col-md-12">
					<select name="doctor_id" id="doctor_id" class="form-control">
						<option value="">Select doctor</option>
						<?php foreach ($doctors as $doctor){?>
							<option value="<?php echo $doctor["id"]?>"><?php echo ucfirst($doctor['fullname'])?></option>
						<?php }?>
					</select>
				</div>
			</div>
		</div>
		<div class="appoinment_upcoming">
			<div class="common_box">
				<div class="common_text">
					<a href="javascript:;" class="common_left_text">Upcoming Appointment</a>
					<a href="<?php echo base_url('admin/appointments/get_appt/upcoming');?>" class="common_right_btn">view all</a>
				</div>
					<?php 
						foreach ($appointments as $appointment) {
					?>
						<ul class="next_appoinment">
							<li class="appointment_box">
								<div class="time_date">
									<span class="date"><?php echo date('d M',strtotime($appointment['date']));?></span>
									<span class="time"><?php echo date('h:i A',strtotime($appointment['time']));?></span>
									
								</div>
								<div class="name_turn">
									<a href="javascript:view_appntmnt(<?php echo $appointment['id']; ?>);"><span class="name"><?php echo $appointment['patient_name'];?></span></a>
									<span class="turn next_color"><?php echo $appointment['status'];?></span>	
								</div>
							</li>
						</ul>
					<?php		
						}
					?>
			</div>
		</div>
	</div>
	<div class="right_part">
		<div class="top_right">
			<div class="box">
				<img src="<?php echo SITE_IMAGES ?>rectangle_one.png" class="bg_shape">
				<div class="right_image">
					<img src="<?php echo SITE_IMAGES ?>timer.svg">
				</div>
				<div class="middle_text today-appointment"><?php echo $today_appt_count->count;?></div>
				<div class="bottom_text">Today’s Appointments</div>
			</div>
			<div class="box two">
				<img src="<?php echo SITE_IMAGES ?>rectangle_two.png" class="bg_shape">
				<div class="right_image">
					<img src="<?php echo SITE_IMAGES ?>doctor.svg">
				</div>
				<div class="middle_text today-doctor"><?php echo $today_doctor_count->count; ?></div>
				<div class="bottom_text">Doctors Available Today</div>
			</div>
			<div class="box three">
				<img src="<?php echo SITE_IMAGES ?>rectangle_three.png" class="bg_shape">
				<div class="right_image">
					<img src="<?php echo SITE_IMAGES ?>notes.svg">
				</div>
				<div class="middle_text total-appointment"><?php echo $total_appt_count;?></div>
				<div class="bottom_text">Total Appointments</div>
			</div>
		</div>
		<div class="middle_right">
			<div class="common_box">
				<div class="common_text">
					<div class="common_left_text">Appointment Chart</div>
					<div class="custom_select">
						<select name="chart_type">
						    <option value="0">This Week</option>
						    <option value="1">Last Week</option>
						    <option value="2">Last Month</option>
						</select>
					</div>
				</div>
				<div class="graph_image">
					<!-- <img src="<?php echo SITE_IMAGES ?>graph.png"> --> 
					<div id="chartContainer" style="height: 370px; width: 100%;"></div>
				</div>
			</div>
		</div>
		<div class="bottom_right">
			<div class="common_box">
				<div class="common_text">
					<div class="common_left_text">Doctors</div>
					<a href="<?php echo base_url('admin/doctors'); ?>" class="common_right_btn">view all</a>
				</div>
				<div class="doctor_list">
					<?php foreach ($doctors as $doctor) { ?>
						<a href="javascript:view_doctor(<?php echo $doctor['id']; ?>);" class="doctor_detail">
							<div class="doctor_image">
								<?php if($doctor['profile_photo'] != ""){ ?>
										<img src="<?php echo base_url('uploads/doctors_profile_images/'. $doctor['profile_photo']); ?>" style="width: 70px; height: 70px; border-radius: 50%;">
								<?php }else{ ?>
										<img src="<?php echo SITE_IMAGES ?>default_user.jpg" style="width: 70px; height: 70px; border-radius: 50%;"> 
								<?php } ?>
							</div>
							<div class="doctor_name">Dr. <?php echo $doctor['fullname'];?></div>
						</a>
					<?php } ?>
				</div>
			</div>
		</div>
	</div>
</div>

<?php
$this->load->view('admin/view_doctor',$doctor); 
$this->load->view('admin/view_appointment',$doctor); 
include("includes/footer.php"); 
?>
<script src="//code.highcharts.com/highcharts.js"></script>
<script src="//code.highcharts.com/modules/exporting.js"></script>
<script src="//code.highcharts.com/modules/export-data.js"></script>
<script src="//code.highcharts.com/modules/accessibility.js"></script>
<script>
var $temp = $("<input>");
$('.link_image').on('click', function() {
	var $url = $("#booking_link").attr('href');
	var doctor_id=$("#doctor_id").val();
	if(doctor_id>0)
		$url+="/"+doctor_id;
  $("body").append($temp);
  $temp.val($url).select();
  document.execCommand("copy");
  $temp.remove();
  swal("Booking link copied. now you can share link to your patient!");
});
$("#doctor_id").change(function(){
	get_dashboard();
});
$("select[name='chart_type']").change(function(){
	get_dashboard();
});
get_dashboard=function(){
	var doctor_id=$("#doctor_id").val();
	var chart_type=$("select[name='chart_type'] option:selected").val();
	$.ajax({
		url: "<?php echo base_url('admin/dashboard/get_dashboard'); ?>",
		type: "POST",
		dataType: "JSON",
		data:{"doctor_id":doctor_id,"chart_type":chart_type},
		success: function(response){
			if(response.chart)
				drawChart(response.chart);
			if(response.today_appt_count.count)
				$(".today-appointment").text(response.today_appt_count.count);
			if(response.today_doctor_count.count)
				$(".today-doctor").text(response.today_doctor_count.count);
			if(response.total_appt_count)
				$(".total-appointment").text(response.total_appt_count);
			$(".next_appoinment").empty();
			if(response.appointments){
				response.appointments.map(function(data,index){
					var li='<li class="appointment_box">';
					li+='<div class="time_date" bis_skin_checked="1">';
					li+='<span class="date">'+data.date+'</span>';
					li+='<span class="time">'+data.time+'</span>';
					li+='<span class="time">'+data.time+'</span>';
					li+='</div>';
					li+='<div class="name_turn" bis_skin_checked="1">';
					li+='<a href="javascript:view_appntmnt('+data.id+');"><span class="name">'+data.patient_name+'</span></a>';
					li+='<span class="turn next_color">'+data.status+'</span>';
					li+='</div>';
					li+='</li>';
					$(".next_appoinment").append(li);
				});
			}
		}
	});
}
get_dashboard();
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

drawChart=function(data){
	var days=[];
	var totalAppointment=[];
	$.map(data,(item,day)=>{
		days.push(day);
		totalAppointment.push(parseFloat(item));
	});
	var options= {
		chart: {
			type: 'area'
		},
		title: {
			text: 'Appintments'
		},
		xAxis: {
			categories: days
		},
		yAxis: {
			title: {
				text: 'Total appointments'
			}
		},
		plotOptions: {
			line: {
				dataLabels: {
					enabled: true
				},
				enableMouseTracking: false
			}
		},
		series: [{
			name: 'Appointment',
			color:"#28a745",
			data: totalAppointment
		}]
	};

	Highcharts.chart('chartContainer',options);
}
</script>
