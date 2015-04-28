<?php
/**
 * @package Umbrella
 * @ProjectName: Umbrella
 * @version 1.0.1
 * @link https://bitbucket.org/AlvesDouglaz/umbrella The Umbrella Bitbucket project
 * @author Douglas Alves <alves.douglaz@gmail.com>
 * @copyright (c) 2014, Douglas Alves <alves.douglaz@gmail.com>
 * @Date: 14/11/2014 
 * @note Esta classe, juntamente com o package, podem ser utilizadas por qualquer
 * pessoa, porem não pode ser alterada em qualquer condição
 * 
 * ******************************************************************************
 * <b>Alert</b>
 * Essa classe gera boxes estilizados com mensagens de erros, alertas ou 
 * mensagem de sucesso
 * ******************************************************************************
 */

namespace Umbrella 
{
    class Alert
    {


        public static function PHPErro( $errMsg, $errType, $errFile = null, $errDie = false )
        {
            @define( 'WS_ACCEPT', 'accept' );
            @define( 'WS_ALERT', 'alert' );
            @define( 'WS_ERROR', 'error' );
            @define( 'WS_INFO', 'info' );

            echo ($errDie == true) ? "<style>
            .box-erro { border:1px solid #ccc;padding:15px;margin:15px 0;background:#eee;display:block;position:relative;font-family:arial;font:400 14px 'arial',sans-serif;color:#333;}
            .box-erro { border-radius:5px;-moz-border-radius:5px;-webkit-border-radius:5px; }
            .box-erro .close,.close { position:absolute;top:10px;right:10px;cursor:pointer;font-family:arial;width:16px;height:16px;background:url(http://www.vitaminplanet.co.uk/StoreImages/close-icon.png) no-repeat center; }
            .box-erro.alert { background:#fff6bf;border-color:#f2e06c; }
            .box-erro.accept { background:#e5f8ce;border-color:#C1E68F; }
            .box-erro.info { background:#d1ecf7;border-color:#8DCBE8; }
            .box-erro.error { background:#fad0d0;border-color:#E78C8C; }</style>" : null;

            $css = ($errType == E_USER_NOTICE ? WS_INFO : ($errType == 'E_USER_ACCEPT' ? WS_ACCEPT : ($errType == E_USER_WARNING ? WS_ALERT : ($errType == E_USER_ERROR ? WS_ERROR : $errType))));
            $html = "<div class=\"box-erro {$css}\">";
            $html .= '<i class="close" onclick="$( this ).parent(\'.box-erro\').hide( 300, function() {$(this).remove();});"></i>';
            $html .= $errMsg;
            $html .= "</div>";
            echo $html;
            if ( $errDie ):
                die;
            endif;
        }


        public function PHPDebug( $obj, $die = null )
        {
            echo $html = '<div class="box-erro" style="padding:15px;width:100%;height:200px;position:fixed;top:0;color:#fff;left:0;background:rgba( 0, 0, 0, .4 );overflow:auto;">';
            echo '<pre>';
            print_r( $obj );
            echo '</pre>';
            echo '<i onclick="$( this ).parent(\'.box-erro\').hide( 300, function() {$(this).remove();});" style="position: fixed;top:50px;right:50px;cursor:pointer;">Close</i>';
            echo $html = '</div>';
            ($die == true) ? die() : null;
        }


        function __destruct()
        {
            
        }


    }
}