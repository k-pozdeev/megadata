<?php

namespace MegaData\MegaDataBundle\Services\Api\Response;

use MegaData\MegaDataBundle\Services\Api\Exception\InvalidResponseException;

class Response
{
    /**
     * @var array
     */
    private $data;
    
    /**
     * @var bool
     */
    private $success;

    /**
     * @var string
     */
    private $errorCode;
    
    /**
     * @var string
     */
    private $errorMessage;
    
    /**
     * @param mixed $data
     * @param bool $success
     */
    public function __construct($data, bool $success, ?string $errorCode, ?string $errorMessage)
    {
        $this->data = $data;
        $this->success = $success;
        $this->errorCode = $errorCode;
        $this->errorMessage = $errorMessage;
    }
    
    public function getData(): array {
        return $this->data;
    }
    
    public function getIsSuccess(): bool {
        return $this->success;
    }
    
    public function getErrorCode(): ?string {
        return $this->errorCode;
    }
    
    public function getErrorMessage(): ?string {
        return $this->errorMessage;
    }
}