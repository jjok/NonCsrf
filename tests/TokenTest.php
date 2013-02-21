<?php

require_once 'src/jjok/NonCsrf/Token.php';

class TokenTest extends PHPUnit_Framework_TestCase {
	
	/**
	 * @covers \jjok\NonCsrf\Token::__construct
	 * @covers \jjok\NonCsrf\Token::__toString
	 */
	public function testTokenValueCanBeSet() {
		$token = new \jjok\NonCsrf\Token('some value');
		$this->assertSame('some value', (string) $token);
	}

	/**
	 * @covers \jjok\NonCsrf\Token::__construct
	 * @covers \jjok\NonCsrf\Token::getExpiration
	 */
	public function testExpirationCanBeSet() {
		$expires = new DateTime();
		$expires->add(new DateInterval('PT1M'));
		$token = new \jjok\NonCsrf\Token('some value', $expires);
		$this->assertInstanceof('\DateTime', $token->getExpiration());
	}
	
	/**
	 * @covers \jjok\NonCsrf\Token::isValid
	 */
	public function testTokenIsValidIfExpirationNull() {
		$token = new \jjok\NonCsrf\Token('some value');
		$this->assertTrue($token->isValid());
	}
	
	/**
	 * @covers \jjok\NonCsrf\Token::isValid
	 */
	public function testTokenIsValidUntilExpiration() {
		$expires = new DateTime();
		$expires->add(new DateInterval('PT1S'));
		
		$token = new \jjok\NonCsrf\Token('some value', $expires);
		$this->assertTrue($token->isValid());
		
		sleep(1);
		$this->assertFalse($token->isValid());
	}

	/**
	 * @covers \jjok\NonCsrf\Token::generate
	 */
	public function testRandomTokenCanBeGenerated() {
		$token = jjok\NonCsrf\Token::generate();
		$this->assertNotEmpty((string) $token);
		$this->assertNull($token->getExpiration());
	}
	
	/**
	 * @covers \jjok\NonCsrf\Token::generate
	 */
	public function testRandomTokenCanBeGeneratedWithExpiration() {	
		$expires = new DateTime();
		$expires->add(new DateInterval('PT10M'));
	
		$token2 = jjok\NonCsrf\Token::generate($expires);
		$this->assertNotEmpty((string) $token2);
		$this->assertSame(
				$expires->getTimestamp(),
				$token2->getExpiration()->getTimestamp()
		);
	}
}
