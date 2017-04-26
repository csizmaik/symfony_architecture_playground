<?php
/**
 * Created by PhpStorm.
 * User: csizmarik
 * Date: 4/26/2017
 * Time: 4:14 PM
 */

namespace lib\validation;


class ValidationFailedException extends \Exception
{
	private $failReasons;

	public function __construct($message = "", $code = 0, \Exception $previous = null)
	{
		parent::__construct($message, $code, $previous);
	}

	public function setFailReasons($failReasons)
	{
		$this->failReasons = $failReasons;
	}

	public function getFailReasons()
	{
		return $this->failReasons;
	}
}