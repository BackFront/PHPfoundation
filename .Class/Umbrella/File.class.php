<?php
/**
 * @package Umbrella
 * @ProjectName: Umbrella
 * @version 1.1.0
 * @link https://bitbucket.org/AlvesDouglaz/umbrella The Umbrella Bitbucket project
 * @author Douglas Alves <alves.douglaz@gmail.com>
 * @copyright (c) 2014, Douglas Alves <alves.douglaz@gmail.com>
 * @Date 12/12/2014
 * @note Esta classe, juntamente com o package, podem ser utilizadas por qualquer
 * pessoa, porem não pode ser alterada em qualquer condição
 * 
 * ******************************************************************************
 * <b>File</b>
 * Esta classe gerencia arquivos
 * ******************************************************************************
 */

namespace Umbrella 
{
    class File
    {

        private $File;
        private $Name;
        private $Send;

        /** ATRIBUTOS DA IMAGEM */
        private $Width;
        private $Image;

        /** RESULTSET */
        private $Result;
        private $Error;

        /** DIRECTORYS */
        private $Folder;
        private static $BaseDirUploads;


        function __construct( $BaseDirUploads = null )
        {
            self::$BaseDirUploads = (( string ) $BaseDirUploads ? $BaseDirUploads : '../uploads/');
            if ( !file_exists( self::$BaseDirUploads ) && !is_dir( self::$BaseDirUploads ) ):
                mkdir( self::$BaseDirUploads, 0777 );
            endif;
        }


        public function getResult()
        {
            return $this->Result;
        }


        public function getError()
        {
            return $this->Error;
        }


        public function Image( array $Image, $ImageName = null, $ImageWidth = null, $ImageFolder = null )
        {
            $this->File = $Image;
            $this->Name = (( string ) $ImageName ? $ImageName : substr( $Image[ 'name' ], 0, strripos( $Image[ 'name' ], '.' ) ) );
            $this->Width = (( int ) $ImageWidth ? $ImageWidth : 500 );
            $this->Folder = (( String ) $ImageFolder ? $ImageFolder : 'imagens' );

            $this->checkFolder( $this->Folder );
            $this->setFileName();
            $this->uploadImage();
        }


        public function File( array $File, $FileName = null, $FileFolfer = null, $MaxSizeFile = null )
        {
            $this->File = $File;
            $this->Name = (( string ) $FileName ? $FileName : substr( $File[ 'name' ], 0, strripos( $File[ 'name' ], '.' ) ) );
            $this->Folder = (( String ) $FileFolfer ? $FileFolfer : 'files' );
            $MaxSizeFile = (( int ) $MaxSizeFile ? $MaxSizeFile : 2);

            $MediaAccept = [
                'text/plain',
                'application/x-compressed',
                'application/x-zip-compressed',
                'application/zip',
                'application/pdf'
            ];

            if ( $this->File[ 'size' ] > ($MaxSizeMedia * (1024 * 1024)) ):
                $this->Result = false;
                $this->Error = "Tamanho máximo permitido {$MaxSizeFile}MB";
            elseif ( !in_array( $this->File[ 'type' ], $MediaAccept ) ):
                $this->Result = false;
                $this->Error = 'Tipo de arquivo inválido!';
            else:
                $this->checkFolder( $this->Folder );
                $this->setFileName();
                $this->uploadFile();
            endif;
        }


        public function Media( array $Media, $MediaName = null, $MediaFolfer = null, $MaxSizeMedia = null )
        {
            $this->File = $Media;
            $this->Name = (( string ) $MediaName ? $MediaName : substr( $Media[ 'name' ], 0, strripos( $Media[ 'name' ], '.' ) ) );
            $this->Folder = (( String ) $MediaFolfer ? $MediaFolfer : 'media' );
            $MaxSizeMedia = (( int ) $MaxSizeMedia ? $MaxSizeMedia : 25);

            $FileAccept = [
                'application/mp4',
                'video/mp4'
            ];

            if ( $this->File[ 'size' ] > ($MaxSizeMedia * (1024 * 1024)) ):
                $this->Result = false;
                $this->Error = "Tamanho máximo permitido {$MaxSizeMedia}MB";
            elseif ( !in_array( $this->File[ 'type' ], $FileAccept ) ):
                $this->Result = false;
                $this->Error = 'Tipo de arquivo inválido!';
            else:
                $this->checkFolder( $this->Folder );
                $this->setFileName();
                $this->uploadFile();
            endif;
        }


