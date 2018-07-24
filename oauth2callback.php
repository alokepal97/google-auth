<?
require_once 'google-api-php/vendor/autoload.php';

session_start();

$client = new Google_Client();
$client->setAuthConfigFile('client_secret_53900403748-evlgcuha9epiuu0jft9ginebu3661bg1.apps.googleusercontent.com.json');
$client->setRedirectUri('http://localhost/google_auth/oauth2callback.php');
$client->addScope(Google_Service_Drive::DRIVE);

if (!isset($_GET['code'])) {
	$auth_url = $client->createAuthUrl();
	header('Location: '.filter_var($auth_url, FILTER_SANITIZE_URL));
} else {
	$client->authenticate($_GET['code']);
	$_SESSION['access_token'] = $client->getAccessToken();
	$redirect_uri             = 'http://localhost/google_auth/';
	header('Location: '.filter_var($redirect_uri, FILTER_SANITIZE_URL));
}