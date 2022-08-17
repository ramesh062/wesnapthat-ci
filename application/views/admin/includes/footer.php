<?php if($PageName == 'login') { } else { ?>
	<footer></footer>
	<?php } ?> 


<script src="<?php echo SITE_JS ?>app.js<?php echo VER ?>"></script>
<link href="<?php echo SITE_FONTS; ?>" rel="stylesheet">

<?php if(isset($dataTable) && $dataTable == "test"){ ?>
<script type="text/javascript" charset="utf8" src="<?php echo SITE_JS?>jquery.dataTables.js"></script>

 <script>
	$(document).ready(function(){
		$('#table_id').DataTable();
	});
</script>
<?php } ?>
<!-- <script src="https://cdn.onesignal.com/sdks/OneSignalSDK.js" async=""></script>
    <script>
      window.OneSignal = window.OneSignal || [];
      OneSignal.push(function() {
        OneSignal.init({
          appId: "363b9368-268a-420e-802e-fa5363e2402e",
        });
      });
    </script> -->
</body>
</html>
