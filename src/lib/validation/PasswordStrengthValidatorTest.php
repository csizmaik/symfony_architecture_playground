<?php
/**
 * Created by PhpStorm.
 * User: csizmarik
 * Date: 5/8/2017
 * Time: 3:47 PM
 */

namespace lib\validation;

use PHPUnit\Framework\TestCase;

class PasswordStrengthValidatorTest extends TestCase
{
	const VALID_PASSWORD = 'secret1';
	const TOO_SHORT_PASSWORD = 'a1';
	const PASSWORD_WITHOUT_LETTER = '11111';
	const PASSWORD_WITHOUT_NUMBER = 'aaaaa';

	/**
	 * @test
	 */
	public function shouldBeValid() {
		$this->validateGoodPassword(self::VALID_PASSWORD);
	}

	/**
	 * @test
	 */
	public function shortPasswordShouldBeInvalid() {
		$this->validateWrongPassword(self::TOO_SHORT_PASSWORD);
	}

	/**
	 * @test
	 */
	public function passwordWithoutLetterShouldBeInvalid() {
		$this->validateWrongPassword(self::PASSWORD_WITHOUT_LETTER);
	}

	/**
	 * @test
	 */
	public function passwordWithoutNumberShouldBeInvalid() {
		$this->validateWrongPassword(self::PASSWORD_WITHOUT_NUMBER);
	}

	/**
	 * @param $password
	 */
	private function validateGoodPassword($password)
	{
		$validationResult = $this->validatePassword($password);
		$this->assertTrue($validationResult->isSuccess());
	}

	/**
	 * @param $password
	 */
	private function validateWrongPassword($password)
	{
		$validationResult = $this->validatePassword($password);
		$this->assertFalse($validationResult->isSuccess());
	}

	/**
	 * @param $password
	 * @return ValidationResultContainer
	 */
	private function validatePassword($password)
	{
		$valdator = new PasswordStrengthValidator($password);
		$validationResult = $valdator->getValidationResult();
		return $validationResult;
	}


}
