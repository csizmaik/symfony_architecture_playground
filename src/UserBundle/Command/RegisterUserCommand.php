<?php
/**
 * Created by PhpStorm.
 * User: csizmarik
 * Date: 5/8/2017
 * Time: 12:28 PM
 */

namespace UserBundle\Command;


use Symfony\Component\Validator\Constraints as Assert;
use UserBundle\Validator as MyAssert;

class RegisterUserCommand
{
	/**
	 * @Assert\Type(type="string")
	 * @Assert\Length(min="3")
	 */
	private $name;
	/**
	 * @Assert\Type(type="string")
	 * @Assert\Length(min="3")
	 */
	private $loginName;
	/**
	 * @Assert\NotBlank()
	 * @Assert\Length(min="3")
	 * @MyAssert\SecurePassword()
	 */
	private $password;
	/**
	 * @Assert\NotBlank()
	 * @Assert\Length(min="2")
	 */
	private $passwordAgain;

	/**
	 * @Assert\IsTrue(message="The repeteated password different!")
	 */
	public function isPasswordRepeatedCorrectly()
	{
		return $this->getPassword() == $this->getPasswordAgain();
	}

	/**
	 * @return mixed
	 */
	public function getName()
	{
		return $this->name;
	}

	/**
	 * @param mixed $name
	 */
	public function setName($name)
	{
		$this->name = $name;
	}

	/**
	 * @return mixed
	 */
	public function getLoginName()
	{
		return $this->loginName;
	}

	/**
	 * @param mixed $loginName
	 */
	public function setLoginName($loginName)
	{
		$this->loginName = $loginName;
	}

	/**
	 * @return mixed
	 */
	public function getPassword()
	{
		return $this->password;
	}

	/**
	 * @param mixed $password
	 */
	public function setPassword($password)
	{
		$this->password = $password;
	}

	/**
	 * @return mixed
	 */
	public function getPasswordAgain()
	{
		return $this->passwordAgain;
	}

	/**
	 * @param mixed $passwordAgain
	 */
	public function setPasswordAgain($passwordAgain)
	{
		$this->passwordAgain = $passwordAgain;
	}
}