<?php
function __autoload( $Class )
{
    $Class = str_replace( '\\', DIRECTORY_SEPARATOR, $Class );
    $dirName = BASEPATCH . '/.Class';
    if ( file_exists( "{$dirName}/{$Class}.class.php" ) ):
        require_once("{$dirName}/{$Class}.class.php");
    elseif ( file_exists( "{$dirName}/{$Class}.php" ) ):
        require_once("{$dirName}/{$Class}.php");
    else:
        die( "Erro ao incluir {$dirName}/{$Class}.class.php<hr />" );
    endif;
}