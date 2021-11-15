<?php
/***
 * TEST
 */

require_once "src/CorreoArgentinoEpago/Models/Request/RequestInterface.php";
require_once "src/CorreoArgentinoEpago/Models/Request/Declaration.php";
require_once "src/CorreoArgentinoEpago/Models/Request/DeclarationProduct.php";
require_once "src/CorreoArgentinoEpago/AbstractCorreoArgentino.php";
require_once "src/CorreoArgentinoEpago/AbstractCorreoArgentinoEpago.php";
require_once "src/CorreoArgentinoEpago/CorreoArgentinoEpago.php";

use CorreoArgentinoEpago\CorreoArgentinoEpago;
use CorreoArgentinoEpago\Models\Request\Declaration;
use CorreoArgentinoEpago\Models\Request\DeclarationProduct;

$epago = new CorreoArgentinoEpago('my_email@example.com', 'myPassword');
// All categories
print_r($epago->rubros());
//// My packages informed
print_r($epago->me());
//// Track the packages
print_r($epago->track('AB123456789TS'));

// Construct declaration
$d = (new Declaration())
    ->setPartId('AB123456789TS')
    ->setShippingCost(12.3)
    ->setAuthorizeCoraza(true);

// Adding products to declaration
for ($i = 0; $i < rand(1, 5); $i++) {
    $dp = (new DeclarationProduct())
        ->setDescription("Test test")
        ->setCategory(10010000)
        ->setSubcategory(10010001)
        ->setQty(rand(1, 3))
        ->setUnitPrice(20 / rand(1, 10));

    $d->addProduct($dp);
}
// Declare
print_r($epago->declaration($d));
