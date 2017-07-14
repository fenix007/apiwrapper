<?php

namespace Siqwell\Eagle\Tests;

use Orchestra\Database\ConsoleServiceProvider;
use Siqwell\Eagle\ApiToken;
use Siqwell\Eagle\Tests\HttpClient\HttpClient;

class TestCase extends \Orchestra\Testbench\TestCase
{
    use ArrayFunctions;

    protected function getPackageProviders($app)
    {
        return [
            ConsoleServiceProvider::class
        ];
    }

    public function createFakeHttpClient() : HttpClient
    {
        return new HttpClient($this->createApiToken(), $this->createFakeConfig());
    }

    public function createRealHttpClient() : \Siqwell\Eagle\HttpClient\HttpClient
    {
        return new \Siqwell\Eagle\HttpClient\HttpClient($this->createApiToken(true), $this->createRealConfig());
    }

    protected function createApiToken($isReal = false) : ApiToken
    {
        $config = $isReal ? $this->createRealConfig() : $this->createFakeConfig();

        return new ApiToken($config['api_key']);
    }

    protected function createFakeConfig() : array
    {
        return [
            'api_key' => '',
            'base_uri' => __DIR__ . '/Resources'
        ];
    }

    protected function createRealConfig()
    {
        //TODO: fix no load config
        return include __DIR__ . '/../../../../src/config/eagle.php';
    }

    public function assertEqualsExcept(array $one, array $two, array $fields)
    {
        $this->assertEquals(
            $this->excludeArrayOrSubArrayFields($one, $fields),
            $this->excludeArrayOrSubArrayFields($two, $fields)
        );
    }
}
