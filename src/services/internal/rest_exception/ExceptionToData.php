<?php
/**
 * Created by PhpStorm.
 * User: csizmarik
 * Date: 6/19/2017
 * Time: 6:25 PM
 */

namespace services\internal\rest_exception;

use lib\validation\symfony_validation\FailedValidationException;
use Symfony\Component\Validator\ConstraintViolation;

class ExceptionToData
{
	public static function getDataFromException(\Exception $exception)
	{
		if ($exception instanceof FailedValidationException)
		{
			return self::getDataFromValidationFailedException($exception);
		}
		return [
			"message" => $exception->getMessage()
		];
	}

	private static function getDataFromValidationFailedException(FailedValidationException $failedValidationException)
	{
		$errors = [];
		/** @var ConstraintViolation $violation */
		foreach ($failedValidationException->getConstraintViolationList() as $violation) {
			$errors[$violation->getPropertyPath()] = $violation->getMessage();
		}
		return [
			"message" => $failedValidationException->getMessage(),
			"errors" => $errors
		];
	}
}