<?php

namespace MegaData\MegaDataBundle\Services\Api;

use MegaData\MegaDataBundle\Services\Api\Response\ResponseParserInterface;
use MegaData\MegaDataBundle\Services\Api\Response\Response;
use MegaData\MegaDataBundle\Services\Api\Exception\NetworkException;
use MegaData\MegaDataBundle\Services\Api\Exception\InvalidResponseException;

class Api
{
    const METHOD_GET = 'GET';
    const METHOD_POST = 'POST';
    
    /**
     * @var string
     */
    private $apiUrl;
    
    /**
     * @var ResponseParserInterface
     */
    private $responseParser;
    
    private $curl;
    
	public function __construct(string $apiUrl, ResponseParserInterface $responseParser) {
		$this->apiUrl = $apiUrl;
		$this->responseParser = $responseParser;
		
		$this->curl = curl_init();
		curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, 1);
	}
	
	/**
	 * /location API method.
	 * 
	 * @return Response
	 * @throws NetworkException
	 * @throws InvalidResponseException
	 */
	public function methodLocation(): Response {
	    $uri = '/location';
	    $response = $this->doRequest($uri, self::METHOD_GET);
	    
	    return $this->responseParser->parse($response);
	}
	
	/**
	 * @param string $uri URI part of API request address
	 * @param string $method 'GET' or 'POST'
	 * @param array $data query params in case of GET request, or POST data.
	 * @throws NetworkException
	 * @return string
	 */
	private function doRequest(string $uri, string $method, array $data = []): string {
	    if ($method == self::METHOD_GET) {
	        $url = $this->apiUrl . $uri;
	        curl_setopt($this->curl, CURLOPT_POST, 0);

	        if ($data) {
	            $url .= '?' . http_build_query($data);
	        }
	        curl_setopt($this->curl, CURLOPT_URL, $url);
	    }
	    elseif ($method == self::METHOD_POST) {
	        $url = $this->apiUrl . $uri;
	        curl_setopt($this->curl, CURLOPT_POST, 1);
	        curl_setopt($this->curl, CURLOPT_POSTFIELDS, $data);
	    }
	    $result = curl_exec($this->curl);
	    $errno = curl_errno($this->curl);
	    if (!$errno) {
	        return $result;
	    }
	    else {
	        $errstr = curl_error($this->curl);
	        throw new NetworkException($errstr);
	    }
	}
	
	public function __destruct() {
	    curl_close($this->curl);
	}
}