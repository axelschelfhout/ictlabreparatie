<?php

namespace ApiBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AvailabilityTest extends WebTestCase
{
    /**
     * Test the routes
     */
    public function __construct(){
        date_default_timezone_set("Europe/Amsterdam");
    }
    
    public function testDefaultApiPath()
    {
        $client = self::createClient();
        
        $client->request('GET', '/api/');
        
        $response = $client->getResponse();
        $this->assertSame(200, $client->getResponse()->getStatusCode()); 
        $this->assertSame('application/json', $response->headers->get('Content-Type')); 
        $this->assertNotEmpty($client->getResponse()->getContent());
    }
    
    public function testGetcityJsonApiCall()
    {
        $client = self::createClient();
        
        $client->request('GET', '/api/basisschool/getcity/numansdorp');
        
        $response = $client->getResponse();
        $this->assertSame(200, $client->getResponse()->getStatusCode()); 
        $this->assertSame('application/json', $response->headers->get('Content-Type')); 
        $this->assertNotEmpty($client->getResponse()->getContent());
    }
    
    public function testGetrangeXMLApiCall()
    {
        $client = self::createClient();
        
        $client->request('GET', '/api/basisschool/getrange/edisonstraat/100/numansdorp/10.xml');
        
        $response = $client->getResponse();
        
        $this->assertSame(200, $client->getResponse()->getStatusCode()); 
        $this->assertSame('application/json', $response->headers->get('Content-Type')); 
        $this->assertNotEmpty($client->getResponse()->getContent());
    }
    
    
    
    public function testGetcityXMLApiCall()
    {
        $client = self::createClient();
        
        $client->request('GET', '/api/basisschool/getcity/numansdorp.xml');
        
        $response = $client->getResponse();
        $this->assertSame(200, $client->getResponse()->getStatusCode()); 
        $this->assertSame('application/xml', $response->headers->get('Content-Type')); 
        $this->assertNotEmpty($client->getResponse()->getContent());
    }
    
    public function testGetrangeJsonApiCall()
    {
        $client = self::createClient();
        
        $client->request('GET', '/api/basisschool/getrange/edisonstraat/100/numansdorp/10');
        
        $response = $client->getResponse();
        
        $this->assertSame(200, $client->getResponse()->getStatusCode()); 
        $this->assertSame('application/json', $response->headers->get('Content-Type')); 
        $this->assertNotEmpty($client->getResponse()->getContent());
    }
    
}