        //PRIVATES METODS
        private function checkFolder( $FolderName )
        {
            list($y, $m) = explode( '/', date( 'Y/m' ) );
            $this->createFolder( "{$FolderName}" );
            $this->createFolder( "{$FolderName}/{$y}/" );
            $this->createFolder( "{$FolderName}/{$y}/{$m}/" );
            $this->Send = "{$FolderName}/{$y}/{$m}/";
        }


        private function createFolder( $FolderName )
        {
            if ( !file_exists( self::$BaseDirUploads . $FolderName ) && !is_dir( self::$BaseDirUploads . $FolderName ) ):
                mkdir( self::$BaseDirUploads . $FolderName, 0777 );
            endif;
        }


        private function setFileName()
        {
            $FileName = Helper::ClearString( $this->Name ) . strrchr( $this->File[ 'name' ], '.' );
            if ( file_exists( self::$BaseDirUploads . $this->Send . $FileName ) ):
                $FileName = Helper::ClearString( $this->Name ) . '-' . time() . strrchr( $this->File[ 'name' ], '.' );
            endif;
            $this->Name = $FileName;
        }


        private function uploadImage()
        {
            switch ( $this->File[ 'type' ] ):
                case 'image/jpg' :
                case 'image/jpeg' :
                case 'image/pjpeg' :
                    $this->Image = imagecreatefromjpeg( $this->File[ 'tmp_name' ] );
                    break;
                case 'image/png' :
                case 'image/xpng' :
                    $this->Image = imagecreatefrompng( $this->File[ 'tmp_name' ] );
                    break;
            endswitch;
            if ( !$this->Image ):
                $this->Result = false;
                $this->Error = 'Somente aceito imagens no formato JPG ou PNG';
            else:
                $X = imagesx( $this->Image );
                $Y = imagesy( $this->Image );
                $ImageW = ( $this->Width < $X ? $this->Width : $X );
                $ImageH = ($ImageW * $Y) / $X;

                $NewImage = imagecreatetruecolor( $ImageW, $ImageH );
                imagealphablending( $NewImage, false );
                imagesavealpha( $NewImage, true );
                imagecopyresampled( $NewImage, $this->Image, 0, 0, 0, 0, $ImageW, $ImageH, $X, $Y );
                switch ( $this->File[ 'type' ] ):
                    case 'image/jpg' :
                    case 'image/jpeg' :
                    case 'image/pjpeg' :
                        imagejpeg( $NewImage, self::$BaseDirUploads . $this->Send . $this->Name );
                        break;
                    case 'image/png' :
                    case 'image/xpng' :
                        imagepng( $NewImage, self::$BaseDirUploads . $this->Send . $this->Name );
                        break;
                endswitch;
                if ( !$NewImage ):
                    $this->Result = false;
                    $this->Error = 'Somente aceito imagens no formato JPG ou PNG';
                else:
                    $this->Result = $this->Send . $this->Name;
                    $this->Error = null;
                endif;
                imagedestroy( $this->Image );
                imagedestroy( $NewImage );
            endif;
        }


        private function uploadFile()
        {
            if ( move_uploaded_file( $this->File[ 'tmp_name' ], self::$BaseDirUploads . $this->Send . $this->Name ) ):
                $this->Result = $this->Send . $this->Name;
                $this->Error = null;
            else:
                $this->Result = false;
                $this->Error = 'Erro ao enviar arquivo';
            endif;
        }


    }
}