<?php
/**
 * Created by PhpStorm.
 * User: csizmarik
 * Date: 4/20/2017
 * Time: 4:01 PM
 */

namespace services\external\store;


interface TransactionService
{
	public function transactional(callable $transactionalFunction);
	public function flush();
}