<?php

/*
 * (c) Axel Schelfhout 
 */

namespace AppBundle\Lib;

use Symfony\Component\HttpFoundation\Response;

class XMLResponse extends Response {
    
    public function __construct($aData = null, $iStatus = 200, $aHeaders = array())
    {
        parent::__construct('', $iStatus, $aHeaders);

        if (null === $aData) {
            $aData = new \ArrayObject();
        }
        return $this->processData($aData);
    }
    
    public function processData($aData = array()) {
        $oXML = new \SimpleXMLElement('<root/>');
        $oXML = $this->createXML($aData, $oXML);
        
        return $oXML->asXML();
    }
    
    private function createXML($aArray, $oXML)
    {
        foreach($aArray as $mKey => $mValue)
        {
            if(is_array($mValue))
            {
                if(!is_numeric($mKey))
                {
                    $oXMLSubNode = $oXML->addChild("{$mKey}");
                    $this->createXML($mValue, $oXMLSubNode);
                }
                else
                {
                    $oXMLSubNode = $oXML->addChild("item{$mKey}");
                    $this->createXML($mValue, $oXMLSubNode);
                }
            } else {
                $oXML->addChild("{$mKey}", htmlspecialchars($mValue));
            }
        }
        return $oXML;
    }

}