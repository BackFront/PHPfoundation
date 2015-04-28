<?php
/**
 * @package Umbrella
 * @ProjectName: Umbrella
 * @version 1.0.1
 * @link https://bitbucket.org/AlvesDouglaz/umbrella The Umbrella Bitbucket project
 * @author Douglas Alves <alves.douglaz@gmail.com>
 * @copyright (c) 2014, Douglas Alves <alves.douglaz@gmail.com>
 * @Date 32/11/2014 
 * @note Esta classe, juntamente com o package, podem ser utilizadas por qualquer
 * pessoa, porem não pode ser alterada em qualquer condição sem previa do autor!
 * 
 * ******************************************************************************
 * <b>TemplateView</b>
 * Responsavel pelo carregamento do template - Part VIEW(MVC)
 * ******************************************************************************
 */

namespace Umbrella {
    class TemplateView
    {

        private static $Datas;
        private static $Keys;
        private static $Values;
        private static $Template;


        public static function Load( $Template )
        {
            self::$Template = ( string ) $Template;
            self::$Template = file_get_contents( self::$Template . '.tpl.html' );
        }


        public static function Show( array $Datas )
        {
            self::setKeys( $Datas );
            self::setValues();
            self::showView();
        }


        public static function Request( $File, array $Datas )
        {
            extract( $Datas );
            require ("{$File}.inc.php");
        }


        private static function setKeys( $Datas )
        {
            self::$Datas = $Datas;
            self::$Keys = explode( '&', ('#' . implode( '#&#', array_keys( self::$Datas ) ) . '#' ) );
        }


        private static function setValues()
        {
            self::$Values = array_values( self::$Datas );
        }


        private static function showView()
        {
            echo str_replace( self::$Keys, self::$Values, self::$Template );
        }


    }
}