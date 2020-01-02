<?php

//include("..\\tests\\tests\\controllerIndexFunctionsTest.php");

function showLoginRegisterLogout($user)
{
    $showMenuLogin = "";
    if (isset($user)) {
        $showMenuLogin = "<span class=\"nav-item text-white mr-sm-2\">Bienvenido " . decrypt($user, "1235@") . "</span>
        <input class=\"btn btn-outline-success my-2 my-sm-0\" type=\"submit\" name=\"logout\" aria-label=\"Logout\" value=\"Logout\">";
    } else {
        $showMenuLogin = "<input class=\"form-control mr-sm-2\" type=\"text\" name=\"usernameLogin\" placeholder=\"Username\" aria-label=\"Search\">
                <input class=\"form-control mr-sm-2\" type=\"text\" name=\"passwordLogin\" placeholder=\"Password\" aria-label=\"Search\">
                <input class=\"btn btn-outline-success my-2 my-sm-0 mr-sm-2\" type=\"submit\" name=\"login\" aria-label=\"Login\" value=\"Login\">
                <input class=\"btn btn-outline-success my-2 my-sm-0\" type=\"submit\" name=\"registerForm\" aria-label=\"Sign in\" value=\"Sign in\">";
    }
    return $showMenuLogin;
}

function showMenuAdministrator($administrator)
{

    $showMenuAdministrator = "";

    if (isset($administrator)) {

        $showMenuAdministrator =
            "<li class=\"nav-item active dropdown\">
                <a class=\"nav-link dropdown-toggle\" href=\"#\" id=\"navbarDropdown\" role=\"button\" data-toggle=\"dropdown\" aria-haspopup=\"true\" aria-expanded=\"false\">
                        Manage smallShop
                </a>
                <div class=\"dropdown-menu\" aria-labelledby=\"navbarDropdown\">
                    <form method=\"post\" action=\"\" enctype=\"multipart/form-data\" class=\"needs-validation\">
                        <button type=\"submit\" class=\"dropdown-item list-group-item-action\" name=\"listAllCustomers\">List all customers</button>
                        <button type=\"submit\" class=\"dropdown-item list-group-item-action\" name=\"getCostumberInformation\">Get full costumer information</button>
                        <button type=\"submit\" class=\"dropdown-item list-group-item-action\" name=\"createCostumer\">Create a new customer</button>
                        <button type=\"submit\" class=\"dropdown-item list-group-item-action\" name=\"updateCostumer\">Update an existing customer</button>
                        <button type=\"submit\" class=\"dropdown-item list-group-item-action\" name=\"deleteCostumer\">Delete an existing customer</button>
                    </form>
                </div>
            </li>";
    } else {
        $showMenuAdministrator = "";
    }

    return $showMenuAdministrator;
}

function registerForm($errorUsername, $errorPassword, $errorFullname, $errorEmail, $username, $password, $fullname, $email) {
    $registerForm =
        "<div class=\"row w-100 mt-5 mb-5\">
        <div class=\"mx-auto w-50 p-3 text-center opacity-80\">
        <form method=\"post\" action=\"\" enctype=\"multipart/form-data\" class=\"needs-validation\" novalidate>
            <h1>FORMULARIO DE REGISTRO</h1>
            <div class=\"form-group\">
                <label for=\"username\">Username</label>
                <input type=\"text\" class=\"form-control\" name=\"username\" value=\"$username\" placeholder=\"Username\" required>
                <div class=\"valid-feedback\">
                    Looks good!
                </div>
                <div class=\"invalid-feedback\">
                    Please, complete the field! Only letters and numbers without spaces
                </div>
                $errorUsername
            </div>
            <div class=\"form-group\">
                <label for=\"password\">Password</label>
                <input type=\"password\" class=\"form-control\" name=\"password\" value=\"$password\" placeholder=\"Password\" required>
                <div class=\"valid-feedback\">
                    Looks good!
                </div>
                <div class=\"invalid-feedback\">
                    Please, complete the field! Only letters and numbers without spaces
                </div>
                $errorPassword
            </div>
            <div class=\"form-group\">
                <label for=\"fullname\">Full name</label>
                <input type=\"fullname\" class=\"form-control\" name=\"fullname\" value=\"$fullname\" placeholder=\"Full name\" required>
                <div class=\"valid-feedback\">
                    Looks good!
                </div>
                <div class=\"invalid-feedback\">
                    Please, complete the field! Only letters and spaces
                </div>
                $errorFullname
            </div>
            <div class=\"form-group\">
                <label for=\"email\">Email</label>
                <input type=\"email\" class=\"form-control\" name=\"email\" value=\"$email\" placeholder=\"Email\" required>
                <div class=\"valid-feedback\">
                    Looks good!
                </div>
                <div class=\"invalid-feedback\">
                    Please, complete the field!
                </div>
                $errorEmail
            </div>
            <div class=\"d-flex justify-content-around\">
                <button type=\"submit\" class=\"btn btn-primary\" name=\"signin\">Sign in</button><a href=\"\" class=\"btn btn-primary\">Return</a>
            </div>
        </form>
        </div>
        </div>";

        return $registerForm;
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

function loginUser($username, $password, $allUsers)
{
    foreach ($allUsers as $user) {
        if ($username == decrypt($user->getUsername(), "1235@") && $password == decrypt($user->getPassword(), "1235@")) {
            newSession($user->getIdUser(), $user->getUsername(), $user->getPassword(), $user->getFullName(), $user->getEmail());
            return true;
        }
    }

    return false;
}

function newSession($idUser ,$userEncrypt, $passwordEncrypt, $fullNameEncrypt, $emailEncrypt) {
    $_SESSION["idUser"] = $idUser;
    $_SESSION["username"] = $userEncrypt;
    $_SESSION["password"] = $passwordEncrypt;
    $_SESSION["fullName"] = $fullNameEncrypt;
    $_SESSION["email"] = $emailEncrypt;
}

function sessionDestroy()
{
    unset($_SESSION);
    setcookie(session_name(), '', time() - 3600);
    session_destroy();
    header("Location: index.php");
}

function userExists($username, $allUsers) {

    foreach ($allUsers as $user) {
        if (decrypt($user->getUsername(), "1235@") == $username) {
            return true;
        }
    }
    return false;
}

function emailExists($email, $allUsers)
{

    foreach ($allUsers as $user) {
        if (decrypt($user->getEmail(), "1235@") == $email) {
            return true;
        }
    }
    return false;
}