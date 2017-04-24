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
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\SchemaTool;
use services\internal\auth\AuthenticationFailedException;
use services\internal\auth\AuthService;
use services\internal\user\UserRepository;
use services\internal\user\UserService;

class UserContext implements Context
{
	/**
	 * @var UserService
	 */
	private $userService;
	/**
	 * @var UserRepository
	 */
	private $userRepository;

	private $authService;

	private $entityManager;

	private $registrationResult;
	private $successLogin;

	/**
	 * UserContext constructor.
	 */
	public function __construct(EntityManager $entityManager, UserRepository $userRepository, UserService $userService, AuthService $authService)
	{
		$this->entityManager = $entityManager;
		$this->userRepository = $userRepository;
		$this->userService = $userService;
		$this->authService = $authService;
	}

	/**
	 * @BeforeScenario
	 */
	public function initDataBase()
	{
		$this->entityManager->clear();
		$schemaTool = new SchemaTool($this->entityManager);
		$classes = $this->entityManager->getMetadataFactory()->getAllMetadata();
		$schemaTool->dropSchema($classes);
		$schemaTool->createSchema($classes);
	}

	/**
	 * @Given /^a user base where "([^"]*)" loginname hasn't registered yet$/
	 */
	public function aUserBaseWhereLoginnameHasnTRegisteredYet($loginName)
	{
		if ($this->userRepository->isUserExistsWithLogin($loginName))
		{
			$this->userRepository->removeUserByLoginName($loginName);
		}
	}

	/**
	 * @When /^the user "([^"]*)" tries to register with "([^"]*)" loginname and "([^"]*)" password$/
	 */
	public function theUserTriesToRegisterWithLoginnameAndPassword($name, $login, $password)
	{
		try {
			$this->registrationResult = $this->userService->registerUser($name, $login, $password);
		} catch (\Exception $exception) {
			$this->registrationResult = $exception;
		}
	}

	/**
	 * @Then /^the registration is "([^"]*)"$/
	 */
	public function theRegistrationIs($expectedRegistrationResult)
	{
		switch ($expectedRegistrationResult) {
			case 'success':
				\PHPUnit\Framework\Assert::assertGreaterThan(0, $this->registrationResult);
				break;
			case 'failed':
				\PHPUnit\Framework\Assert::assertInstanceOf("Exception", $this->registrationResult);
				break;
		}
	}

	/**
	 * @Given /^a registered user with "([^"]*)" loginname and "([^"]*)" password$/
	 */
	public function aRegisteredUserWithLoginnameAndPassword($login, $password)
	{
		if (!$this->userRepository->isUserExistsWithLogin($login))
		{
			$this->userService->registerUser("Existing User",$login,$password);
		}
	}

	/**
	 * @When /^"([^"]*)" user tries to login with "([^"]*)" password$/
	 */
	public function userTriesToLoginWithPassword($login, $password)
	{
		try {
			$this->authService->login($login, $password);
			$this->successLogin = true;
		} catch (AuthenticationFailedException $exception) {
			$this->successLogin = false;
		}
	}

	/**
	 * @Then /^the login is "([^"]*)"$/
	 */
	public function theLoginIs($expectedResult)
	{
		switch ($expectedResult) {
			case 'success':
				\PHPUnit\Framework\Assert::assertTrue($this->successLogin);
				break;
			case 'failed':
				\PHPUnit\Framework\Assert::assertFalse($this->successLogin);
				break;
		}
	}

	/**
	 * @Given /^"([^"]*)" user is deactivated$/
	 */
	public function userIsDeactivated($loginName)
	{
		$this->userService->deactivateUserByLogin($loginName);
	}

	/**
	 * @Given /^reset unsuccess login counter for "([^"]*)" user$/
	 */
	public function resetUnsuccessLoginCounterForUser($login)
	{
		/** @var \services\internal\user\User $user */
		$user = $this->userRepository->getUserByLoginName($login);
		$this->userService->resetUnsuccessLoginCounterByUserId($user->getId());
	}

}