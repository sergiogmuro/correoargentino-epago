<?php

namespace CorreoArgentinoEpago\Models\Request;

use Exception;

class DeclarationProduct implements RequestInterface
{
    private $description = null;
    private $qty = 0;
    private $unitPrice = 0.00;
    private $category = 10170000;
    private $subcategory = 10170001;

    /**
     * @throws Exception
     */
    public function get(): array
    {
        if (empty($this->category)) {
            throw new Exception('Category is not defined.');
        }
        if (empty($this->subcategory)) {
            throw new Exception('Subcategory is not defined.');
        }
        if (empty($this->description)) {
            throw new Exception('Description is not defined.');
        }
        if (empty($this->qty)) {
            throw new Exception('Qty is not defined.');
        }
        if (empty($this->unitPrice)) {
            throw new Exception('UnitPrice is not defined.');
        }

        return [
            "id_rubro" => (string)$this->category,
            "id_subrubro" => (string)$this->subcategory,
            "descripcion" => $this->description,
            "cantidad" => (string)$this->qty,
            "monto_unitario" => $this->unitPrice,
            "op" => "", // ??
            "isClicked" => false // ??
        ];
    }

    /**
     * @param int $category
     *
     * @return DeclarationProduct
     * @throws Exception
     */
    public function setCategory(int $category): DeclarationProduct
    {
        if ($category % 100 > 0 || $category < 10010000) {
            throw new Exception('Use category instead subcategory');
        }
        $this->category = (string)$category;
        return $this;
    }

    /**
     * @param int $subcategory
     *
     * @return DeclarationProduct
     * @throws Exception
     */
    public function setSubcategory(int $subcategory): DeclarationProduct
    {
        if ($subcategory % 11 == 0 || $subcategory < 10010000) {
            throw new Exception('Use subcategory instead category');
        }
        $this->subcategory = (string)$subcategory;
        return $this;
    }

    /**
     * @param string $description
     * @param bool   $cleanString
     *
     * @return DeclarationProduct
     */
    public function setDescription(string $description, bool $cleanString = true): DeclarationProduct
    {
        $this->description = $description;

        if ($cleanString) {
            $this->description = preg_replace('/[^a-zA-Z0-9\s]/', '', $description);
        }
        return $this;
    }

    /**
     * @param int $qty
     *
     * @return DeclarationProduct
     */
    public function setQty(int $qty): DeclarationProduct
    {
        $this->qty = (string)$qty;
        return $this;
    }

    /**
     * @param float $unitPrice
     *
     * @return DeclarationProduct
     */
    public function setUnitPrice(float $unitPrice): DeclarationProduct
    {
        $this->unitPrice = $unitPrice;
        return $this;
    }
}
