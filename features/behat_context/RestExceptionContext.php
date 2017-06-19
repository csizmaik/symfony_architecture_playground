<?php

namespace behat_context;
/**
 * Created by PhpStorm.
 * User: csizmarik
 * Date: 6/19/2017
 * Time: 5:26 PM
 */
use Behat\Behat\Context\Context;
use services\internal\rest_exception\RestExceptionService;
use Webmozart\Assert\Assert;

class RestExceptionContext implements Context
{
	private $exception;
	private $data;

	/**
	 * @var RestExceptionService
	 */
	private $restExceptionService;

	/**
	 * RestExceptionContext constructor.
	 */
	public function __construct(RestExceptionService $restExceptionService)
	{
		$this->restExceptionService = $restExceptionService;
	}


	/**
	 * @Given /^an "([^"]*)" instance exception$/
	 */
	public function anInstanceException($exceptionType)
	{
		switch ($exceptionType)
		{
			default:
				$this->exception = new \Exception("Test exception",500);
				break;
		}

	}

	/**
	 * @When /^we transform it an array$/
	 */
	public function weTransformItAnArray()
	{
		$this->data = $this->restExceptionService->getDataByException($this->exception);
	}

	/**
	 * @Then /^we get an array with basic exception informations$/
	 */
	public function weGetAnArrayWithBasicExceptionInformations()
	{
		Assert::true(
			isset($this->data["success"]) && $this->data["success"] == "false" &&
			isset($this->data["code"]) && $this->data["code"] == "500"
		);
	}


}