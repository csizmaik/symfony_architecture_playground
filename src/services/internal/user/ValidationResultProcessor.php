<?php
/**
 * Created by PhpStorm.
 * User: csizmarik
 * Date: 6/19/2017
 * Time: 7:51 AM
 */

namespace services\internal\user;


use Symfony\Component\Validator\ConstraintViolationListInterface;

class ValidationResultProcessor
{
	public static function processConstraintViolationList(ConstraintViolationListInterface $constraintViolationList)
	{
		if ($constraintViolationList->count() > 0) {
			$exception = new FailedValidationException("Validation failed");
			$exception->setConstraintViolationList($constraintViolationList);
			throw $exception;
		}
	}
}