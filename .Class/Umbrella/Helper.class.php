<?php
/**
 * @package Umbrella
 * @ProjectName: Umbrella
 * @version 1.1.0
 * @link https://bitbucket.org/AlvesDouglaz/umbrella The Umbrella Bitbucket project
 * @author Douglas Alves <alves.douglaz@gmail.com>
 * @copyright (c) 2014, Douglas Alves <alves.douglaz@gmail.com>
 * @Date 14/11/2014 
 * @note Esta classe, juntamente com o package, podem ser utilizadas por qualquer
 * pessoa, porem não pode ser alterada em qualquer condição
 * 
 * ******************************************************************************
 * <b>Helper</b>
 * Classe auxiliar responsável por realizar funcões genericas
 * ******************************************************************************
 */

namespace Umbrella {
    class Helper
    {

        private static $Data;
        private static $Format;


        /**
         * <b>Email: </b>Verifica e valida email
         * @param type $Email
         * @return boolean
         */
        public static function CheckEmail( $Email )
        {
            self::$Data = ( string ) $Email;
            self::$Format = '/[a-z0-9_\.\-]+@[a-z0-9_\.\-]*[a-z0-9_\.\-]+\.[a-z]{2,4}$/';

            if ( preg_match( self::$Format, self::$Data ) ):
                return true;
            else:
                return false;
            endif;
        }


        /**
         * <b>CPF: </b>Verifica se um CPF é válido
         * @param type $Email
         * @return boolean
         */
        public static function CheckCPF( $CPF )
        {
            $CPF = preg_replace( "/[^0-9]/", "", $CPF );
            $A = 0;
            $B = 0;
            //Descobre o primeiro digito
            for ( $i = 0, $j = 10; $i <= 8; ++$i, --$j ):
                $A += $CPF[ $i ] * $j;
            endfor;
            //Descobre o segundo digito
            for ( $i = 0, $j = 11; $i <= 9; ++$i, --$j ):
                $B += $CPF[ $i ] * $j;
            endfor;

            $calcA = (($A % 11) < 2) ? 0 : 11 - ($A % 11);
            $calcB = (($B % 11) < 2) ? 0 : 11 - ($B % 11);

            if ( $CPF[ 9 ] != $calcA ) {
                return false;
            } else if ( $CPF[ 10 ] != $calcB ) {
                return false;
            } else {
                return true;
            }
        }


        /**
         * <b>Clear String:</b> Limpa os caracteres especiais de uma string
         * @param string $String = Uma string qualquer
         * @return string = $Data = Uma URL amigável válida
         */
        public static function ClearString( $String )
        {
            self::$Format = array();
            self::$Format[ 'a' ] = 'ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜüÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûýýþÿRr"!@#$%&*()_-+={[}]/?;:.,\\\'<>°ºª';
            self::$Format[ 'b' ] = 'aaaaaaaceeeeiiiidnoooooouuuuuybsaaaaaaaceeeeiiiidnoooooouuuyybyRr                                 ';

            self::$Data = strtr( utf8_decode( $String ), utf8_decode( self::$Format[ 'a' ] ), self::$Format[ 'b' ] );
            self::$Data = strip_tags( trim( self::$Data ) );
            self::$Data = str_replace( ' ', '-', self::$Data );
            self::$Data = str_replace( array( '-----', '----', '---', '--' ), '-', self::$Data );

            return strtolower( utf8_encode( self::$Data ) );
        }


        /**
         * <b>LimitWords:</b> Limita a quantidade de palavras a serem exibidas em uma string!
         * @param string $String = Uma string qualquer
         * @param int $Limiter = Quantidade de palavras a ser exibida
         * @param string $Pointer complemento no final da string
         * @return int = $Limite = String limitada pelo $Limiter
         */
        public static function LimitWords( $String, $Limiter, $Pointer = null )
        {
            self::$Data = strip_tags( trim( $String ) );
            self::$Format = ( int ) $Limite;

            $ArrWords = explode( ' ', self::$Data );
            $NumWords = count( $ArrWords );
            $NewWords = implode( ' ', array_slice( $ArrWords, 0, self::$Format ) );

            $Pointer = (empty( $Pointer ) ? '...' : ' ' . $Pointer );
            $Result = ( self::$Format < $NumWords ? $NewWords . $Pointer : self::$Data );
            return $Result;
        }


        /**
         * <b>turnImageToBase64:</b> Transforma uma imagem em Base64
         * @param string $Image = caminho absoluto até a imagem
         */
        public static function turnImageToBase64( $Image )
        {
            return $imageData = base64_encode( file_get_contents( $Image ) );
        }


        /**
         * <b>getDataUriMime:</b> gera o Data Mime Type de uma imagem base64
         * @param string $Image = caminho absoluto até a imagem
         */
        public static function getDataUriMime( $Image )
        {
            $ext = explode( '.', $Image );
            return 'data:image/' . $ext[ 1 ] . ';base64,' . self::turnImageToBase64( $Image );
        }


    }
}