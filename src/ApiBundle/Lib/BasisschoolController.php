<?php

/*
 * (c) Axel Schelfhout 
 */

namespace ApiBundle\Lib;

use ApiBundle\Controller\ApiController;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use ApiBundle\Entity\ScholenAttr;
use ApiBundle\Entity\Attributes;

class BasisschoolController extends ApiController
{
    
    private $oController;
    
    /**
     * Handle the Function request.
     * 
     * @param type $sMethod
     * @param type $sAction
     * @param type $aArgs
     * @return type
     */
    public function handle($oController, $sMethod,$sAction,$aArgs) {
        $this->oController = $oController;
        
        $sFunction = $sMethod.ucfirst($sAction);
        
        if(method_exists($this, $sFunction)){
            return $this->$sFunction($aArgs);
        }
        else {
            $this->setResponseCode(404);
            return array('Error' => 'Action not found');   
        }
    }
    
    /**
     * 
     * @param type $aArgs
     * @return type
     */
    public function getCity($aArgs) {
        /*
         * Query all the schools inside city.
         */                
        
        if(count($aArgs) == 1) {
            $aScholen = array();
            $sCity = $aArgs[0];
            
            $oScholenAttrRepo = $this->oController->getDoctrine()->getRepository('ApiBundle:ScholenAttr');
                       
            $sSubQuery = $oScholenAttrRepo->createQueryBuilder('saa')
                    ->select('saa.schoolid')
                    ->innerJoin('ApiBundle:Attributes', 'aa', 'WITH', 'saa.attrId = aa.attributeid')
                    ->where('aa.name = \'plaatsnaam\'')
                    ->andWhere('aa.value = :city')
                    ->getDql();
            
            $oQuery = $oScholenAttrRepo->createQueryBuilder('sa')
                    ->select('sa.schoolid','a.name','a.value')
                    ->innerJoin('ApiBundle:Attributes', 'a', 'WITH', 'sa.attrId = a.attributeid')
                    ->where('sa.schoolid IN ('.$sSubQuery.')')
                    ->setParameter('city', $sCity)
                    ->getQuery();
            
            foreach($oQuery->getResult() as $aRow){
                $aScholen[$aRow['schoolid']][$aRow['name']] = $aRow['value'];
            }

            return $aScholen;
        }
        return array('Error' => 'Invalid number of arguments.');
    }
    
    
    
    
    
    
    
    public function getRange($aArgs) {
        
        /*
         * Query all the schools inside the given address and range
         */
        
        
        
//        $city = $aArgs[0];
//            $street = $aArgs[1];
//            $number = $aArgs[2];
//            $range = $aArgs[3];
//
//            $oLatLng = new LatitudeLongitude();
//            $aLatLng = $oLatLng->getLatLng($city,$street,$number,false); // get the lat and lng from address
//            
//            $outcome = $this->oBasisschool->getScholenForRange($aLatLng, $range);
//            if($outcome) {
//                return $outcome;
//            }
//            return array("ERROR" => array("MESSAGE" => "No results"));
//        
//        
        
        
        return array('Range' => 'Range');
    }
    
}

