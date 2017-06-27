<?php
/**
 * Created by PhpStorm.
 * User: csizmarik
 * Date: 6/19/2017
 * Time: 6:15 PM
 */

namespace services\internal\rest_exception;

use PHPUnit\Framework\TestCase;
use lib\validation\symfony_validation\FailedValidationException;


class ExceptionToErrorCodeTest extends TestCase
{
	/**
	 * @test
	 */
	public function basicExceptionShouldBeTranslatedTo500() {
		$this->assertEquals(500,ExceptionToErrorCode::getCodeFor(\Exception::class));
	}

	/**
	 * @test
	 */
	public function failedValidationExceptionShouldBeTranslatedTo400() {
		$this->assertEquals(400,ExceptionToErrorCode::getCodeFor(FailedValidationException::class));
	}
}
