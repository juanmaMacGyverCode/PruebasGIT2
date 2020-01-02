<?php

function showBoxCreateCostumer($name, $surname, $errorName, $errorSurname, $errorUpload) {

    return "<div class=\"row w-100 mt-5\">
            <div class=\"mx-auto w-50 p-3 text-center opacity-80\">
                <h1 class=\"mb-0\">CREATE A NEW COSTUMER</h1>
                <hr>
                <div class=\"list-group mt-3\">
                    <form method=\"post\" action=\"\" enctype=\"multipart/form-data\" class=\"needs-validation\">
                        <div class=\"form-group col-md-6 mx-auto\">
                            <label for=\"inputName\">Name</label>
                            <input type=\"text\" class=\"form-control\" id=\"inputName\" name=\"name\" value=\"" . $name . "\" placeholder=\"Name\">".
                            $errorName
                        . "</div>
                        <div class=\"form-group col-md-6 mx-auto\">
                            <label for=\"inputSurname\">Surname</label>
                            <input type=\"text\" class=\"form-control\" id=\"inputSurname\" name=\"surname\" value=\"" . $surname . "\" placeholder=\"Surname\">".
                            $errorSurname
                        ."</div>
                        <div class=\"form-group mx-auto\">
                            <label for=\"exampleFormControlFile1\">Example file input</label>
                            <input type=\"file\" class=\"form-control-file\" id=\"exampleFormControlFile1\" name=\"uploadImage\">".
                            $errorUpload
                        . "</div>
                        <div class=\"d-flex justify-content-around\">
                            <button type=\"submit\" class=\"btn btn-primary\" name=\"buttonCreateCostumer\">Create</button><a href=\"\" class=\"btn btn-primary\">Return</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>";
}

function uploadFile($fileUpload)
{
    $errorUpload = "";

    $fileType = $_FILES["uploadImage"]["type"];

    $rutaDef = "../uploads/";
    if (!is_dir($rutaDef)) {
        mkdir($rutaDef);
    }

    if ($fileType == "image/jpg" || $fileType == "image/jpeg" || $fileType == "image/png" || $fileType == "image/png") {
        if (strlen($_FILES["uploadImage"]['name']) <= 60) {
            if ($_FILES["uploadImage"]['size'] <= 1048576) {
                //$fileName = $_FILES["uploadImage"]['name'];
                //$fileExtension = explode("/", $fileType)[1];
                $folderAddress = "../uploads/";
                move_uploaded_file($_FILES["uploadImage"]["tmp_name"], $folderAddress . $fileUpload);
            } else {
                $errorUpload = "<p class=\"text-danger\">Max size image 1 MB</p>";
            }
        } else {
            $errorUpload = "<p class=\"text-danger\">Name too huge, change the name.</p>";
        }
    } else {
        $errorUpload = "<p class=\"text-danger\">Only files jpg, jpeg, png and gif</p>";
    }

    return $errorUpload;
}

function showFormUpdateCustomer($customer, $errorIdCustomer, $errorName, $errorSurname, $errorUpload) {

    $image = "";
    if ($customer->getImage() == null || $customer->getImage() == "") {
        $image = "<input type=\"hidden\" class=\"form-control-file\" id=\"customerFile\" name=\"uploadImageHidden\" value=\"\">";
    } else {
        $image = "<input type=\"hidden\" class=\"form-control-file\" id=\"customerFile\" name=\"uploadImageHidden\" value=\"" . decrypt($customer->getImage(), "1235@") . "\">
        <label for=\"checkboxDeleteImage\" class=\"mt-3\">Would you like to delete the customer image?</label>
        <input type=\"checkbox\" class=\"form-control-file\" id=\"checkboxDeleteImage\" name=\"checkboxDeleteImage\" value=\"yes\">";
    }

        return "<div class=\"row w-100 mt-5 mb-5\">
            <div class=\"mx-auto w-50 p-3 text-center opacity-80\">
                <h1 class=\"mb-0\">CREATE A NEW COSTUMER</h1>
                <hr>
                <div class=\"list-group mt-3\">
                    <form method=\"post\" action=\"\" enctype=\"multipart/form-data\" class=\"needs-validation\">
                        <div class=\"form-group col-md-6 mx-auto\">
                            <label for=\"idCustomer\">ID customer</label>
                            <input type=\"text\" class=\"form-control\" id=\"idCustomer\" name=\"idCustomer\" value=\"" . $customer->getIdCostumer() . "\" readonly>".
                            $errorIdCustomer
                        . "</div>
                        <div class=\"form-group col-md-6 mx-auto\">
                            <label for=\"name\">Name</label>
                            <input type=\"text\" class=\"form-control\" id=\"name\" name=\"name\" value=\"" . decrypt($customer->getNameCostumer(), "1235@") . "\" placeholder=\"Name\">".
                            $errorName
                        . "</div>
                        <div class=\"form-group col-md-6 mx-auto\">
                            <label for=\"surname\">Surname</label>
                            <input type=\"text\" class=\"form-control\" id=\"surname\" name=\"surname\" value=\"" . decrypt($customer->getSurname(), "1235@") . "\" placeholder=\"Surname\">".
                            $errorSurname
                        ."</div>
                        <div class=\"form-group mx-auto\">
                            <label for=\"customerFile\">Choose customer file</label>
                            <input type=\"file\" class=\"form-control-file\" id=\"customerFile\" name=\"uploadImage\">
                            $image".
                            $errorUpload
                        . "</div>
                        <div class=\"d-flex justify-content-around\">
                            <button type=\"submit\" class=\"btn btn-primary\" name=\"buttonUpdateCustomer\">Update</button><a href=\"\" class=\"btn btn-primary\">Return</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>";
}

function thereIsThatID($idCustomer, $allCustomers) 
{
    foreach ($allCustomers as $customerObject) {
        if ($idCustomer == $customerObject->getIdCostumer()) {
            return false;
        }
    }
    return true;
}

function createAlphanumericName($fileType) {
    
    $alphanumeric = "abcdefghijklmnopqrstuvwxyz0123456789";
    $fileExtension = explode("/", $fileType)[1];
    /*$newName = "";
    for ($i=0; $i < 20; $i++) { 
        $newName .= $alphanumeric[rand(0, strlen($alphanumeric) - 1)];
    }*/

    while (true) {
        $newName = "";
        for ($i = 0; $i < 20; $i++) {
            $newName .= $alphanumeric[rand(0, strlen($alphanumeric) - 1)];
        }
        
        if (!file_exists($newName)) {
            return $newName . "." . $fileExtension;
        }
    }
   
}

function deleteImage($idCustomer, $allCustomers) {

    foreach ($allCustomers as $customer) {
        if ($idCustomer == $customer->getIdCostumer()) {
            unlink("..\\uploads\\" . decrypt($customer->getImage(), "1235@"));
        }
    }
}