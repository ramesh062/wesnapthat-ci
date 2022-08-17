<?php require("includes/header.php")?>
<!-- Hero -->
<section class="hero_sec">
<div class="container">
	<div class="row">
		<div class="col-md-6">
			<div class="detail">
				<div class="hero_logo"><img src="<?php echo SITE_FRONTEND_IMAGES?>hero_logo.svg" alt=""></div>
				<h1>MonDoc-Patient</h1>
				<p id="header_subtitle">is a digital platform offering appointment booking service for healthcare professionals.</p>                    
				<div class="download_info">
					<a href="#"><img src="<?php echo SITE_FRONTEND_IMAGES?>download_btn1.svg" alt=""></a>
					<a href="#"><img src="<?php echo SITE_FRONTEND_IMAGES?>download_btn2.svg" alt=""></a>
				</div>
			</div>
		</div>
		<div class="col-md-6">
			<figure><img src="<?php echo SITE_FRONTEND_IMAGES?>hero_image.png" alt=""></figure>
		</div>
	</div>
</div>
</section>

<!-- Welcome -->
<section class="welcome_sec">
<div class="container">
	<div class="row flex-row-reverse align-items-center">
		<div class="col-md-6">
			<div class="detail">
				<h2 class="title green" id="section1_title"><small>SEARCH For</small> your practitioner </h2>
				<p id="section1_subtitle">from a list of health practitioners (doctors, nurses, laboratories, etc.) registered on the platform. MonDoc-Patient allows you to refine your search according to the name, specialty and location of your practitioner..</p>
			</div>
		</div>
		<div class="col-md-6">
			<figure><img src="<?php echo SITE_FRONTEND_IMAGES?>welcome_img.png" alt=""></figure>
		</div>
	</div>
</div>
</section>

<!-- Booking -->
<section class="booking_sec">
<div class="container">
	<h2 class="title green center" id="section2_title"><small>Appoitment</small> booking</h2>
	<div class="info" id="section2_subtitle" >is carried out according to the availability of practitioners. Once the patient's request has been submitted, the requested practitioner will accept (or not) the appointment before the patient is notified via the application and by email.</div>
	<figure><img src="<?php echo SITE_FRONTEND_IMAGES?>booking_img.png" alt=""></figure>
</div>
</section>

<!-- Download Sec -->
<section class="downalod_sec green">
<div class="container">
	<div class="row">
		<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 align-self-center">
			<h2 class="title white" id="section3_title">Download <br>The Mondoc Patient App</h2>
			<a href="#"><img src="<?php echo SITE_FRONTEND_IMAGES?>download_btn1.svg" alt=""></a>
			<a href="#"><img src="<?php echo SITE_FRONTEND_IMAGES?>download_btn2.svg" alt=""></a>
		</div>
		
		<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
			<figure><img src="<?php echo SITE_FRONTEND_IMAGES?>download_img_1.png" alt=""></figure>
		</div>
	</div>
</div>
</section>

<!-- Summary -->
<section class="summary_sec">
<div class="container">
	<div class="row align-items-center">
		<div class="col-md-6">
			<div class="detail">
				<div class="sum_logo"><img src="<?php echo SITE_FRONTEND_IMAGES?>summary_logo.svg" alt=""></div>
				<h2 id="section4_title">Summary</h2>
				<p id="section4_subtitle">Summary of pending confirmation and upcoming appointments as well as a calendar summarizing the daily schedule.</p>
			</div>
		</div>
		<div class="col-md-6 text-md-end">
			<figure><img src="<?php echo SITE_FRONTEND_IMAGES?>summary_img.png" alt=""></figure>
		</div>
	</div>
</div>
</section>

<!-- Doctor Sec -->
<section class="doctor_sec manage">
<div class="container">
	<div class="row flex-row-reverse">
		<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 align-self-center">
			<h2 class="title" id="section5_title"><small>mondoc doctor app</small>Manage your schedule</h2>
			<p id="section5_subtitle">Manage your schedule with access to all appointments (pending confirmation, upcoming and completed) and their details.</p>
		</div>
		
		<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
			<figure><img src="<?php echo SITE_FRONTEND_IMAGES?>manage_img.png" alt=""></figure>
		</div>
	</div>
</div>
</section>

<!-- Doctor Sec -->
<section class="doctor_sec">
<div class="container">
	<div class="row">
		<div class="col-xl-7 col-lg-7 col-md-7 col-sm-12 align-self-center">
			<h2 class="title" id="section6_title"><small>mondoc doctor app</small>Setting up your availability</h2>
			<p id="section6_subtitle" >Setting up your availablity by choosing the duration <br>of the consultations and the days of rest.</p>
		</div>
		
		<div class="col-xl-5 col-lg-5 col-md-5 col-sm-12">
			<figure><img src="<?php echo SITE_FRONTEND_IMAGES?>doctor_img.png" alt=""></figure>
		</div>
	</div>
</div>
</section>

