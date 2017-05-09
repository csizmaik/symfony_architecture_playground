<?php
/**
 * Created by PhpStorm.
 * User: csizmarik
 * Date: 3/25/2017
 * Time: 7:36 AM
 */

namespace services\internal\user;

use Doctrine\Common\Collections\ArrayCollection;
use lib\validation\PasswordStrengthValidator;
use lib\validation\ValidationResultContainer;

class User
{
	const MAX_UNSUCCESS_LOGIN = 3;
	private $id;
	private $userId;
	private $name;
	private $login;
	private $password;
	private $active = true;
	private $unsuccessLoginCount = 0;
	private $lastSuccessLogin = null;
	private $emailContacts;

	/**
	 * User constructor.
	 * @param $userId
	 * @param $name
	 * @param $login
	 * @param $password
	 */
	public function __construct($userId, $name, $login, $password)
	{
		$this->userId = $userId;
		$this->setName($name);
		$this->setLogin($login);
		$this->setPassword($password);
		$this->emailContacts = new ArrayCollection();
	}

	public function validateCredential($password)
	{
		$validationResult = new ValidationResultContainer();
		if ($this->isMaxUnsuccessLoginReached())
		{
			$validationResult->addFailure("Maximum unsuccess login reached!");
		}
		if ($password != $this->password)
		{
			$validationResult->addFailure("Wrong password");
		}
		if (!$this->isActive())
		{
			$validationResult->addFailure("Inactive user can't login!");
		}
		return $validationResult;
	}

	public function registerCredentialValidationResult($successValidation, \DateTime $validationDate)
	{
		if ($successValidation)
		{
			$this->registerSuccessLoginAt($validationDate);
		}
		else
		{
			$this->registerFailedLogin();
		}
	}

	public function addEmailContact(EmailContact $emailContact)
	{
		$this->emailContacts->add($emailContact);
	}

	public function getEmailContacts() {
		return $this->emailContacts->toArray();
	}

	public function deactivate()
	{
		$this->active = false;
	}

	public function activate()
	{
		$this->active = true;
	}

	public function isActive()
	{
		return $this->active;
	}

	public function resetUnsuccessLoginCounter()
	{
		$this->unsuccessLoginCount = 0;
	}

	public function getId()
	{
		return $this->id;
	}

	/**
	 * @return mixed
	 */
	public function getUserId()
	{
		return $this->userId;
	}

	/**
	 * @return mixed
	 */
	public function getLogin()
	{
		return $this->login;
	}

	public function registerSuccessLoginAt(\DateTime $loginTime)
	{
		$this->lastSuccessLogin = $loginTime;
	}

	public function registerFailedLogin()
	{
		$this->unsuccessLoginCount++;
	}

	private function setName($name)
	{
		$this->name = $name;
	}

	private function setLogin($login)
	{
		LoginNameValidator::validate($login);
		$this->login = $login;
	}

	private function setPassword($password)
	{
		$validator = new PasswordStrengthValidator($password);
		$validationResult = $validator->getValidationResult();
		$validationResult->validate("Wrong password!");
		$this->password = $password;
	}

	private function isMaxUnsuccessLoginReached()
	{
		if (self::MAX_UNSUCCESS_LOGIN <= $this->unsuccessLoginCount)
		{
			return true;
		}
		return false;
	}
}