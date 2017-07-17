<?php

namespace Fenix007\Wrapper\HttpClient;

use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Uri;
use Illuminate\Support\Facades\Cache;
use Kevinrob\GuzzleCache\CacheMiddleware;
use Kevinrob\GuzzleCache\Storage\LaravelCacheStorage;
use Kevinrob\GuzzleCache\Strategy\GreedyCacheStrategy;
use Phlib\Guzzle\ConvertCharset;
use Fenix007\Wrapper\ApiToken;

/**
 * Class HttpClient
 * @package Fenix007\Wrapper
 */
abstract class AbstractHttpClient extends Client
{
    /**
     * @var string
     */
    protected $cstore = 'file';

    /**
     * @var \Fenix007\Wrapper\ApiToken
     */
    protected $apiToken;

    protected abstract function getSecurityParamsToUri() : string;

    /**
     * HttpClient constructor.
     *
     * @param \Fenix007\Wrapper\ApiToken $apiToken
     * @param array                   $config
     */
    public function __construct(ApiToken $apiToken, array $config = [])
    {
        $this->apiToken = $apiToken;
        $stack          = HandlerStack::create();

        $stack->push($this->cacheMiddleware(), 'cache');
        $stack->push($this->charsetMiddleware(), 'charset');

        $config = array_merge([
            'handler' => $stack,
        ], $config);

        parent::__construct($config);
    }

    private function injectAuthInfoToUri(Uri $uri): Uri
    {
        if ($secureParams = $this->getSecurityParamsToUri()) {
            // Returns a string if the URL has parameters or NULL if not
            $uri = $uri->withQuery(($uri->getQuery() ? $uri->getQuery() . '&' : '') . $secureParams);
        }

        return $uri;
    }

    /**
     * @param int $ttl
     *
     * @return CacheMiddleware
     */
    protected function cacheMiddleware($ttl = 86400): CacheMiddleware
    {
        $store = new LaravelCacheStorage(Cache::store($this->cstore));

        return new CacheMiddleware(new GreedyCacheStrategy($store, $ttl));
    }

    /**
     * @return ConvertCharset
     */
    protected function charsetMiddleware(): ConvertCharset
    {
        return new ConvertCharset();
    }

    public function __call($name, $arguments)
    {
        if (in_array($name, Request::METHODS)) {
            $uri = $this->injectAuthInfoToUri($arguments[0]);

            $options = $arguments[1] ?? [];

            return Response::createFromPsrResponse(
                $this->getContent(strtolower($name), [$uri, $options])
            );
        }

        throw new \BadMethodCallException("There is not method $name in HtppClient class");
    }

    protected function getContent($name, $arguments)
    {
        return parent::__call(strtolower($name), $arguments);
    }

    public function getApiToken() : string
    {
        return $this->apiToken->getToken();
    }
}
