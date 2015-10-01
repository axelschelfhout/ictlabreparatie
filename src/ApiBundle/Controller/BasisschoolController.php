<?php

namespace ApiBundle\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

use ApiBundle\Entity\ScholenAttr;
use ApiBundle\Entity\Attributes;

// Start Custom 
use ApiBundle\Lib\Returntype;
use ApiBundle\Lib\LatitudeLongitude;
use ApiBundle\View\XMLResponse;
// End Custom 

/**
 * @Route("/api/basisschool")
 */
class BasisschoolController extends Controller
{
    
    /**
     * @Route("/getcity/{sCity}")
     * @Method({"GET"})
     */
    public function getcityAction($sCity)
    {
        $sReturnType = Returntype::getReturnType($sCity);
        $sCity = Returntype::stripLastArgumentInRequestFromStructureType($sCity);
        
        $aScholen = array();

        $oScholenAttrRepo = $this->getDoctrine()->getRepository('ApiBundle:ScholenAttr');
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
        return $this->returnData($aScholen,$sReturnType);
    }
    
    
    /**
     * @Route("/getrange/{sStreet}/{sNumber}/{sCity}/{iRange}")
     * @Method({"GET"})
     */
    public function getrangeAction($sStreet, $sNumber, $sCity, $iRange)
    {
        $sReturnType = Returntype::getReturnType($iRange);
        $iRange = Returntype::stripLastArgumentInRequestFromStructureType($iRange);
        
        $oScholenAttrRepo = $this->getDoctrine()->getRepository('ApiBundle:ScholenAttr');
        $oQuery = $oScholenAttrRepo->createQueryBuilder('sa')
                ->select('sa.schoolid,a.name,a.value')
                ->innerJoin('ApiBundle:Attributes', 'a', 'WITH', 'sa.attrId = a.attributeid')
                ->where('a.name = \'lat\'')
                ->orWhere('a.name = \'lng\'')
                ->getQuery();
       
        $aScholen = array();
        foreach($oQuery->getResult() as $aRow){
            $aScholen[$aRow['schoolid']][$aRow['name']] = $aRow['value'];
        }
        
        $aLatLng = LatitudeLongitude::getLatLng($sStreet,$sNumber,$sCity);
        
        $sInRange = '';
        foreach($aScholen as $key => $value) {
            if(LatitudeLongitude::distance($aLatLng['lat'],$aLatLng['lng'],$value['lat'],$value['lng']) < $iRange) {
                $sInRange .= $key.',';
            }
        }
        
        $sInRange = rtrim($sInRange,',');
        
        $oInRangeQuery = $oScholenAttrRepo->createQueryBuilder('sa')
                ->select('sa.schoolid','a.name','a.value')
                ->innerJoin('ApiBundle:Attributes', 'a', 'WITH', 'sa.attrId = a.attributeid')
                ->where('sa.schoolid IN ('.$sInRange.')')
                ->getQuery();
        
        $aScholenInRange = array();
        foreach($oInRangeQuery->getResult() as $aRow){
            $aScholenInRange[$aRow['schoolid']][$aRow['name']] = $aRow['value'];
        }
        
        return $this->returnData($aScholenInRange, $sReturnType);
    }
    
    /**
     * 
     * @param array $aData
     * @param string $sReturnType
     * @return JsonResponse|XMLResponse
     */
    private function returnData($aData, $sReturnType)
    {
        if(strtoupper($sReturnType) == "XML")
        {
            return new XMLResponse($aData);
        }
        return new JsonResponse($aData);
    }
    
}