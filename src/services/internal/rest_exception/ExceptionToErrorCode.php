<?php
/**
 * Created by PhpStorm.
 * User: csizmarik
 * Date: 6/19/2017
 * Time: 6:07 PM
 */

namespace services\internal\rest_exception;

use lib\validation\symfony_validation\FailedValidationException;
use Symfony\Component\HttpFoundation\Response;

class ExceptionToErrorCode
{
	public static function getCodeFor($exceptionClass)
	{
		switch ($exceptionClass) {
			case FailedValidationException::class:
				return Response::HTTP_BAD_REQUEST;
				break;
			case \Exception::class:
			default:
				return Response::HTTP_INTERNAL_SERVER_ERROR;
				break;
		}
	}
}