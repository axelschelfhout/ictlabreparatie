<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

class ApiController extends Controller
{
    /**
     * @Route("/api/{subject}")
     * @Route("/api/{subject}/{method}")
     * @Route("/api/{subject}/{method}/{action}")
     */
    public function indexAction($subject = null, $method = "GET", $action = null){
        
        
        
        return new JsonResponse(array("Hallo" => "Wereld"));
    }
    
    
}



