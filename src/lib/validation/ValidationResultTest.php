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
	public function testInitiallySuccessResult()
	{
		$validationResult = new ValidationResultContainer();
		$this->assertTrue($validationResult->isSuccess());
	}

	public function testFailedResult()
	{
		$validationResult = new ValidationResultContainer();
		$validationResult->addFailure("Failure message!");
		$this->assertFalse($validationResult->isSuccess());
	}
}
