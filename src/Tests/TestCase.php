<?php

namespace Fenix007\Wrapper\Tests;

use Fenix007\Wrapper\Tests\Api\FileHttpTrait;
use Orchestra\Database\ConsoleServiceProvider;
use Fenix007\Wrapper\ApiToken;
use Fenix007\Wrapper\Tests\HttpClient\HttpClient;
use Symfony\Component\Finder\Finder;

class TestCase extends \Orchestra\Testbench\TestCase
{
    use ArrayFunctions;
    use FileHttpTrait;

    const CONFIG_DIRECTORY = '/../../../../src/config/';

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

    public function createRealHttpClient() : \Fenix007\Wrapper\HttpClient\HttpClient
    {
        return new \Fenix007\Wrapper\HttpClient\HttpClient($this->createApiToken(true), $this->createRealConfig());
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

    /**
     *  get first file from config folder
     * TODO: correct
     */
    protected function createRealConfig()
    {
        return include $this->getFirstFileNameInPath(static::CONFIG_DIRECTORY);
    }

    protected function getFirstFileNameInPath(string $path) : string
    {
        $finder = new Finder();
        $iterator = $finder->in($path)->getIterator();
        $iterator->rewind();

        return (string)$iterator->current();
    }

    public function assertEqualsExcept(array $one, array $two, array $fields)
    {
        $this->assertEquals(
            $this->excludeArrayOrSubArrayFields($one, $fields),
            $this->excludeArrayOrSubArrayFields($two, $fields)
        );
    }
}
