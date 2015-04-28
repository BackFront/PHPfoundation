<?php
/**
 * @package Umbrella
 * @ProjectName: Umbrella
 * @version 2.0
 * @link https://bitbucket.org/AlvesDouglaz/umbrella The Umbrella Bitbucket project
 * @author Douglas Alves <alves.douglaz@gmail.com>
 * @copyright (c) 2014, Douglas Alves <alves.douglaz@gmail.com>
 * @Date 14/11/2014 
 * @note Esta classe, juntamente com o package, podem ser utilizadas por qualquer
 * pessoa, porem não pode ser alterada em qualquer condição sem previa do autor!
 * 
 * ******************************************************************************
 * <b>Database</b>
 * Responsavel pela validacao, criacao, autenticação e manipulacao de usuarios
 * ******************************************************************************
 */

namespace Umbrella\Models {
    class User
    {

        private $Level;
        private $Email;
        private $Senha;
        private $Error;
        private $Result;
        private $Token;

        /** Tabelas e colunas a serem manipuladas  */
        public $TableUser = 'umb_user'; //TABELA USER
        //----------------------------------------------------------------------
        public $userEmail = 'user_email'; //CAMPO USER -> user_email
        public $userPassword = 'user_password'; //CAMPO USER -> user_password
        public $userToken = 'user_token'; //CAMPO USER -> user_token

        /**
         * @param type $Level = Informar o level minimo que o usuario deve ter 
         */
        function __construct( $Level )
        {
            $this->Level = ( int ) $Level;
        }


        public function getResult()
        {
            return $this->Result;
        }


        public function getError()
        {
            return $this->Error;
        }


        public function getCurrentUser()
        {
            if ( $this->checkLogin() ) :
                return $_SESSION[ 'userLogin' ];
            else:
                return false;
            endif;
        }


        /**  @param array $Datas = Array retornado do formulário com o email e senha do usuário */
        public function Logar( array $Datas )
        {
            $this->Email = ( string ) strip_tags( trim( $Datas[ 'email' ] ) );
            $this->Senha = ( string ) strip_tags( trim( sha1( md5( $Datas[ 'senha' ] ) ) ) );
            $this->actionLogin();
        }


        /** Faz o logout do usuario matando as sessoes */
        public function logout()
        {
            $this->Result = FALSE;
            if ( isset( $_SESSION[ 'userLogin' ] ) ) :
                unset( $_SESSION[ 'userLogin' ] );
            endif;
        }


        /**
         * <b>checkLogin: </b>Verifica se o usuario esta logado
         * @global $DB Instancia com o banco de dados
         * @return boolean retorna TRUE se o usuario estiver logado ou FALSE 
         * se nao estiver logado
         */
        public function checkLogin()
        {
            global $DB;
            if ( empty( $_SESSION[ 'userLogin' ] ) || $_SESSION[ 'userLogin' ][ 'user_level' ] < $this->Level ):
                $this->Result = FALSE;

                if ( isset( $_SESSION[ 'userLogin' ] ) ) {
                    unset( $_SESSION[ 'userLogin' ] );
                }
                return FALSE;
            else :
                $authUser = $DB;
                $authUser->QRSelect( $TableUser, "WHERE {$this->userEmail} = :e AND {$this->userPassword} = :p AND {$this->userToken} = :t", "e={$_SESSION[ 'userLogin' ][ 'user_email' ]}&p={$_SESSION[ 'userLogin' ][ 'user_password' ]}&t={$_SESSION[ 'userLogin' ][ 'user_token' ]}" );
                if ( $authUser->getResult() ) {
                    return TRUE;
                } else {
                    return FALSE;
                }
            endif;
        }


        /**
         * <b>actionLogin: </b>Faz as verificações antes de logar
         */
        private function actionLogin()
        {
            if ( !$this->Email || !$this->Senha || \Umbrella\Helper::CheckEmail( $this->Email ) ) :
                $this->Error = "Login ou senha não pode ser vazio";
                $this->Result = FALSE;
                if ( isset( $_SESSION[ 'userLogin' ] ) ) :
                    unset( $_SESSION[ 'userLogin' ] );
                endif;

            elseif ( !$this->getUser() ) :
                $this->Error = "Os dados informados estão incorretos";
                $this->Result = FALSE;
                if ( isset( $_SESSION[ 'userLogin' ] ) ) :
                    unset( $_SESSION[ 'userLogin' ] );
                endif;

            elseif ( $this->Result[ 'user_level' ] < $this->Level ) :
                $this->Result = FALSE;
                $this->Error = "Você não tem premissão para acessar essa área";
            else:
                $this->setAuthentication();
            endif;
        }


        /**
         * <b>getUser: </b>Verifica se o email e a senha existem no banco de dados
         * @global $DB = Instancia com o banco de dados
         * @return boolean = Retorna TRUE ou FALSE e joga o resultado dentro do
         * atribulto Result
         */
        private function getUser()
        {
            global $DB;
            $this->setToken();
            $getUser = $DB;
            $getUser->QRSelect( $TableUser, "WHERE {$this->userEmail} = :e AND {$this->userPassword} = :p", "e={$this->Email}&p={$this->Senha}" );
            if ( $getUser->getResult() ) :
                $this->Result = $getUser->getResult()[ 0 ];
                return true;
            else:
                return false;
            endif;
        }


