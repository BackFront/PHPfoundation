<?php
/**
 * @package Umbrella
 * @ProjectName: Umbrella
 * @version 1.0.1
 * @link https://bitbucket.org/AlvesDouglaz/umbrella The Umbrella Bitbucket project
 * @author Douglas Alves <alves.douglaz@gmail.com>
 * @copyright (c) 2014, Douglas Alves <alves.douglaz@gmail.com>
 * @Date 14/11/2014 
 * @note Esta classe, juntamente com o package, podem ser utilizadas por qualquer
 * pessoa, porem não pode ser alterada em qualquer condição sem previa do autor!
 * 
 * ******************************************************************************
 * <b>Database</b>
 * Responsavel pela manipulação do banco de dados
 * ******************************************************************************
 */

namespace Umbrella {
    class Database
    {

        private static $DBHost = DB_HOST;
        private static $DBUser = DB_USER;
        private static $DBPass = DB_PASS;
        private static $DBName = DB_NAME;

        /** @var PDO */
        private static $Connect = NULL;


        function __construct( $DB_Host, $DB_User, $DB_Pass, $DB_Name )
        {
            self::$DBHost = $DB_Host;
            self::$DBUser = $DB_User;
            self::$DBPass = $DB_Pass;
            self::$DBName = $DB_Name;
            self::Connection();
        }


        /** Essa classe cria a conxão. Ela é chamada pelo metodo construtor */
        private static function Connection()
        {
            try {
                if ( !isset( self::$Connect ) ):
                    $dsn = "mysql:host=" . self::$DBHost . ";dbname=" . self::$DBName;
                    self::$Connect = new \PDO( $dsn, self::$DBUser, self::$DBPass );
                endif;
            } catch ( \PDOException $ex ) {
                set_error_handler( Alert::PHPErro( "Erro: #{$ex->getCode()} - Não foi possivel estabelecer conexão com o banco de dados", E_USER_ERROR, __FILE__, true ) );
            }
            self::$Connect->SetAttribute( \PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION );
            return self::$Connect;
        }
        

        /** Retorna o Singleton do metodo Connection */
        public function getConnection()
        {
            return self::$Connect;
        }


        /** @return boolean Retorna o resultado de uma execução */
        public function getResult()
        {
            return $this->Result;
        }


        function __destruct()
        {
            
        }


        /**
         * *********************************************************************
         * ********************** MANIPULAÇÃO DO BANCO *************************
         * *********************************************************************
         */
        //QRInsert
        private $Table;
        private $Datas;
        private $Result;
        private $QueryCreate;
        private $PrepareInsert;
        private $QuerySelect;
        private $Places;
        private $PrepareSelect;
        private $QueryUpdate;
        private $QueryDelete;


        /**
         * <b>QRInsert: </b>Faz o insert no banco de dados.
         * @param string $TableName = Informar o nome da tabela a ser manipulada.
         * @param array $Datas = Informar um array atribuitivo ('nome_da_coluna' => 'valor_a_ser_inserido').
         */
        public function QRInsert( $TableName, array $Datas )
        {
            $this->Table = ( string ) $TableName;
            $this->Datas = $Datas;
            $this->getSyntaxInsert();
            $this->ExecuteInsert();
        }


        private function getSyntaxInsert()
        {
            $Fields = implode( ", ", array_keys( $this->Datas ) );
            $Places = ':' . implode( ', :', array_keys( $this->Datas ) );
            $this->QueryCreate = "INSERT INTO {$this->Table} ({$Fields}) VALUES ({$Places})";
            $this->PrepareInsert = $this->getConnection()->prepare( $this->QueryCreate );
        }


        private function ExecuteInsert()
        {
            $this->PrepareInsert;
            try {
                $this->PrepareInsert->execute( $this->Datas );
                $this->Result = $this->getConnection()->lastInsertId();
            } catch ( \PDOException $ex ) {
                $this->Result = NULL;
                set_error_handler( Alert::PHPErro( "<b>Erro: #{$ex->getCode()}</b> - Erro ao incluir dados no Banco<hr />{$ex->getMessage()}", E_USER_NOTICE, __FILE__ ) );
            }
        }


        /**
         * <b>QRSelect: </b>Faz o select de informacões em uma tabela.
         * @param string $TableName = Informar o nome da tabela a ser manipulada.
         * @param string $Query = Informar a condicão da query ex: WHERE user = :user AND pass = :password
         * @param string $ParseString = Imformar o valor das chaves da $Query no formato ParseString ex: user=admin&password=123456
         */
        public function QRSelect( $TableName, $Query = NULL, $ParseString = NULL )
        {
            if ( !empty( $ParseString ) ):
                parse_str( $ParseString, $this->Places );
            endif;
            $this->QuerySelect = "SELECT * FROM {$TableName} {$Query}";
            $this->getSyntaxSelect();
            $this->ExecuteSelect();
        }


        private function getSyntaxSelect()
        {
            $this->QuerySelect;
            $this->PrepareSelect = $this->getConnection()->prepare( $this->QuerySelect );
            $this->PrepareSelect->setFetchMode( \PDO::FETCH_ASSOC );
            if ( $this->Places ):
                foreach ( $this->Places as $key => $values ):
                    if ( $key == 'limit' || $key == 'offset' ):
                        $values = ( int ) $values;
                    endif;
                    $this->PrepareSelect->bindValue( ":$key", $values, ( is_int( $values ) ? \PDO::PARAM_INT : \PDO::PARAM_STR ) );
                endforeach;
            endif;
        }


