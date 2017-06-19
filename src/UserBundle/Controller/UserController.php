<?php

namespace UserBundle\Controller;

use FOS\RestBundle\Controller\Annotations as Rest;
use services\internal\user\RegisterUserCommand;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class UserController extends Controller
{
	/**
	 * @Rest\Post("/users")
	 * @Rest\View()
	 */
    public function registerUser(RegisterUserCommand $command)
    {
		$userService = $this->get('user_service');
		$userId = $userService->registerUser($command);
		return [
			"result" => "success_registration",
			"user_id" => $userId
		];
    }

	/**
	 * @Rest\Post("/users/{userId}/email_contact")
	 * @Rest\View()
	 */
	public function addContactToUser(Request $request, $userId)
	{
		$emailAddress = $request->request->get('emailAddress');
		$userService = $this->get('user_service');
		$userService->addEmailContactToUser($userId,$emailAddress);
		return [
			"result" => "success_registration",
		];
	}

	/**
	 * @Rest\Get("/users")
	 * @Rest\View()
	 */
    public function getUsers() {
    	$userService = $this->get('user_service');
    	$allUser = $userService->getAllUserData();
		return [
			"users" => $allUser
		];
	}
}
