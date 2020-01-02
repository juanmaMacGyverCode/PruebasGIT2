<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;

final class TestEncrypt extends TestCase
{
    public function testShowLoginRegisterLogoutEquals1(): void
    {
        $this->assertEquals(
            "<span class=\"nav-item text-white mr-sm-2\">Bienvenido AmorDeMiAlmaProfundo</span>
            <input class=\"btn btn-outline-success my-2 my-sm-0\" type=\"submit\" name=\"logout\" aria-label=\"Logout\" value=\"Logout\">",
            showLoginRegisterLogout("AmorDeMiAlmaProfundo")
        );
    }

    public function testShowLoginRegisterLogoutEquals2(): void
    {
        $this->assertEquals(
            "<span class=\"nav-item text-white mr-sm-2\">Bienvenido Fernando</span>
            <input class=\"btn btn-outline-success my-2 my-sm-0\" type=\"submit\" name=\"logout\" aria-label=\"Logout\" value=\"Logout\">",
            showLoginRegisterLogout("Fernando")
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
            showLoginRegisterLogout("AmorDeMiAlmaProfundo")
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
            showLoginRegisterLogout("")
        );
    }
}

function showLoginRegisterLogout($user)
{
    $showMenuLogin = "";
    if (isset($user)) {
        $showMenuLogin = "<span class=\"nav-item text-white mr-sm-2\">Bienvenido " . $user . "</span>
            <input class=\"btn btn-outline-success my-2 my-sm-0\" type=\"submit\" name=\"logout\" aria-label=\"Logout\" value=\"Logout\">";
    } else {
        $showMenuLogin = "<input class=\"form-control mr-sm-2\" type=\"text\" name=\"usernameLogin\" placeholder=\"Username\" aria-label=\"Search\">
                <input class=\"form-control mr-sm-2\" type=\"text\" name=\"passwordLogin\" placeholder=\"Password\" aria-label=\"Search\">
                <input class=\"btn btn-outline-success my-2 my-sm-0 mr-sm-2\" type=\"submit\" name=\"login\" aria-label=\"Login\" value=\"Login\">
                <input class=\"btn btn-outline-success my-2 my-sm-0\" type=\"submit\" name=\"registerForm\" aria-label=\"Sign in\" value=\"Sign in\">";
    }
    return $showMenuLogin;
}
