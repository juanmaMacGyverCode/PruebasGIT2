<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="styles/styles.css">
    <script src='https://kit.fontawesome.com/a076d05399.js'></script>
</head>

<body>
    <?php include("..\\controller\\controllerIndex\\controller.php"); ?>
    <?php include("..\\controller\\controllerCostumer\\controller.php"); ?>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="">smallShop <i class='fas fa-building' style='font-size:1em;color:red'></i></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <?php echo $showMenuAdministrator; ?>
            </ul>
            <form class="form-inline my-2 my-lg-0" method="post" action="" enctype="multipart/form-data">
                <?php echo $showMenuLogin; ?>
            </form>
        </div>
    </nav>

    <?php echo $showErrorLogin; ?>
    <?php echo $showBoxDatabase; ?>
    <?php echo $showBoxWarning; ?>
    <?php echo $showBoxProgram; ?>
    <?php echo $showFormNumberRows; ?>
    <?php echo $showFormFindCostumer; ?>
    <?php echo $showFormUpdateCustomer; ?>
    <?php echo $showUpdateCustomer; ?>
    <?php echo $showLastNewCostumer; ?>
    <?php echo $showTableDataCostumers; ?>
    <?php echo $registerForm; ?>

    <script src="..//controlador//checkInfo.js"></script>
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>

</html>