<?php

/*
 * Author: Axel Schelfhout
 */

namespace ApiBundle\Lib;

abstract class Returntype
{
    /**
     * Set the return type.
     * 
     * @param mixed $mReturn
     */
    public static function getReturnType($mReturn) {
        $sEndpoint = '';
        $aMatches = array();
        
        if(is_array($mReturn)) {
            $sEndpoint = end($mReturn);
        } else {
            $sEndpoint = $mReturn;
        }
        
        preg_match('([^.]+$)', $sEndpoint, $aMatches);
        if(count($aMatches) > 0 && $aMatches[0] != $sEndpoint) {
            return $aMatches[0];
        } else {
            return 'json';
        }
    }
    
    /**
     * 
     * @param mixed $mValue
     * @return type
     */
    public static function stripLastArgumentInRequestFromStructureType($mValue)
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


