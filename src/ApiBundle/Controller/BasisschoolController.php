<?php

namespace ApiBundle\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

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
     * Get schools in a city
     * @Route("/getcity/{sCity}")
     * @Method({"GET"})
     */
    public function getcityAction($sCity)
    {
        $sReturnType = Returntype::getReturnType($sCity);
        $sCity = Returntype::stripLastArgumentInRequestFromStructureType($sCity);
        
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
        
        $aScholen = $this->getScholenResultArrayFromQuery($oQuery);
        
        return $this->returnData($aScholen,$sReturnType);
    }
    
    
    /**
     * Get schools in range of a given address and range
     * @Route("/getrange/{sStreet}/{sNumber}/{sCity}/{iRange}")
     * @Method({"GET"})
     */
    public function getrangeAction($sStreet, $sNumber, $sCity, $iRange)
    {
        $sReturnType = Returntype::getReturnType($iRange);
        $iRange = Returntype::stripLastArgumentInRequestFromStructureType($iRange);
        
        $oScholenAttrRepo = $this->getDoctrine()->getRepository('ApiBundle:ScholenAttr');
        $oGetLatLngFromSchoolIdQuery = $oScholenAttrRepo->createQueryBuilder('sa')
                ->select('sa.schoolid,a.name,a.value')
                ->innerJoin('ApiBundle:Attributes', 'a', 'WITH', 'sa.attrId = a.attributeid')
                ->where('a.name = \'lat\'')
                ->orWhere('a.name = \'lng\'')
                ->getQuery();
       
        $aScholen = $this->getScholenResultArrayFromQuery($oGetLatLngFromSchoolIdQuery);
        
        $aLatLng = LatitudeLongitude::getLatLng($sStreet,$sNumber,$sCity);
        $sInRange = $this->createScholenIdsInRangeString($aScholen, $aLatLng, $iRange);
        
        if($sInRange) {
            $oInRangeQuery = $oScholenAttrRepo->createQueryBuilder('sa')
                ->select('sa.schoolid','a.name','a.value')
                ->innerJoin('ApiBundle:Attributes', 'a', 'WITH', 'sa.attrId = a.attributeid')
                ->where('sa.schoolid IN ('.$sInRange.')')
                ->getQuery();
        
            $aScholenInRange = $this->getScholenResultArrayFromQuery($oInRangeQuery);
            return $this->returnData($aScholenInRange, $sReturnType);
        }
        return $this->returnData(array('Error' => 'No schools found'), $sReturnType, 500);
    }
    
    /**
     * Returns an array with the attributes linked to school Ids
     * @param object $oQuery
     * @return array
     */
    private function getScholenResultArrayFromQuery($oQuery)
    {
        $aReturn = array();
        foreach($oQuery->getResult() as $aRow){
            $aReturn[$aRow['schoolid']][$aRow['name']] = $aRow['value'];
        }
        return $aReturn;
    }
    
    /**
     * 
     * @param array $aScholen
     * @param array $aLatLng
     * @param integer $iRange
     * @return string
     */
    private function createScholenIdsInRangeString($aScholen, $aLatLng, $iRange){
        $sInRange = '';
        foreach($aScholen as $key => $value) {
            if(LatitudeLongitude::distance($aLatLng['lat'],$aLatLng['lng'],$value['lat'],$value['lng']) < $iRange) {
                $sInRange .= $key.',';
            }
        }
        return rtrim($sInRange,',');
    }
    
    /**
     * Return data according to the returntype
     * @param array $aData
     * @param string $sReturnType
     * @return JsonResponse|XMLResponse
     */
    private function returnData($aData, $sReturnType, $iStatus = 200)
    {
        if(strtoupper($sReturnType) == "XML")
        {
            return new XMLResponse($aData, $iStatus);
        }
        return new JsonResponse($aData, $iStatus);
    }
    
}