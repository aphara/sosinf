<!DOCTYPE html>
<html>
<head>
    <title>Titre de la page</title>
    <link rel="stylesheet" href="css/bootstrap.css">
    <!-- <link rel="stylesheet" href="css/bootstrap-theme.css"> -->
    <link rel="stylesheet" href="css/bootstrap-datepicker.css">
    <link rel="stylesheet" href="css/bootstrap-table.css">
    <link rel="stylesheet" href="webfonts/css/fontawesome-all.css">
    <link rel="stylesheet" href="css/sos.css">


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.m²in.js"></script>
    <script src="js/jquery-resizable.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/bootstrap-confirmation.min.js"></script>
    <script src="js/bootstrap-table.js"></script>
    <script src="js/bootstrap-table-multiple-sort.js"></script>
    <script src="js/bootstrap-table-toolbar.js"></script>
    <script src="js/bootstrap-datepicker.js"></script>
    <script src="js/bootstrap-datepicker.fr.min.js"></script>
    <script src="js/bootstrap-timepicker.js"></script>
    <script src="js/jquery.maskMoney.js"></script>
    <script src="js/bootstrap-table.js"></script>
    <script src="js/bootstrap-table-multiple-sort.js"></script>
    <script src="js/bootstrap-table-toolbar.js"></script>

    <script src="js/main.js"></script>

    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>



<body style="">
<ul class="nav nav-tabs navbar-static-top">
    <li role="presentation"><a href="index.php?action=patients">Patients</a></li>
    <li role="presentation"><a href="#">Infirmier</a></li>
    <li role="presentation" class="active"><a href="index.php?action=planning">Planning</a></li>
    <li role="presentation"><a href="index.php?action=logout">Se déconnecter</a></li>
</ul>
<div>
    <div class="row">
        <?php include('php/Patients/getPatients.php'); ?>
    </div>
</div>

</body>
</html>
