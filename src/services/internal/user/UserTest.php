<?php
/**
 * Created by PhpStorm.
 * User: csizmarik
 * Date: 4/3/2017
 * Time: 11:24 AM
 */

namespace services\internal\user;


use lib\validation\ValidationFailedException;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
	const TOO_SHORT_LOGIN = "a";
	const GOOD_PASS = "secret1";
	const WRONG_PASS = "wrongpass";
	const EMPTY_PASS = "";

	/**
	 * @test
	 */
	public function userWithTooShortLoginNameShouldThrowException()
	{
		$this->expectException(\InvalidArgumentException::class);
		$user = new User(1,"Csizmarik Norbert",self::TOO_SHORT_LOGIN,self::GOOD_PASS);
	}

	/**
	 * @test
	 */
	public function userWithEmptyPasswordShouldThrowException()
	{
		$this->expectException(ValidationFailedException::class);
		$user = new User(1,"Csizmarik Norbert","norbi",self::EMPTY_PASS);
	}

	/**
	 * @test
	 */
	public function shouldBeValidCredential()
	{
		$user = $this->getAUser();
		$credentialValidationResult = $user->validateCredential(self::GOOD_PASS);
		$this->assertTrue($credentialValidationResult->isSuccess());
	}

	/**
	 * @test
	 */
	public function shouldBeFailedCredentialValidationWithWrongPassword()
	{
		$user = $this->getAUser();
		$credentialValidationResult = $user->validateCredential(self::WRONG_PASS);
		$this->assertFalse($credentialValidationResult->isSuccess());
	}

	/**
	 * @test
	 */
	public function shouldBeFailedCredentialValidationForInactiveUser()
	{
		$user = $this->getAUser();
		$user->deactivate();
		$credentialValidationResult = $user->validateCredential(self::GOOD_PASS);
		$this->assertFalse($credentialValidationResult->isSuccess());
	}

	/**
	 * @test
	 */
	public function shouldBeFailedCredentialValidationAfterTooMuchUnsuccess()
	{
		$user = $this->getAUser();
		$this->doAnUnsuccessLoginWithotException($user);
		$this->doAnUnsuccessLoginWithotException($user);
		$this->doAnUnsuccessLoginWithotException($user);
		$credentialValidationResult = $user->validateCredential(self::GOOD_PASS);
		$this->assertFalse($credentialValidationResult->isSuccess());
	}

	/**
	 * @test
	 */
	public function shouldActivateUser()
	{
		$user = $this->getAUser();
		$user->deactivate();
		$user->activate();
		$credentialValidationResult = $user->validateCredential(self::GOOD_PASS);
		$this->assertTrue($credentialValidationResult->isSuccess());
	}

	/**
	 * @test
	 */
	public function shouldResetUnsuccessLoginCounter()
	{
		$user = $this->getAUser();
		$this->doAnUnsuccessLoginWithotException($user);
		$this->doAnUnsuccessLoginWithotException($user);
		$this->doAnUnsuccessLoginWithotException($user);
		$user->resetUnsuccessLoginCounter();
		$credentialValidationResult = $user->validateCredential(self::GOOD_PASS);
		$this->assertTrue($credentialValidationResult->isSuccess());
	}

	private function getAUser()
	{
		return new User(1,"Csizmarik Norbert","norbi",self::GOOD_PASS);
	}

	private function doAnUnsuccessLoginWithotException(User $user)
	{
		$credentialValidationResult = $user->validateCredential(self::WRONG_PASS);
		$user->registerCredentialValidationResult($credentialValidationResult->isSuccess(), new \DateTime("now"));
	}
}
