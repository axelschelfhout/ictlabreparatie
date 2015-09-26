<?php

/*
 * (c) Axel Schelfhout 
 */

namespace ApiBundle\Lib;

use ApiBundle\Controller\ApiController;

class BasisschoolController extends ApiController
{
    /**
     * Handle the Function request.
     * 
     * @param type $sMethod
     * @param type $sAction
     * @param type $aArgs
     * @return type
     */
    public function handle($sMethod,$sAction,$aArgs) {
        $sFunction = $sMethod.ucfirst($sAction);
          
        if(method_exists($this, $sFunction)){
            return $this->$sFunction($aArgs);
        }
        else {
            $this->setResponseCode(404);
            return array('Error' => 'Action not found');   
        }
    }
    
    public function getCity($aArgs) {
        
        
        
        return array('City' => 'City');
    }
    
    public function getRange($aArgs) {
        
        return array('Range' => 'Range');
    }
    
}

