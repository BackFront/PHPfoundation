<?php
$d = $_SERVER[ 'SCRIPT_NAME' ];
$count = strrpos( $d, '/' );
$url = 'http://'.$_SERVER[ 'SERVER_NAME' ].substr( $d, 0, $count );
?>


<!DOCTYPE html>
<html lang="PT">
    <head>
        <title>PHP Foundation</title>
        <meta charset="UTF-8" />

        <link rel="stylesheet" href="<?php echo $url; ?>/css/bootstrap.min.css"/>
        <link rel="stylesheet" href="<?php echo $url; ?>/css/style.css"/>
        <script type="text/javascript" src="<?php echo $url; ?>/js/bootstrap.min.js"></script>
    </head>
    <body>
        <div class="container">
            <div class="row">
                <nav class="collapse navbar-collapse bs-navbar-collapse">
                    <ul class="nav navbar-nav">
                        <li><a href="<?php echo $url; ?>/home">Home</a></li>
                        <li><a href="<?php echo $url; ?>/empresa">Empresa</a></li>
                        <li><a href="<?php echo $url; ?>/produto">Produtos</a></li>
                        <li><a href="<?php echo $url; ?>/servicos">Serviços</a></li>
                        <li><a href="<?php echo $url; ?>/contato">Contato</a></li>
                    </ul>
                </nav>
            </div>
            <div class="row content">
                <?php
                $getexe = filter_input( INPUT_GET, 'nav', FILTER_DEFAULT );
                $getsub = filter_input( INPUT_GET, 'sub', FILTER_DEFAULT );

                if ( !empty( $getexe ) ):

                    if ( !empty( $getsub ) ) :
                        //Inclue arquivo que esta dentro de algum subdiretorio
                        $includepatch = DIRECTORY_SEPARATOR . strip_tags( trim( $getsub ) ) . DIRECTORY_SEPARATOR . 'pg-' . strip_tags( trim( $getexe ) . '.php' );
                    else :
                        //Inclue arquivo que esta na raiz
                        $includepatch = __DIR__ . DIRECTORY_SEPARATOR . 'pg-' . strip_tags( trim( $getexe ) . '.php' );
                    endif;

                else:
                    $includepatch = __DIR__ . DIRECTORY_SEPARATOR . 'pg-home.php';
                endif;

                if ( file_exists( $includepatch ) ):
                    require_once($includepatch);
                else:
                    echo "<div>";
                    echo "<h1 style=\"text-align:center\">KEEP<br />CALM</h1><h1 style=\"text-align:center\">404</h1><h1 style=\"text-align:center\">PAGE NOT <br /> FOUND</h1>";
                    echo "</div>";
                    echo 'Status code: #'.http_response_code(404);
                endif;
                ?>

            </div>
            <footer class="row">
                <p align="center">Todos os direitos reservados - <?php echo date( 'Y' ); ?></p>
            </footer>
        </div>
    </body>
</html>