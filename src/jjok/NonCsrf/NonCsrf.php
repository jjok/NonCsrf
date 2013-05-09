<?php

/**
 * Copyright (c) 2013 Jonathan Jefferies
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to
 * deal in the Software without restriction, including without limitation the
 * rights to use, copy, modify, merge, publish, distribute, sublicense, and/or
 * sell copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING
 * FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS
 * IN THE SOFTWARE.
 */

namespace jjok\NonCsrf;

/**
 * Basic CSRF measures.
 * @package jjok\NonCsrf
 * @author Jonathan Jefferies (jjok)
 * @version 1.0.0
 */
class NonCsrf {
	
	/**
	 * A reference to the session.
	 * @var array
	 */
	protected $session;
	
	/**
	 * The array key to store the token in the session with.
	 * @var string
	 */
	protected $session_namespace;
	
	/**
	 * Set required properties.
	 * @param array $session A reference to the session.
	 * @param string $session_namespace The array key to store the token in the session with.
	 */
	public function __construct(array &$session, $session_namespace) {
		$this->session =& $session;
		$this->session_namespace = $session_namespace;
	}
	
	/**
	 * Set a new token.
	 * @param Token $token
	 */
	public function setToken(Token $token) {
		$this->session[$this->session_namespace] = serialize($token);
	}

	/**
	 * Get the current token.
	 * @return Token
	 */
	public function getToken() {
		if(isset($this->session[$this->session_namespace])) {
			return unserialize($this->session[$this->session_namespace]);
		}
		
		return null;
	}

	/**
	 * Check if the given token is the same as the stored token, and that
	 * the stored token is still valid.
	 * @param Token $token The token to check.
	 * @return boolean
	 */
	public function checkToken(Token $token) {
		$saved_token = $this->getToken();
		
		return (string) $token == (string) $saved_token && $saved_token->isValid();
	}
}
