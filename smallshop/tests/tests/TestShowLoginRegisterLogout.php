<?php

declare(strict_types=1);
//require_once ('../controlador/controladorIndex/functions.php');

//include("..\\controlador\\controladorIndex\\functions.php");

use PHPUnit\Framework\TestCase;
//use functions;

final class TestEncrypt extends TestCase
{
    public function testShowLoginRegisterLogoutEquals1(): void
    {
        $this->assertEquals(
            "<span class=\"nav-item text-white mr-sm-2\">Bienvenido AmorDeMiAlmaProfundo</span>
            <input class=\"btn btn-outline-success my-2 my-sm-0\" type=\"submit\" name=\"logout\" aria-label=\"Logout\" value=\"Logout\">",
            showLoginRegisterLogout(encrypt("AmorDeMiAlmaProfundo", "1235@"))
        );
    }

    public function testShowLoginRegisterLogoutEquals2(): void
    {
        $this->assertEquals(
            "<span class=\"nav-item text-white mr-sm-2\">Bienvenido Fernando</span>
            <input class=\"btn btn-outline-success my-2 my-sm-0\" type=\"submit\" name=\"logout\" aria-label=\"Logout\" value=\"Logout\">",
            showLoginRegisterLogout(encrypt("Fernando", "1235@"))
        );
    }

    public function testShowLoginRegisterLogoutEquals3(): void
    {
        $this->assertEquals(
            "<input class=\"form-control mr-sm-2\" type=\"text\" name=\"usernameLogin\" placeholder=\"Username\" aria-label=\"Search\">
                <input class=\"form-control mr-sm-2\" type=\"text\" name=\"passwordLogin\" placeholder=\"Password\" aria-label=\"Search\">
                <input class=\"btn btn-outline-success my-2 my-sm-0 mr-sm-2\" type=\"submit\" name=\"login\" aria-label=\"Login\" value=\"Login\">
                <input class=\"btn btn-outline-success my-2 my-sm-0\" type=\"submit\" name=\"registerForm\" aria-label=\"Sign in\" value=\"Sign in\">",
            showLoginRegisterLogout(null)
        );
    }

    public function testShowLoginRegisterLogoutNotEquals1(): void
    {
        $this->assertNotEquals(
            "<span class=\"nav-item text-white mr-sm-2\">Bienvenido Fernando</span>
            <input class=\"btn btn-outline-success my-2 my-sm-0\" type=\"submit\" name=\"logout\" aria-label=\"Logout\" value=\"Logout\">",
            showLoginRegisterLogout(encrypt("AmorDeMiAlmaProfundo", "1235@"))
        );
    }

    public function testShowLoginRegisterLogoutNotEquals2(): void
    {
        $this->assertNotEquals(
            "<span class=\"nav-item text-white mr-sm-2\">Bienvenido Fernando</span>
            <input class=\"btn btn-outline-success my-2 my-sm-0\" type=\"submit\" name=\"logout\" aria-label=\"Logout\" value=\"Logout\">",
            showLoginRegisterLogout(null)
        );
    }

    public function testShowLoginRegisterLogoutNotEquals3(): void
    {
        $this->assertNotEquals(
            "<input class=\"form-control mr-sm-2\" type=\"text\" name=\"usernameLogin\" placeholder=\"Username\" aria-label=\"Search\">
                <input class=\"form-control mr-sm-2\" type=\"text\" name=\"passwordLogin\" placeholder=\"Password\" aria-label=\"Search\">
                <input class=\"btn btn-outline-success my-2 my-sm-0 mr-sm-2\" type=\"submit\" name=\"login\" aria-label=\"Login\" value=\"Login\">
                <input class=\"btn btn-outline-success my-2 my-sm-0\" type=\"submit\" name=\"registerForm\" aria-label=\"Sign in\" value=\"Sign in\">",
            showLoginRegisterLogout(encrypt("", "1235@"))
        );
    }
}

function showLoginRegisterLogout($user)
{
    $showMenuLogin = "";
    if (isset($user)) {
        $showMenuLogin = "<span class=\"nav-item text-white mr-sm-2\">Bienvenido " . decrypt($user, "1235@") . "</span>
            <input class=\"btn btn-outline-success my-2 my-sm-0\" type=\"submit\" name=\"logout\" aria-label=\"Logout\" value=\"Logout\">";
    } else {
        $showMenuLogin = "<input class=\"form-control mr-sm-2\" type=\"text\" name=\"usernameLogin\" placeholder=\"Username\" aria-label=\"Search\">
                <input class=\"form-control mr-sm-2\" type=\"text\" name=\"passwordLogin\" placeholder=\"Password\" aria-label=\"Search\">
                <input class=\"btn btn-outline-success my-2 my-sm-0 mr-sm-2\" type=\"submit\" name=\"login\" aria-label=\"Login\" value=\"Login\">
                <input class=\"btn btn-outline-success my-2 my-sm-0\" type=\"submit\" name=\"registerForm\" aria-label=\"Sign in\" value=\"Sign in\">";
    }
    return $showMenuLogin;
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
