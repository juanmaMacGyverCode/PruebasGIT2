# SmallShop application

This is an application for a small store. Their functions are:

- Create a user.
- List all customers.
- List all the information of a client.
- Create a client.
- Modify a client.
- Delete a client.

It has the security requirements (Authentication, Authorization, SQL injection and XSS prevention).

# Requirements to use/modify the application: XAMPP and Composer (tests PHPUnit)

For proper operation, host the application in the htdocs folder in the folder XAMPP. Inside the application is the script to create the database. In the button Shell in the "XAMPP Control Panel", open the mysql database with:

```bash
mysql -u root
```

And finally, copy and paste the script inside in scriptDatabase.sql in the shell the whole script of the database.

## How to run the application?

In the folder /xampp/htdocs, you can open github or dowload from:

https://github.com/juanmaMacGyverCode/PruebasGIT2

The command for github is:

```bash
git clone https://github.com/juanmaMacGyverCode/PruebasGIT2.git
```

And finally, to open the application, open your browser and write: localhost/smallshop/views/index.php.

## How to use?

If this is your first time using the application:

- Please, press the sign in button. Fill in the registration form and press the sign in button in the form.
- Fill the form to login and press the login button to enter the application.

If you have a account in the application:

- Fill the form to login and press the login button to enter the application.

--------------------------------------------------------------------------------

Already logged in, you can see the menu. It has five buttons:

- List all customers
- Get full customer information
- Create a new customer
- Update an existing customer
- Delete an existing customer

#### List all customers

    This option open a form and you write the number of rows what you like rows of the table to have. If you press "Show table", you can see a pagination of the rows inside in the database. With the buttons "next" and "previous", you control what customers you see.

#### Get full costumer information

    This option open a form and you write the number of ID of the customer. If you press "Show customer" button, you can see the full customer information about about the customer chosen.

#### Create a new costumer

    This option open a form and you write the information about the customer. The image isn´t required field. If you press "Create" button, you can see the card with the full customer information.

#### Update an existing costumer

    This option open a form and you write the number of ID of the customer. If you press "Show customer" button, you can see a form and you update the information about the customer. The image isn´t required field and the checkbox about "Delete image". If you press "Update" button, you can see the card with the update customer with him/her full customer information.

#### Delete an existing costumer

    This option open a form and you write the number of ID of the customer. If you press "Delete customer" button, you can delete the full customer information about the customer chosen.           

# Test PHPUnit

## To install the PHPUnit dependencies for the tests:

```bash
composer require --dev phpunit/phpunit ^8.5
```

## Execute tests (I recommend placing the bash of cmd in the project folder \smallshop\tests):

```bash
.\vendor\bin\phpunit --bootstrap .\vendor\autoload.php .\tests\TestLayoutRequestSimple
.\vendor\bin\phpunit --bootstrap .\vendor\autoload.php .\tests\TestShowLoginRegisterLogout
.\vendor\bin\phpunit --bootstrap .\vendor\autoload.php .\tests\TestUserExists
.\vendor\bin\phpunit --bootstrap .\vendor\autoload.php .\tests\TestCreateDeleteUsers
.\vendor\bin\phpunit --bootstrap .\vendor\autoload.php .\tests\TestEmailExists
.\vendor\bin\phpunit --bootstrap .\vendor\autoload.php .\tests\TestCreateDeleteCustomers
.\vendor\bin\phpunit --bootstrap .\vendor\autoload.php .\tests\TestUpdateCustomers
.\vendor\bin\phpunit --bootstrap .\vendor\autoload.php .\tests\TestThereIsThatID
.\vendor\bin\phpunit --bootstrap .\vendor\autoload.php .\tests\TestLayoutDataSheetCustomers
```

# Other information

## Authors

* **Juan Manuel López Durán** - *smallShop* - [juanmaMacGyverCode](https://github.com/juanmaMacGyverCode)