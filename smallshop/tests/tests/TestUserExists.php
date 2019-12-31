<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;

final class TestEncrypt extends TestCase
{
    public function testUserExistsTrue1(): void
    {
        $user = array(new User(1, encrypt("Fernando", "1235@"), encrypt("1234", "1235@"), encrypt("Fernando Gomez", "1235@"), encrypt("fernando@gmail.com", "1235@")));
        
        $this->assertNotFalse(userExists("Fernando", $user));
    }

    public function testUserExistsTrue2(): void
    {
        $user = array(new User(1, encrypt("", "1235@"), encrypt("1234", "1235@"), encrypt("Fernando Gomez", "1235@"), encrypt("fernando@gmail.com", "1235@")));

        $this->assertNotFalse(userExists("", $user));
    }

    public function testUserExistsTrue3(): void
    {
        $user = array(new User(1, encrypt("asd123", "1235@"), encrypt("1234", "1235@"), encrypt("Fernando Gomez", "1235@"), encrypt("fernando@gmail.com", "1235@")));

        $this->assertNotFalse(userExists("asd123", $user));
    }

    public function testUserExistsTrue4(): void
    {
        $user = array(new User(1, encrypt("aaaaddddffffgggghhhh", "1235@"), encrypt("1234", "1235@"), encrypt("Fernando Gomez", "1235@"), encrypt("fernando@gmail.com", "1235@")));

        $this->assertNotFalse(userExists("aaaaddddffffgggghhhh", $user));
    }

    public function testUserExistsFalse1(): void
    {
        $user = array(new User(1, encrypt("Fernando", "1235@"), encrypt("1234", "1235@"), encrypt("Fernando Gomez", "1235@"), encrypt("fernando@gmail.com", "1235@")));

        $this->assertFalse(userExists("Fernndo", $user));
    }

    public function testUserExistsFalse2(): void
    {
        $user = array(new User(1, encrypt("", "1235@"), encrypt("1234", "1235@"), encrypt("Fernando Gomez", "1235@"), encrypt("fernando@gmail.com", "1235@")));

        $this->assertFalse(userExists("a", $user));
    }

    public function testUserExistsFalse3(): void
    {
        $user = array(new User(1, encrypt("asd123", "1235@"), encrypt("1234", "1235@"), encrypt("Fernando Gomez", "1235@"), encrypt("fernando@gmail.com", "1235@")));

        $this->assertFalse(userExists("as123", $user));
    }

    public function testUserExistsFalse4(): void
    {
        $user = array(new User(1, encrypt("aaaaddddffffgggghhhh", "1235@"), encrypt("1234", "1235@"), encrypt("Fernando Gomez", "1235@"), encrypt("fernando@gmail.com", "1235@")));

        $this->assertFalse(userExists("aaaahhhh", $user));
    }
}

function userExists($username, $allUsers)
{

    foreach ($allUsers as $user) {
        if (decrypt($user->getUsername(), "1235@") == $username) {
            return true;
        }
    }
    return false;
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
