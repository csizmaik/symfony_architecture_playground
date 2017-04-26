<?php
/**
 * Created by PhpStorm.
 * User: csizmarik
 * Date: 4/7/2017
 * Time: 10:16 AM
 */

namespace lib\validation;

use PHPUnit\Framework\TestCase;

class ValidationResultTest extends TestCase
{
	/**
	 * @test
	 */
	public function shouldInitiallySuccess()
	{
		$validationResult = new ValidationResultContainer();
		$this->assertTrue($validationResult->isSuccess());
	}

	/**
	 * @test
	 */
	public function shouldFail()
	{
		$validationResult = new ValidationResultContainer();
		$validationResult->addFailure("Failure message!");
		$this->assertFalse($validationResult->isSuccess());
	}

	/**
	 * @test
	 */
	public function failedResultShouldThrowException()
	{
		$this->expectException(ValidationFailedException::class);
		$validationResult = new ValidationResultContainer();
		$validationResult->addFailure("Failure message!");
		$validationResult->validate("Validation exception message");
	}

	/**
	 * @test
	 */
	public function successResultShouldNotThrowException()
	{
		$validationResult = new ValidationResultContainer();
		$validationResult->validate("Validation exception message");
		$this->assertTrue(true);
	}
}
