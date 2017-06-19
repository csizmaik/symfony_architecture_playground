<?php
/**
 * Created by PhpStorm.
 * User: csizmarik
 * Date: 3/26/2017
 * Time: 8:24 AM
 */

namespace services\internal\user;

use services\external\store\TransactionService;
use services\external\time\TimeService;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Webmozart\Assert\Assert;

class UserService
{
	private $userRepository;
	/**
	 * @var TransactionService
	 */
	private $transactionService;
	/**
	 * @var TimeService
	 */
	private $timeService;
	/**
	 * @var ValidatorInterface
	 */
	private $validator;

	public function __construct(UserRepository $userRepository, TransactionService $transactionService, TimeService $timeService, ValidatorInterface $validator)
	{
		$this->userRepository = $userRepository;
		$this->transactionService = $transactionService;
		$this->timeService = $timeService;
		$this->validator = $validator;
	}

	public function registerUser(RegisterUserCommand $command)
	{
		$constraintViolationList = $this->validator->validate($command);
		ValidationResultProcessor::processConstraintViolationList($constraintViolationList);
		return $this->transactionService->transactional(function() use ($command){
			ReservedLoginChecker::check($this->userRepository->isUserExistsWithLogin($command->getLoginName()));
			$userId = $this->userRepository->nextId();
			$user = new User($userId, $command->getName(), $command->getLoginName(), $command->getPassword());
			$this->userRepository->addUser($user);
			return $userId;
		});
	}

	public function addEmailContactToUser($userId, $emailAddress)
	{
		return $this->transactionService->transactional(function() use ($userId, $emailAddress){
			/** @var User $user */
			$user = $this->userRepository->getUserById($userId);
			Assert::allNotNull([$user], "Unkown user id: ".$userId);
			$user->addEmailContact(new EmailContact($emailAddress));
		});
	}

	public function validateCredential($login, $password)
	{
		/** @var User $user */
		$user = $this->userRepository->getUserByLoginName($login);
		$validationResult = $user->validateCredential($password);
		$user->registerCredentialValidationResult($validationResult->isSuccess(),$this->timeService->getCurrentDateTime());
		$this->transactionService->flush();
		return $validationResult;
	}

	public function deactivateUserByLogin($login)
	{
		$this->transactionService->transactional(function() use($login){
			/** @var User $user */
			$user = $this->userRepository->getUserByLoginName($login);
			$user->deactivate();
		});

	}

	public function deactivateUserById($userId)
	{
		$this->transactionService->transactional(function() use($userId) {
			/** @var User $user */
			$user = $this->userRepository->getUserById($userId);
			$user->deactivate();
		});
	}

	public function resetUnsuccessLoginCounterByUserId($userId)
	{
		$this->transactionService->transactional(function() use($userId){
			/** @var User $user */
			$user = $this->userRepository->getUserById($userId);
			$user->resetUnsuccessLoginCounter();
		});
	}

	public function getUserDataById($userId) {
		$this->userRepository->getUserById($userId);
	}

	public function getAllUserData()
	{
		return $this->userRepository->getAllUserData();
	}
}