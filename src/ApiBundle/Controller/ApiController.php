<?php

/*
 * (c) Axel Schelfhout 
 */

namespace ApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

// Start Custom Views
use ApiBundle\View\XMLResponse;
// End Custom Views

class ApiController extends Controller
{
    private $sStructureType;
    
    public $iResponseCode = 200;
    
    public $doctrine;
    
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
     * @Route("/api/{sSubject}/{sMethod}/{sAction}/{sArgument1}")
     * @Route("/api/{sSubject}/{sMethod}/{sAction}/{sArgument1}/{sArgument2}")
     * @Route("/api/{sSubject}/{sMethod}/{sAction}/{sArgument1}/{sArgument2}/{sArgument3}")
     * @Route("/api/{sSubject}/{sMethod}/{sAction}/{sArgument1}/{sArgument2}/{sArgument3}/{sArgument4}")
     */
    public function indexAction($sSubject = null, $sMethod = "GET", $sAction = null, $sArgument1 = null, $sArgument2 = null, $sArgument3 = null, $sArgument4 = null){
        
        if(isset($sSubject) && isset($sMethod) && isset($sAction)) {
            $aArgs = $this->createArrayFromArguments($sArgument1, $sArgument2, $sArgument3, $sArgument4);
            
            // If we have arguments, determine the returntype on the arguments, else on the action;
            if($aArgs != null) {
                $this->setReturnType($aArgs);
                $aArgs = $this->stripLastArgumentInRequestFromStructureType($aArgs);
            }
            else {
                $this->setReturnType($sAction);
                $sAction = $this->stripLastArgumentInRequestFromStructureType($sAction);
            }
            
            if(strtoupper($sMethod) == "GET") { // With this API we only deal with GET requests (for now)
                if(strtoupper($this->sStructureType) == self::XML){
                    return new XMLResponse($this->processRequest($sSubject, $sMethod, $sAction, $aArgs), $this->getResponseCode());
                }
                return new JsonResponse($this->processRequest($sSubject, $sMethod, $sAction, $aArgs), $this->getResponseCode());
            }
            return new JsonResponse($this->requestStatus(405), 405);
        }
        return new JsonResponse($this->requestStatus(404), 404);
    }
    
    /**
     * Dynamicly load the handle controller to process the request
     * 
     * @param string $sController
     * @param string $sMethod
     * @param string $sAction
     * @param mixed array $aArgs
     * @return type
     */
    public function processRequest($sController, $sMethod, $sAction, $aArgs = null) {
        $sControllerName = ucfirst($sController)."Controller";
        $oControllerLoadString = "\\ApiBundle\\Lib\\".$sControllerName;
        
        if(!class_exists($oControllerLoadString)) {
            return array('Error' => 'Method not allowed');
        }
        
        $oController = new $oControllerLoadString();
        return $oController->handle($this,$sMethod,$sAction,$aArgs);
    }
    
    public function createArrayFromArguments($sArgument1, $sArgument2, $sArgument3, $sArgument4) {
        $aArgs = array();
        (isset($sArgument1) ? $aArgs[] = $sArgument1 : false);
        (isset($sArgument2) ? $aArgs[] = $sArgument2 : false);
        (isset($sArgument3) ? $aArgs[] = $sArgument3 : false);
        (isset($sArgument4) ? $aArgs[] = $sArgument4 : false);
        return $aArgs;
    }
    
    public function setResponseCode($iCode) {
        $this->iResponseCode = $iCode;
    }
    
    public function getResponseCode() {
        return $this->iResponseCode;
    }
    
    /**
     * 
     * @param int $iCode
     * @return string
     */
     private function requestStatus($iCode) {
        $aStatus = array(
            200 => 'OK',
            401 => 'Unauthorized',
            404 => 'Not Found',
            405 => 'Method Not Allowed',
            500 => 'Internal Server Error',
        );
        return ($aStatus[$iCode]) ? $aStatus[$iCode] : $aStatus[500];
    }
    
    /**
     * Set the return type.
     * 
     * @param mixed $mReturn
     */
    private function setReturnType($mReturn) {
        $sEndpoint = '';
        $aMatches = array();
        
        if(is_array($mReturn)) {
            $sEndpoint = end($mReturn);
        } else {
            $sEndpoint = $mReturn;
        }
        
        preg_match('([^.]+$)', $sEndpoint, $aMatches);
        if(count($aMatches) > 0 && $aMatches[0] != $sEndpoint) {
            $this->sStructureType = $aMatches[0];
        } else {
            $this->sStructureType = 'json';
        }
    }
    
    /**
     * 
     * @param mixed $mValue
     * @return type
     */
    private function stripLastArgumentInRequestFromStructureType($mValue)
    {
        if(is_array($mValue)) {
            $aEndpoint = explode('.',end($mValue));
            reset($mValue);
            
            $mValue[count($mValue) - 1] = $aEndpoint[0];
            return $mValue;
        } else {
            $aEndpoint = explode('.',$mValue);
            return $aEndpoint[0];
        }
    }
    
}



