<?php
require_once('./.iniSis/iniSys.php');
global $DB;
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
                        <a href=".Inc/Autoload.inc.php"></a>
                        <li><a href="<?php echo $url; ?>/home">Home</a></li>
                        <li><a href="<?php echo $url; ?>/empresa">Empresa</a></li>
                        <li><a href="<?php echo $url; ?>/produtos">Produtos</a></li>
                        <li><a href="<?php echo $url; ?>/servicos">Serviços</a></li>
                        <li><a href="<?php echo $url; ?>/contato">Contato</a></li>
                    </ul>
                    <form class="navbar-form navbar-left" role="search" action="search.php" method="post">
                        <div class="form-group">
                            <input type="text" class="form-control" name="search" placeholder="Search">
                        </div>
                        <button type="submit" class="btn btn-default">Submit</button>
                    </form>
                </nav>
            </div>
            <div class="row content">
                <?php
                $getexe = filter_input( INPUT_GET, 'nav', FILTER_DEFAULT );
                $getsub = filter_input( INPUT_GET, 'sub', FILTER_DEFAULT );

                if ( isset( $getexe ) ):
                    if ( !empty( $getsub ) ) :
                        //Verifica a categoria da página
                        $getPage->QRSelect( "paginas", "WHERE pag_category = :c AND pag_slug = :s", "c={$getexe}&s={$getsub}" );
                        if ( $getPage->getResult() ):
                            $html = "<h1>{$getPage->getResult()[ 0 ][ 'pag_name' ]}</h1>";
                            $html .= "<p>{$getPage->getResult()[ 0 ][ 'pag_content' ]}</p>";
                            echo $html;
                        else:
                            echo "<div>";
                            echo "<h1 style=\"text-align:center\">KEEP<br />CALM</h1><h1 style=\"text-align:center\">404</h1><h1 style=\"text-align:center\">PAGE NOT <br /> FOUND</h1>";
                            echo "</div>";
                            echo 'Status code: #' . http_response_code( 404 );
                        endif;
                    else :
                        //Procura a página sem a categoria
                        $getPage = clone $DB;
                        $getPage->QRSelect( "paginas", "WHERE pag_slug = :s", "s={$getexe}" );
                        if ( $getPage->getResult() ):
                            $html = "<h1>{$getPage->getResult()[ 0 ][ 'pag_name' ]}</h1>";
                            $html .= "<p>{$getPage->getResult()[ 0 ][ 'pag_content' ]}</p>";
                            echo $html;
                        else:
                            echo "<div>";
                            echo "<h1 style=\"text-align:center\">KEEP<br />CALM</h1><h1 style=\"text-align:center\">404</h1><h1 style=\"text-align:center\">PAGE NOT <br /> FOUND</h1>";
                            echo "</div>";
                            echo 'Status code: #' . http_response_code( 404 );
                        endif;
                    endif;

                else:
                    //Retorna a home
                    $getPage = clone $DB;
                    $getPage->QRSelect( "paginas", "WHERE pag_slug = :s", "s=home" );
                    if ( $getPage->getResult() ):
                        $html = "<h1>{$getPage->getResult()[ 0 ][ 'pag_name' ]}</h1>";
                        $html .= "<p>{$getPage->getResult()[ 0 ][ 'pag_content' ]}</p>";
                        echo $html;
                    else:
                        echo "<div>";
                        echo "<h1 style=\"text-align:center\">KEEP<br />CALM</h1><h1 style=\"text-align:center\">404</h1><h1 style=\"text-align:center\">PAGE NOT <br /> FOUND</h1>";
                        echo "</div>";
                        echo 'Status code: #' . http_response_code( 404 );
                    endif;
                endif;
                ?>

            </div>
            <footer class="row">
                <p align="center">Copyright &copy; <?php echo date( 'Y' ); ?> Douglas Alves. Todos os direitos reservador</p>
            </footer>
        </div>
    </body>
</html>