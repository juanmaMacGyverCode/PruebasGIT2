<?php

include("..\\models\\costumer.php");
include("functions.php");

$showBoxWarning = "";

if (isset($_SESSION["username"])) {
    $showBoxWarning = layoutSimple("menu");
} else {
    $showBoxWarning = layoutSimple("requestLogin");
}

$allCustomers = listAllCustomers();
$allUsers = createAllUsers();

$showBoxProgram = "";
$showLastNewCostumer = "";
$showTableDataCustomers = "";
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

    if (isset($_POST["listAllCustomers"])) {
        $showBoxWarning = "";
        $showFormNumberRows = layoutFormUniqueNumericField("showNumberRows", $errorNumberRows);
    }

    if (isset($_POST["showTable"])) {

        if (empty($_POST["numberRows"])) {
            $errorNumberRows = "<p class=\"text-danger\">Required field</p>";
        } else {
            if (strlen($_POST["numberRows"]) > 3) {
                $errorNumberRows = "<p class=\"text-danger\">Max 3 characters</p>";
            } else {
                if (!preg_match("/^[0-9]*$/", $_POST["numberRows"])) {
                    $errorNumberRows = "<p class=\"text-danger\">Wrong format. Only numbers without spaces</p>";
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
            $showTableDataCustomers = leerTodosPaginacionConBoton(0, $numberRows);
        } else {
            $showBoxWarning = "";
            $showFormNumberRows = layoutFormUniqueNumericField("showNumberRows", $errorNumberRows);
        }
    }

    if (isset($_POST["paginacionAnterior"])) {
        $showBoxWarning = "";
        $showTableDataCustomers = leerTodosPaginacionConBoton($_POST["anterior"], $_POST["numberRows"]);
    }

    if (isset($_POST["paginacionPosterior"])) {
        $showBoxWarning = "";
        $showTableDataCustomers = leerTodosPaginacionConBoton($_POST["posterior"], $_POST["numberRows"]);
    }

    if (isset($_POST["getCostumerInformation"])) {
        $showBoxWarning = "";
        $showFormFindCostumer = layoutFormUniqueNumericField("showCustomer", $errorNumber);
    }

    if (isset($_POST["findCostumerInformation"])) {
        $showBoxWarning = "";

        if (empty($_POST["idCustomer"])) {
            $errorNumber = "<p class=\"text-danger\">Required field</p>";
        } else {
            if (!preg_match("/^[0-9]*$/", $_POST["idCustomer"])) {
                $errorNumber = "<p class=\"text-danger\">Wrong format. Only numbers without spaces</p>";
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
            $thereIsData = false;
            $customer = "";
            foreach ($allCustomers as $costumerObject) {
                if ($number == $costumerObject->getIdCostumer()) {
                    $customer = $costumerObject;
                    $thereIsData = true;
                    break;
                }
            }

            if ($thereIsData) {
                $showBoxProgram = layoutDataSheetCustomer("getFullCustomerInformation", $customer, $allUsers);
            } else {
                $showBoxProgram = layoutSimple("dataNotFound");
            }
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
            $errorName = "<p class=\"text-danger\">Required field</p>";
        } else {
            if (strlen($_POST["name"]) > 20 || strlen($_POST["name"]) < 4) {
                $errorName = "<p class=\"text-danger\">Max 20 characters and min 4 characters</p>";
            } else {
                //([a-zA-Z]){1}(([ ]){1}([a-zA-Z])+)
                if (!preg_match("/^([a-zA-Z])+(([ ]){1}([a-zA-Z])+)*$/", $_POST["name"])) {
                    $errorName = "<p class=\"text-danger\">Wrong format. Only letters with spaces</p>";
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
            $errorSurname = "<p class=\"text-danger\">Required field</p>";
        } else {
            if (strlen($_POST["surname"]) > 20 || strlen($_POST["surname"]) < 4) {
                $errorSurname = "<p class=\"text-danger\">Max 20 characters and min 4 characters</p>";
            } else {
                if (!preg_match("/^([a-zA-Z])+(([ ]){1}([a-zA-Z])+)*$/", $_POST["surname"])) {
                    $errorSurname = "<p class=\"text-danger\">Wrong format. Only letters with spaces</p>";
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
                //$nameUpload = $_FILES["uploadImage"]["name"];
                $fileUpload = createAlphanumericName($_FILES["uploadImage"]["type"]);

                $errorUpload = uploadFile($fileUpload);
                //$fileUpload = $alphanumericName;
                //$fileUpload = $_FILES["uploadImage"]["name"];
            }
        }

        if (!empty($name) && !empty($surname) && empty($errorUpload)) {

            if (createNewCostumer($name, $surname, $fileUpload, $_SESSION["idUser"])) {
                $allCustomers = listAllCustomers();
                $showLastNewCostumer = layoutDataSheetCustomer("newCustomer", $allCustomers[count($allCustomers) - 1], $allUsers);
            } else {
                $showBoxDatabase = layoutSimple("errorOperation");
            }
            //$allCustomers = listAllCustomers();
            $showBoxWarning = "";
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
            $errorNumber = "<p class=\"text-danger\">Required field</p>";
        } else {
            if (!preg_match("/^[0-9]*$/", $_POST["idCustomer"])) {
                $errorNumber = "<p class=\"text-danger\">Wrong format. Only numbers without spaces</p>";
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
            foreach ($allCustomers as $customerObject) {
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

        $idCustomer = test_input($_POST["idCustomer"]);

        if (empty($_POST["name"])) {
            $errorName = "<p class=\"text-danger\">Required field</p>";
        } else {
            if (strlen($_POST["name"]) > 20 || strlen($_POST["name"]) < 4) {
                $errorName = "<p class=\"text-danger\">Max 20 characters and min 4 characters</p>";
            } else {
                if (!preg_match("/^([a-zA-Z])+(([ ]){1}([a-zA-Z])+)*$/", $_POST["name"])) {
                    $errorName = "<p class=\"text-danger\">Wrong format. Only letters with spaces</p>";
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
            $errorSurname = "<p class=\"text-danger\">Required field</p>";
        } else {
            if (strlen($_POST["surname"]) > 20 || strlen($_POST["surname"]) < 4) {
                $errorSurname = "<p class=\"text-danger\">Max 20 characters and min 4 characters</p>";
            } else {
                if (!preg_match("/^([a-zA-Z])+(([ ]){1}([a-zA-Z])+)*$/", $_POST["surname"])) {
                    $errorSurname = "<p class=\"text-danger\">Wrong format. Only letters with spaces</p>";
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
                $fileUpload = createAlphanumericName($_FILES["uploadImage"]["type"]);
                $errorUpload = uploadFile($fileUpload);
                //$fileUpload = $_FILES["uploadImage"]["name"];
            }
        }
        
        $imageHidden = $_POST["uploadImageHidden"];

        if ((!empty($idCustomer) && !empty($name) && !empty($surname)) || !empty($fileUpload) || !empty($checkboxDeleteImage)) {

            if ($checkboxDeleteImage || isset($_FILES["uploadImage"]["name"])) {
                deleteImage($idCustomer, $allCustomers);
            }

            $success = updateCustomer($idCustomer, $name, $surname, $fileUpload, $checkboxDeleteImage, $_SESSION["idUser"]);

            $allCustomers = listAllCustomers();

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
        } else {
            $customer = "";
            foreach ($allCustomers as $customerObject) {
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
            $errorIdCustomer = "<p class=\"text-danger\">Required field</p>";
        } else {
            if (!preg_match("/^[0-9]*$/", $_POST["idCustomer"])) {
                $errorIdCustomer = "<p class=\"text-danger\">Wrong format. Only numbers without spaces</p>";
            } else {
                if (strlen(strip_tags($_POST["idCustomer"])) != strlen($_POST["idCustomer"])) {
                    $errorIdCustomer = "<p class=\"text-danger\">Incorrect characters</p>";
                } else {
                    if ($_POST["idCustomer"] > 0) {
                        if (!thereIsThatID($_POST["idCustomer"], $allCustomers)) {
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
            deleteImage($idCustomer, $allCustomers);
            if (deleteCustomer($idCustomer)) {
                $showBoxDatabase = layoutSimple("successOperation");
            } else {
                $showBoxDatabase = layoutSimple("errorOperation");
            }
            $showBoxWarning = "";

            $allCustomers = listAllCustomers();
        } else {
            $showBoxWarning = "";
            $showFormFindCostumer = layoutFormUniqueNumericField("deleteCustomer", $errorIdCustomer);
        }
    }
}
