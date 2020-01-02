<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;

final class TestEncrypt extends TestCase
{
    public function testRequestSimpleEquals1(): void
    {
        $this->assertEquals(
            "<p class=\"text-danger\">Username or password incorrect</p>",
            requestSimple("dataIncorrect")
        );
    }

    public function testRequestSimpleEquals2(): void
    {
        $this->assertEquals(
            "<p class=\"text-danger\">There is any empty field</p>",
            requestSimple("emptyField")
        );
    }

    public function testRequestSimpleEquals3(): void
    {
        $this->assertEquals(
            "<p class=\"mb-0\"><span class=\"font-weight-bold\">Sign up</span> and <span class=\"font-weight-bold\">login</span> to use the application.<br>If you have an account, <span class=\"font-weight-bold\">please login</span></p>",
            requestSimple("requestLogin")
        );
    }

    public function testRequestSimpleEquals4(): void
    {
        $this->assertEquals(
            "<p class=\"text-danger\">Error: The data was not found</p><div class=\"d-flex justify-content-around mt-3 mb-3\"><a href=\"\" class=\"btn btn-primary\">Return</a></div>",
            requestSimple("dataNotFound")
        );
    }

    public function testRequestSimpleEquals5(): void
    {
        $this->assertEquals(
            "<h1 class=\"mb-0\">WELCOME TO SMALLSHOP</h1>
                <hr>
                <p class=\"mb-0\">Choose an option</p>
                <div class=\"list-group mt-3\">
                    <form method=\"post\" action=\"\" enctype=\"multipart/form-data\" class=\"needs-validation\">
                        <button type=\"submit\" class=\"list-group-item list-group-item-action\" name=\"listAllCustomers\">List all costumers</button>
                        <button type=\"submit\" class=\"list-group-item list-group-item-action\" name=\"getCostumerInformation\">Get full costumer information</button>
                        <button type=\"submit\" class=\"list-group-item list-group-item-action\" name=\"createCostumer\">Create a new costumer</button>
                        <button type=\"submit\" class=\"list-group-item list-group-item-action\" name=\"updateCostumer\">Update an existing costumer</button>
                        <button type=\"submit\" class=\"list-group-item list-group-item-action\" name=\"deleteCostumer\">Delete an existing costumer</button>
                    </form>
                </div>",
            requestSimple("menu")
        );
    }

    public function testRequestSimpleEquals6(): void
    {
        $this->assertEquals(
            "<p class=\"text-danger\">OPTION ERROR</p>",
            requestSimple("anywhere")
        );
    }

    public function testRequestSimpleEquals7(): void
    {
        $this->assertEquals(
            "<p class=\"text-body\">The operation in the database has been satisfactory</p><div class=\"d-flex justify-content-around mt-3 mb-3\"><a href=\"\" class=\"btn btn-primary\">Return</a></div>",
            requestSimple("successOperation")
        );
    }

    public function testRequestSimpleEquals8(): void
    {
        $this->assertEquals(
            "<p class=\"text-danger\">Error: The operation has been aborted</p><div class=\"d-flex justify-content-around mt-3 mb-3\"><a href=\"\" class=\"btn btn-primary\">Return</a></div>",
            requestSimple("errorOperation")
        );
    }

    public function testRequestSimpleNotEquals1(): void
    {
        $this->assertNotEquals(
            "<p class=\"text-danger\">OPTION ERROR</p>",
            requestSimple("dataIncorrect")
        );
    }

    public function testRequestSimpleNotEquals2(): void
    {
        $this->assertNotEquals(
            "<p class=\"text-danger\">Username or password incorrect</p>",
            requestSimple("emptyField")
        );
    }

    public function testRequestSimpleNotEquals3(): void
    {
        $this->assertNotEquals(
            "<p class=\"text-danger\">There is any empty field</p>",
            requestSimple("requestLogin")
        );
    }

    public function testRequestSimpleNotEquals4(): void
    {
        $this->assertNotEquals(
            "<p class=\"mb-0\"><span class=\"font-weight-bold\">Sign up</span> and <span class=\"font-weight-bold\">login</span> to use the application.<br>If you have an account, <span class=\"font-weight-bold\">please login</span></p>",
            requestSimple("dataNotFound")
        );
    }

    public function testRequestSimpleNotEquals5(): void
    {
        $this->assertNotEquals(
            "<p class=\"text-danger\">Error: The data was not found</p><div class=\"d-flex justify-content-around mt-3 mb-3\"><a href=\"\" class=\"btn btn-primary\">Return</a></div>",
            requestSimple("menu")
        );
    }

