<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use AppBundle\Lib\XMLResponse;

class ApiController extends Controller
{
    private $sStructureType;
    
    const JSON = "JSON";
    const XML = "XML";

    public function __construct() {
        header("Access-Control-Allow-Orgin: *");
        header("Access-Control-Allow-Methods: *");
    }
    
    /**
     * @Route("/api/{sSubject}")
     * @Route("/api/{sSubject}/{sMethod}")
     * @Route("/api/{sSubject}/{sMethod}/{sAction}")
     */
    public function indexAction($sSubject = null, $sMethod = "GET", $sAction = null){
        $this->setReturnType($sAction);
        
        $testArray = array("Hallo" => "Wereld");
        
        if(strtoupper($sMethod) == "GET") {
            if(strtoupper($this->sStructureType) == self::XML){
                return new XMLResponse($testArray, 200);
            } 
            return new JsonResponse($testArray, 200);
        }
        return new JsonResponse($this->requestStatus(405), 405);
    }
    
    /**
     * 
     * @param int $iCode
     * @return type
     */
     private function requestStatus($iCode) {
        $aStatus = array(
            200 => 'OK',
            401 => 'Unauthorized',
            404 => 'Not Found',
            405 => 'Method Not Allowed',
            500 => 'Internal Server Error',
        );
        return ($aStatus[$iCode])?$aStatus[$iCode]:$aStatus[500];
    }
    
    /**
     * 
     * @param string $sValue
     */
    private function setReturnType($sValue) {
        preg_match('([^.]+$)', $sValue, $aMatches);
        if(count($aMatches) > 0 && $aMatches[0] != $sValue) {
            $this->sStructureType = $aMatches[0];
        } else {
            $this->sStructureType = 'json';
        }
    }
    
}



