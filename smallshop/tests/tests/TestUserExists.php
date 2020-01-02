<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;

final class TestEncrypt extends TestCase
{
    public function testUserExistsTrue1(): void
    {
        $user = array(new User(1, "Fernando", "1234", "Fernando Gomez", "fernando@gmail.com"));
        
        $this->assertNotFalse(userExists("Fernando", $user));
    }

    public function testUserExistsTrue2(): void
    {
        $user = array(new User(1, "", "1234", "Fernando Gomez", "fernando@gmail.com"));

        $this->assertNotFalse(userExists("", $user));
    }

    public function testUserExistsTrue3(): void
    {
        $user = array(new User(1, "asd123", "1234", "Fernando Gomez", "fernando@gmail.com"));

        $this->assertNotFalse(userExists("asd123", $user));
    }

    public function testUserExistsTrue4(): void
    {
        $user = array(new User(1, "aaaaddddffffgggghhhh", "1234", "Fernando Gomez", "fernando@gmail.com"));

        $this->assertNotFalse(userExists("aaaaddddffffgggghhhh", $user));
    }

    public function testUserExistsFalse1(): void
    {
        $user = array(new User(1, "Fernando", "1234", "Fernando Gomez", "fernando@gmail.com"));

        $this->assertFalse(userExists("Fernndo", $user));
    }

    public function testUserExistsFalse2(): void
    {
        $user = array(new User(1, "", "1234", "Fernando Gomez", "fernando@gmail.com", "1235@"));

        $this->assertFalse(userExists("a", $user));
    }

    public function testUserExistsFalse3(): void
    {
        $user = array(new User(1, "asd123", "1234", "Fernando Gomez", "fernando@gmail.com"));

        $this->assertFalse(userExists("as123", $user));
    }

    public function testUserExistsFalse4(): void
    {
        $user = array(new User(1, "aaaaddddffffgggghhhh", "1234", "Fernando Gomez", "fernando@gmail.com"));

        $this->assertFalse(userExists("aaaahhhh", $user));
    }
}

function userExists($username, $allUsers)
{

    foreach ($allUsers as $user) {
        if ($user->getUsername() == $username) {
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
