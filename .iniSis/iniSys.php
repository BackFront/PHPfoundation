<?php
(!isset( $_SESSION )) ? session_start() : NULL;

/**
 * VALORES GLOBAIS DE URL/BASEPATCH
 */
@define( SUBDIR, '/TrilhandoCaminhoPHP/PHP_FOUNDATION' ); //Usar caso o projeto n�o esteja na pasta raiz do htdocs
@define( BASEPATCH, substr( $_SERVER[ 'SCRIPT_FILENAME' ], 0, -strlen( $_SERVER[ 'SCRIPT_NAME' ] ) ) . SUBDIR );
@define( BASEURL, 'http://' . $_SERVER[ 'SERVER_NAME' ] . SUBDIR );

/**
 * VALORES CONFIGURACAO DO BANCO DE DADOS
 */
@define( DB_HOST, 'localhost' );
@define( DB_USER, 'root' );
@define( DB_PASS, '' );
@define( DB_NAME, 'php_fundation' );
@define( DP_PORT, '' );

require_once(BASEPATCH . "/.Inc/Autoload.inc.php");
@$DB = new Umbrella\Database( DB_HOST, DB_USER, DB_PASS, DB_NAME );


$d = $_SERVER[ 'SCRIPT_NAME' ];
$count = strrpos( $d, '/' );
$url = 'http://'.$_SERVER[ 'SERVER_NAME' ].substr( $d, 0, $count );