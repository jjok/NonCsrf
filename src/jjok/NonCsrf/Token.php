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

use DateTime;

/**
 * A CSRF token.
 * @package jjok\NonCsrf
 * @author Jonathan Jefferies (jjok)
 * @version 1.0.0
 */
class Token {
	
	/**
	 * The token value.
	 * @var string
	 */
	protected $value;

	/**
	 * The expiration time of the token.
	 * @var DateTime
	 */
	protected $expires;

	/**
	 * Set the value and expiration time of the token. 
	 * @param string $value
	 * @param DateTime $expires
	 */
	public function __construct($value, DateTime $expires = null) {
		$this->value = $value;
		$this->expires = $expires;
	}

	/**
	 * Convert the token to a string.
	 * @return string
	 */
	public function __toString() {
		return $this->value;
	}

	/**
	 * Get the expiration time of the token.
	 * @return \DateTime
	 */
	public function getExpiration() {
		return $this->expires;
	}

	/**
	 * Check that the token has not expired.
	 * @return boolean
	 */
	public function isValid() {
		return $this->expires == null ||
			$this->expires->getTimestamp() > time();
	}
	
	/**
	 * Generate a new token with a random value.
	 * @param DateTime $expires The expiration date of the token.
	 * @return \jjok\NonCsrf\Token
	 */
	public static function generate(DateTime $expires = null) {
		//TODO
		$token = uniqid();
		return new static($token, $expires);
	}
}
