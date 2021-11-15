<?php

namespace CorreoArgentinoEpago;

use CorreoArgentinoEpago\Models\Request\Ecommerce;
use CorreoArgentinoEpago\Models\Request\Internacional;
use CorreoArgentinoEpago\Models\Request\Mercadolibre;
use CorreoArgentinoEpago\Models\Request\Nacional;
use CorreoArgentinoEpago\Models\Request\RequestInterface;

abstract class AbstractCorreoArgentino
{
    protected function request(string $url, array $headers = [], string $method = 'GET', array $params = []): string
    {
        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => $method,
            CURLOPT_POST => ($method == 'POST' ? 1 : 0),
            CURLOPT_POSTFIELDS => json_encode($params),
            CURLOPT_HTTPHEADER => $headers,
        ]);

        $response = curl_exec($curl);

        curl_close($curl);
        return json_decode(json_encode($response, true)) ?? '';
    }
}
