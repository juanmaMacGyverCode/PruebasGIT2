<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;

final class TestEncrypt extends TestCase
{
    public function testUpdateCustomersTrue1(): void
    {
        $this->assertNotFalse(testUpdateCustomers("hello", "hello", null, true));
    }

    public function testUpdateCustomersTrue2(): void
    {
        $this->assertNotFalse(testUpdateCustomers("hello", "325dsagf", null, true));
    }

    public function testUpdateCustomersTrue3(): void
    {
        $this->assertNotFalse(testUpdateCustomers("".null, "hello", null, true));
    }

    public function testUpdateCustomersFalse1(): void
    {
        $this->assertFalse(testUpdateCustomers(null, "hello", null, true));
    }

    public function testUpdateCustomersFalse2(): void
    {
        $this->assertFalse(testUpdateCustomers("hello", null, null, true));
    }

    public function testUpdateCustomersFalse3(): void
    {
        $this->assertFalse(testUpdateCustomers(null, null, null, true));
    }
}

function testUpdateCustomers($name, $surname, $fileUpload, $checkboxDeleteImage)
{
    signinUser("test", "test", "test", "test");
    $allUsers = createAllUsers();
    createNewCostumer($name, $surname, $fileUpload, $idUser);
    $allCustomers = listAllCostumers();
    $success = updateCustomer($allCustomers[count($allCustomers) - 1]->getIdCostumer(), $name, $surname, $fileUpload, $checkboxDeleteImage, $allUsers[count($allUsers) - 1]->getIdUser());
    deleteCustomer($allCustomers[count($allCustomers) - 1]->getIdCostumer());
    deleteUser($allUsers[count($allUsers) - 1]->getIdUser());
    return $success;
}

