<?php

namespace Fenix007\Wrapper\Tests\Api;

use Fenix007\Wrapper\ApiToken;
use Fenix007\Wrapper\Methods;
use Fenix007\Wrapper\Tests\HttpClient\HttpClient;

class TestCase extends \Fenix007\Wrapper\Tests\TestCase
{
    use FileHttpTrait;

    const DYNAMIC_FIELDS = [
    ];

    /** @var  Api */
    private $api;

    /**
     * TestCase constructor.
     */
    public function __construct()
    {
        $this->api = new Api(new HttpClient(new ApiToken()), new Methods());
    }

    public function setFakeApiClient()
    {
        $this->api->setClient(new HttpClient(new ApiToken()), new Methods());
    }

    public function setRealApiClient()
    {
        $this->api->setClient(new \Fenix007\Wrapper\HttpClient\HttpClient(new ApiToken()), new Methods());
    }

    protected function getUrlWithoutQuery($url)
    {
        $urlParts = explode('?', $url);

        return $urlParts[0];
    }
}

