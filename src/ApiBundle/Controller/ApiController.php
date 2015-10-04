<?php

/*
 * (c) Axel Schelfhout 
 */

namespace ApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * @Route("/api")
 */
class ApiController extends Controller
{
    /**
     * @Route("/")
     */
    public function indexAction(){
        return new JsonResponse(array("Welcome" => "Have fun using this API"));
    }
    
}
