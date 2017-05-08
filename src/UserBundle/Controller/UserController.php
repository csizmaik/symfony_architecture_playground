<?php

namespace UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
	/**
	 * @Route("/users")
	 */
    public function indexAction()
    {
        return new Response("Hello Users!");
    }
}
