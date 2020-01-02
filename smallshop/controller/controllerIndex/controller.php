<?php

include("..\\database\\databaseOperations.php");
include("..\\models\\user.php");
include("..\\controller\\commomFunctions.php");
include("functions.php");
session_name("sesionUsuario");
session_start();

$showMenuLogin = "";
$showMenuAdministrator = "";
$showBoxWarning = "";
$showErrorLogin = "";
$showBoxDatabase = "";

if (isset($_SESSION["username"])) {
    $showMenuLogin = showLoginRegisterLogout($_SESSION["username"]);
    $showMenuAdministrator = showMenuAdministrator($_SESSION["username"]);
} else {
    $showMenuLogin = showLoginRegisterLogout(null);
    $showMenuAdministrator = showMenuAdministrator(null);
}

$allUsers = createAllUsers();

$registerForm = "";

$username = $password = $fullname = $email = "";
$errorUsername = $errorPassword = $errorFullname = $errorEmail = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (isset($_POST["registerForm"])) {
        $showBoxWarning = "";
        $registerForm = registerForm($errorUsername, $errorPassword, $errorFullname, $errorEmail, $username, $password, $fullname, $email);
    }

    if (isset($_POST["signin"])) {

        $data = $_POST["username"];
        if (empty($data)) {
            $errorUsername = getHTMLerror("requiredField");
        } else {
            if (strlen($data) > 20 || strlen($data) < 4) {
                $errorUsername = getHTMLerror("numberCharacters20");
            } else {
                if (!preg_match("/^[a-zA-Z0-9]*$/", $data)) {
                    $errorUsername = getHTMLerror("numbersLetters");
                } else {
                    if (strlen(strip_tags($data)) != strlen($data)) {
                        $errorUsername = getHTMLerror("incorrectCharacters");
                    } else {
                        if (userExists($data, $allUsers)) {
                            $errorUsername = getHTMLerror("usernameExists");
                        } else {
                            $username = strip_tags(test_input($data));
                        }
                    }
                }
            }
        }

        $data = $_POST["password"];
        if (empty($data)) {
            $errorPassword = getHTMLerror("requiredField");
        } else {
            if (strlen($data) > 20 || strlen($data) < 4) {
                $errorPassword = getHTMLerror("numberCharacters20");
            } else {
                if (!preg_match("/^[a-zA-Z0-9]*$/", $data)) {
                    $errorPassword = getHTMLerror("numbersLetters");
                } else {
                    if (strlen(strip_tags($data)) != strlen($data)) {
                        $errorPassword = getHTMLerror("incorrectCharacters");
                    } else {
                        $password = strip_tags(test_input($data));
                    }
                }
            }
        }

        $data = $_POST["fullname"];
        if (empty($data)) {
            $errorFullname = getHTMLerror("requiredField");
        } else {
            if (strlen(trim($data)) > 40 || strlen($data) < 4) {
                $errorFullname = getHTMLerror("numberCharacters40");
            } else {
                if (!preg_match("/^([a-zA-Z])+(([ ]){1}([a-zA-Z])+)*$/", trim($data))) {
                    $errorFullname = getHTMLerror("numbersLettersSpaces");
                } else {
                    if (strlen(strip_tags(trim($data))) != strlen(trim($data))) {
                        $errorFullname = getHTMLerror("incorrectCharacters");
                    } else {
                        $fullname = strip_tags(test_input($data));
                    }
                }
            }
        }

        $data = $_POST["email"];
        if (empty($data)) {
            $errorEmail = getHTMLerror("requiredField");
        } else {
            if (strlen(trim($data)) > 40 || strlen($data) < 4) {
                $errorEmail = getHTMLerror("numberCharacters40");
            } else {
                if (emailExists($data, $allUsers)) {
                    $errorEmail = getHTMLerror("emailExists");
                } else {
                    $email = strip_tags(test_input($data));
                }
            }
        }

        if (!empty($username) && !empty($password) && !empty($fullname) && !empty($email)) {
            if (signinUser($username, $password, $fullname, $email)) {
                $showBoxDatabase = layoutSimple("successOperation");
            } else {
                $showBoxDatabase = layoutSimple("errorOperation");
            }
        } else {
            $registerForm = registerForm($errorUsername, $errorPassword, $errorFullname, $errorEmail, $username, $password, $fullname, $email);
            $showBoxWarning = "";
        }
    }

    if (isset($_POST["login"])) {

        $data = $_POST["usernameLogin"];
        if (empty($data)) {
            $errorUsername = getHTMLerror("requiredField");
        } else {
            if (strlen($data) > 20 || strlen($data) < 4) {
                $errorUsername = getHTMLerror("numberCharacters20");
            } else {
                if (!preg_match("/^[a-zA-Z0-9]*$/", $data)) {
                    $errorUsername = getHTMLerror("numbersLetters");
                } else {
                    if (strlen(strip_tags($data)) != strlen($data)) {
                        $errorUsername = getHTMLerror("incorrectCharacters");
                    } else {
                        $username = strip_tags(test_input($data));
                    }
                }
            }
        }

        $data = $_POST["passwordLogin"];
        if (empty($data)) {
            $errorPassword = getHTMLerror("requiredField");
        } else {
            if (strlen($data) > 20 || strlen($data) < 4) {
                $errorPassword = getHTMLerror("numberCharacters20");
            } else {
                if (!preg_match("/^[a-zA-Z0-9]*$/", $data)) {
                    $errorPassword = getHTMLerror("numbersLetters");
                } else {
                    if (strlen(strip_tags($data)) != strlen($data)) {
                        $errorPassword = getHTMLerror("incorrectCharacters");
                    } else {
                        $password = strip_tags(test_input($data));
                    }
                }
            }
        }

        if (!empty($username) && !empty($password)) {
            if (loginUser($username, $password, $allUsers)) {
                header("Location: index.php");
            } else {
                $showErrorLogin = layoutSimple("dataIncorrect");
            }
        } else {
            $showErrorLogin = layoutSimple("emptyField");
        }
    }

    if (isset($_POST["logout"])) {
        sessionDestroy();
    }
}
