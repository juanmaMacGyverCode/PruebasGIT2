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
    }

    if (isset($_POST["listAllCustomers"])) {
        $showBoxWarning = "";
        $showFormNumberRows = layoutFormUniqueNumericField("showNumberRows", $errorNumberRows);
    }

    if (isset($_POST["showTable"])) {

        $data = $_POST["numberRows"];
        if (empty($data)) {
            $errorNumberRows = getHTMLerror("requiredField");
        } else {
            if (strlen($data) > 3) {
                $errorNumberRows = getHTMLerror("max3Characters");
            } else {
                if (!preg_match("/^[0-9]*$/", $data)) {
                    $errorNumberRows = getHTMLerror("onlyNumbers");
                } else {
                    if (strlen(strip_tags($data)) != strlen($data)) {
                        $errorNumberRows = getHTMLerror("incorrectCharacters");
                    } else {
                        if ($data > 0 && $data <= 300) {
                            $numberRows = strip_tags(test_input($data));
                        } else {
                            $errorNumberRows = getHTMLerror("number300");
                        }
                    }
                }
            }
        }

        if (!empty($numberRows)) {
            $showBoxWarning = "";
            $showTableDataCustomers = paginationWithButtom(0, $numberRows);
        } else {
            $showBoxWarning = "";
            $showFormNumberRows = layoutFormUniqueNumericField("showNumberRows", $errorNumberRows);
        }
    }

    if (isset($_POST["previousPagination"])) {
        $showBoxWarning = "";
        $showTableDataCustomers = paginationWithButtom($_POST["previous"], $_POST["numberRows"]);
    }

    if (isset($_POST["nextPagination"])) {
        $showBoxWarning = "";
        $showTableDataCustomers = paginationWithButtom($_POST["next"], $_POST["numberRows"]);
    }

    if (isset($_POST["getCostumerInformation"])) {
        $showBoxWarning = "";
        $showFormFindCostumer = layoutFormUniqueNumericField("showCustomer", $errorNumber);
    }

    if (isset($_POST["findCostumerInformation"])) {
        $showBoxWarning = "";

        $data = $_POST["idCustomer"];
        if (empty($data)) {
            $errorNumber = getHTMLerror("requiredField");
        } else {
            if (!preg_match("/^[0-9]*$/", $data)) {
                $errorNumber = getHTMLerror("onlyNumbers");
            } else {
                if (strlen(strip_tags($data)) != strlen($data)) {
                    $errorNumber = getHTMLerror("incorrectCharacters");
                } else {
                    if ($data > 0) {
                        $number = strip_tags(test_input($data));
                    } else {
                        $errorNumber = getHTMLerror("min1Character");
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

        $data = $_POST["name"];
        if (empty($data)) {
            $errorName = getHTMLerror("requiredField");
        } else {
            if (strlen($data) > 20 || strlen($data) < 4) {
                $errorName = getHTMLerror("numberCharacters20");
            } else {
                if (!preg_match("/^([a-zA-Z])+(([ ]){1}([a-zA-Z])+)*$/", $data)) {
                    $errorName = getHTMLerror("nameOnlyLettersSpaces");
                } else {
                    if (strlen(strip_tags($data)) != strlen($data)) {
                        $errorName = getHTMLerror("incorrectCharacters");
                    } else {
                        $name = strip_tags(test_input($data));
                    }
                }
            }
        }

        $data = $_POST["surname"];
        if (empty($data)) {
            $errorSurname = getHTMLerror("requiredField");
        } else {
            if (strlen($data) > 20 || strlen($data) < 4) {
                $errorSurname = getHTMLerror("numberCharacters20");
            } else {
                if (!preg_match("/^([a-zA-Z])+(([ ]){1}([a-zA-Z])+)*$/", $data)) {
                    $errorSurname = getHTMLerror("nameOnlyLettersSpaces");
                } else {
                    if (strlen(strip_tags($data)) != strlen($data)) {
                        $errorSurname = getHTMLerror("incorrectCharacters");
                    } else {
                        $surname = strip_tags(test_input($data));
                    }
                }
            }
        }

        $data = $_FILES["uploadImage"]["name"];
        if (!empty($data)) {
            if (strlen(strip_tags($data)) != strlen($data)) {
                $errorUpload = getHTMLerror("incorrectCharacters");
            } else {
                $fileUpload = createAlphanumericName($_FILES["uploadImage"]["type"]);

                $errorUpload = uploadFile($fileUpload);
            }
        }

        if (!empty($name) && !empty($surname) && empty($errorUpload)) {

            if (createNewCostumer($name, $surname, $fileUpload, $_SESSION["idUser"])) {
                $allCustomers = listAllCustomers();
                $showLastNewCostumer = layoutDataSheetCustomer("newCustomer", $allCustomers[count($allCustomers) - 1], $allUsers);
            } else {
                $showBoxDatabase = layoutSimple("errorOperation");
            }
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

        $data = $_POST["idCustomer"];
        if (empty($data)) {
            $errorNumber = getHTMLerror("requiredField");
        } else {
            if (!preg_match("/^[0-9]*$/", $data)) {
                $errorNumber = getHTMLerror("onlyNumbers");
            } else {
                if (strlen(strip_tags($data)) != strlen($data)) {
                    $errorNumber = getHTMLerror("incorrectCharacters");
                } else {
                    if ($data > 0) {
                        $number = strip_tags(test_input($data));
                    } else {
                        $errorNumber = getHTMLerror("min1Character");
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
                    $errorNumber = getHTMLerror("dataNotFound");
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

        $data = $_POST["name"];
        if (empty($data)) {
            $errorName = getHTMLerror("requiredField");
        } else {
            if (strlen($data) > 20 || strlen($data) < 4) {
                $errorName = getHTMLerror("numberCharacters20");
            } else {
                if (!preg_match("/^([a-zA-Z])+(([ ]){1}([a-zA-Z])+)*$/", $data)) {
                    $errorName = getHTMLerror("nameOnlyLettersSpaces");
                } else {
                    if (strlen(strip_tags($data)) != strlen($data)) {
                        $errorName = getHTMLerror("incorrectCharacters");
                    } else {
                        $name = strip_tags(test_input($data));
                    }
                }
            }
        }

        $data = $_POST["surname"];
        if (empty($data)) {
            $errorSurname = getHTMLerror("requiredField");
        } else {
            if (strlen($data) > 20 || strlen($data) < 4) {
                $errorSurname = getHTMLerror("numberCharacters20");
            } else {
                if (!preg_match("/^([a-zA-Z])+(([ ]){1}([a-zA-Z])+)*$/", $data)) {
                    $errorSurname = getHTMLerror("nameOnlyLettersSpaces");
                } else {
                    if (strlen(strip_tags($data)) != strlen($data)) {
                        $errorSurname = getHTMLerror("incorrectCharacters");
                    } else {
                        $surname = strip_tags(test_input($data));
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
                $errorUpload = getHTMLerror("incorrectCharacters");
            } else {
                $fileUpload = createAlphanumericName($_FILES["uploadImage"]["type"]);
                $errorUpload = uploadFile($fileUpload);
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

        $data = $_POST["idCustomer"];
        if (empty($data)) {
            $errorIdCustomer = getHTMLerror("requiredField");
        } else {
            if (!preg_match("/^[0-9]*$/", $data)) {
                $errorIdCustomer = getHTMLerror("onlyNumbers");
            } else {
                if (strlen(strip_tags($data)) != strlen($data)) {
                    $errorIdCustomer = getHTMLerror("incorrectCharacters");
                } else {
                    if ($data > 0) {
                        if (!thereIsThatID($data, $allCustomers)) {
                            $idCustomer = strip_tags(test_input($data));
                        } else {
                            $errorIdCustomer = getHTMLerror("idExists");
                        }
                    } else {
                        $errorIdCustomer = getHTMLerror("minID1");
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
