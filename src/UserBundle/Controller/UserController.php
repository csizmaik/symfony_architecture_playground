<?php

namespace UserBundle\Controller;

use FOS\RestBundle\Controller\Annotations as Rest;
use services\internal\user\RegisterUserCommand;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use UserBundle\Form\RegisterUserForm;

class UserController extends Controller
{
	/**
	 * @Rest\Post("/users")
	 * @Rest\View()
	 */
    public function registerUser(Request $request)
    {
		$registeredUserCommand = new RegisterUserCommand();
    	$form = $this->createForm(RegisterUserForm::class, $registeredUserCommand);
    	$form->submit($request->request->all());

    	if ($form->isSubmitted() && $form->isValid()) {
			$userService = $this->get('user_service');
			$userId =
				$userService
					->registerUser($registeredUserCommand);
			return [
				"result" => "success_registration",
				"user_id" => $userId
			];
		}

		return $form;
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
