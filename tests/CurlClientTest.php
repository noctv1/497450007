<?php
namespace tests;

use http\CurlClient;

class CurlClientTest extends \PHPUnit\Framework\TestCase
{
    public function testCurlRequest()
    {
        $url = "https://my-api.vertu.com/vemory/api/records?user_name=%E4%BD%95%E5%90%8D%E6%B1%9F";
        try {
            $client = new CurlClient();
            $result = $client->CurlRequest($url);
        } catch (\Exception $e) {
            $this->fail($e->getMessage());
        }
        print_r($result);
        $this->assertIsArray($result,"curl request failed");
    }
}