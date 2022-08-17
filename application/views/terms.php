<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="">
<meta name="author" content="">
<meta name="theme-color" content="#FAC678" />
<link rel="shortcut icon" type="image/x-icon" href="favicon.png" />
<title>MonDoc-Patient</title>
<!-- Bootstrap -->
<link href="css/bootstrap.min.css" rel="stylesheet">
<link href="css/style.css" rel="stylesheet">
<link href="css/responsive.css" rel="stylesheet">
<link href="css/font-awesome.css" rel="stylesheet">
</head>
<body>


<div class="container">
    	<div class="row">
        	<div class="col-xl-5 col-lg-5 col-md-4 col-sm-12">

<?php
function callAPI(){
    
    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://mondoc.info/index.php/api/get_cms_content',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => array('page_id' => '2'),
    ));
    $response = curl_exec($curl);
    curl_close($curl);
    return $response;
 }

$make_call = callAPI();
$response = json_decode($make_call, true);


echo "<p>".$response['data']['content'] . "</p>";
	
?>
            </div>
    </div>
</footer>


