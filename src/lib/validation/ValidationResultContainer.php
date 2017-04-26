<?php
/**
 * Created by PhpStorm.
 * User: csizmarik
 * Date: 4/6/2017
 * Time: 5:25 PM
 */

namespace lib\validation;


class ValidationResultContainer
{
	private $isValid;
	private $failReasons;

	public function __construct()
	{
		$this->isValid = true;
		$this->failReasons = array();
	}

	public function isSuccess()
	{
		return $this->isValid;
	}

	public function addFailure($failMessage)
	{
		$this->isValid = false;
		$this->failReasons[] = $failMessage;
	}

	public function getFailureReasons()
	{
		return $this->failReasons;
	}

	public function validate($exceptionMessage)
	{
		if (!$this->isSuccess())
		{
			$exception = new ValidationFailedException($exceptionMessage);
			$exception->setFailReasons($this->getFailureReasons());
			throw $exception;
		}
		return true;
	}
}