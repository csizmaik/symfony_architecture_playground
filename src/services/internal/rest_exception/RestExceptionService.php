<?php
/**
 * Created by PhpStorm.
 * User: csizmarik
 * Date: 6/19/2017
 * Time: 5:13 PM
 */

namespace services\internal\rest_exception;


class RestExceptionService
{
	public function getDataByException(\Exception $exception)
	{
		return [
			"code" => ExceptionToErrorCode::getCodeFor(get_class($exception)),
			"success" => "false",
			"data" => [
				"message" => $exception->getMessage()
			]
		];
	}
}