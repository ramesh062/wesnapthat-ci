<?php
	include("includes/header.php");
?>
<div class="doctor_appo_detail main_div ">
	<div class="timing_part">
        <div class="time_heading input_label">
            Consultation Hours
        </div>
         <div class="time_sub_heading">The consultation hours you prefer during the day. You can add more than one slots.</div>   
        </div>
        <?php echo form_open('',array("id" => "consultation_hours","name" => "consultation_hours","onsubmit"=>"return false")); ?>
        <input type="hidden" name="doctor_id" id="doctor_id" value="<?php echo isset($doctor_id) ? $doctor_id : "";?>">
        <?php
            if($doctor_id == "" && empty($consultation_time)){
        ?>
        <div id="consultation1">
          <div class="time_selection" id="div_0">
            <div class="custom_timing" >
              <input class="timepicker text-center" name="from_time[]" id="from_0" readonly="true">
              <label>To</label>
              <input class="timepicker text-center" name="to_time[]" id="to_0" readonly="true">
              <a href="javascript:add_slot();" class="add_more" id="plus_0">
                  <span>+</span>
              </a>
              <a href="javascript:remove_slot(0);" class="add_more" style="display: none;" id="minus_0">
                 <span>-</span>
              </a>
              <span name="errors[]" style="display: none;">Please select valid start and end time.</span><br>
            </div>  
          </div>
        </div>
        <?php 
           }
        ?>

        <div id="consultation1">
          <?php foreach ($consultation_time as $key => $value) { ?>
              <div class="time_selection" id="div_<?php echo $key + 1; ?>">
                <div class="custom_timing" >
                  <input class="timepicker text-center" name="from_time[]" id="from_<?php echo $key + 1; ?>" readonly="true" value="<?php echo  date("h:i A", strtotime($value['from_time'])); ?>">
                  <label>To</label>
                  <input class="timepicker text-center" name="to_time[]" id="to_<?php echo $key + 1; ?>" readonly="true" value="<?php echo  date("h:i A", strtotime($value['to_time'])); ?>">
                  <a href="javascript:add_slot();" class="add_more" id="plus_<?php echo $key + 1; ?>">
                      <span>+</span>
                  </a>
                  <a href="javascript:remove_slot(<?php echo $key + 1; ?>);" class="add_more" style="display: none;" id="minus_<?php echo $key + 1; ?>">
                     <span>-</span>
                  </a>
                  <span name="errors[]" style="display: none;">Please select valid start and end time.</span><br>
                </div>  
              </div>
          <?php } ?>
        </div>
        <div>
          <?php
              if(isset($doctor_id) && $doctor_id != ""){
          ?>
            <br>
            <label>Appointment Time Slots</label><br>
            <input type="radio" name="appointment_time_slots" value="10" <?php if($doctor_details->appointment_time_slots == "10") echo "checked"; ?>> 10 min &nbsp
            <input type="radio" name="appointment_time_slots" value="15" <?php if($doctor_details->appointment_time_slots == "15") echo "checked"; ?>> 15 min &nbsp
            <input type="radio" name="appointment_time_slots" value="20" <?php if($doctor_details->appointment_time_slots == "20") echo "checked"; ?>> 20 min &nbsp<br>
            <input type="radio" name="appointment_time_slots" value="30" <?php if($doctor_details->appointment_time_slots == "30") echo "checked"; ?>> 30 min &nbsp
            <input type="radio" name="appointment_time_slots" value="45" <?php if($doctor_details->appointment_time_slots == "45") echo "checked"; ?>> 45 min &nbsp
            <input type="radio" name="appointment_time_slots" value="60" <?php if($doctor_details->appointment_time_slots == "60") echo "checked"; ?>> 1 hr <br>
            <br>
            <?php 
              $mon = "";$tue = "";$wed = "";$thu = "";$fri = "";$sat = "";$sun = "";
              $weekly_off_days = explode(',', $doctor_details->weekly_off_days);
              foreach ($weekly_off_days as $each) {
                if($each == "mon"){
                  $mon = "checked";
                }else if($each == "tue"){
                  $tue = "checked";
                }else if($each == "wed"){
                  $wed = "checked";
                }else if($each == "thu"){
                  $thu = "checked";
                }else if($each == "fri"){
                  $fri = "checked";
                }else if($each == "sat"){
                  $sat = "checked";
                }else if($each == "sun"){
                  $sun = "checked";
                }
              }
            ?>
            <label>Weekly off Day(s)</label><br>
            <input type="checkbox" name="mon" id="mon" value="mon" <?php echo $mon; ?>> Mon &nbsp
            <input type="checkbox" name="tue" id="tue" value="tue" <?php echo $tue; ?>> Tue &nbsp
            <input type="checkbox" name="wed" id="wed" value="wed" <?php echo $wed; ?>> Wed &nbsp
            <input type="checkbox" name="thu" id="thu" value="thu" <?php echo $thu; ?>> Thu &nbsp<br>
            <input type="checkbox" name="fri" id="fri" value="fri" <?php echo $fri; ?>> Fri &nbsp
            <input type="checkbox" name="sat" id="sat" value="sat" <?php echo $sat; ?>> Sat &nbsp
            <input type="checkbox" name="sun" id="sun" value="sun" <?php echo $sun; ?>> Sun <br>
          <?php      
              } 
          ?>
        </div>
        <div>
          <br>
          <button type="submit" form="consultation_hours" class="btn btn-info" style="margin-right: 900px;" onclick="add_time();">Save</button>
        </div>
        <?php echo form_close(); ?>
	</div>
