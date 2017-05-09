<?php
/**
 * Created by PhpStorm.
 * User: csizmarik
 * Date: 5/9/2017
 * Time: 6:18 AM
 */

namespace services\external\store\doctrine;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Query;
use services\external\UserQuery;

class UserQueryDoctrine implements UserQuery
{
	/**
	 * @var EntityManager
	 */
	private $entityManager;


	/**
	 * UserQueryDoctrine constructor.
	 */
	public function __construct(EntityManager $entityManager)
	{
		$this->entityManager = $entityManager;
	}

	public function getAllUser()
	{
		$query = $this
					->entityManager
					->createQueryBuilder()
						->from('user_services:User','u')
						->select('u.id','u.login','u.name','u.active')
						->getQuery();
		return $query->getResult(Query::HYDRATE_ARRAY);
	}
}