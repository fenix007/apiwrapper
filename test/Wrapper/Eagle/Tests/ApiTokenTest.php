<?php
namespace Fenix007\Wrapper\Tests;

class ApiTokenTest extends \PHPUnit_Framework_TestCase
{
    const API_TOKEN = 'abcdefg';

    /**
     * @test
     */
    public function testSetGet()
    {
        $token  = new \Fenix007\Wrapper\ApiToken();
        $token->setToken(self::API_TOKEN);

        $this->assertEquals(self::API_TOKEN, $token->getToken());
        $this->assertEquals(self::API_TOKEN, (string) $token);
    }

    /**
     * @expectedException \RuntimeException
     * @test
     */
    public function testThrowsErrorOnEmptyApiToken()
    {
        $token  = new \Fenix007\Wrapper\ApiToken();
        $token->setToken(null);
    }
}
