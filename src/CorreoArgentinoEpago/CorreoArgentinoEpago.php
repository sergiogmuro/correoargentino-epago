<?php

namespace CorreoArgentinoEpago;

use CorreoArgentinoEpago\Models\Request\Declaration;
use Exception;

/**
 * Class CorreoArgentinoEpago
 *
 * API For Corre Argentino EPago
 *
 * @package App\CorreoArgentinoApi
 */
class CorreoArgentinoEpago extends AbstractCorreoArgentinoEpago
{
    /**
     * Setting credentials for user into epago website
     *
     * @param string $email    username to login in epago
     * @param string $password password to login in epago
     *
     * @throws Exception
     */
    public function __construct(string $email, string $password)
    {
        parent::__construct($email, $password);
    }

    public function rubros(): array
    {
        $url = self::BASE_URL . self::API_URL_CATEGORIES;
        $result = $this->requestEpago($url);

        $rubros = $result['data']["rubros"];
        $subrubros = $result['data']["subrubros"];

        $categories = [];
        $codeThreshold = 10000;
        foreach ($rubros as $k => $rubro) {
            $categories[$k]['code'] = $rubro['codigo'];
            $categories[$k]['name'] = $rubro['nombre'];
            foreach ($subrubros as $ks => $subrubro) {
                if ($subrubro['codigo'] > $rubro['codigo'] &&
                    $subrubro['codigo'] < $rubro['codigo'] + $codeThreshold) {
                    $categories[$k]['subcategory'][] = [
                        'code' => $subrubro['codigo'],
                        'name' => $subrubro['nombre']
                    ];
                }
            }
        }

        return $categories;
    }

    public function me(): array
    {
        $url = self::BASE_URL . self::API_URL_ME;
        return $this->requestEpago($url);
    }

    public function track($partId): array
    {
        $url = self::BASE_URL . self::API_URL_TRACK;
        $params = [
            "pieza_id" => $partId,
        ];
        return $this->requestEpago($url, 'POST', $params);
    }

    /**
     * Inform an international buy with an international tracking number
     *
     * @param string $partId
     * @param string $firstname
     * @param string $lastname
     *
     * @return array
     */
    public function inform(string $partId, string $firstname, string $lastname): array
    {
        $url = self::BASE_URL . self::API_URL_INFORM_BUY;
        $params = [
            "pieza_id" => $partId,
            "acepto_tyc" => true,
            "nombre" => ucwords($firstname),
            "apellido" => ucwords($lastname)
        ];
        return $this->requestEpago($url, 'POST', $params);
    }

    /**
     * Declare items for tracking order
     *
     * @param Declaration $declaration
     *
     * @return array
     * @throws Exception
     */
    public function declaration(Declaration $declaration): array
    {
        $url = self::BASE_URL . self::API_URL_STORE_DECLARE;
        return $this->requestEpago($url, 'POST', $declaration->get());
    }

}