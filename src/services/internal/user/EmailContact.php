<?php
/**
 * Created by PhpStorm.
 * User: csizmarik
 * Date: 5/9/2017
 * Time: 7:00 AM
 */

namespace services\internal\user;


class EmailContact
{
	private $id;
	private $email;

	public function __construct($email)
	{
		$this->email = $email;
	}

	/**
	 * @return mixed
	 */
	public function getId()
	{
		return $this->id;
	}

	/**
	 * @return mixed
	 */
	public function getEmail()
	{
		return $this->email;
	}


}