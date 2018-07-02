<?php

namespace Tests\MegaData\MegaDataBundle;

use MegaData\MegaDataBundle\Services\Api\Response\JsonResponseParser;
use MegaData\MegaDataBundle\Services\Api\Response\Response;

class JsonResponseParserTest extends \PHPUnit\Framework\TestCase
{
    private $parser;
    
    public function setUp() {
        $this->parser = new JsonResponseParser();
    }
    
    public function testParseSuccessfulResponse() {
        $input = <<<DOC
{
    "data": {
        "locations": [
            {
                "name": "Eiffel Tower",
                "coordinates": {
                    "lat": 21.12,
                    "long": 19.56
                }
            }
        ]
    },
    "success": true
}
DOC;
        $response = $this->parser->parse($input);
        
        $this->assertInstanceOf(Response::class, $response);
        $this->assertEquals(true, $response->getIsSuccess());
        $this->assertArrayHasKey('locations', $response->getData());
        $this->assertArrayHasKey('name', $response->getData()['locations'][0]);
        $this->assertNull($response->getErrorCode());
        $this->assertNull($response->getErrorMessage());
    }
    
    public function testParseNotSuccessResponse() {
        $input = <<<DOC
{   
    "data": {
        "message": "message",
        "code": "code"
    },
    "success": false
}
DOC;
        $response = $this->parser->parse($input);
        $this->assertEquals(false, $response->getIsSuccess());
        $this->assertNotNull($response->getErrorCode());
        $this->assertNotNull($response->getErrorMessage());
    }
}
