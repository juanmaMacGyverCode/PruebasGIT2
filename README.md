# Requisitos para usar la aplicación: XAMPP y Composer

## Para instalar las dependencias PHPUnit para los test:

```bash
composer require --dev phpunit/phpunit ^8.5
```

## Probar test (Recomiendo situar el bash de cmd en la carpeta del proyecto \smallshop\tests): 

```bash
.\vendor\bin\phpunit --bootstrap .\vendor\autoload.php .\tests\TestEncrypt
.\vendor\bin\phpunit --bootstrap .\vendor\autoload.php .\tests\TestLayoutRequestSimple
.\vendor\bin\phpunit --bootstrap .\vendor\autoload.php .\tests\TestShowLoginRegisterLogout
.\vendor\bin\phpunit --bootstrap .\vendor\autoload.php .\tests\TestUserExists
.\vendor\bin\phpunit --bootstrap .\vendor\autoload.php .\tests\TestCreateDeleteUsers
.\vendor\bin\phpunit --bootstrap .\vendor\autoload.php .\tests\TestEmailExists
.\vendor\bin\phpunit --bootstrap .\vendor\autoload.php .\tests\TestCreateDeleteCustomers
.\vendor\bin\phpunit --bootstrap .\vendor\autoload.php .\tests\TestUpdateCustomers
.\vendor\bin\phpunit --bootstrap .\vendor\autoload.php .\tests\TestThereIsThatID
.\vendor\bin\phpunit --bootstrap .\vendor\autoload.php .\tests\TestLayoutDataSheetCustomers
```