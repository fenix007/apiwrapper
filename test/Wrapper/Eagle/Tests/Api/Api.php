<?php

namespace Fenix007\Wrapper\Tests\Api;

use Fenix007\Wrapper\Api\AbstractApi;
use Fenix007\Wrapper\HttpClient\Request;
use Fenix007\Wrapper\HttpClient\Response;

class Api extends AbstractApi
{
    /**
     * @param Request $request
     * @param Request $mapper
     * @throws \Exception
     *
     * @return mixed
     */
    public function get(Request $request, $mapper = null) : ?\GuzzleHttp\Psr7\Response
    {
        try {
            /** @var \Psr\Http\Message\ResponseInterface $response */
            return $this->loadByFile($request->getPath())->map($mapper);
        } catch (\InvalidArgumentException $e) {
            return null;
        }
    }

    /**
     * Load an json file from the Resources directory
     *
     * @param $file
     * @throws \HttpInvalidParamException
     * @return Response
     */
    public function loadByFile($file) : Response
    {
        if (!file_exists(__DIR__ . '/Resources/' . $file)) {
            throw new \InvalidArgumentException('File not found in resource');
        }

        $content = file_get_contents(
            sprintf(
                '%s/%s',
                __DIR__ . '/Resources/',
                $file
            )
        );

        return new Response(
            $content ? 200: 500,
            [],
            $content
        );
    }
}
