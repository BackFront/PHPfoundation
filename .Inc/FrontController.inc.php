<?php
$getexe = filter_input( INPUT_GET, 'exe', FILTER_DEFAULT );
$getexe = str_replace( '\\', DIRECTORY_SEPARATOR, $getexe );
$_ = DIRECTORY_SEPARATOR;$_ = DIRECTORY_SEPARATOR;
//QUERY STRING
if ( !empty( $getexe ) ):
    echo $includepatch = __DIR__ . "${_}system${_}" . strip_tags( trim( $getexe ) . '.php' );
else:
    $includepatch = __DIR__ . "${_}system${_}home.php";
endif;

if ( file_exists( $includepatch ) ):
    require_once($includepatch);
else:
    echo "<div class=\"content notfound\">";
    Umbrella\Alert::PHPErro( "<b>Erro ao incluir tela:</b> Erro ao incluir o controller /{$getexe}.php!", E_USER_NOTICE );
    echo "</div>";
endif;