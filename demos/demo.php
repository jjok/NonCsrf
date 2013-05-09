<?php

require_once '../src/jjok/NonCsrf/NonCsrf.php';
require_once '../src/jjok/NonCsrf/Token.php';

session_start();

$non_csrf = new \jjok\NonCsrf\NonCsrf($_SESSION, 'csrf_token');
$message = '';

# Form was posted
if(isset($_POST['token'])) {
	
	# Check the posted token is still valid
	if($non_csrf->checkToken(new \jjok\NonCsrf\Token($_POST['token']))) {
		$message = 'token valid';
	}
	# Posted token is not valid
	else {
		$message = 'token invalid';
	}
}

# Create a new token
$non_csrf->setToken(\jjok\NonCsrf\Token::generate());
$token = $non_csrf->getToken();

?>

<!DOCTYPE html>
<html lang="en-GB">
<head>
<title>NonCsrf Demo</title>
</head>
<body>
	<?php echo $message; ?>
	<form method="post" action="demo.php">
		<input type="submit" />
		<input type="hidden" name="token" value="<?php echo $token; ?>" />
	</form>
</body>
</html>
