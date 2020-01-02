<?php

include("conexion.php");

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

function createNewCostumer($name, $surname, $fileUpload, $idUser)
{

    if ($name == null || $surname == null) {
        return false;
    }

    $mysqli = connection();

    $prepareStatement = $mysqli->stmt_init();

    if (!empty($fileUpload)) {
        $fileUpload = $mysqli->real_escape_string($fileUpload);

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


function listAllCustomers()
{
    $allCustomers = array();

    $mysqli = connection();

    $sql = "SELECT idCostumer, nameCostumer, surname, imageName, idUserCreator, idUserLastModify FROM costumers";
    if ($query = $mysqli->query($sql)) {
        while ($row = $query->fetch_assoc()) {
            $newCostumer = new Costumer($row["idCostumer"], $row["nameCostumer"], $row["surname"], $row["imageName"], $row["idUserCreator"], $row["idUserLastModify"]);
            array_push($allCustomers, $newCostumer);
        }
    }

    $mysqli->close();

    return $allCustomers;
}

function paginationWithButtom($value, $numberRow)
{

    $mysqli = connection();
    $start = $value;

    $printed = 0;
    $allQuery = "";

    $sql = "SELECT idCostumer, nameCostumer, surname, idUserCreator, idUserLastModify FROM costumers LIMIT $start, $numberRow";

    if ($summary = $mysqli->query($sql)) {
        $allQuery =
            "<div class=\"row mt-5\">
            <div class=\"mx-auto w-75 p-3 text-center opacity-80\">
                <h1 class=\"mb-0\">LIST ALL CUSTOMERS</h1>
                <hr>
                <table class=\"table table-striped table-dark\">
                  <thead>
                    <tr>
                      <th scope=\"col\">ID</th>
                      <th scope=\"col\">First name</th>
                      <th scope=\"col\">Surname</th>
                      <th scope=\"col\">ID user creator</th>
                      <th scope=\"col\">ID last user modify</th>
                    </tr>
                  </thead>
                  <tbody>";
        while ($fila = $summary->fetch_assoc()) {
            $printed++;
            $allQuery .=
                "<tr>
                <th scope=\"row\">" . $fila["idCostumer"] . "</th>
                <td>" . $fila["nameCostumer"] . "</td>
                <td>" . $fila["surname"] . "</td>
                <td>" . $fila["idUserCreator"] . "</td>
                <td>" . $fila["idUserLastModify"] . "</td>
            </tr>";
        }
        $allQuery .= "</tbody></table><form method=\"post\" action=\"\" enctype=\"multipart/form-data\" class=\"needs-validation\">";
        $summary->close();
    }
    $mysqli->close();


    $allQuery .= "<br><div class=\"d-flex justify-content-around\">";

    if ($start == 0) {
        $allQuery .= "<p class=\"font-weight-bold\">Previous</p>";
    } else {
        $previous = $start - $numberRow;
        $allQuery .= "<input type=\"submit\" class=\"btn btn-primary\" name=\"previousPagination\" value=\"Previous\">";
        $allQuery .= "<input type=\"hidden\" name=\"previous\" value=\"" . $previous . "\">";
        $allQuery .= "<input type=\"hidden\" name=\"numberRows\" value=\"" . $numberRow . "\">";
    }
    if ($printed == $numberRow) {
        $next = $start + $numberRow;
        $allQuery .= "<input type=\"submit\" class=\"btn btn-primary\" name=\"nextPagination\" value=\"Next\">";
        $allQuery .= "<input type=\"hidden\" name=\"next\" value=\"" . $next . "\">";
        $allQuery .= "<input type=\"hidden\" name=\"numberRows\" value=\"" . $numberRow . "\">";
    } else {
        $allQuery .= "<p class=\"font-weight-bold\">Next</p>";
    }

    $allQuery .= "</div></form>
    <div class=\"d-flex justify-content-around mt-3\">
        <a href=\"\" class=\"btn btn-primary\">Return</a>
    </div></div></div>";

    return $allQuery;
}

function updateCustomer($idCustomer, $name, $surname, $fileUpload, $checkboxDeleteImage, $idUser)
{

    if ($idCustomer == null || $name == null || $surname == null) {
        return false;
    }

    $mysqli = connection();

    $prepareStatement = $mysqli->stmt_init();

    if ($checkboxDeleteImage) {
        $prepareStatement->prepare("UPDATE costumers SET idCostumer=?, nameCostumer=?, surname=?, imageName=NULL, idUserLastModify=? WHERE idCostumer=?");
        $prepareStatement->bind_param("issii", $idCustomer, $name, $surname, $idUser, $idCustomer);
    } else {
        if (!empty($fileUpload)) {
            $fileUpload = $mysqli->real_escape_string($fileUpload);

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

function deleteCustomer($idCustomer) {

    if ($idCustomer == null) {
        return false;
    }

    $mysqli = connection();

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
