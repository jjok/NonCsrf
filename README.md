NonCsrf
=======

[![Build Status](https://travis-ci.org/jjok/NonCsrf.png)](https://travis-ci.org/jjok/NonCsrf)

Basic anti-cross-site request forgery (CSRF) measures.

	$non_csrf = new \jjok\NonCsrf\NonCsrf($_SESSION, 'csrf_token');
	$token = new \jjok\NonCsrf\Token('some random value');
	$non_csrf->setToken(token);

	// Embed the token in a hidden form field or something
	// ...
	
	// Get the token value from a posted form or somewhere
	$token_value = $_POST['token'];
	if($non_csrf->checkToken(new \jjok\NonCsrf\Token(token_value))) {
		echo 'token valid';
	}

TODO
----

* Add support for multiple valid tokens, so multiple tabs can be used at once.