</div>
<?php include("includes/footer.php"); ?>
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.css">
<script src="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js"></script>
<script>
      var count = <?php echo count($consultation_time); ?>;

      $(document).ready(function(){

          for(i=1;i<count;i++){
              $('#plus_' + i).hide();
              $('#minus_' + i).show();    
          }

          initialize_timepicker();
      });

      function add_slot(){
        $('#plus_' + count).hide();
        $('#minus_' + count).show();

        count += 1;
        var html = `<div class="time_selection" id="div_`+ count +`">
                      <div class="custom_timing" >
                         <input class="timepicker text-center" name="from_time[]" readonly="true" id="from_`+ count +`">
                         <label>To</label>
                         <input class="timepicker text-center" name="to_time[]" readonly="true" id="to_`+ count +`">
                         <a href="javascript:add_slot();" class="add_more" id="plus_`+ count +`">
                            <span>+</span>
                         </a>
                         <a href="javascript:remove_slot(`+ count +`);" class="add_more" style="display: none;" id="minus_`+ count +`">
                            <span>-</span>
                         </a>
                         <span name="errors[]" style="display: none;">Please select valid start and end time.</span><br>
                      </div>  
                    </div>`;
       
        $('#consultation1').append(html);
        initialize_timepicker();
      }

      function remove_slot(count){
        var from = $("#from_" + count).val();
        var to   = $("#to_" + count).val();

        if(from == "" && to == ""){
          $("#div_" + count).remove();
        }else{
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
                  $("#div_" + count).remove();
                }
              })
        }
      }

      function initialize_timepicker() {
        $('input.timepicker').timepicker({
          timeFormat: 'hh:mm p',
          defaultTime: '',
          interval: 30,
          dynamic: true,
          dropdown: true,
          scrollbar: false
        });
      }

      function GetFormattedTime(input) {

        var time  = input;
        var hours = Number(time.match(/^(\d+)/)[1]);
        var minutes = Number(time.match(/:(\d+)/)[1]);
        var AMPM = time.match(/\s(.*)$/)[1];
        if(AMPM == "PM" && hours<12) hours = hours+12;
        if(AMPM == "AM" && hours==12) hours = hours-12;
        var sHours = hours.toString();
        var sMinutes = minutes.toString();
        if(hours<10) sHours = "0" + sHours;
        if(minutes<10) sMinutes = "0" + sMinutes;

        return sHours + ":" + sMinutes;
      }

      function add_time(){

          var valid      = true;
          var off_days   = [];
          var doctor_id  = $('#doctor_id').val();
          var input1     = document.getElementsByName('from_time[]'); 
          var input2     = document.getElementsByName('to_time[]'); 
          var errors     =  document.getElementsByName('errors[]');
           
          for (var i = 0; i < input1.length; i++) { 
              var from = input1[i].value;
              var to   = input2[i].value;
              
              if(from == ''){
                 valid = false;break;
              }else if(to == ''){
                 valid = false;break;
              }else{
                 valid = true;

                 var from_time = GetFormattedTime(input1[i].value);
                 var to_time   = GetFormattedTime(input2[i].value);
                 
                 if(i > 0){
                   var last_to_time = GetFormattedTime(input2[i-1].value);
                   if(from_time < last_to_time){
                      errors[i].style.display = "block";return;
                   }  
                 }

                 if(to_time < from_time){
                    errors[i].style.display = "block";return;
                 }else if(to_time == from_time){
                    errors[i].style.display = "block";return;
                 }else{
                    errors[i].style.display = "none";
                 }
              } 
          }  
          
          var days = ['mon','tue','wed','thu','fri','sat','sun'];
          for(i=0;i<days.length;i++){
            if($('#' + days[i]).is(":checked")){
              off_days.push(days[i]);
            } 
          }

          if(valid == false){
            swal("Please Select Consultation Hours..");
          }else{
            var formData  = new FormData(eval(document.consultation_hours));
            
            if(doctor_id != ""){
              var url = '<?php echo base_url('admin/dashboard/add_consultation_hours/'); ?>' + doctor_id;
              formData.append('weekly_off_days',off_days); 
            }else{
              var url = '<?php echo base_url('admin/dashboard/add_consultation_hours'); ?>';
            }

            $.ajax({
              url: url,
              type: 'POST',
              data: formData,
              dataType: 'JSON',
              processData: false,
              contentType: false,
              success: function(response){
                if(response.status == 1){
                  swal(response.message);
                  setTimeout(function() {
                      window.location = '<?php echo base_url('admin/dashboard/time_management');?>';
                  }, 1000);
                }else{
                  swal(response.message);
                }
              }
            });  
          }
      }
</script>
