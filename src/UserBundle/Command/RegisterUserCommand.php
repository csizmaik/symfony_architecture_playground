<?php
/**
 * Created by PhpStorm.
 * User: csizmarik
 * Date: 5/8/2017
 * Time: 12:28 PM
 */

namespace UserBundle\Command;


class RegisterUserCommand
{
	private $name;
	private $loginName;
	private $password;

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
}