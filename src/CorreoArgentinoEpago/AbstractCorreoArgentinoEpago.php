<?php

namespace CorreoArgentinoEpago;

use Exception;

abstract class AbstractCorreoArgentinoEpago extends AbstractCorreoArgentino
{
    const BASE_URL = 'https://epagobe.correoargentino.com.ar';
    const API_URL_BASE = '/api/v2';
    const API_URL_TOKEN = '/oauth/token';
    const API_URL_ME = self::API_URL_BASE . '/me';
    const API_URL_TRACK = self::API_URL_BASE . '/get-seguimiento';
    const API_URL_INFORM_BUY = self::API_URL_BASE . '/aviso-compra';
    const API_URL_STORE_DECLARE = self::API_URL_BASE . '/guardar-declarar';
    const API_URL_CATEGORIES = self::API_URL_BASE . '/general';

    // Credentials used by epago api
    private static $apiClientId = 2;
    private static $apiClientSecret = "tmUH9mBHeh1h7cq7krmDZIKOsBJxmYwxnBsCVhev";

    private static $username = null;
    private static $password = null;

    private static $headers = [
        'Content-Type:application/json'
    ];

    public function __construct(string $username, string $password)
    {
        self::$username = $username;
        self::$password = $password;

        $this->getAccessToken();
    }

    protected function requestEpago(string $url, string $method = 'GET', array $params = [], array $headers = []): array
    {
        if (empty($headers)) {
            $headers = self::$headers;
        }

        return json_decode($this->request($url, $headers, $method, $params), true);
    }

    /**
     * Getting access token for queries
     */
    private function getAccessToken()
    {
        $url = self::BASE_URL . self::API_URL_TOKEN;
        $data = [
            "grant_type" => "password",
            "client_id" => self::$apiClientId,
            "client_secret" => self::$apiClientSecret,
            "username" => self::$username,
            "password" => self::$password
        ];

        $result = json_decode($this->request($url, self::$headers, 'POST', $data));

        if (empty($result->access_token)) {
            throw new \Exception("Can't get access token. Error: " . $result);
        }

        self::$headers[] = 'Authorization: Bearer ' . $result->access_token;
    }

}