<!-- Download Sec -->
<section class="downalod_sec">
<div class="container">
	<div class="row">
		<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 align-self-center">
			<h2 class="title white" id= "section7_title" >Download <br>The Mondoc Praticien App</h2>
			<a href="#"><img src="<?php echo SITE_FRONTEND_IMAGES?>download_btn1.svg" alt=""></a>
			<a href="#"><img src="<?php echo SITE_FRONTEND_IMAGES?>download_btn2.svg" alt=""></a>
		</div>
		
		<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
			<figure><img src="<?php echo SITE_FRONTEND_IMAGES?>download_img.png" alt=""></figure>
		</div>
	</div>
</div>
</section>

<!-- Footer -->
<?php require("includes/footer.php")?>
<script>
	$(function(){
		if(selectedLangauge == "En"){
			$("#langid1").addClass("switch-button-case active-case");
			$("#langid2").removeClass("active-case");
		}else{
			$("#langid2").addClass("switch-button-case active-case");
			$("#langid1").removeClass("active-case");
		}
	});		
	let selectedLangauge = localStorage.getItem("selectedLanguage");
	if(selectedLangauge != "En" || selectedLangauge != "Fr") {
		//localStorage.setItem("selectedLanguage", "Fr");
	}
	function change_language(lang){
		localStorage.setItem("selectedLanguage", lang);
		location.reload();
	}

 	if(selectedLangauge == "En"){
		document.getElementById("header_subtitle").innerHTML =  "is a digital platform offering appointment booking service for healthcare professionals.";
		//SECTION 1
		document.getElementById("section1_title").innerHTML =   "<small>SEARCH For</small> your practitioner";
		document.getElementById("section1_subtitle").innerHTML =   "from a list of health practitioners (doctors, nurses, laboratories, etc.) registered on the platform. MonDoc-Patient allows you to refine your search according to the name, specialty and location of your practitioner..";
		//SECTION2 
		document.getElementById("section2_title").innerHTML =   "<small>Appoitment</small> booking";
		document.getElementById("section2_subtitle").innerHTML =   "is carried out according to the availability of practitioners. Once the patient's request has been submitted, the requested practitioner will accept (or not) the appointment before the patient is notified via the application and by email.";
		//SECTION3
		document.getElementById("section3_title").innerHTML =   "Download <br>The Mondoc Patient App";

		//SECTION4
		document.getElementById("section4_title").innerHTML =   "Summary";
		document.getElementById("section4_subtitle").innerHTML =   "Summary of pending confirmation and upcoming appointments as well as a calendar summarizing the daily schedule.";

		//SECTION5
		document.getElementById("section5_title").innerHTML =   "<small>mondoc doctor app</small>Manage your schedule";
		document.getElementById("section5_subtitle").innerHTML =   "Manage your schedule with access to all appointments (pending confirmation, upcoming and completed) and their details.";

		//SECTION6
		document.getElementById("section6_title").innerHTML =   "<small>mondoc doctor app</small>Setting up your availability";
		document.getElementById("section6_subtitle").innerHTML =   "Setting up your availablity by choosing the duration <br>of the consultations and the days of rest.";

		//SECTION7
		document.getElementById("section7_title").innerHTML =   "Download <br>The Mondoc Praticien App";

		//SECTION8
		document.getElementById("section8_subtitle").innerHTML =   "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod ncididunt ut labore et dolore";
		
		
	}else{
		document.getElementById("header_subtitle").innerHTML =  "est une plateforme digitale qui propose un service de prise de RDV auprès des professionnels de santé."
		//SECTION 1
		document.getElementById("section1_title").innerHTML =   "<small>Rechercher</small> votre praticien";
		document.getElementById("section1_subtitle").innerHTML =   "parmi une liste de praticiens de santé (médecins, infirmiers, laboratoires, etc.) inscrits sur la plateforme. MonDoc-Patient vous permet d’affiner votre recherche selon le nom, la spécialité et la localisation de votre praticien.";
		//SECTION2 
		document.getElementById("section2_title").innerHTML =   "<small>La</small> prise de RDV";
		document.getElementById("section2_subtitle").innerHTML =   "s’effectue selon les disponibilités des praticiens. Une fois la demande du patient soumise, le praticien sollicité acceptera (ou non) la demande avant que le patient soit notifié via l’application et par email.";
		//SECTION3
		document.getElementById("section3_title").innerHTML =   "Télécharger <br>L'application patient Mondoc";

		//SECTION4
		document.getElementById("section4_title").innerHTML =   "Synthèse";
		document.getElementById("section4_subtitle").innerHTML =   "des RDV en attente de confirmation et à venir ainsi qu’un calendrier de recapitulant les RDV quotidien.";

		//SECTION5
		document.getElementById("section5_title").innerHTML =   "<small>mondoc doctor app</small>Gérer son planning";
		document.getElementById("section5_subtitle").innerHTML =   "avec l’accès à tous les RDV (en attente de confirmation, à venir et réalisés) et leurs détails.";

		//SECTION6
		document.getElementById("section6_title").innerHTML =   "<small>mondoc doctor app</small>Paramétrer ses disponibilités";
		document.getElementById("section6_subtitle").innerHTML =   "en choisissant la durée des consultations et les <br>jours de repos.";

		//SECTION7
		document.getElementById("section7_title").innerHTML =   "Télécharger <br>L'application Mondoc Praticien";

		//SECTION8
		document.getElementById("section8_subtitle").innerHTML =   "Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod ncididunt ut labore et dolore";
	}
</script>
</body>
</html>
