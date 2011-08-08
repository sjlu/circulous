<?php
include_once('include/config.php');
include_once('register.helpers.php');

$response = array('type' => '', 'message' => '');

if ($_POST['pw'] !== $_POST['confirm'] || is_null($_POST['email'])) // sanity check
{
	$response['type'] = 'error';
	$response['message'] = 'Something went wrong, please refresh and try again.';
}
else
{
	db_query('INSERT INTO users (email, password, verified) VALUES ("%s", AES_ENCRYPT("%s", "%s"), "%s")', $_POST['email'], $_POST['pw'], BLOWFISH_SECRET, 0);
	//TODO: Write any responses that are bad to output.

	send_email_verification($_POST['email']);

	$response['type'] = 'success';
	$response['message'] = 'All good to go! Check your email for the verification link!';
}

echo json_encode($response);
?>