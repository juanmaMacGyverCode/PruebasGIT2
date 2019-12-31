<?php

include("..\\database\\databaseOperations.php");
include("..\\modelo\\user.php");
include("..\\controlador\\commomFunctions.php");
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

        if (empty($_POST["username"])) {
            $errorUsername = "Campo requerido.";
        } else {
            if (strlen($_POST["username"]) > 20) {
                $errorUsername = "<p class=\"text-danger\">Max 20 characters</p>";
            } else {
                if (!preg_match("/^[a-zA-Z0-9]*$/", $_POST["username"])) {
                    $errorUsername = "<p class=\"text-danger\">Formato no correcto. Solo números y letras sin espacios</p>";
                } else {
                    if (strlen(strip_tags($_POST["username"])) != strlen($_POST["username"])) {
                        $errorUsername = "<p class=\"text-danger\">Incorrect characters</p>";
                    } else {
                        if (userExists($_POST["username"], $allUsers)) {
                            $errorUsername = "<p class=\"text-danger\">The username already exists, please choose another</p>";
                        } else {
                            $username = test_input($_POST["username"]);
                        }
                    }
                }
            }
        }

        if (empty($_POST["password"])) {
            $errorPassword = "Campo requerido.";
        } else {
            if (strlen($_POST["password"]) > 20) {
                $errorPassword = "<p class=\"text-danger\">Max 20 characters</p>";
            } else {
                if (!preg_match("/^[a-zA-Z0-9]*$/", $_POST["password"])) {
                    $errorPassword = "Formato no correcto. Solo números y letras sin espacios.";
                } else {
                    if (strlen(strip_tags($_POST["password"])) != strlen($_POST["password"])) {
                        $errorPassword = "<p class=\"text-danger\">Incorrect characters</p>";
                    } else {
                        $password = test_input($_POST["password"]);
                    }
                }
            }
        }

        if (empty($_POST["fullname"])) {
            $errorFullname = "Campo requerido.";
        } else {
            if (strlen(trim($_POST["fullname"])) > 40) {
                $errorFullname = "<p class=\"text-danger\">Max 40 characters</p>";
            } else {
                if (!preg_match("/^[a-zA-Z ]*$/", trim($_POST["fullname"]))) {
                    $errorFullname = "Formato no correcto. Solo letras y espacios si los hubiera.";
                } else {
                    if (strlen(strip_tags(trim($_POST["fullname"]))) != strlen(trim($_POST["fullname"]))) {
                        $errorFullname = "<p class=\"text-danger\">Incorrect characters</p>";
                    } else {
                        $fullname = test_input($_POST["fullname"]);
                    }
                }
            }
        }

        if (empty($_POST["email"])) {
            $errorEmail = "Campo requerido.";
        } else {
            if (emailExists($_POST["email"], $allUsers)) {
                $errorEmail = "<p class=\"text-danger\">The email already exists, please choose another</p>";
            } else {
                $email = test_input($_POST["email"]);
            }
            //$email = test_input($_POST["email"]);
        }

        if (!empty($username) && !empty($password) && !empty($fullname) && !empty($email)) {
            //signinUser($username, $password, $fullname, $email);
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

        if (empty($_POST["usernameLogin"])) {
            $errorUsername = "Campo requerido.";
        } else {
            if (strlen($_POST["usernameLogin"]) > 20) {
                $errorUsername = "<p class=\"text-danger\">Max 20 characters</p>";
            } else {
                if (!preg_match("/^[a-zA-Z0-9]*$/", $_POST["usernameLogin"])) {
                    $errorUsername = "<p class=\"text-danger\">Formato no correcto. Solo números y letras sin espacios</p>";
                } else {
                    if (strlen(strip_tags($_POST["usernameLogin"])) != strlen($_POST["usernameLogin"])) {
                        $errorUsername = "<p class=\"text-danger\">Incorrect characters</p>";
                    } else {
                        $username = test_input($_POST["usernameLogin"]);
                    }
                }
            }
        }

        if (empty($_POST["passwordLogin"])) {
            $errorPassword = "Campo requerido.";
        } else {
            if (strlen($_POST["passwordLogin"]) > 20) {
                $errorPassword = "<p class=\"text-danger\">Max 20 characters</p>";
            } else {
                if (!preg_match("/^[a-zA-Z0-9]*$/", $_POST["passwordLogin"])) {
                    $errorPassword = "Formato no correcto. Solo números y letras sin espacios.";
                } else {
                    if (strlen(strip_tags($_POST["passwordLogin"])) != strlen($_POST["passwordLogin"])) {
                        $errorPassword = "<p class=\"text-danger\">Incorrect characters</p>";
                    } else {
                        $password = test_input($_POST["passwordLogin"]);
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
