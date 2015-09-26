<?php

/*
 * (c) Axel Schelfhout 
 */

namespace ApiBundle\View;

use Symfony\Component\HttpFoundation\Response;

class XMLResponse extends Response {
    
    /**
     * 
     * @param \ArrayObject $aData
     * @param int $iStatus
     * @param Array $aHeaders
     * @return type
     */
    public function __construct($aData = null, $iStatus = 200, $aHeaders = array())
    {
        parent::__construct('', $iStatus, $aHeaders);

        if (null === $aData) {
            $aData = new \ArrayObject();
        }
        
        return $this->processData($aData);
    }
    
    /**
     * 
     * @param Array $aData
     * @return type
     */
    public function processData($aData = array()) {
        $oXML = new \SimpleXMLElement('<root/>');
        $oXML = $this->createXML($aData, $oXML);
         
        $this->headers->set('Content-Type', 'application/xml');
        return $this->setContent($oXML->asXML());
    }
    
    /**
     * 
     * @param Array $aArray
     * @param SimpleXMLElement $oXML
     * @return type
     */
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