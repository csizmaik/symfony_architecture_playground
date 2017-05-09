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
							->from('user_services:User','user')
							->leftJoin('user.emailContacts','email_contacts')
							->select('user','email_contacts')
							->getQuery();
		return $query->getResult(Query::HYDRATE_ARRAY);
	}
}