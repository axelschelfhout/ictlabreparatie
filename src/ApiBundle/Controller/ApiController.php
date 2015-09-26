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
     */
    public function indexAction($sSubject = null, $sMethod = "GET", $sAction = null, $sArgument1 = null, $sArgument2 = null, $sArgument3 = null){
        
        if(isset($sSubject) && isset($sMethod) && isset($sAction)) {
            $aArgs = $this->createArrayFromArguments($sArgument1, $sArgument2, $sArgument3);
            
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
        $oController = new $oControllerLoadString();
        
        return $oController->handle($sMethod,$sAction,$aArgs);
    }
    
    public function createArrayFromArguments($sArgument1, $sArgument2, $sArgument3) {
        $aArgs = array();
        (isset($sArgument1) ? $aArgs[] = $sArgument1 : false);
        (isset($sArgument2) ? $aArgs[] = $sArgument2 : false);
        (isset($sArgument3) ? $aArgs[] = $sArgument3 : false);
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
    
    
    private function stripLastArgumentInRequestFromStructureType($mValue)
    {
        if(is_array($mValue)) {
            //
        } else {
            $aEndpoint = explode('.',$mValue);
            $sStripedValue = $aEndpoint[0];
            return $sStripedValue;
        }
        
//        $sEndpoint = explode('.',$this->sLastArgumentInUrl);
//        $this->sLastArgumentInUrl = $sEndpoint[0];
//        $this->aArgs[count($this->aArgs)-1] = $this->sLastArgumentInUrl;
    }
    
}



