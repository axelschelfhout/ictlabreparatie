<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;


class ApiController extends Controller
{
    /**
     * @Route("/api")
     */
    public function indexAction(){
        die('Hallo wereld');
    }
    
    
}



