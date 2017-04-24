<?php
/**
 * Created by PhpStorm.
 * User: csizmarik
 * Date: 4/26/2017
 * Time: 12:44 PM
 */

namespace services\external\store\doctrine;


use Doctrine\ORM\EntityManager;
use services\external\store\TransactionService;

class TransactionServiceDoctrine implements TransactionService
{
	/**
	 * @var EntityManager
	 */
	private $entityManager;

	/**
	 * DoctrineTransaction constructor.
	 */
	public function __construct(EntityManager $entityManager)
	{
		$this->entityManager = $entityManager;
	}

	public function transactional(callable $transactionalFunction)
	{
		return $this->entityManager->transactional($transactionalFunction);
	}

	public function flush()
	{
		$this->entityManager->flush();
	}
}