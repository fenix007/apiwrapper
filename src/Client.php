<?php

namespace Fenix007\Wrapper;

use Fenix007\Wrapper\HttpClient\HttpClient;

/**
 * Class Client
 * @package Fenix007\Wrapper
 */
class Client
{
    /**
     * @var \Fenix007\Wrapper\HttpClient\HttpClient
     */
    protected $client;
    /**
     * @var \Fenix007\Wrapper\ApiToken
     */
    protected $apiToken;

    /**
     * Client constructor.
     * @param \Fenix007\Wrapper\ApiToken $apiToken
     * @param array                   $options
     */
    public function __construct(ApiToken $apiToken, array $options = [])
    {
        $this->client = new HttpClient($apiToken, $options);
    }
}
