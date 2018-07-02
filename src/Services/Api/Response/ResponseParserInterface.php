<?php

namespace MegaData\MegaDataBundle\Services\Api\Response;

use MegaData\MegaDataBundle\Services\Api\Exception\InvalidResponseException;

interface ResponseParserInterface
{
    /**
     * Parses response string from server and returns Response object.
     * 
     * @param string $response
     * @throws InvalidResponseException
     */
    public function parse(string $response): Response;
}
