<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;

final class TestEncrypt extends TestCase
{
    public function testCreateDeleteUsersTrue1(): void
    {
        $this->assertNotFalse(testCreateDeleteUsers("hello", "hello".null, "hello", "hello"));
    }

    public function testCreateDeleteUsersTrue2(): void
    {
        $this->assertNotFalse(testCreateDeleteUsers("blind 235 sfasf", "hello", "hello", "hello"));
    }

    public function testCreateDeleteUsersTrue3(): void
    {
        $this->assertNotFalse(testCreateDeleteUsers("blabla", "car", "asfg as f", "hello"));
    }

    public function testCreateDeleteUsersFalse1(): void
    {
        $this->assertFalse(testOnlyCreateUsers(null, "hello", "hello", "hello"));
    }

    public function testCreateDeleteUsersFalse2(): void
    {
        $this->assertFalse(testOnlyCreateUsers("blind 235 sfasf", null, "hello", "hello"));
    }

    public function testCreateDeleteUsersFalse3(): void
    {
        $this->assertFalse(testOnlyCreateUsers("blabla", "car", null, "hello"));
    }

    public function testCreateDeleteUsersFalse4(): void
    {
        $this->assertFalse(testOnlyCreateUsers("blabla", "car", "asfg as f", null));
    }
}

function testCreateDeleteUsers($username, $password, $fullname, $email) 
{
    signinUser($username, $password, $fullname, $email);
    $allUsers = createAllUsers();
    return deleteUser($allUsers[count($allUsers)-1]->getIdUser());
}

function testOnlyCreateUsers($username, $password, $fullname, $email)
{
    return signinUser($username, $password, $fullname, $email);
}

function createAllUsers()
{
    $allUsers = array();
    $mysqli = connection();
    $sql = "SELECT idUser, username, pass, fullName, email FROM users";
    if ($query = $mysqli->query($sql)) {
        while ($row = $query->fetch_assoc()) {
            $newUser = new User($row["idUser"], $row["username"], $row["pass"], $row["fullName"], $row["email"]);
            array_push($allUsers, $newUser);
        }
    }
    $mysqli->close();
    return $allUsers;
}

function signinUser($username, $password, $fullname, $email)
{

    if ($username == null || $password == null || $fullname == null || $email == null) {
        return false;
    }

    $mysqli = connection();

    $prepareStatement = $mysqli->stmt_init();
    $prepareStatement->prepare("INSERT INTO users (username, pass, fullName, email) VALUES (?, ?, ?, ?)");
    $prepareStatement->bind_param("ssss", $username, $password, $fullname, $email);

    $success = "";
    if ($prepareStatement->execute()) {
        $success = true;
    } else {
        $success = false;
    }

    $prepareStatement->close();
    $mysqli->close();

    return $success;
}

function deleteUser($idUser) 
{
    $mysqli = connection();

    if ($idUser == null) {
        return false;
    }

    $idUser = $mysqli->real_escape_string($idUser);

    $prepareStatement = $mysqli->stmt_init();
    $prepareStatement->prepare("DELETE FROM users WHERE idUser=?");
    $prepareStatement->bind_param("i", $idUser);

    $success = "";
    if ($prepareStatement->execute()) {
        $success = true;
    } else {
        $success = false;
    }

    $prepareStatement->close();
    $mysqli->close();

    return $success;
}

function connection()
{
    $mysqli = new mysqli('localhost', 'root', '', 'smallShop');
    if ($mysqli->connect_error) {
        die('Error de Conexión (' . $mysqli->connect_errno . ') '
            . $mysqli->connect_error);
    } else {
        return $mysqli;
    }
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