        private function ExecuteSelect()
        {
            $this->PrepareSelect;
            try {
                $this->getSyntaxSelect();
                $this->PrepareSelect->execute();
                $this->Result = $this->PrepareSelect->fetchAll();
            } catch ( \PDOException $ex ) {
                $this->Result = NULL;
                set_error_handler( Alert::PHPErro( "<b>Erro: #{$ex->getCode()}</b> - Erro ao selecionar dados no Banco<hr />{$ex->getMessage()}", E_USER_NOTICE, __FILE__ ) );
            }
        }


        /** @return int Retorna a quantidade de respostas de seleção do metodo QRSelect */
        public function getRowCountSelect()
        {
            return $this->PrepareSelect->rowCount();
        }


        /** @param string $ParseString = Muda a Query da instancia sem precisar inicias uma nova instancia */
        public function setPlacesSelect( $ParseString )
        {
            parse_str( $ParseString, $this->Places );
            $this->ExecuteSelect();
        }


        /** Executa um Select full */
        public function FullQRSelect( $Query, $ParseString = NULL )
        {
            $this->QuerySelect = ( string ) $Query;
            if ( !empty( $ParseString ) ):
                parse_str( $ParseString, $this->Places );
            endif;
            $this->ExecuteSelect();
        }


        /**
         * <b>QRUpdate: </b>Faz a atualização de informacões em uma tabela.
         * @param string $TableName = Informar o nome da tabela a ser manipulada.
         * @param array $Datas = Informar um array atribuitivo ('nome_da_coluna' => 'valor_a_ser_atualizado').
         * @param array $Query Informar a queri de condição ex: WHERE id = :id
         * @param string $ParseString = Imformar o valor das chaves da $Query no formato ParseString ex: id=9999
         */
        public function QRUpdate( $TableName, array $Datas, $Query, $ParseString )
        {
            $this->Table = ( string ) $TableName;
            $this->Datas = $Datas;
            $this->QueryUpdate = ( string ) $Query;
            parse_str( $ParseString, $this->Places );
            $this->getSyntaxUpdate();
            $this->ExecuteUpdate();
        }


        private function getSyntaxUpdate()
        {
            foreach ( $this->Datas as $key => $values ):
                $Places[] = $key . "=:" . $key;
            endforeach;
            $Places = implode( ', ', $Places );
            $this->QueryUpdate = "UPDATE {$this->Table} SET {$Places} {$this->QueryUpdate} ";
            $this->PrepareUpdate = $this->getConnection()->prepare( $this->QueryUpdate );
        }


        private function ExecuteUpdate()
        {
            $this->QueryUpdate;
            try {
                $this->PrepareUpdate->execute( array_merge( $this->Datas, $this->Places ) );
                $this->Result = TRUE;
            } catch ( \PDOException $ex ) {
                $this->Result = NULL;
                set_error_handler( Alert::PHPErro( "<b>Erro: #{$ex->getCode()}</b> - Erro ao atualizar dados no Banco<hr />{$ex->getMessage()}", E_USER_NOTICE, __FILE__ ) );
            }
        }


        /** @return int Retorna a quantidade de updates realizados no metodo QRUpdate */
        public function getRowCountUpdate()
        {
            return $this->PrepareUpdate->rowCount();
        }


        /** @param string $ParseString = Muda a Query da instancia sem precisar inicias uma nova instancia */
        public function setPlacesUpdate( $ParseString )
        {
            parse_str( $ParseString, $this->Places );
            $this->ExecuteUpdate();
        }


        /**
         * <b>QRDelete: </b>Deleta linha especifica de uma tabela
         * @param string $TableName = Informar o nome da tabela a ser manipulada.
         * @param array $Query Informar a queri de condição ex: WHERE id = :id
         * @param string $ParseString = Informar o valor das chaves da $Query no formato ParseString ex: id=9999
         */
        public function QRDelete( $TableName, $Query, $ParseString )
        {
            $this->Table = ( string ) $TableName;
            $this->QueryDelete = ( string ) $Query;
            parse_str( $ParseString, $this->Places );
            $this->getSyntaxDelete();
            $this->ExecuteDelete();
        }


        private function getSyntaxDelete()
        {
            $this->QueryDelete = "DELETE FROM {$this->Table} {$this->QueryDelete}";
            $this->PrepareDelete = $this->getConnection()->prepare( $this->QueryDelete );
        }


        private function ExecuteDelete()
        {
            $this->getConnection();
            try {
                $this->PrepareDelete->execute( $this->Places );
                $this->Result = TRUE;
            } catch ( \PDOException $ex ) {
                $this->Result = NULL;
                set_error_handler( Alert::PHPErro( "<b>Erro: #{$ex->getCode()}</b> - Erro ao deletar linha do Banco<hr />{$ex->getMessage()}", E_USER_NOTICE, __FILE__ ) );
            }
        }


        /** @return int Retorna a quantidade de registros deletados no metodo QRDelete */
        public function getRowCountDelete()
        {
            return $this->PrepareDelete->rowCount();
        }


        /** @param string $ParseString = Muda a Query da instancia sem precisar inicias uma nova instancia */
        public function setPlacesDelete( $ParseString )
        {
            parse_str( $ParseString, $this->Places );
            $this->ExecuteDelete();
        }


    }
}