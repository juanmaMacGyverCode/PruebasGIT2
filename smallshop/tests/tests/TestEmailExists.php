<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;

final class TestEncrypt extends TestCase
{
    public function testEmailExistsTrue1(): void
    {
        $user = array(new User(1, "Fernando", "1234", "Fernando Gomez", "fernando@gmail.com"));

        $this->assertNotFalse(emailExists("fernando@gmail.com", $user));
    }

    public function testEmailExistsTrue2(): void
    {
        $user = array(new User(1, "Fernando", "1234", "Fernando Gomez", ""));

        $this->assertNotFalse(emailExists("", $user));
    }

    public function testEmailExistsTrue3(): void
    {
        $user = array(new User(1, "Fernando", "1234", "Fernando Gomez", "asd123"));

        $this->assertNotFalse(emailExists("asd123", $user));
    }

    public function testEmailExistsTrue4(): void
    {
        $user = array(new User(1, "Fernando", "1234", "Fernando Gomez", "aaaaddddffffgggghhhh"));

        $this->assertNotFalse(emailExists("aaaaddddffffgggghhhh", $user));
    }

    public function testEmailExistsFalse1(): void
    {
        $user = array(new User(1, "Fernando", "1234", "Fernando Gomez", "Fernando"));

        $this->assertFalse(emailExists("Fernndo", $user));
    }

    public function testEmailExistsFalse2(): void
    {
        $user = array(new User(1, "Fernando", "1234", "Fernando Gomez", "b"));

        $this->assertFalse(emailExists("a", $user));
    }

    public function testEmailExistsFalse3(): void
    {
        $user = array(new User(1, "Fernando", "1234", "Fernando Gomez", "asd234"));

        $this->assertFalse(emailExists("as123", $user));
    }

    public function testEmailExistsFalse4(): void
    {
        $user = array(new User(1, "Fernando", "1234", "Fernando Gomez", "ah"));

        $this->assertFalse(emailExists("aaaahhhh", $user));
    }
}

function emailExists($email, $allUsers)
{

    foreach ($allUsers as $user) {
        if ($user->getEmail() == $email) {
            return true;
        }
    }
    return false;
}

class User
{
    private $idUser;
    private $username;
    private $password;
    private $fullName;
    private $email;

    public function __construct($idUser, $username, $password, $fullName, $email)
    {
        $this->idUser = $idUser;
        $this->username = $username;
        $this->password = $password;
        $this->fullName = $fullName;
        $this->email = $email;
    }

    /* Getters */
    public function getIdUser()
    {
        return $this->idUser;
    }
    public function getUsername()
    {
        return $this->username;
    }
    public function getPassword()
    {
        return $this->password;
    }
    public function getFullName()
    {
        return $this->fullName;
    }
    public function getEmail()
    {
        return $this->email;
    }

    /* Setters */
    public function setIdUser($idUser)
    {
        $this->idUser = $idUser;
    }
    public function setUsername($username)
    {
        $this->username = $username;
    }
    public function setPassword($password)
    {
        $this->password = $password;
    }
    public function setFullName($fullName)
    {
        $this->fullName = $fullName;
    }
    public function setEmail($email)
    {
        $this->email = $email;
    }
}
