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

        if (empty($_POST["username"])) {
            $errorUsername = "<p class=\"text-danger\">Required field</p>";
        } else {
            if (strlen($_POST["username"]) > 20 || strlen($_POST["username"]) < 4) {
                $errorUsername = "<p class=\"text-danger\">Max 20 characters and min 4 characters</p>";
            } else {
                if (!preg_match("/^[a-zA-Z0-9]*$/", $_POST["username"])) {
                    $errorUsername = "<p class=\"text-danger\">Wrong format. Only numbers and letters without spaces</p>";
                } else {
                    if (strlen(strip_tags($_POST["username"])) != strlen($_POST["username"])) {
                        $errorUsername = "<p class=\"text-danger\">Incorrect characters</p>";
                    } else {
                        if (userExists($_POST["username"], $allUsers)) {
                            $errorUsername = "<p class=\"text-danger\">The username already exists, please choose another</p>";
                        } else {
                            $username = strip_tags(test_input($_POST["username"]));
                        }
                    }
                }
            }
        }

        if (empty($_POST["password"])) {
            $errorPassword = "<p class=\"text-danger\">Required field</p>.";
        } else {
            if (strlen($_POST["password"]) > 20 || strlen($_POST["password"]) < 4) {
                $errorPassword = "<p class=\"text-danger\">Max 20 characters and min 4 characters</p>";
            } else {
                if (!preg_match("/^[a-zA-Z0-9]*$/", $_POST["password"])) {
                    $errorPassword = "<p class=\"text-danger\">Wrong format. Only numbers and letters without spaces</p>";
                } else {
                    if (strlen(strip_tags($_POST["password"])) != strlen($_POST["password"])) {
                        $errorPassword = "<p class=\"text-danger\">Incorrect characters</p>";
                    } else {
                        $password = strip_tags(test_input($_POST["password"]));
                    }
                }
            }
        }

        if (empty($_POST["fullname"])) {
            $errorFullname = "<p class=\"text-danger\">Required field</p>.";
        } else {
            if (strlen(trim($_POST["fullname"])) > 40 || strlen($_POST["fullname"]) < 4) {
                $errorFullname = "<p class=\"text-danger\">Max 40 characters and min 4 characters</p>";
            } else {
                if (!preg_match("/^([a-zA-Z])+(([ ]){1}([a-zA-Z])+)*$/", trim($_POST["fullname"]))) {
                    $errorFullname = "<p class=\"text-danger\">Wrong format. Only numbers and letters with spaces</p>";
                } else {
                    if (strlen(strip_tags(trim($_POST["fullname"]))) != strlen(trim($_POST["fullname"]))) {
                        $errorFullname = "<p class=\"text-danger\">Incorrect characters</p>";
                    } else {
                        $fullname = strip_tags(test_input($_POST["fullname"]));
                    }
                }
            }
        }

        if (empty($_POST["email"])) {
            $errorEmail = "<p class=\"text-danger\">Required field</p>.";
        } else {
            if (emailExists($_POST["email"], $allUsers)) {
                $errorEmail = "<p class=\"text-danger\">The email already exists, please choose another</p>";
            } else {
                $email = strip_tags(test_input($_POST["email"]));
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
            $errorUsername = "<p class=\"text-danger\">Required field</p>.";
        } else {
            if (strlen($_POST["usernameLogin"]) > 20 || strlen($_POST["usernameLogin"]) < 4) {
                $errorUsername = "<p class=\"text-danger\">Max 20 characters</p>";
            } else {
                if (!preg_match("/^[a-zA-Z0-9]*$/", $_POST["usernameLogin"])) {
                    $errorUsername = "<p class=\"text-danger\">Wrong format. Only numbers and letters without spaces</p>";
                } else {
                    if (strlen(strip_tags($_POST["usernameLogin"])) != strlen($_POST["usernameLogin"])) {
                        $errorUsername = "<p class=\"text-danger\">Incorrect characters</p>";
                    } else {
                        $username = strip_tags(test_input($_POST["usernameLogin"]));
                    }
                }
            }
        }

        if (empty($_POST["passwordLogin"])) {
            $errorPassword = "<p class=\"text-danger\">Required field</p>.";
        } else {
            if (strlen($_POST["passwordLogin"]) > 20 || strlen($_POST["passwordLogin"]) < 4) {
                $errorPassword = "<p class=\"text-danger\">Max 20 characters</p>";
            } else {
                if (!preg_match("/^[a-zA-Z0-9]*$/", $_POST["passwordLogin"])) {
                    $errorPassword = "<p class=\"text-danger\">Wrong format. Only numbers and letters without spaces</p>";
                } else {
                    if (strlen(strip_tags($_POST["passwordLogin"])) != strlen($_POST["passwordLogin"])) {
                        $errorPassword = "<p class=\"text-danger\">Incorrect characters</p>";
                    } else {
                        $password = strip_tags(test_input($_POST["passwordLogin"]));
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
