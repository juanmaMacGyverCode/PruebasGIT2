<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;

final class TestEncrypt extends TestCase
{
    public function testRequestSimpleEquals1(): void
    {
        $this->assertEquals(
            "<h1 class=\"mb-0\">GET FULL CUSTOMER INFORMATION</h1>",
            requestDataSheetCustomer("getFullCustomerInformation")
        );
    }

    public function testRequestSimpleEquals2(): void
    {
        $this->assertEquals(
            "<h1 class=\"mb-0\">NEW COSTUMER</h1>",
            requestDataSheetCustomer("newCustomer")
        );
    }

    public function testRequestSimpleEquals3(): void
    {
        $this->assertEquals(
            "<h1 class=\"mb-0\">UPDATE CUSTOMER</h1>",
            requestDataSheetCustomer("updateCustomer")
        );
    }

    public function testRequestSimpleEquals4(): void
    {
        $this->assertEquals(
            "<p class=\"text-danger\">PROGRAMMING ERROR</p>",
            requestDataSheetCustomer("other")
        );
    }

    public function testRequestSimpleNotEquals1(): void
    {
        $this->assertNotEquals(
            "<h1 class=\"mb-0\">GET FULL CUSTOMER INFORMATION</h1>",
            requestDataSheetCustomer("other")
        );
    }

    public function testRequestSimpleNotEquals2(): void
    {
        $this->assertNotEquals(
            "<h1 class=\"mb-0\">NEW COSTUMER</h1>",
            requestDataSheetCustomer("getFullCustomerInformation")
        );
    }

    public function testRequestSimpleNotEquals3(): void
    {
        $this->assertNotEquals(
            "<h1 class=\"mb-0\">UPDATE CUSTOMER</h1>",
            requestDataSheetCustomer("newCustomer")
        );
    }

    public function testRequestSimpleNotEquals4(): void
    {
        $this->assertNotEquals(
            "<p class=\"text-danger\">PROGRAMMING ERROR</p>",
            requestDataSheetCustomer("updateCustomer")
        );
    }

    public function testLayoutSimpleNotEquals1(): void
    {
        $customer = new Costumer(1, "Fernando", "1234", "Fernando Gomez", 1, 1);
        $allUsers = array(new User(1, "asd123", "1234", "Fernando Gomez", "fernando@gmail.com"));

        $this->assertNotEquals(
            "<div class=\"row mt-5 mb-5\">
                <div class=\"mx-auto w-50 p-3 text-center opacity-80\">
                    <p class=\"mb-0\"><span class=\"font-weight-bold\">Sign up</span> and <span class=\"font-weight-bold\">login</span> to use the application.<br>If you have an account, <span class=\"font-weight-bold\">please login</span></p>
                </div>
            </div>",
            layoutDataSheetCustomer("getFullCustomerInformation", $customer, $allUsers)
        );
    }

    public function testLayoutSimpleNotEquals2(): void
    {
        $customer = new Costumer(1, "Fernando", "1234", "Fernando Gomez", 1, 1);
        $allUsers = array(new User(1, "asd123", "1234", "Fernando Gomez", "fernando@gmail.com"));

        $this->assertNotEquals(
            "<div class=\"row mt-5 mb-5\">
                <div class=\"mx-auto w-50 p-3 text-center opacity-80\">
                    <p class=\"text-danger\">Username or password incorrect</p>
                </div>
            </div>",
            layoutDataSheetCustomer("newCustomer", $customer, $allUsers)
        );
    }

    public function testLayoutSimpleNotEquals3(): void
    {
        $customer = new Costumer(1, "Fernando", "1234", "Fernando Gomez", 1, 1);
        $allUsers = array(new User(1, "asd123", "1234", "Fernando Gomez", "fernando@gmail.com"));

        $this->assertNotEquals(
            "<div class=\"row mt-5 mb-5\">
                <div class=\"mx-auto w-50 p-3 text-center opacity-80\">
                    <p class=\"text-danger\">There is any empty field</p>
                </div>
            </div>",
            layoutDataSheetCustomer("updateCustomer", $customer, $allUsers)
        );
    }
}

function layoutDataSheetCustomer($option, $customer, $allUsers)
{
    return "<div class=\"row mt-5 mb-5\">
                <div class=\"mx-auto w-75 p-3 text-center opacity-80\">

                    " . requestDataSheetCustomer($option) . "

                    <hr>
                    " . $customer->dataSheetCostumer($allUsers) . " 
                    <div class=\"d-flex justify-content-around mt-3\">
                        <a href=\"\" class=\"btn btn-primary\">Return</a>
                    </div>
                </div>
            </div>";
}

function requestDataSheetCustomer($option)
{

    if ($option == "getFullCustomerInformation") {
        return "<h1 class=\"mb-0\">GET FULL CUSTOMER INFORMATION</h1>";
    } else if ($option == "newCustomer") {
        return "<h1 class=\"mb-0\">NEW COSTUMER</h1>";
    } else if ($option == "updateCustomer") {
        return "<h1 class=\"mb-0\">UPDATE CUSTOMER</h1>";
    } else {
        return "<p class=\"text-danger\">PROGRAMMING ERROR</p>";
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
            $cardLastModify = "<p class=\"card-text\"><span class=\"font-weight-bold\">ID user update:</span> " . $this->idUserLastModify . ". <span class=\"font-weight-bold\">Username:</span> " . $userLastModify->getUsername() . "</p>";
        } else {
            $cardLastModify = "<p class=\"card-text\"><span class=\"font-weight-bold\">ID user update:</span> EMPTY. <span class=\"font-weight-bold\">Username:</span> EMPTY. </p>";
        }

        $image = "";
        if (strlen($this->image) > 1) {
            $image = "<div class=\"col-md-4\">
                  <img src=\"..\\uploads\\" . $this->image . "\" class=\"card-img\" alt=\"File Not Found\">
                </div>";
        } else {
            $image = "<div class=\"col-md-4\"><i class='fas fa-user' style='font-size:15em;color:red'></i></div>";
        }

        $dataSheet =
            "<div class=\"card mb-3 mt-3 mx-auto w-100 text-left\">
              <div class=\"row no-gutters\">
                " . $image . "
                <div class=\"col-md-8\">
                  <div class=\"card-header\">
                    <h5 class=\"card-title\">Id: " . $this->idCostumer . "</h5>
                  </div>
                  <div class=\"card-body\">
                    <h5 class=\"card-title\">Surname: " . $this->surname . "</h5>
                    <h5 class=\"card-title\">Name: " . $this->nameCostumer . "</h5>
                    <hr>
                    <p class=\"card-text\"><span class=\"font-weight-bold\">ID user creator:</span> " . $this->idUserCreator . ". <span class=\"font-weight-bold\">Username:</span> " . $userCreator->getUsername() . "</p>
                    " . $cardLastModify . "
                  </div>
                </div>
              </div>
            </div>";

        return $dataSheet;
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