function signinUser($username, $password, $fullname, $email)
{
    if ($username == null || $password == null || $fullname == null || $email == null) {
        return false;
    }

    $mysqli = connection();

    $username = $mysqli->real_escape_string($username);
    $password = $mysqli->real_escape_string($password);
    $fullname = $mysqli->real_escape_string($fullname);
    $email = $mysqli->real_escape_string($email);

    $username = encrypt($username, "1235@");
    $password = encrypt($password, "1235@");
    $fullname = encrypt($fullname, "1235@");
    $email = encrypt($email, "1235@");

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

function listAllCostumers()
{
    $allCostumers = array();

    $mysqli = connection();

    $sql = "SELECT idCostumer, nameCostumer, surname, imageName, idUserCreator, idUserLastModify FROM costumers";
    if ($query = $mysqli->query($sql)) {
        while ($row = $query->fetch_assoc()) {
            $newCostumer = new Costumer($row["idCostumer"], $row["nameCostumer"], $row["surname"], $row["imageName"], $row["idUserCreator"], $row["idUserLastModify"]);
            array_push($allCostumers, $newCostumer);
        }
    }

    $mysqli->close();

    return $allCostumers;
}

function createNewCostumer($name, $surname, $fileUpload, $idUser)
{

    if ($name == null || $surname == null || $idUser == null) {
        return false;
    }

    $mysqli = connection();

    $name = $mysqli->real_escape_string($name);
    $surname = $mysqli->real_escape_string($surname);
    $idUser = $mysqli->real_escape_string($idUser);

    $name = encrypt($name, "1235@");
    $surname = encrypt($surname, "1235@");

    $prepareStatement = $mysqli->stmt_init();

    if (!empty($fileUpload)) {
        $fileUpload = $mysqli->real_escape_string($fileUpload);
        $fileUpload = encrypt($fileUpload, "1235@");

        $prepareStatement->prepare("INSERT INTO costumers (nameCostumer, surname, imageName, idUserCreator) VALUES (?, ?, ?, ?)");
        $prepareStatement->bind_param("sssi", $name, $surname, $fileUpload, $idUser);
    } else {
        $prepareStatement->prepare("INSERT INTO costumers (nameCostumer, surname, idUserCreator) VALUES (?, ?, ?)");
        $prepareStatement->bind_param("ssi", $name, $surname, $idUser);
    }

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


function deleteCustomer($idCustomer)
{

    if ($idCustomer == null) {
        return false;
    }

    $mysqli = connection();

    $idCustomer = $mysqli->real_escape_string($idCustomer);

    $prepareStatement = $mysqli->stmt_init();

    $prepareStatement->prepare("DELETE FROM costumers WHERE idCostumer=?");
    $prepareStatement->bind_param("i", $idCustomer);

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

function updateCustomer($idCustomer, $name, $surname, $fileUpload, $checkboxDeleteImage, $idUser)
{

    if ($idCustomer == null || $name == null || $surname == null) {
        return false;
    }

    $mysqli = connection();

    $idCustomer = $mysqli->real_escape_string($idCustomer);
    $name = $mysqli->real_escape_string($name);
    $surname = $mysqli->real_escape_string($surname);

    $name = encrypt($name, "1235@");
    $surname = encrypt($surname, "1235@");

    $prepareStatement = $mysqli->stmt_init();

    if ($checkboxDeleteImage) {
        $prepareStatement->prepare("UPDATE costumers SET idCostumer=?, nameCostumer=?, surname=?, imageName=NULL, idUserLastModify=? WHERE idCostumer=?");
        $prepareStatement->bind_param("issii", $idCustomer, $name, $surname, $idUser, $idCustomer);
    } else {
        if (!empty($fileUpload)) {
            $fileUpload = $mysqli->real_escape_string($fileUpload);
            $fileUpload = encrypt($fileUpload, "1235@");
            $prepareStatement->prepare("UPDATE costumers SET nameCostumer=?, surname=?, imageName=?, idUserLastModify=? WHERE idCostumer=?");
            $prepareStatement->bind_param("sssii", $name, $surname, $fileUpload, $idUser, $idCustomer);
        } else {
            $prepareStatement->prepare("UPDATE costumers SET nameCostumer=?, surname=?, idUserLastModify=? WHERE idCostumer=?");
            $prepareStatement->bind_param("ssii", $name, $surname, $idUser, $idCustomer);
        }
    }

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

function encrypt($data, $key)
{
    $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
    $encrypted = openssl_encrypt($data, "aes-256-cbc", $key, 0, $iv);
    return base64_encode($encrypted . "::" . $iv);
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

class Costumer
{
    private $idCostumer;
    private $nameCostumer;
    private $surname;
    private $image;
    private $idUserCreator;
    private $idUserLastModify;

    public function __construct($idCostumer, $nameCostumer, $surname, $image, $idUserCreator, $idUserLastModify)
    {
        $this->idCostumer = $idCostumer;
        $this->nameCostumer = $nameCostumer;
        $this->surname = $surname;
        $this->image = $image;
        $this->idUserCreator = $idUserCreator;
        $this->idUserLastModify = $idUserLastModify;
    }

    /* Getters */
    public function getIdCostumer()
    {
        return $this->idCostumer;
    }
    public function getNameCostumer()
    {
        return $this->nameCostumer;
    }
    public function getSurname()
    {
        return $this->surname;
    }
    public function getImage()
    {
        return $this->image;
    }
    public function getIdUserCreator()
    {
        return $this->idUserCreator;
    }
    public function getIdUserLastModify()
    {
        return $this->idUserLastModify;
    }

    /* Setters */
    public function setIdCostumer($idCostumer)
    {
        $this->idCostumer = $idCostumer;
    }
    public function setNameCostumer($nameCostumer)
    {
        $this->nameCostumer = $nameCostumer;
    }
    public function setSurname($surname)
    {
        $this->surname = $surname;
    }
    public function setImage($image)
    {
        $this->image = $image;
    }
    public function setIdUserCreator($idUserCreator)
    {
        $this->idUserCreator = $idUserCreator;
    }
    public function setIdUserLastModify($idUserLastModify)
    {
        $this->idUserLastModify = $idUserLastModify;
    }

    //Other functions
    public function dataSheetCostumer($allUsers)
    {
        $userCreator = null;
        $userLastModify = null;
        foreach ($allUsers as $userObject) {
            if ($userObject->getIdUser() == $this->idUserCreator) {
                $userCreator = $userObject;
            }
            if ($userObject->getIdUser() == $this->idUserLastModify) {
                $userLastModify = $userObject;
            }
        }

        $cardLastModify = "";
        if ($userLastModify != null) {
            $cardLastModify = "<p class=\"card-text\"><span class=\"font-weight-bold\">ID user update:</span> " . $this->idUserLastModify . ". <span class=\"font-weight-bold\">Username:</span> " . decrypt($userLastModify->getUsername(), "1235@") . "</p>";
        } else {
            $cardLastModify = "<p class=\"card-text\"><span class=\"font-weight-bold\">ID user update:</span> EMPTY. <span class=\"font-weight-bold\">Username:</span> EMPTY. </p>";
        }

        $image = "";
        if (strlen($this->image) > 1) {
            //$image = "\"..\\uploads\\" . decrypt($this->image, "1235@") . "\"";
            $image = "<div class=\"col-md-4\">
                  <img src=\"..\\uploads\\" . decrypt($this->image, "1235@") . "\" class=\"card-img\" alt=\"File Not Found\">
                </div>";
        } else {
            $image = "<div class=\"col-md-4\"><i class='fas fa-user' style='font-size:15em;color:red'></i></div>";
        }

        /*$dataSheet =
            "<div class=\"card mb-3 mt-3 mx-auto w-100 text-left\">
              <div class=\"row no-gutters\">
                <div class=\"col-md-4\">
                  <img src=" . $image . " class=\"card-img\" alt=\"File Not Found\">
                </div>
                <div class=\"col-md-8\">
                  <div class=\"card-header\">
                    <h5 class=\"card-title\">Id: " . $this->idCostumer . "</h5>
                  </div>
                  <div class=\"card-body\">
                    <h5 class=\"card-title\">Surname: " . decrypt($this->surname, "1235@") . "</h5>
                    <h5 class=\"card-title\">Name: " . decrypt($this->nameCostumer, "1235@") . "</h5>
                    <hr>
                    <p class=\"card-text\"><span class=\"font-weight-bold\">ID user creator:</span> " . $this->idUserCreator . ". <span class=\"font-weight-bold\">Username:</span> " . decrypt($userCreator->getUsername(), "1235@") . "</p>
                    " . $cardLastModify . "
                  </div>
                </div>
              </div>
            </div>";*/

        $dataSheet =
            "<div class=\"card mb-3 mt-3 mx-auto w-100 text-left\">
              <div class=\"row no-gutters\">
                " . $image . "
                <div class=\"col-md-8\">
                  <div class=\"card-header\">
                    <h5 class=\"card-title\">Id: " . $this->idCostumer . "</h5>
                  </div>
                  <div class=\"card-body\">
                    <h5 class=\"card-title\">Surname: " . decrypt($this->surname, "1235@") . "</h5>
                    <h5 class=\"card-title\">Name: " . decrypt($this->nameCostumer, "1235@") . "</h5>
                    <hr>
                    <p class=\"card-text\"><span class=\"font-weight-bold\">ID user creator:</span> " . $this->idUserCreator . ". <span class=\"font-weight-bold\">Username:</span> " . decrypt($userCreator->getUsername(), "1235@") . "</p>
                    " . $cardLastModify . "
                  </div>
                </div>
              </div>
            </div>";

        return $dataSheet;
    }
}
