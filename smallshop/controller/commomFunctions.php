<?php

function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

function layoutSimple($option) {

    return "<div class=\"row mt-5 mb-5\">
                <div class=\"mx-auto w-50 p-3 text-center opacity-80\">
                    " . requestSimple($option) . "
                </div>
            </div>";
}

function requestSimple($option) {
    if ($option == "dataIncorrect") {
        return "<p class=\"text-danger\">Username or password incorrect</p>";
    } else if ($option == "emptyField") {
        return "<p class=\"text-danger\">There is any empty field</p>";
    } else if ($option == "requestLogin") {
        return "<p class=\"mb-0\"><span class=\"font-weight-bold\">Sign up</span> and <span class=\"font-weight-bold\">login</span> to use the application.<br>If you have an account, <span class=\"font-weight-bold\">please login</span></p>";
    } else if ($option == "dataNotFound") {
        return "<p class=\"text-danger\">Error: The data was not found</p><div class=\"d-flex justify-content-around mt-3 mb-3\"><a href=\"\" class=\"btn btn-primary\">Return</a></div>";
    } else if ($option == "successOperation") {
        return "<p class=\"text-body\">The operation in the database has been satisfactory</p><div class=\"d-flex justify-content-around mt-3 mb-3\"><a href=\"\" class=\"btn btn-primary\">Return</a></div>";
    } else if ($option == "errorOperation") {
        return "<p class=\"text-danger\">Error: The operation has been aborted</p><div class=\"d-flex justify-content-around mt-3 mb-3\"><a href=\"\" class=\"btn btn-primary\">Return</a></div>";
    } else if ($option == "menu") {
        return "<h1 class=\"mb-0\">WELCOME TO SMALLSHOP</h1>
                <hr>
                <p class=\"mb-0\">Choose an option</p>
                <div class=\"list-group mt-3\">
                    <form method=\"post\" action=\"\" enctype=\"multipart/form-data\" class=\"needs-validation\">
                        <button type=\"submit\" class=\"list-group-item list-group-item-action\" name=\"listAllCustomers\">List all customers</button>
                        <button type=\"submit\" class=\"list-group-item list-group-item-action\" name=\"getCostumerInformation\">Get full costumer information</button>
                        <button type=\"submit\" class=\"list-group-item list-group-item-action\" name=\"createCostumer\">Create a new costumer</button>
                        <button type=\"submit\" class=\"list-group-item list-group-item-action\" name=\"updateCostumer\">Update an existing costumer</button>
                        <button type=\"submit\" class=\"list-group-item list-group-item-action\" name=\"deleteCostumer\">Delete an existing costumer</button>
                    </form>
                </div>";
    } else {
        return "<p class=\"text-danger\">OPTION ERROR</p>";
    }
}


function layoutFormUniqueNumericField($option, $errorNumber)
{
    $request = requestFormUniqueNumericField($option, $errorNumber);

    return "<div class=\"row mt-5 mb-5\">
            <div class=\"mx-auto w-50 p-3 text-center opacity-80\">
                " . $request[0] . "
                <hr>
                <div class=\"list-group mt-3\">
                    <form method=\"post\" action=\"\" enctype=\"multipart/form-data\" class=\"needs-validation\">
                        <div class=\"form-group col-md-6 mx-auto\">
                            " . $request[1] . "
                        </div>
                        <div class=\"d-flex justify-content-around\">
                            " . $request[2] . "
                        </div>
                    </form>
                </div>
            </div>
        </div>";
}

function requestFormUniqueNumericField($option, $errorNumber) {

    if ($option == "deleteCustomer") {
        return ["<h1 class=\"mb-0\">DELETE A CUSTOMER</h1>",
            "<label for=\"idCustomer\">Which customer do you want to look for to delete? Only numbers</label>
            <input type=\"number\" class=\"form-control\" id=\"idCustomer\" name=\"idCustomer\" value=\"1\">
            " . $errorNumber . "",
            "<button type=\"submit\" class=\"btn btn-primary\" name=\"findCustomerInformationToDelete\">Delete customer</button><a href=\"\" class=\"btn btn-primary\">Return</a>"
        ];
    } else if ($option == "showCustomer") {
        return [
            "<h1 class=\"mb-0\">GET FULL CUSTOMER INFORMATION</h1>",
            "<label for=\"idCustomer\">Which customer do you want to look for? Only numbers</label>
            <input type=\"number\" class=\"form-control\" id=\"idCustomer\" name=\"idCustomer\" value=\"1\">
            " . $errorNumber . "",
            "<button type=\"submit\" class=\"btn btn-primary\" name=\"findCostumerInformation\">Show customer</button><a href=\"\" class=\"btn btn-primary\">Return</a>"
        ];
    } else if ($option == "showNumberRows") {
        return [
            "<h1 class=\"mb-0\">CHOOSE THE NUMBER OF LINES</h1>",
            "<label for=\"numberRows\">Choose the number of lines to show in the table</label>
            <input type=\"number\" class=\"form-control\" id=\"numberRows\" name=\"numberRows\" value=\"1\">
            " . $errorNumber . "",
            "<button type=\"submit\" class=\"btn btn-primary\" name=\"showTable\">Show table</button><a href=\"\" class=\"btn btn-primary\">Return</a>"
        ];
    } else if ($option == "updateCustomer") {
        return [
            "<h1 class=\"mb-0\">UPDATE AN EXISTING CUSTOMER</h1>",
            "<label for=\"idCustomer\">Which customer do you want to look for to update? Only numbers</label>
            <input type=\"number\" class=\"form-control\" id=\"idCustomer\" name=\"idCustomer\" value=\"1\">
            " . $errorNumber . "",
            "<button type=\"submit\" class=\"btn btn-primary\" name=\"findCustomerInformationToUpdate\">Show customer</button><a href=\"\" class=\"btn btn-primary\">Return</a>"
        ];
    } else {
        return ["PROGRAMMING ERROR", "PROGRAMMING ERROR", "PROGRAMMING ERROR"];
    }
}

function layoutDataSheetCustomer($option, $customer, $allUsers)
{
    //$request = requestDataSheetCustomer($option);

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