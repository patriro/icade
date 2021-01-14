<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

class BaseController extends AbstractController
{
    public function returnJSONResponse($data)
    {
        $response = new JsonResponse($data);
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }
}
