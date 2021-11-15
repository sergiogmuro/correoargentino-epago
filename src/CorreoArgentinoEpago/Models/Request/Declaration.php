<?php

namespace CorreoArgentinoEpago\Models\Request;

use Exception;

class Declaration implements RequestInterface
{
    private $partId = '';
    private $shippingCost = 0.0;
    private $authorizeCoraza = true; // Authorize Correo Argentino management front Aduanas
    private $authorizeOther = false; // Authorize other person to get package
    private $cuitOther = ""; //Other person CUIT
    private $products = [];

    /**
     * @throws Exception
     */
    public function get(): array
    {
        if (empty($this->shippingCost) ||
            empty($this->partId) ||
            empty($this->products)
        ) {
            throw new Exception('Required fields not completed', 400);
        }

        return [
            "pieza_id" => $this->partId,
            "cif" => $this->shippingCost,
            "ignora_contenido" => false,
            "autoriza_tercero" => $this->authorizeOther,
            "cuit_tercero" => $this->cuitOther,
            "autoriza_corasa" => $this->authorizeCoraza,
            "ip" => "",
            "productos" => $this->products
        ];
    }

    public function addProduct(DeclarationProduct $product) {
        $this->products[] = $product;
    }

    /**
     * @param string $partId
     *
     * @return Declaration
     */
    public function setPartId(string $partId): Declaration
    {
        $this->partId = $partId;
        return $this;
    }

    /**
     * @param float $shippingCost
     *
     * @return Declaration
     */
    public function setShippingCost(float $shippingCost): Declaration
    {
        $this->shippingCost = $shippingCost;
        return $this;
    }

    /**
     * @param bool $authorizeCoraza
     *
     * @return Declaration
     */
    public function setAuthorizeCoraza(bool $authorizeCoraza): Declaration
    {
        $this->authorizeCoraza = $authorizeCoraza;
        return $this;
    }

    /**
     * @param bool $authorizeOther
     *
     * @return Declaration
     */
    public function setAuthorizeOther(bool $authorizeOther): Declaration
    {
        $this->authorizeOther = $authorizeOther;
        return $this;
    }

    /**
     * @param string $cuitOther
     *
     * @return Declaration
     */
    public function setCuitOther(string $cuitOther): Declaration
    {
        $this->cuitOther = $cuitOther;
        return $this;
    }
}
