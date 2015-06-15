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
Conteudo