<?php
	include("includes/header.php");
?>
<div class="appoinment_detail main_div">
	<div class="calendar">
	 	<div id='calendar'></div>
	</div>
	<div class="calendar calendar_dayview">
		<div id='calendar_dayview'></div>
	</div>
</div>
<?php include("includes/footer.php"); ?>
 
<script>

    var selected_date = "";

    $(document).ready(function() {
        $('#calendar').fullCalendar({
            plugins: [ 'dayGrid' ],
            editable: true,
            eventLimit: true, // allow "more" link when too many events
            header: {
              left: 'title',
              center: "",
              right: 'prev,next'
            },
            // eventSources: [{
            //   url: '<?php echo site_url("admin/calendar/get_calendar_data"); ?>'
            // }],
            dayClick: function(date, jsEvent, view) {
              render_calendar(date.format());
            }
        });
        render_calendar('<?php echo date("Y-m-d"); ?>');
    });

    function render_calendar(date = ""){
      
      var calendarEl = document.getElementById('calendar_dayview');

      calendarEl.innerHTML = '';
      
      var days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday','Sunday'];
      var d = new Date(date);
      var dayName = days[d.getDay()];

      var calendar = new FullCalendar.Calendar(calendarEl, {
        plugins: [ 'resourceTimeGrid' ],
        defaultView: 'resourceTimeGridDay',
        timeZone: "UTC",
        datesAboveResources: true,
        header: {
         left: "title",
         center: "",
         right: ""
        },
        resources: [
          { id: 'day', title: dayName },
        ],
        eventSources: [{
          url: '<?php echo site_url("admin/calendar/get_calendar_data/"); ?>' + date
        }],
        eventRender: function(info) {
        
          var img = info.event.extendedProps.imageurl;
          
          // var tooltip = new Tooltip(info.el, {
          //       title: info.event.extendedProps.time,
          //       placement: 'top',
          //       trigger: 'hover',
          //       container: 'body'
          //     });

          if (img != "") {
              info.el.querySelector('div.fc-time').innerHTML = "<img src='"+ img +"' width='24' height='24' border-radius='50%'>";
          }
        },
        // eventRender: function(event, element) {
        //   var img = event.event._def.extendedProps.imageurl;
        //   console.log(element)
        //     if (img != "") {
        //         //eventElement.find("div.fc-content").prepend("<img src='" + img +"' width='16' height='16'>");
        //     }
        // },
        defaultDate: date
      });

      calendar.render();
      $("#calendar_dayview div.fc-left").each(function(){
          $(this).text(dayName.toUpperCase() + moment(date).format(' MMM DD'));
      });
    }
    
      //  document.addEventListener('DOMContentLoaded', function() {
      //   var calendarEl = document.getElementById('calendar');

      //   var calendar = new FullCalendar.Calendar(calendarEl, {
      //     plugins: [ 'dayGrid' ],
      //     //  header: {
			   // //   left:   'title','prev,next',
			   // //   center: '',
			   // //   right:  ''
			   // // },
			   //  header: {
      //     		left: 'title, prev,next',
      //     		right: ''
      // 		},

      //   });

      //   calendar.render();
      // });

    </script>

<style>

.fc {
	direction: ltr;
	text-align: left;
}

.fc-rtl {
	text-align: right;
}

body .fc { /* extra precedence to overcome jqui */
	font-size: 1em;
}


/* Colors
--------------------------------------------------------------------------------------------------*/

.fc-unthemed th,
.fc-unthemed td,
.fc-unthemed thead,
.fc-unthemed tbody,
.fc-unthemed .fc-divider,
.fc-unthemed .fc-row,
.fc-unthemed .fc-content, /* for gutter border */
.fc-unthemed .fc-popover,
.fc-unthemed .fc-list-view,
.fc-unthemed .fc-list-heading td {
	border-color: #ddd;
}

.fc-unthemed .fc-popover {
	background-color: #fff;
}

.fc-unthemed .fc-divider,
.fc-unthemed .fc-popover .fc-header,
.fc-unthemed .fc-list-heading td {
	background: #eee;
}

.fc-unthemed .fc-popover .fc-header .fc-close {
	color: #666;
}

.fc-unthemed td.fc-today {
	background: #fcf8e3;
}

.fc-highlight { /* when user is selecting cells */
	background: #bce8f1;
	opacity: .3;
}

.fc-bgevent { /* default look for background events */
	background: rgb(143, 223, 130);
	opacity: .3;
}

.fc-nonbusiness { /* default look for non-business-hours areas */
	/* will inherit .fc-bgevent's styles */
	background: #d7d7d7;
}


/* Icons (inline elements with styled text that mock arrow icons)
--------------------------------------------------------------------------------------------------*/

.fc-icon {
	display: inline-block;
	height: 1em;
	line-height: 1em;
	font-size: 1em;
	text-align: center;
	overflow: hidden;
	font-family: "Courier New", Courier, monospace;

	/* don't allow browser text-selection */
	-webkit-touch-callout: none;
	-webkit-user-select: none;
	-khtml-user-select: none;
	-moz-user-select: none;
	-ms-user-select: none;
	user-select: none;
	}

/*
Acceptable font-family overrides for individual icons:
	"Arial", sans-serif
	"Times New Roman", serif

NOTE: use percentage font sizes or else old IE chokes
*/

.fc-icon:after {
	position: relative;
}

.fc-icon-left-single-arrow:after {
	content: "\02039";
	font-weight: bold;
	font-size: 200%;
	top: -28%;
}

.fc-icon-right-single-arrow:after {
	content: "\0203A";
	font-weight: bold;
	font-size: 200%;
	top: -28%;
}

.fc-icon-left-double-arrow:after {
	content: "\000AB";
	font-size: 160%;
	top: -7%;
}

.fc-icon-right-double-arrow:after {
	content: "\000BB";
	font-size: 160%;
	top: -7%;
}

.fc-icon-left-triangle:after {
	content: "\25C4";
	font-size: 125%;
	top: 3%;
}

.fc-icon-right-triangle:after {
	content: "\25BA";
	font-size: 125%;
	top: 3%;
}

.fc-icon-down-triangle:after {
	content: "\25BC";
	font-size: 125%;
	top: 2%;
}

.fc-icon-x:after {
	content: "\000D7";
	font-size: 200%;
	top: 6%;
}
</style>
