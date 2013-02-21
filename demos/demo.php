<?php

require_once '../src/jjok/NonCsrf/NonCsrf.php';
require_once '../src/jjok/NonCsrf/Token.php';

session_start();

$non_csrf = new \jjok\NonCsrf\NonCsrf($_SESSION, 'csrf_token');

# Create a new token
if(empty($_POST['token'])) {
	$non_csrf->setToken(\jjok\NonCsrf\Token::generate());
}
# Check the posted token is still valid
elseif($non_csrf->checkToken(new \jjok\NonCsrf\Token($_POST['token']))) {
	echo 'token valid';
}
# Posted token is not valid
else {
	echo 'token invalid';
}

$token = $non_csrf->getToken();

?>

<!DOCTYPE html>
<html lang="en-GB">
<head>
<title>NonCsrf Demo</title>
</head>
<body>
	<form method="post" action="demo.php">
		<input type="submit" />
		<input type="hidden" name="token" value="<?php echo $token; ?>" />
	</form>
</body>
</html>
