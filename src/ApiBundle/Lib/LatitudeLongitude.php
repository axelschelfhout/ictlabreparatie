<?php

/*
 * (c) Axel Schelfhout
 */

namespace ApiBundle\Lib;

abstract class LatitudeLongitude
{
    
    /**
     * Get the LatLng from an address
     * @param string $sCity
     * @param string $sStreet
     * @param string $sNumber
     * @return array
     */
    public static function getLatLng($sCity,$sStreet,$sNumber) {
        $sApiKey = 'AIzaSyCnTprn4t0Z7a9G_wCJOo7je8exBgGw5_Q';
        
        $sAddress = "{$sStreet},{$sNumber},{$sCity}";
        $sAddress = str_replace(' ','%20',$sAddress); // Replace spaces with html encoding for the URL to be correct.

        $oResponse = json_decode(self::getLatLngFromAddressWithGoogleGeocode($sAddress, $sApiKey)); // Decode the response\
        $aReturn = array();
        
        if($oResponse){
            if($oResponse->status != 'OK') {
                return array("Error" => "Someting went wrong");
            }
            else {
                $aReturn['lat'] = $oResponse->results[0]->geometry->location->lat; // Get latitude from response
                $aReturn['lng'] = $oResponse->results[0]->geometry->location->lng; // Get longitude from response
            }
        }
        else{
            return array("Error" => "Someting went wrong");
        }
        return $aReturn;
    }
    
    /**
     * Get the longitude and latitude from an address using the Google Geocode API
     * @param string $sAddress
     * @param string $sApiKey
     * @return object
     */
    private static function getLatLngFromAddressWithGoogleGeocode($sAddress,$sApiKey)
    {
        $sUrl = "https://maps.google.com/maps/api/geocode/json?address={$sAddress}&sensor=false&key={$sApiKey}"; // Build the URL to get geometry data
        
        $oCurl = curl_init(); // Start transaction
        curl_setopt($oCurl, CURLOPT_URL, $sUrl);
        curl_setopt($oCurl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($oCurl, CURLOPT_PROXYPORT, 3128);
        curl_setopt($oCurl, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($oCurl, CURLOPT_SSL_VERIFYPEER, 0);
        $oResponse = curl_exec($oCurl); // Save the response
        curl_close($oCurl); //Close transaction
        
        return $oResponse;
    }
    
    
    /*::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::*/
    /*::                                                                         :*/
    /*::  This routine calculates the distance between two points (given the     :*/
    /*::  latitude/longitude of those points). It is being used to calculate     :*/
    /*::  the distance between two locations using GeoDataSource(TM) Products    :*/
    /*::                                                                         :*/
    /*::  Definitions:                                                           :*/
    /*::    South latitudes are negative, east longitudes are positive           :*/
    /*::                                                                         :*/
    /*::  Passed to function:                                                    :*/
    /*::    lat1, lon1 = Latitude and Longitude of point 1 (in decimal degrees)  :*/
    /*::    lat2, lon2 = Latitude and Longitude of point 2 (in decimal degrees)  :*/
    /*::    unit = the unit you desire for results                               :*/
    /*::           where: 'M' is statute miles (default)                         :*/
    /*::                  'K' is kilometers                                      :*/
    /*::                  'N' is nautical miles                                  :*/
    /*::  Worldwide cities and other features databases with latitude longitude  :*/
    /*::  are available at http://www.geodatasource.com                          :*/
    /*::                                                                         :*/
    /*::  For enquiries, please contact sales@geodatasource.com                  :*/
    /*::                                                                         :*/
    /*::  Official Web site: http://www.geodatasource.com                        :*/
    /*::                                                                         :*/
    /*::         GeoDataSource.com (C) All Rights Reserved 2015		   		     :*/
    /*::                                                                         :*/
    /*::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::*/
    public static function distance($lat1, $lon1, $lat2, $lon2) {

        $theta = $lon1 - $lon2;
        $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
        $dist = acos($dist);
        $dist = rad2deg($dist);
        $miles = $dist * 60 * 1.1515;

        return ($miles * 1.609344);
    }
    
}

