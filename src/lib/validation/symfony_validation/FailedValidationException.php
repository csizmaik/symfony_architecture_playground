<?php
/**
 * Created by PhpStorm.
 * User: csizmarik
 * Date: 6/19/2017
 * Time: 7:48 AM
 */

namespace lib\validation\symfony_validation;


use Symfony\Component\Validator\ConstraintViolationListInterface;
use Throwable;

class FailedValidationException extends \Exception
{
	private $constraintViolationList;

	public function __construct($message = "", $code = 0, Throwable $previous = null)
	{
		parent::__construct($message, $code, $previous);
		$this->constraintViolationList = null;
	}

	public function setConstraintViolationList(ConstraintViolationListInterface $constraintViolationList)
	{
		$this->constraintViolationList = $constraintViolationList;
	}

	/**
	 * @return null
	 */
	public function getConstraintViolationList()
	{
		return $this->constraintViolationList;
	}

}