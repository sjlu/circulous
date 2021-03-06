<?php
$response = array('type' => '', 'message' => '');

if ($_POST['pw'] !== $_POST['confirm'] || is_null($_POST['email'])) // sanity check
{
	$response['type'] = 'error';
	$response['message'] = 'Something went wrong, please refresh and try again.';
}
else
{
   $_POST['email'] = strtolower($_POST['email']);
   // this is done reversely -- password can decrypt string which must match our blowfish_secret
	db_query('INSERT INTO users (email, password, verified) VALUES ("%s", AES_ENCRYPT("%s", "%s"), "%s")', $_POST['email'], BLOWFISH_SECRET, $_POST['pw'], 0);
	//TODO: Write any responses that are bad to output.

	send_email_verification($_POST['email']); // we send email out when we've added it to our database.
   $_SESSION['has_registered'] = 1;

	$response['type'] = 'success';
	$response['message'] = 'All good to go! Check your email for the verification link!';
}

echo json_encode($response);
?>