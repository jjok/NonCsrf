<?php

require_once 'src/jjok/NonCsrf/NonCsrf.php';
require_once 'src/jjok/NonCsrf/Token.php';

class NonCsrfTest extends PHPUnit_Framework_TestCase {

	private $session;

	public function setUp() {
		$this->session = array();
	}

	/**
	 * @covers jjok\NonCsrf\NonCsrf::__construct
	 * @covers jjok\NonCsrf\NonCsrf::getToken
	 */
	public function testTokenIsNullIfNotSet() {
		$non_csrf = new jjok\NonCsrf\NonCsrf($this->session, 'blah');
		$this->assertNull($non_csrf->getToken());
	}

	/**
	 * @covers jjok\NonCsrf\NonCsrf::__construct
	 * @covers jjok\NonCsrf\NonCsrf::setToken
	 * @covers jjok\NonCsrf\NonCsrf::getToken
	 */
	public function testTokenCanBeSet() {
		$non_csrf = new jjok\NonCsrf\NonCsrf($this->session, 'blah');
		$non_csrf->setToken(new jjok\NonCsrf\Token('test token'));

		$this->assertInstanceOf('jjok\NonCsrf\Token', $non_csrf->getToken());
	}

	/**
	 * @covers jjok\NonCsrf\NonCsrf::__construct
	 * @covers jjok\NonCsrf\NonCsrf::setToken
	 */
	public function testTokenIsStoredInSession() {
		$non_csrf = new jjok\NonCsrf\NonCsrf($this->session, 'some_array_key');
		$non_csrf->setToken(new jjok\NonCsrf\Token('test token'));

		$this->assertArrayHasKey('some_array_key', $this->session);
		$this->assertInstanceOf('jjok\NonCsrf\Token', unserialize($this->session['some_array_key']));
	}

	/**
	 * @covers jjok\NonCsrf\NonCsrf::__construct
	 * @covers jjok\NonCsrf\NonCsrf::setToken
	 * @covers jjok\NonCsrf\NonCsrf::checkToken
	 */
	public function testCheckTokenTrueForSameToken() {
		$non_csrf = new jjok\NonCsrf\NonCsrf($this->session, 'blah');
		$non_csrf->setToken(new jjok\NonCsrf\Token('test token'));
		
		$this->assertTrue($non_csrf->checkToken(new jjok\NonCsrf\Token('test token')));
	}
	
	/**
	 * @covers jjok\NonCsrf\NonCsrf::__construct
	 * @covers jjok\NonCsrf\NonCsrf::setToken
	 * @covers jjok\NonCsrf\NonCsrf::checkToken
	 */
	public function testCheckTokenFalseForDifferentToken() {
		$non_csrf = new jjok\NonCsrf\NonCsrf($this->session, 'blah');
		$non_csrf->setToken(new jjok\NonCsrf\Token('test token'));
		
		$this->assertFalse($non_csrf->checkToken(new jjok\NonCsrf\Token('another token')));
	}

	/**
	 * @covers jjok\NonCsrf\NonCsrf::__construct
	 * @covers jjok\NonCsrf\NonCsrf::setToken
	 * @covers jjok\NonCsrf\NonCsrf::checkToken
	 */
	public function testCheckTokenTrueforNonExpiredSameToken() {
		$non_csrf = new jjok\NonCsrf\NonCsrf($this->session, 'blah');
		$non_csrf->setToken(
			new jjok\NonCsrf\Token(
				'test token',
				new DateTime('tomorrow')
			)
		);
		$this->assertTrue($non_csrf->checkToken(new jjok\NonCsrf\Token('test token')));
	}

	/**
	 * @covers jjok\NonCsrf\NonCsrf::__construct
	 * @covers jjok\NonCsrf\NonCsrf::setToken
	 * @covers jjok\NonCsrf\NonCsrf::checkToken
	 */
	public function testCheckTokenFalseforExpiredToken() {
		$non_csrf = new jjok\NonCsrf\NonCsrf($this->session, 'blah');
		$non_csrf->setToken(
			new jjok\NonCsrf\Token(
				'test token',
				new DateTime('yesterday')
			)
		);
		$this->assertFalse($non_csrf->checkToken(new jjok\NonCsrf\Token('test token')));
	}
}
