<?php

namespace Fenix007\Wrapper;

/**
 * Class ApiToken
 * @package Fenix007\Wrapper
 */
class ApiToken
{
    private $apiToken = null;
    
    /**
     * Token bag
     *
     * @param $api_token
     */
    public function __construct($api_token = null)
    {
        $this->apiToken = $api_token;
    }
    
    /**
     * @param  string $apiToken
     * @throws \RuntimeException
     * @return $this
     */
    public function setToken($apiToken)
    {
        if (!is_string($apiToken)) {
            throw new \RuntimeException('The Apitoken must be set.');
        }
        $this->apiToken = $apiToken;
        return $this;
    }
    
    /**
     * @return string
     */
    public function getToken()
    {
        return $this->apiToken;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string)$this->apiToken;
    }
}