        /**
         * <b>setToken: </b>Cria um token aleatorio para validar um unico usuário por vez
         * @global type $DB = Instancia com o banco de dados 
         */
        private function setToken()
        {
            global $DB;
            $this->Token = sha1( date( 'Y-m-d h:i:s' ) . $this->Email . 'UMBR3LL4' . $this->Senha );
            $setToken = $DB;
            $setToken->QRUpdate( $this->TableUser, ["{$this->userToken}" => "{$this->Token}" ], "WHERE {$this->userEmail} = :e AND {$this->userPassword} = :p", "e={$this->Email}&p={$this->Senha}" );
        }


        private function setRecoveryToken()
        {
            global $DB;
            $this->Token = sha1( date( 'Y-m-d h:i:s' ) . $this->Email . 'R3C0V3RY' . $this->Senha );
            $setToken = $DB;
            $setToken->QRUpdate( $this->TableUser, ["{$this->userToken}" => "{$this->Token}" ], "WHERE {$this->userEmail} = :e", "e={$this->Email}" );
        }


        /** <b>setAuthentication: </b>Cria a sessao do usuario */
        private function setAuthentication()
        {
            if ( !session_id() ) :
                session_start();
            endif;
            $_SESSION[ 'userLogin' ] = $this->Result;
            $this->Result = true;
        }


        /**
         * <b>setPassword: </b>Modifica o password de um usuário 
         * @global $DB = Instancia de conexao com o banco de dados
         * @param type $userEmail = Email do usuario na qual sera modificado o password
         * @param type $userToken = Token de segurança necessario para a alteração do password
         * @param type $userNewPassword = Novo password
         */
        public function updatePassword( $userEmail, $userToken, $userNewPassword )
        {
            global $DB;
            $this->Email = ( string ) base64_decode( base64_decode( $userEmail ) );
            $this->Senha = ( string ) strip_tags( trim( sha1( md5( $userNewPassword ) ) ) );
            $this->Token = ( string ) $userToken;

            $setPassword = $DB;
            $setPassword->QRUpdate( $this->TableUser, ["{$this->userPassword}" => "{$this->Senha}" ], "WHERE {$this->userEmail} = :e AND {$this->userToken} = :t", "e={$this->Email}&t={$this->Token}" );

            if ( $setPassword->getRowCountUpdate() ):
                $this->Result = $setPassword->getRowCountUpdate();
                $this->Error = null;
                $this->setRecoveryToken();
            endif;
        }


        /**
         * <b>recoverPassword: </b>Envia um link de recuperação de senha via email do usuário
         * @param type $Email = Email em qual sera recuperado o password
         */
        public function recoverPassword( $Email )
        {
            $this->Email = $Email;
            if ( $this->checkEmail() ):
                if ( $this->Mailer() ) {
                    \Umbrella\Alert::PHPErro( "Recuperação enviada", 'E_USER_ACCEPT', null );
                    $this->Error = null;
                    $this->Result = true;
                } else {
                    #$this->Error = "Email não enviado";
                    $this->Result = false;
                }
            else:
                $this->Error = "Email não encontrado";
                $this->Result = false;
            endif;
        }


        /**
         * <b>checkEmail: </b>Verifica se o email está cadastrado no banco de dados
         * @global \Umbrella\Models\$DB $DB
         * @return boolean
         */
        private function checkEmail()
        {
            global $DB;
            $checkEmail = $DB;
            $checkEmail->QRSelect( $this->TableUser, "WHERE {$this->userEmail} = :e", "e={$this->Email}" );
            if ( $checkEmail->getResult() ) :
                return TRUE;
            else:
                return FALSE;
            endif;
        }


        /**
         * <b>Mailer: </b>Função que envia o email
         * @global \Umbrella\Models\$DB $DB
         * @return boolean
         */
        private function Mailer()
        {
            /* ====================================
              CORPO DA MENSAGEM
              =================================== */
            $this->setRecoveryToken();
            $BodyMSG = '<h3>Recuperação de senha</h3>';
            $BodyMSG .= 'Se você não solicitou alteração de senha, ignore este email.<br>';
            $BodyMSG .= 'Caso contrario, use o link a seguir para alterar sua senha:<br>';
            $BodyMSG .= '<b><a href="' . \BASEURL . '/recoveryPassword.php/?uid=' . $this->Token . '&ue=' . base64_encode( base64_encode( $this->Email ) ) . '" target="_blank">' . \BASEURL . '/recoveryPassword.php/?uid=' . $this->Token . '&ue=' . base64_encode( base64_encode( $this->Email ) ) . '</a></b>';

            $Mailer = new \Umbrella\Mailer();
            /* ====================================
              CONFIGURAÇÕES DO SERVIDOR DE ENVIO
              =================================== */
            $Mailer->IsSMTP();
            $Mailer->IsHTML( true );
            $Mailer->CharSet = 'UTF-8';
            $Mailer->SMTPDebug = 0;
            $Mailer->SMTPAuth = true;
            $Mailer->SMTPSecure = "ssl";
            $Mailer->Host = \MAIL_HOST;
            $Mailer->Port = \MAIL_PORT;
            $Mailer->Username = \MAIL_USER;
            $Mailer->Password = \MAIL_PASS;

            $Mailer->Subject = '<Recover Password>';
            $Mailer->MsgHTML( $BodyMSG );
            $Mailer->AddAddress( $this->Email );

            if ( $Mailer->Send() ):
                $this->Result = true;
                $this->Error = false;
                return true;
            else:
                $this->Error = $Mailer->ErrorInfo;
                $this->Result = false;
                return false;
            endif;
        }


    }
}