# Correo Argentino Epago
Api para consultas y gestion en Correo Argentino plataforma epago

### Installation
```shell
composer require sergiomuro/correoargentino-epago
```

### Make Request

```php
use CorreoArgentinoEpago\CorreoArgentinoEpago;

$epago = new CorreoArgentinoEpago('my_email@example.com', 'myPassword');
```
-----
### Usage
Get all rubros
```php
print_r($epago->rubros());
```

Get my packages inform
```php
print_r($epago->me());
```

Track my inform package
```php
print_r($epago->track('AB123456789CD'));
```

Set Declaration AFIP
```php
// Construct declaration
$d = (new Declaration())
    ->setPartId('AB123456789CD')
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
```