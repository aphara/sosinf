<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>SOS Infirmières - Connexion</title>
    <link rel="stylesheet" href="css/bootstrap.css">
    <!-- <link rel="stylesheet" href="css/bootstrap-theme.css"> -->
    <link rel="stylesheet" href="css/bootstrap-datepicker.css">
    <link rel="stylesheet" href="css/bootstrap-table.css">
    <link rel="stylesheet" href="webfonts/css/fontawesome-all.css">



    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
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

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>


<body>

<div class="container">
    <div class="row text-center">
        <div class="col-lg-12">
            <br /><br/>
            <img src='images/logo-infirmieres.png' alt='logo' id="img_logo"/>
            <br />
        </div>
    </div>

    <div class="row">
        <div class="col-lg-4 col-lg-offset-4">
            <div class="panel panel-default">
                <div class="panel-heading text-center">
                    <h3>Connexion</h3>
                </div>
                <div class="panel-body">

                    <form class="login-form" action="index.php?action=login" method="post">
                        <div class="login-wrap">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-user fa-fw"></i></span>
                                <input type="text" class="form-control" placeholder="Nom d'utilisateur" id="username" name="_username" value="" autofocus required>
                            </div>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-lock fa-fw"></i></span>
                                <input type="password" class="form-control" placeholder="Mot de passe" id="password" name="_password" required>
                            </div>



                            <label class="checkbox">
                                <label for="remember-me"><input type="checkbox" value="remember-me" id="remember-me">Se souvenir de moi</label>
                                <span class="pull-right"> <a href=#>Mot de passe oublié</a></span>
                            </label>

                            <hr>

                            <div class="row">
                                <div class="col-lg-6 col-sm-12">
                                    <button class="btn btn-info btn-lg btn-block" type="submit">Se connecter</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

</body>

</html>