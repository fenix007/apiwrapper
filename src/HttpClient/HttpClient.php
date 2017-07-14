<?php
namespace Fenix007\Wrapper\HttpClient;

class HttpClient extends AbstractHttpClient
{
    protected function getSecurityParamsToUri(): string
    {
        return "account={$this->getConfig('account')}&auth_token={$this->apiToken->getToken()}";
    }
}
