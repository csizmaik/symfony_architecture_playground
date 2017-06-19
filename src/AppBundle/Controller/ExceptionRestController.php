<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

class ExceptionRestController extends Controller
{
    public function indexAction(\Exception $exception)
    {
        $restExceptionService = $this->get("rest_exception");
        $exceptionData = $restExceptionService->getDataByException($exception);
        return new JsonResponse($exceptionData,$exceptionData["code"]);
    }
}
