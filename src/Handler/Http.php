<?php
/**
 * Created by PhpStorm.
 * User: AMC19
 * Date: 2017/9/11
 * Time: 17:04
 */

namespace liyaojian\Easemob\Handler;

use GuzzleHttp\Client;

class Http
{
    public $http;

    public function __construct()
    {
        $this->http = new Client();
    }

    private static function format($response)
    {
        $responseBody = json_decode((string)$response->getBody(), true);
        if ($response->getStatusCode() != 200) {
            throw new EasemobError($responseBody['error'], $response->getStatusCode());
        }
        
        return $responseBody;
    }

    public function get($uri, array $option = [], $access_token = null)
    {
        $body = [
            'http_errors' => false
        ];
        empty($access_token) ?: $body['headers'] = [
            'Authorization' => 'Bearer ' . $access_token
        ];
        empty($option) ?: $body['json'] = $option;

        $response = $this->http->get($uri, $body);
        return $this->format($response);
    }

    public function post($uri, array $option = [], $access_token = null)
    {
        $body = [
            'http_errors' => false
        ];
        empty($access_token) ?: $body['headers'] = [
            'Authorization' => 'Bearer ' . $access_token
        ];
        empty($option) ?: $body['json'] = $option;

        $response = $this->http->post($uri, $body);
        return $this->format($response);
    }

    public function put($uri, array $option = [], $access_token = null)
    {
        $body = [
            'http_errors' => false
        ];
        empty($access_token) ?: $body['headers'] = [
            'Authorization' => 'Bearer ' . $access_token
        ];
        empty($option) ?: $body['json'] = $option;

        $response = $this->http->put($uri, $body);
        return $this->format($response);
    }

    public function delete($uri, array $option = [], $access_token = null)
    {
        $body = [
            'http_errors' => false
        ];
        empty($access_token) ?: $body['headers'] = [
            'Authorization' => 'Bearer ' . $access_token
        ];
        empty($option) ?: $body['json'] = $option;

        $response = $this->http->delete($uri, $body);
        return $this->format($response);
    }
}