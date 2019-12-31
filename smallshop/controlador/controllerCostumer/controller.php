<?php

include("..\\modelo\\costumer.php");
include("functions.php");

$showBoxWarning = "";

if (isset($_SESSION["username"])) {
    $showBoxWarning = layoutSimple("menu");
} else {
    $showBoxWarning = layoutSimple("requestLogin");
}

$allCostumers = listAllCostumers();
$allUsers = createAllUsers();

$showBoxProgram = "";
$showLastNewCostumer = "";
$showTableDataCostumers = "";
$showFormNumberRows = "";
$showFormFindCostumer = "";
$showFormUpdateCustomer = "";
$showUpdateCustomer = "";

$name = $surname = $fileUpload = $numberRows = $number = $checkboxDeleteImage = $idCustomer = "";
$errorName = $errorSurname = $errorUpload = $errorNumberRows = $errorNumber = $errorIdCustomer = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (isset($_POST["registerForm"])) {
        $showBoxWarning = "";
    }

    if (isset($_POST["signin"])) {
        $showBoxWarning = "";
        /*if (!(!empty($username) && !empty($password) && !empty($fullname) && !empty($email))) {
            $showBoxWarning = "";
        }*/
    }

    if (isset($_POST["listAllCostumers"])) {
        $showBoxWarning = "";
        $showFormNumberRows = layoutFormUniqueNumericField("showNumberRows", $errorNumberRows);
    }

    if (isset($_POST["showTable"])) {

        if (empty($_POST["numberRows"])) {
            $errorNumberRows = "<p class=\"text-danger\">Campo requerido</p>";
        } else {
            if (strlen($_POST["numberRows"]) > 3) {
                $errorNumberRows = "<p class=\"text-danger\">Max 3 characters</p>";
            } else {
                if (!preg_match("/^[0-9]*$/", $_POST["numberRows"])) {
                    $errorNumberRows = "<p class=\"text-danger\">Formato no correcto. Solo números sin espacios</p>";
                } else {
                    if (strlen(strip_tags($_POST["numberRows"])) != strlen($_POST["numberRows"])) {
                        $errorNumberRows = "<p class=\"text-danger\">Incorrect characters</p>";
                    } else {
                        if ($_POST["numberRows"] > 0 && $_POST["numberRows"] <= 300) {
                            $numberRows = test_input($_POST["numberRows"]);
                        } else {
                            $errorNumberRows = "<p class=\"text-danger\">Minimun of lines 1, maximun of lines 300</p>";
                        }
                    }
                }
            }
        }

        if (!empty($numberRows)) {
            $showBoxWarning = "";
            $showTableDataCostumers = leerTodosPaginacionConBoton(0, $numberRows);
        } else {
            $showBoxWarning = "";
            $showFormNumberRows = layoutFormUniqueNumericField("showNumberRows", $errorNumberRows);
        }
    }

    if (isset($_POST["paginacionAnterior"])) {
        $showBoxWarning = "";
        $showTableDataCostumers = leerTodosPaginacionConBoton($_POST["anterior"], $_POST["numberRows"]);
    }

    if (isset($_POST["paginacionPosterior"])) {
        $showBoxWarning = "";
        $showTableDataCostumers = leerTodosPaginacionConBoton($_POST["posterior"], $_POST["numberRows"]);
    }

    if (isset($_POST["getCostumerInformation"])) {
        $showBoxWarning = "";
        $showFormFindCostumer = layoutFormUniqueNumericField("showCustomer", $errorNumber);
    }

    if (isset($_POST["findCostumerInformation"])) {
        $showBoxWarning = "";

        if (empty($_POST["idCustomer"])) {
            $errorNumber = "<p class=\"text-danger\">Campo requerido</p>";
        } else {
            if (!preg_match("/^[0-9]*$/", $_POST["idCustomer"])) {
                $errorNumber = "<p class=\"text-danger\">Formato no correcto. Solo números sin espacios</p>";
            } else {
                if (strlen(strip_tags($_POST["idCustomer"])) != strlen($_POST["idCustomer"])) {
                    $errorNumber = "<p class=\"text-danger\">Incorrect characters</p>";
                } else {
                    if ($_POST["idCustomer"] > 0) {
                        $number = test_input($_POST["idCustomer"]);
                    } else {
                        $errorNumber = "<p class=\"text-danger\">Minimun of lines 1</p>";
                    }
                }
            }
        }

        if (!empty($number)) {
            //$allDataSheetsCostumer = "";
            $thereIsData = false;
            $customer = "";
            foreach ($allCostumers as $costumerObject) {
                if ($number == $costumerObject->getIdCostumer()) {
                    $customer = $costumerObject;
                    $thereIsData = true;
                    //$allDataSheetsCostumer = $costumerObject->dataSheetCostumer($allUsers);
                    break;
                } //else {
                    //$allDataSheetsCostumer = "<p class=\"text-danger\">Error: The data was not found</p>";

                    // NO TIENE SENTIDO REPETIR LA MISMA ACCION 1212412125 VECES
                    //$showBoxProgram = layoutSimple("dataNotFound");
                //}
            }

            if ($thereIsData) {
                $showBoxProgram = layoutDataSheetCustomer("getFullCustomerInformation", $customer, $allUsers);
            } else {
                $showBoxProgram = layoutSimple("dataNotFound");
            }
            /*$showBoxProgram =
                "<div class=\"row mt-5 mb-5\">
                    <div class=\"mx-auto w-75 p-3 text-center opacity-80\">
                        <h1 class=\"mb-0\">GET FULL CUSTOMER INFORMATION</h1>
                        <hr>
                        " . $allDataSheetsCostumer . "
                        <div class=\"d-flex justify-content-around mt-3\">
                            <a href=\"\" class=\"btn btn-primary\">Return</a>
                        </div>
                    </div>
                </div>";*/
        } else {
            $showBoxWarning = "";
            $showFormFindCostumer = layoutFormUniqueNumericField("showCustomer", $errorNumber);
        }
    }

    if (isset($_POST["createCostumer"])) {
        $showBoxWarning = "";
        $showBoxProgram = showBoxCreateCostumer($name, $surname, $errorName, $errorSurname, $errorUpload);
    }

    if (isset($_POST["buttonCreateCostumer"])) {

        if (empty($_POST["name"])) {
            $errorName = "<p class=\"text-danger\">Campo requerido</p>";
        } else {
            if (strlen($_POST["name"]) > 20 || strlen($_POST["name"]) < 4) {
                $errorName = "<p class=\"text-danger\">Max 20 characters</p>";
            } else {
                if (!preg_match("/^[a-zA-Z ]*$/", $_POST["name"])) {
                    $errorName = "<p class=\"text-danger\">Formato no correcto. Solo letras con espacios</p>";
                } else {
                    if (strlen(strip_tags($_POST["name"])) != strlen($_POST["name"])) {
                        $errorName = "<p class=\"text-danger\">Incorrect characters</p>";
                    } else {
                        $name = test_input($_POST["name"]);
                    }
                }
            }
        }

        if (empty($_POST["surname"])) {
            $errorSurname = "<p class=\"text-danger\">Campo requerido</p>";
        } else {
            if (strlen($_POST["surname"]) > 20 || strlen($_POST["surname"]) < 4) {
                $errorSurname = "<p class=\"text-danger\">Max 20 characters</p>";
            } else {
                if (!preg_match("/^[a-zA-Z ]*$/", $_POST["surname"])) {
                    $errorSurname = "<p class=\"text-danger\">Formato no correcto. Solo letras con espacios</p>";
                } else {
                    if (strlen(strip_tags($_POST["surname"])) != strlen($_POST["surname"])) {
                        $errorSurname = "<p class=\"text-danger\">Incorrect characters</p>";
                    } else {
                        $surname = test_input($_POST["surname"]);
                    }
                }
            }
        }

        if (!empty($_FILES["uploadImage"]["name"])) {
            if (strlen(strip_tags($_FILES["uploadImage"]["name"])) != strlen($_FILES["uploadImage"]["name"])) {
                $errorUpload = "<p class=\"text-danger\">Incorrect characters</p>";
            } else {
                $errorUpload = uploadFile();
                $fileUpload = $_FILES["uploadImage"]["name"];
            }
        }

        if (!empty($name) && !empty($surname) && empty($errorUpload)) {

            //createNewCostumer($name, $surname, $fileUpload, $_SESSION["idUser"]);
            if (createNewCostumer($name, $surname, $fileUpload, $_SESSION["idUser"])) {
                $showLastNewCostumer = layoutDataSheetCustomer("newCustomer", $allCostumers[count($allCostumers) - 1], $allUsers);
            } else {
                $showBoxDatabase = layoutSimple("errorOperation");
            }
            $allCostumers = listAllCostumers();
            $showBoxWarning = "";
            //$showLastNewCostumer = layoutDataSheetCustomer("newCustomer", $allCostumers[count($allCostumers) - 1], $allUsers);
            /*$showLastNewCostumer = 
            "<div class=\"row mt-5 mb-5\">
                <div class=\"mx-auto w-75 p-3 text-center opacity-80\">
                    <h1 class=\"mb-0\">NEW COSTUMER</h1>"
                    . $allCostumers[count($allCostumers) - 1]->dataSheetCostumer($allUsers) .
                    "<a href=\"\" class=\"btn btn-primary\">Return</a>
                </div>
            </div>";*/
        } else {
            $showBoxWarning = "";
            $showBoxProgram = showBoxCreateCostumer($name, $surname, $errorName, $errorSurname, $errorUpload);
        }
    }

    if (isset($_POST["updateCostumer"])) {
        $showBoxWarning = "";
        $showFormFindCostumer = layoutFormUniqueNumericField("updateCustomer", $errorNumber);
    }

    if (isset($_POST["findCustomerInformationToUpdate"])) {
        $showBoxWarning = "";

        if (empty($_POST["idCustomer"])) {
            $errorNumber = "<p class=\"text-danger\">Campo requerido</p>";
        } else {
            if (!preg_match("/^[0-9]*$/", $_POST["idCustomer"])) {
                $errorNumber = "<p class=\"text-danger\">Formato no correcto. Solo números sin espacios</p>";
            } else {
                if (strlen(strip_tags($_POST["idCustomer"])) != strlen($_POST["idCustomer"])) {
                    $errorNumber = "<p class=\"text-danger\">Incorrect characters</p>";
                } else {
                    if ($_POST["idCustomer"] > 0) {
                        $number = test_input($_POST["idCustomer"]);
                    } else {
                        $errorNumber = "<p class=\"text-danger\">Minimun of lines 1</p>";
                    }
                }
            }
        }

        if (!empty($number)) {
            $customer = "";
            foreach ($allCostumers as $customerObject) {
                if ($number == $customerObject->getIdCostumer()) {
                    $customer = $customerObject;
                    break;
                } else {
                    $errorNumber = "<p class=\"text-danger\">Error: The data was not found</p>";
                }
            }

            if (!empty($customer)) {
                $showFormUpdateCustomer = showFormUpdateCustomer($customer, $errorIdCustomer, $errorName, $errorSurname, $errorUpload);
            } else {
                $showBoxWarning = "";
                $showFormFindCostumer = layoutFormUniqueNumericField("updateCustomer", $errorNumber);
            }
        } else {
            $showBoxWarning = "";
            $showFormFindCostumer = layoutFormUniqueNumericField("updateCustomer", $errorNumber);
        }
    }

    if (isset($_POST["buttonUpdateCustomer"])) {

        //$idCustomerHidden = $_POST["idCustomerHidden"];

        /*if (empty($_POST["idCustomer"])) {
            $errorIdCustomer = "<p class=\"text-danger\">Campo requerido</p>";
        } else {
            if (!preg_match("/^[0-9]*$/", $_POST["idCustomer"])) {
                $errorIdCustomer = "<p class=\"text-danger\">Formato no correcto. Solo números sin espacios</p>";
            } else {
                if (strlen(strip_tags($_POST["idCustomer"])) != strlen($_POST["idCustomer"])) {
                    $errorIdCustomer = "<p class=\"text-danger\">Incorrect characters</p>";
                } else {
                    if ($_POST["idCustomer"] > 0) {
                        //if ($idCustomerHidden == $_POST["idCustomer"] || thereIsThatID($_POST["idCustomer"], $allCostumers)) {
                            $idCustomer = test_input($_POST["idCustomer"]);
                        //} else {
                            //$errorIdCustomer = "<p class=\"text-danger\">There is that ID customer, choose any other</p>";
                        //}
                    } else {
                        $errorIdCustomer = "<p class=\"text-danger\">Minimun ID is 1</p>";
                    }
                }
            }
        }*/

        $idCustomer = test_input($_POST["idCustomer"]);

        if (empty($_POST["name"])) {
            $errorName = "<p class=\"text-danger\">Campo requerido</p>";
        } else {
            if (strlen($_POST["name"]) > 20 || strlen($_POST["name"]) < 4) {
                $errorName = "<p class=\"text-danger\">Max 20 characters</p>";
            } else {
                if (!preg_match("/^[a-zA-Z ]*$/", $_POST["name"])) {
                    $errorName = "<p class=\"text-danger\">Formato no correcto. Solo letras con espacios</p>";
                } else {
                    if (strlen(strip_tags($_POST["name"])) != strlen($_POST["name"])) {
                        $errorName = "<p class=\"text-danger\">Incorrect characters</p>";
                    } else {
                        $name = test_input($_POST["name"]);
                    }
                }
            }
        }

        if (empty($_POST["surname"])) {
            $errorSurname = "<p class=\"text-danger\">Campo requerido</p>";
        } else {
            if (strlen($_POST["surname"]) > 20 || strlen($_POST["surname"]) < 4) {
                $errorSurname = "<p class=\"text-danger\">Max 20 characters</p>";
            } else {
                if (!preg_match("/^[a-zA-Z ]*$/", $_POST["surname"])) {
                    $errorSurname = "<p class=\"text-danger\">Formato no correcto. Solo letras con espacios</p>";
                } else {
                    if (strlen(strip_tags($_POST["surname"])) != strlen($_POST["surname"])) {
                        $errorSurname = "<p class=\"text-danger\">Incorrect characters</p>";
                    } else {
                        $surname = test_input($_POST["surname"]);
                    }
                }
            }
        }

        if (isset($_POST["checkboxDeleteImage"])) {
            $checkboxDeleteImage = true;
        } else {
            $checkboxDeleteImage = false;
        }

        if (!$checkboxDeleteImage && !empty($_FILES["uploadImage"]["name"])) {
            if (strlen(strip_tags($_FILES["uploadImage"]["name"])) != strlen($_FILES["uploadImage"]["name"])) {
                $errorUpload = "<p class=\"text-danger\">Incorrect characters</p>";
            } else {
                $errorUpload = uploadFile();
                $fileUpload = $_FILES["uploadImage"]["name"];
            }
        }
        
        $imageHidden = $_POST["uploadImageHidden"];
        //$idCustomerHidden = $_POST["idCustomerHidden"];


        if ((!empty($idCustomer) && !empty($name) && !empty($surname)) || !empty($fileUpload) || !empty($checkboxDeleteImage)) {
            /*if (updateCustomer($idCustomer, $name, $surname, $fileUpload, $checkboxDeleteImage, $_SESSION["idUser"])) {
                $showUpdateCustomer = layoutDataSheetCustomer("updateCustomer", $customer, $allUsers);
            } else {
                $showBoxDatabase = layoutSimple("errorOperation");
            }*/
            $success = updateCustomer($idCustomer, $name, $surname, $fileUpload, $checkboxDeleteImage, $_SESSION["idUser"]);

            $allCustomers = listAllCostumers();
            $allCostumers = $allCustomers;

            $customer = "";
            foreach ($allCustomers as $customerObject) {
                if ($customerObject->getIdCostumer() == $idCustomer) {
                    $customer = $customerObject;
                }
            }

            $showBoxWarning = "";
            if ($success) {
                $showUpdateCustomer = layoutDataSheetCustomer("updateCustomer", $customer, $allUsers);
            } else {
                $showBoxDatabase = layoutSimple("errorOperation");
            }
            //$showUpdateCustomer = layoutDataSheetCustomer("updateCustomer", $customer, $allUsers);
            /*$showUpdateCustomer =
            "<div class=\"row mt-5 mb-5\">
                <div class=\"mx-auto w-75 p-3 text-center opacity-80\">
                    <h1 class=\"mb-0\">UPDATE CUSTOMER</h1>"
                    . $customer->dataSheetCostumer($allUsers) .
                    "<a href=\"\" class=\"btn btn-primary\">Return</a>
                </div>
            </div>";*/
        } else {
            $customer = "";
            foreach ($allCostumers as $customerObject) {
                if ($customerObject->getIdCostumer() == $idCustomer) {
                    $customer = $customerObject;
                }
            }
            $showBoxWarning = "";
            $showFormFindCostumer = showFormUpdateCustomer($customer, $errorIdCustomer, $errorName, $errorSurname, $errorUpload);
        }
    }

    if (isset($_POST["deleteCostumer"])) {
        $showBoxWarning = "";
        $showFormFindCostumer = layoutFormUniqueNumericField("deleteCustomer", $errorIdCustomer);
    }

    if (isset($_POST["findCustomerInformationToDelete"])) {
        if (empty($_POST["idCustomer"])) {
            $errorIdCustomer = "<p class=\"text-danger\">Campo requerido</p>";
        } else {
            if (!preg_match("/^[0-9]*$/", $_POST["idCustomer"])) {
                $errorIdCustomer = "<p class=\"text-danger\">Formato no correcto. Solo números sin espacios</p>";
            } else {
                if (strlen(strip_tags($_POST["idCustomer"])) != strlen($_POST["idCustomer"])) {
                    $errorIdCustomer = "<p class=\"text-danger\">Incorrect characters</p>";
                } else {
                    if ($_POST["idCustomer"] > 0) {
                        if (!thereIsThatID($_POST["idCustomer"], $allCostumers)) {
                            $idCustomer = test_input($_POST["idCustomer"]);
                        } else {
                            $errorIdCustomer = "<p class=\"text-danger\">There isn´t that ID customer, choose any other</p>";
                        }
                    } else {
                        $errorIdCustomer = "<p class=\"text-danger\">Minimun ID is 1</p>";
                    }
                }
            }
        }

        if (!empty($idCustomer)) {
            if (deleteCustomer($idCustomer)) {
                $showBoxDatabase = layoutSimple("successOperation");
            } else {
                $showBoxDatabase = layoutSimple("errorOperation");
            }
            //deleteCustomer($idCustomer);
            $showBoxWarning = "";

            $allCustomers = listAllCostumers();
            $allCostumers = $allCustomers;
        } else {
            $showBoxWarning = "";
            $showFormFindCostumer = layoutFormUniqueNumericField("deleteCustomer", $errorIdCustomer);
        }
    }
}
