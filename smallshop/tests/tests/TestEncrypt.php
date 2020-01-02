<?php

declare(strict_types=1);
//require_once ('../controlador/controladorIndex/functions.php');

//include("..\\controlador\\controladorIndex\\functions.php");

use PHPUnit\Framework\TestCase;
//use functions;

final class TestEncrypt extends TestCase
{
    /*public function testCanBeCreatedFromValidEmailAddress(): void
    {
        $this->assertInstanceOf(
            Email::class,
            Email::fromString('user@example.com')
        );
    }*/

    /*public function testCannotBeCreatedFromInvalidEmailAddress(): void
    {
        $this->expectException(InvalidArgumentException::class);

        Email::fromString('invalid');
    }*/

    /*public function testCanBeUsedAsString(): void
    {
        $calc = new Email();
        $this->assertEquals(
            7,
            $calc->suma(3, 4)
        );
    }
    public function testCanBeUsedAsString2(): void
    {
        $calc = new Email();
        $this->assertEquals(
            7,
            $calc->suma(3, 4)
        );
    }
    public function testCanBeUsedAsString3(): void
    {
        $calc = new Email();
        $this->assertEquals(
            7,
            $calc->suma(3, 4)
        );
    }*/
    public function testEncryptDecryptEquals1(): void
    {
        $this->assertEquals(
            "fernando",
            decrypt(encrypt("fernando", "1235@"), "1235@")
        );
    }
    public function testEncryptDecryptEquals2(): void
    {
        $this->assertEquals(
            "j",
            decrypt(encrypt("j", "1235@"), "1235@")
        );
    }
    public function testEncryptDecryptEquals3(): void
    {
        $this->assertEquals(
            "1234",
            decrypt(encrypt("1234", "1235@"), "1235@")
        );
    }
    public function testEncryptDecryptEquals4(): void
    {
        $this->assertEquals(
            "lu23da",
            decrypt(encrypt("lu23da", "1235@"), "1235@")
        );
    }
    public function testEncryptDecryptEquals5(): void
    {
        $this->assertEquals(
            "bla bla",
            decrypt(encrypt("bla bla", "1235@"), "1235@")
        );
    }
    public function testEncryptDecryptNotEquals1(): void
    {
        $this->assertNotEquals(
            "b",
            decrypt(encrypt("a", "1235@"), "1235@")
        );
    }
    public function testEncryptDecryptNotEquals2(): void
    {
        $this->assertNotEquals(
            "lara",
            decrypt(encrypt("larc", "1235@"), "1235@")
        );
    }
    public function testEncryptDecryptNotEquals3(): void
    {
        $this->assertNotEquals(
            "blabla",
            decrypt(encrypt("bla bla", "1235@"), "1235@")
        );
    }
    public function testEncryptDecryptNotEquals4(): void
    {
        $this->assertNotEquals(
            "ab123c",
            decrypt(encrypt("abc123", "1235@"), "1235@")
        );
    }
    public function testEncryptDecryptNotEquals5(): void
    {
        $this->assertNotEquals(
            "fernando",
            decrypt(encrypt("carlos", "1235@"), "1235@")
        );
    }

    /*public function testRequestSimple(): void
    {
        $layout = new functions();
        //$encrypt->encrypt("fernando", "1235@");
        $this->assertEquals(
            "<p class=\"text-danger\">Username or password incorrect</p>",
            $layout->requestSimple("dataIncorrect")
        );
    }

    public function testRequestSimpleNotEquals(): void
    {
        $layout = new functions();
        //$encrypt->encrypt("fernando", "1235@");
        $this->assertNotEquals(
            "<p class=\"text-danger\">There is any empty field</p>",
            $layout->requestSimple("dataIncorrect")
        );
    }*/
}

function encrypt($data, $key)
{
    $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
    $encrypted = openssl_encrypt($data, "aes-256-cbc", $key, 0, $iv);
    return base64_encode($encrypted . "::" . $iv);
}

function decrypt($data, $key)
{
    list($encrypted_data, $iv) = explode('::', base64_decode($data), 2);
    return openssl_decrypt($encrypted_data, 'aes-256-cbc', $key, 0, $iv);
}

/*class functionsTester
{
    public function __construct()
    {
    }

    public function encrypt($data, $key)
    {
        $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
        $encrypted = openssl_encrypt($data, "aes-256-cbc", $key, 0, $iv);
        return base64_encode($encrypted . "::" . $iv);
    }

    public function decrypt($data, $key)
    {
        list($encrypted_data, $iv) = explode('::', base64_decode($data), 2);
        return openssl_decrypt($encrypted_data, 'aes-256-cbc', $key, 0, $iv);
    }*/

    /*public function layoutSimple($option)
    {

        return "<div class=\"row mt-5 mb-5\">
                <div class=\"mx-auto w-50 p-3 text-center opacity-80\">
                    " . requestSimple($option) . "
                </div>
            </div>";
    }

    public function requestSimple($option)
    {
        if ($option == "dataIncorrect") {
            return "<p class=\"text-danger\">Username or password incorrect</p>";
        } else if ($option == "emptyField") {
            return "<p class=\"text-danger\">There is any empty field</p>";
        } else if ($option == "requestLogin") {
            return "<p class=\"mb-0\"><span class=\"font-weight-bold\">Sign up</span> and <span class=\"font-weight-bold\">login</span> to use the application.<br>If you have an account, <span class=\"font-weight-bold\">please login</span></p>";
        } else if ($option == "dataNotFound") {
            return "<p class=\"text-danger\">Error: The data was not found</p><div class=\"d-flex justify-content-around mt-3 mb-3\"><a href=\"\" class=\"btn btn-primary\">Return</a></div>";
        } else if ($option == "menu") {
            return "<h1 class=\"mb-0\">WELCOME TO SMALLSHOP</h1>
                <hr>
                <p class=\"mb-0\">Choose an option</p>
                <div class=\"list-group mt-3\">
                    <form method=\"post\" action=\"\" enctype=\"multipart/form-data\" class=\"needs-validation\">
                        <button type=\"submit\" class=\"list-group-item list-group-item-action\" name=\"listAllCostumers\">List all costumers</button>
                        <button type=\"submit\" class=\"list-group-item list-group-item-action\" name=\"getCostumerInformation\">Get full costumer information</button>
                        <button type=\"submit\" class=\"list-group-item list-group-item-action\" name=\"createCostumer\">Create a new costumer</button>
                        <button type=\"submit\" class=\"list-group-item list-group-item-action\" name=\"updateCostumer\">Update an existing costumer</button>
                        <button type=\"submit\" class=\"list-group-item list-group-item-action\" name=\"deleteCostumer\">Delete an existing costumer</button>
                    </form>
                </div>";
        }
    }*/
/*}*/
