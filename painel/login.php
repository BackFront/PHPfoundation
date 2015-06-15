<?php
require_once ('../.iniSis/iniSys.php');
$User = new Umbrella\Models\User( 1 );
if ( $User->checkLogin() ) :
    header( 'Location: index.php' );
endif;
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Open Code</title>

        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <link rel="stylesheet" type="text/css" href="css/main.css" />
        <link rel="stylesheet" type="text/css" href="painel/css/root.css" />
        <script type="text/javascript" src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
        <script type="text/javascript" src="js/main.js"></script>
    </head>
    <body class="auth">
        <div class="login">
            <a href="">
                <h1 class=""></h1>
            </a>
            <?php
            $Hack = filter_input( INPUT_GET, 'restrito', FILTER_VALIDATE_BOOLEAN );
            $Logout = filter_input( INPUT_GET, 'logout', FILTER_VALIDATE_BOOLEAN );
            
            if ( !empty( $Hack ) ):
                Umbrella\Alert::PHPErro( '<b><i class="icon-lock-closed"></i>Você é um hacker? (O.O)!!!  Não faça isso</b>', E_USER_ERROR, '' );
            elseif ( $Logout ):
                Umbrella\Alert::PHPErro( '<b>Você foi deslogado com sucesso!', 'E_USER_ACCEPT' );
            endif;

            $Datas = filter_input_array( INPUT_POST, FILTER_DEFAULT );
            if ( !empty( $Datas[ 'userLogin' ] ) ) :
                $User->Logar( $Datas );
                if ( $User->getResult() ) :
                    header( 'Location: index.php' );
                else:
                    Umbrella\Alert::PHPErro( $User->getError(), E_USER_ERROR, '' );
                endif;
            endif; ?>
            <div class="box  clearfix">
                <form action="" method="post">
                    <label>
                        <input type="text" id="loginEmail" name="email" autocomplete="off" placeholder="Seu E-mail"/>
                    </label>
                    <label>
                        <input type="password" id="loginSenha" name="senha" placeholder="••••••••" />
                    </label>

                    <div class="checkbox-group disp-ib marg-b-0">
                        <div class="checkbox-button" style="background: rgba(255, 255, 255, .25);">
                            <input id="lembrar" type="checkbox"> 
                            <label for="lembrar">Lembrar</label>
                        </div>
                    </div>

                    <input type="submit" name="userLogin" id="userLogin" value="Logar" class="pull-right"/>
                </form>
            </div>

        </div>
    </body>
</html>
