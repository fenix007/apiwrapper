<?php

namespace Fenix007\Wrapper\Api;

use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Psr7\Uri;
use Fenix007\Wrapper\HttpClient\HttpClient;
use Fenix007\Wrapper\HttpClient\Request;

/**
 * Class ContractApi
 * @package Fenix007\Wrapper\Api
 */
abstract class AbstractApi
{
    /**
     * @var string
     */
    protected $pattern;
    /**
     * @var HttpClient
     */
    protected $client;
    
    /**
     * Api constructor.
     *
     * @param HttpClient $client
     */
    public function __construct(HttpClient $client)
    {
        $this->client = $client;
    }
    
    /**
     * @param Request $request
     * @param  $mapper
     * @throws \Exception
     *
     * @return mixed
     */
    protected function get(Request $request, $mapper = null)
    {
        $url = $this->getPattern($request->getParameters(), $request->getPath());
        
        try {
            $method = $request->getMethod();
            /** @var \Psr\Http\Message\ResponseInterface $response */
            return $this->client->$method($url)->map($mapper);
        } catch (ConnectException $e) {
            return null;
        }
    }
    
    /**
     * @param array $variables
     * @param null  $pattern
     *
     * @return mixed
     */
    protected function getPattern(array $variables = [], $pattern = null)
    {
        $pattern = $pattern ?: $this->pattern;
        $query =  count($variables) ? http_build_query($variables) : '';

        /* @var Uri $uri */
        $uri = $this->client->getConfig('base_uri');

        return $uri->withPath($pattern)->withQuery($query);
    }
    
    /**
     * @return HttpClient
     */
    protected function getClient()
    {
        return $this->client;
    }

    /**
     * @param HttpClient $client
     */
    public function setClient(HttpClient $client)
    {
        $this->client = $client;
    }

    protected function createRequestFromMethod(array $method, array $options = []) : Request
    {

    }
}