    public function testRequestSimpleNotEquals6(): void
    {
        $this->assertNotEquals(
            "<h1 class=\"mb-0\">WELCOME TO SMALLSHOP</h1>
                <hr>
                <p class=\"mb-0\">Choose an option</p>
                <div class=\"list-group mt-3\">
                    <form method=\"post\" action=\"\" enctype=\"multipart/form-data\" class=\"needs-validation\">
                        <button type=\"submit\" class=\"list-group-item list-group-item-action\" name=\"listAllCustomers\">List all costumers</button>
                        <button type=\"submit\" class=\"list-group-item list-group-item-action\" name=\"getCostumerInformation\">Get full costumer information</button>
                        <button type=\"submit\" class=\"list-group-item list-group-item-action\" name=\"createCostumer\">Create a new costumer</button>
                        <button type=\"submit\" class=\"list-group-item list-group-item-action\" name=\"updateCostumer\">Update an existing costumer</button>
                        <button type=\"submit\" class=\"list-group-item list-group-item-action\" name=\"deleteCostumer\">Delete an existing costumer</button>
                    </form>
                </div>",
            requestSimple("anywhere")
        );
    }

    public function testRequestSimpleNotEquals7(): void
    {
        $this->assertNotEquals(
            "<p class=\"text-body\">Error: The operation has been aborted</p><div class=\"d-flex justify-content-around mt-3 mb-3\"><a href=\"\" class=\"btn btn-primary\">Return</a></div>",
            requestSimple("successOperation")
        );
    }

    public function testRequestSimpleNotEquals8(): void
    {
        $this->assertNotEquals(
            "<p class=\"text-danger\">The operation in the database has been satisfactory</p><div class=\"d-flex justify-content-around mt-3 mb-3\"><a href=\"\" class=\"btn btn-primary\">Return</a></div>",
            requestSimple("errorOperation")
        );
    }

    public function testLayoutSimpleEquals1(): void
    {
        $this->assertEquals(
            "<div class=\"row mt-5 mb-5\">
                <div class=\"mx-auto w-50 p-3 text-center opacity-80\">
                    <p class=\"text-danger\">Username or password incorrect</p>
                </div>
            </div>",
            layoutSimple("dataIncorrect")
        );
    }

    public function testLayoutSimpleEquals2(): void
    {
        $this->assertEquals(
            "<div class=\"row mt-5 mb-5\">
                <div class=\"mx-auto w-50 p-3 text-center opacity-80\">
                    <p class=\"text-danger\">There is any empty field</p>
                </div>
            </div>",
            layoutSimple("emptyField")
        );
    }

    public function testLayoutSimpleEquals3(): void
    {
        $this->assertEquals(
            "<div class=\"row mt-5 mb-5\">
                <div class=\"mx-auto w-50 p-3 text-center opacity-80\">
                    <p class=\"mb-0\"><span class=\"font-weight-bold\">Sign up</span> and <span class=\"font-weight-bold\">login</span> to use the application.<br>If you have an account, <span class=\"font-weight-bold\">please login</span></p>
                </div>
            </div>",
            layoutSimple("requestLogin")
        );
    }

    public function testLayoutSimpleNotEquals1(): void
    {
        $this->assertNotEquals(
            "<div class=\"row mt-5 mb-5\">
                <div class=\"mx-auto w-50 p-3 text-center opacity-80\">
                    <p class=\"mb-0\"><span class=\"font-weight-bold\">Sign up</span> and <span class=\"font-weight-bold\">login</span> to use the application.<br>If you have an account, <span class=\"font-weight-bold\">please login</span></p>
                </div>
            </div>",
            layoutSimple("dataIncorrect")
        );
    }

    public function testLayoutSimpleNotEquals2(): void
    {
        $this->assertNotEquals(
            "<div class=\"row mt-5 mb-5\">
                <div class=\"mx-auto w-50 p-3 text-center opacity-80\">
                    <p class=\"text-danger\">Username or password incorrect</p>
                </div>
            </div>",
            layoutSimple("emptyField")
        );
    }

    public function testLayoutSimpleNotEquals3(): void
    {
        $this->assertNotEquals(
            "<div class=\"row mt-5 mb-5\">
                <div class=\"mx-auto w-50 p-3 text-center opacity-80\">
                    <p class=\"text-danger\">There is any empty field</p>
                </div>
            </div>",
            layoutSimple("requestLogin")
        );
    }
}

function layoutSimple($option)
{
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
                        <button type=\"submit\" class=\"list-group-item list-group-item-action\" name=\"listAllCustomers\">List all costumers</button>
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
