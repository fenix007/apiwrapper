<?php

namespace Fenix007\Wrapper\Tests\Api;

use Siqwell\DataScreen\HttpClient\Request;

trait FileHttpTrait
{
    /**
     * Get the expected request that will deliver a response
     *
     * @param $path
     * @param  array   $parameters
     * @param  string  $method
     * @return \Siqwell\DataScreen\HttpClient\Request
     */
    protected function createRequest($method = 'GET', $path, array $parameters = []) : Request
    {
        $request = new Request(
            $method,
            $path,
            $parameters
        );

        return $request;
    }

    public function getResponseDataFromFile($relativePath, $parameters = [])
    {
        $response = $this->getDataFromFile(
            $this->getAbsolutePath($relativePath),
            $parameters
        );

        if (!isset($response['data'])) {
            throw new \RuntimeException(sprintf(
                "Data field not found in response body file '%s'",
                $relativePath
            ));
        }

        return $response['data'];
    }

    protected function getDataFromFile($path, array $parameters = []) : array
    {
        foreach ($parameters as $var => $val) {
            $path = str_replace('{' . $var . '}', $val, $path);
        }

        if (!file_exists($path)) {
            throw new \RuntimeException("Resource test file '$path' does not found");
        }

        if (!$response = @\json_decode(file_get_contents($path), true)) {
            throw new \RuntimeException("Error to decode json file '$path'");
        }

        return $response;
    }

    protected function getAbsolutePath($path, $ext = null) : string
    {
        $config = $this->createFakeConfig();

        return $this->checkFileExtension($config['base_uri'] . '/' . $path, $ext) ;
    }

    protected function checkFileExtension($path, $ext = 'json') : string
    {
        if (!$ext) {
            return $path;
        }

        $fileParts = pathinfo($path);

        if (!isset($fileParts['extension'])) {
            $path .= '.' . $ext;
        }

        return $path;
    }

    protected function createRequestFromFile($relativePath,  $method = 'GET', $parameters = []) : Request
    {
        $jsonData = $this->getDataFromFile($this->getAbsolutePath($relativePath, 'json'));

        $parameters = $jsonData ? [$jsonData] : $parameters;

        return $this->createRequest(
            $method,
            $relativePath,
            $parameters
        );
    }
}
