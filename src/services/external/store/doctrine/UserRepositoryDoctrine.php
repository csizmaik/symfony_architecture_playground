<?php
/**
 * Created by PhpStorm.
 * User: csizmarik
 * Date: 4/20/2017
 * Time: 3:07 PM
 */
namespace services\external\store\doctrine;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;
use services\external\store\TransactionService;
use services\internal\user\User;
use services\internal\user\UserRepository;

class UserRepositoryDoctrine extends EntityRepository implements UserRepository
{

	public function nextId()
	{
		return uniqid();
	}

	public function getUserById($userId)
	{
		return $this->find($userId);
	}

	public function isUserExistsWithLogin($login)
	{
		$user = $this->getUserByLoginName($login);
		return (!is_null($user));
	}

	public function getUserByLoginName($login)
	{
		return $this->findOneBy(['login' => $login]);
	}

	public function addUser(User $user)
	{
		$this->getEntityManager()->persist($user);
	}

	public function removeUserByLoginName($loginName)
	{
		$user = $this->getUserByLoginName($loginName);
		if (!is_null($user))
		{
			$this->getEntityManager()->remove($user);
		}
	}

	public function getAllUser()
	{
		return $this->createQueryBuilder('u')
			->select('u.login','u.name','u.lastSuccessLogin')
			->where('u.active = 1')
			->getQuery()
			->getResult(Query::HYDRATE_ARRAY);
	}
}