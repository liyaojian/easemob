<?php
/**
 * Created by PhpStorm.
 * User: AMC19
 * Date: 2017/9/11
 * Time: 17:04
 */

namespace liyaojian\Easemob\App;


use GuzzleHttp\Client;

class Http
{
    private $http;

    public function __construct()
    {
        $this->http = new Client();
    }

    private static function format($response)
    {
        return json_decode($response->getBody());
    }

    public function get($uri, $access_token, $option)
    {
        $body = [
            'headers' => [
                'Authorization' => 'Bearer ' . $access_token
            ],
        ];
        empty($option) ?: $body['json'] = $option;

        $response = $this->http->get($uri, $body);
        return $this->format($response);
    }

    public function post($uri, $access_token, $option)
    {
        $body = [
            'headers' => [
                'Authorization' => 'Bearer ' . $access_token
            ],
        ];
        empty($option) ?: $body['json'] = $option;

        $response = $this->http->post($uri, $body);
        return $this->format($response);
    }


}