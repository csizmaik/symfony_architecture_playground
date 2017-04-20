<?php
/**
 * Created by PhpStorm.
 * User: csizmarik
 * Date: 4/20/2017
 * Time: 12:02 PM
 */

namespace behat_context;

use Behat\Behat\Context\Context;
use Behat\Behat\Tester\Exception\PendingException;

class UserContext implements Context
{

	/**
	 * @Given /^no user with loginname "([^"]*)" exists$/
	 */
	public function noUserWithLoginnameExists($loginName)
	{
		throw new PendingException();
	}

	/**
	 * @When /^the user tries to register with name "([^"]*)" "([^"]*)", email "([^"]*)" and password "([^"]*)"$/
	 */
	public function theUserTriesToRegisterWithNameEmailAndPassword($surname, $forename, $email, $password)
	{
		throw new PendingException();
	}

	/**
	 * @Then /^the user with login name "([^"]*)" created$/
	 */
	public function theUserWithLoginNameCreated($login)
	{
		throw new PendingException();
	}
}