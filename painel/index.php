<?php
require_once ('../.iniSis/iniSys.php');

$Login = new Umbrella\Models\User( 1 );
$logoff = filter_input( INPUT_GET, 'logout', FILTER_VALIDATE_BOOLEAN );

//Executa logoff
if ( !empty( $logoff ) ) {
    $Login->logout();
    header( 'Location: ' . BASEURL . '/painel/login.php?logout=true' );
    die;
}

//Checa o login
if ( !$Login->checkLogin() ) {
    header( 'Location: ' . BASEURL . '/painel/login.php' );
    die;
} else {
    $UserCurrent = $Login->getCurrentUser();
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <meta name="description" content="">
        <meta name="author" content="">
        <link rel="icon" href="../../favicon.ico">

        <title>Admin Painel</title>

        <!-- Bootstrap core CSS -->
        <link href="http://getbootstrap.com/dist/css/bootstrap.min.css" rel="stylesheet">

        <!-- Custom styles for this template -->
        <link href="http://getbootstrap.com/examples/dashboard/dashboard.css" rel="stylesheet">

        <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
        <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
        <script src="http://getbootstrap.com/dist/assets/js/ie-emulation-modes-warning.js"></script>

        <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
          <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>

    <body>

        <nav class="navbar navbar-inverse navbar-fixed-top">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="#">Curso - Trilhando caminho PHP</a>
                </div>
                <div id="navbar" class="navbar-collapse collapse">
                    <ul class="nav navbar-nav navbar-right">
                        <li><a href="../">Ir para o site</a></li>
                        <li><a href="index.php?logout=true">Sair</a></li>
                    </ul>
                    <form class="navbar-form navbar-right" style="padding-top: 7px !important;">
                        <b style="color:#fff">Olá, <?php echo$UserCurrent['user_name']?></b>
                    </form>
                </div>
            </div>
        </nav>

        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-3 col-md-2 sidebar">
                    <ul class="nav nav-sidebar">

                        <?php
                        $DB->QRSelect( "paginas" );
                        foreach ( $DB->getResult() as $key ):
                            echo "<li><a href=\"?exe=edit&uid={$key[ 'id' ]}\">{$key[ 'pag_name' ]}</a></li>";
                        endforeach;
                        ?>
                    </ul>
                </div>
                <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
                    <h1 class="page-header">Painel <small>editar páginas</small></h1>

                    <?php require_once('../.Inc/FrontController.inc.php'); ?>

                </div>
            </div>
        </div>

        <!-- Bootstrap core JavaScript
        ================================================== -->
        <!-- Placed at the end of the document so the pages load faster -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
        <script src="../../dist/js/bootstrap.min.js"></script>
        <!-- Just to make our placeholder images work. Don't actually copy the next line! -->
        <script src="../../assets/js/vendor/holder.js"></script>
        <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
        <script src="../../assets/js/ie10-viewport-bug-workaround.js"></script>
    </body>
</html>
