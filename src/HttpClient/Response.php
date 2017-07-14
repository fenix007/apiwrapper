<?php

namespace Fenix007\Wrapper\HttpClient;

use Illuminate\Support\Str;
use Fenix007\Wrapper\Mappers\MapperTrait;

/**
 * Class Response
 * @package Fenix007\Wrapper\HttpClient
 */
class Response extends  \GuzzleHttp\Psr7\Response
{
    use MapperTrait;

    public function getContentOrNull() : ?string
    {
        if ($this->getStatusCode() !== 200) {
            return null;
        }

        if (!$content = $this->getBody()->getContents()) {
            return null;
        }

        if (!$content = $this->checkContent($content)) {
            return null;
        }

        return $content;
    }

    /**
     * @param string $content
     *
     * @return string|bool
     */
    protected function checkContent(string $content)
    {
        if (Str::contains($content, 'captchaSound')) {
            return false;
        }

        return $content;
    }

    public static function createFromPsrResponse(\GuzzleHttp\Psr7\Response $response) : self
    {
        return new static(
            $response->getStatusCode(),
            $response->getHeaders(),
            $response->getBody(),
            $response->getProtocolVersion(),
            $response->getReasonPhrase()
        );
    }
}
