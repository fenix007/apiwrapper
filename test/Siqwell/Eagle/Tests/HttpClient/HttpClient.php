<?php

namespace Siqwell\Eagle\Tests\HttpClient;

use Kevinrob\GuzzleCache\CacheMiddleware;
use Siqwell\Eagle\HttpClient\Response;

class HttpClient extends \Siqwell\Eagle\HttpClient\HttpClient
{
    protected function getSecurityParamsToUri(): string
    {
        return "";
    }

    protected function getContent($name, $arguments)
    {
        $baseUri = $this->getConfig('base_uri');

        [$uri, $options] = $arguments;

        $filePath = $baseUri . '/' . $uri;
        if (!file_exists($filePath)) {
            throw new \InvalidArgumentException("File $filePath does not exists");
            //throw new ConnectException("File $filePath does not exists", new \GuzzleHttp\Psr7\Request('GET', $uri));
        }

        $content = file_get_contents($filePath);

        return new Response(200, [], $content);
    }

    public function cacheMiddleware($ttl = 86400): CacheMiddleware
    {
        return new CacheMiddleware();
    }
}
