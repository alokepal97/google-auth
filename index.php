<html>
<head>
<link href="//netdna.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//netdna.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<!------ Include the above in your HEAD tag ---------->
</head>
<body>
<div class="row">

    <div class="col-lg-12">
        <h1 class="page-header">Google Drive</h1>

<?
require_once 'google-api-php/vendor/autoload.php';
session_start();
$client = new Google_Client();
$client->setAuthConfigFile('client_secret_53900403748-evlgcuha9epiuu0jft9ginebu3661bg1.apps.googleusercontent.com.json');
$client->setRedirectUri('http://localhost/google_auth/oauth2callback.php');
$client->addScope(Google_Service_Drive::DRIVE);

if ($_SESSION['access_token'] != null) {
	$access_token = $_SESSION['access_token'];
	$client->setAccessToken($access_token);
	//Refresh the token if it's expired.
	if ($client->isAccessTokenExpired()) {
		session_destroy();
		$redirect_uri = 'http://localhost/google_auth/oauth2callback.php';
		header('Location: '.filter_var($redirect_uri, FILTER_SANITIZE_URL));
	}
	$drive_service = new Google_Service_Drive($client);
	$files_list    = $drive_service->files->listFiles(array())->getFiles();
	echo "<ul>";

	foreach ($files_list as $value) {
		fileview($value->id, $value->name);

	}
} else {
	$redirect_uri = 'http://localhost/google_auth/oauth2callback.php';
	header('Location: '.filter_var($redirect_uri, FILTER_SANITIZE_URL));
}
function fileview($file_id, $file_name) {

	?>
	 <div class="col-lg-3 col-md-4 col-xs-6 thumb">
		 <a class="thumbnail" href="https://drive.google.com/open?id=<?php echo $file_id;?>" data-image-id="" data-toggle="modal" data-title="<?php echo $file_name;?>" data-caption="" data-image="https://drive.google.com/thumbnail?id=<?php echo $file_id;?>" data-target="#image-gallery">
			 <img class="img-responsive" src="https://drive.google.com/thumbnail?id=<?php echo $file_id;?>" alt="">
	<?php echo $file_name;?></a>
	 </div>
	<?
}

?>
</div>
</body>
</html>