<?php

namespace MegaData\MegaDataBundle\Services\Api;

use MegaData\MegaDataBundle\Services\Api\Response\ResponseParserInterface;

class Factory
{
    /**
     * @var string
     */
    private $apiUrl = null;
    
    /**
     * @var ResponseParserInterface
     */
    private $responseParser = null;
    
    public function setApiUrl(string $apiUrl) {
        if (parse_url($apiUrl, PHP_URL_SCHEME) == false || parse_url($apiUrl, PHP_URL_HOST) == false) {
            throw new \Exception("API URL must have a form of {scheme}://{host}.");
        }
        $this->apiUrl = $apiUrl;
    }
    
    public function setFormat(string $format) {
        $parserClass = "MegaData\\MegaDataBundle\\Services\\Api\\Response\\" . ucfirst($format) . "ResponseParser";
        if (class_exists($parserClass, true)) {
            $this->responseParser = new $parserClass;
        }
        else throw new \Exception("Parser class not found for format: " . $format);
    }
    
    public function setCustomResponseParser(ResponseParserInterface $parser) {
        $this->responseParser = $parser;
    }
    
    public function createInstance(): Api {
        if (empty($this->apiUrl) || empty($this->responseParser)) {
            throw new \Exception("Fabric is set up improperly. Ensure all parameters are set before building.");
        }
        return new Api($this->apiUrl, $this->responseParser);        
    }
}