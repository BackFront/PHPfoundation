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
                $getsearch = filter_input( INPUT_POST, 'search', FILTER_DEFAULT );
                $getPage = clone $DB;
                $getPage->QRSelect( "paginas", "WHERE pag_name LIKE :pn OR pag_content LIKE :pc", "pn=%{$getsearch}%&pc=%{$getsearch}%" );
                if ( !$getPage->getResult() ):
                    echo "<div class=\"alert alert-info\" role=\"alert\">Nenhum resultado encontrado!</div>";
                else:
                    echo "<div class=\"list-group\">";
                    foreach ( $getPage->getResult() as $key ):
                        echo utf8_encode("<a href=\"{$key[ 'pag_slug' ]}\" class=\"list-group-item\">{$key[ 'pag_name' ]}</a>");
                    endforeach;
                    echo "</div>";
                endif;
                ?>
            </div>
            <footer class="row">
                <p align="center">Copyright &copy; <?php echo date( 'Y' ); ?> Douglas Alves. Todos os direitos reservador</p>
            </footer>
        </div>
    </body>
</html>