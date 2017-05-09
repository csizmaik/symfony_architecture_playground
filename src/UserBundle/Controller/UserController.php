<?php

namespace UserBundle\Controller;

use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use UserBundle\Command\RegisterUserCommand;
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
					->registerUser(
						$registeredUserCommand->getName(),
						$registeredUserCommand->getLoginName(),
						$registeredUserCommand->getPassword()
					);
			return [
				"result" => "success_registration",
				"user_id" => $userId
			];
		}

		return $form;
    }

	/**
	 * @Rest\Get("/users")
	 * @Rest\View()
	 */
    public function getUsers() {
		$userQuery = $this->get('user_query');
		$allUser = $userQuery->getAllUser();
		return [
			"users" => $allUser
		];
	}
}
