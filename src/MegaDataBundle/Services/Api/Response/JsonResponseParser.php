<?php

namespace MegaData\MegaDataBundle\Services\Api\Response;

use MegaData\MegaDataBundle\Services\Api\Exception\InvalidResponseException;

class JsonResponseParser implements ResponseParserInterface
{
    /**
     * {@inheritDoc}
     */
    public function parse(string $response): Response
    {
        $responseValue = json_decode($response, true);
        
        if (json_last_error() != JSON_ERROR_NONE) {
            throw new InvalidResponseException("Error while parsing response. Error message: " . json_last_error_msg());
        }
        
        [$data, $success, $errCode, $errMessage] = $this->extractValues($responseValue);
        
        return new Response($data, $success, $errCode, $errMessage);
    }
        
    private function extractValues($responseValue) {
        if (!is_array($responseValue)) {
            throw new InvalidResponseException("Response is not a valid JSON object.");
        }
        
        if (!array_key_exists('success', $responseValue) || !array_key_exists('data', $responseValue)) {
            throw new InvalidResponseException("Response object must contain 'success' and 'data' keys.");
        }
        $success = $responseValue['success'];
        $data = $responseValue['data'];
        
        if (!is_bool($success)) {
            throw new InvalidResponseException("Attribute 'success' value must be of type bool.");
        }
        
        $errCode = null;
        $errMessage = null;
        
        if ($success == false) {
            if ( ! (is_array($data) && isset($data['code']) && is_string($data['code'])) ) {
                throw new InvalidResponseException("Response with fail status must contain 'code' string.");
            }
            $errCode = $data['code'];
            
            if ( ! (is_array($data) && isset($data['message']) && is_string($data['message'])) ) {
                throw new InvalidResponseException("Response with fail status must contain 'message' string.");
            }
            $errMessage = $data['message'];
        }
        
        return [$data, $success, $errCode, $errMessage];
    }
}