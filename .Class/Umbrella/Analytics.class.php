<?php
/**
 * @package Umbrella
 * @ProjectName: Umbrella
 * @version 1.0.1
 * @link https://bitbucket.org/AlvesDouglaz/umbrella The Umbrella Bitbucket project
 * @author Douglas Alves <alves.douglaz@gmail.com>
 * @copyright (c) 2014, Douglas Alves <alves.douglaz@gmail.com>
 * @Date: 19/11/2014 
 * @note Esta classe, juntamente com o package, podem ser utilizadas por qualquer
 * pessoa, porem não pode ser alterada em qualquer condição
 * 
 * *****************************************************************************
 * <b>Analytics</b>
 * Responsavel por gerenciamento das estatisticas do sistema.
 * *****************************************************************************
 */

namespace Umbrella 
{
    class Analytics
    {

        private $Date;
        private $Cache;
        private $Traffic;
        private $Browser;

        /** Tabelas e colunas a serem manipuladas  */
        public $TableAnalytics = 'umb_analytics'; //TABELA ANALYTICS
        public $TableAnalyticsAgents = 'umb_analyticsAgents'; //TABELA ANALYTICS AGENTS
        public $TableAnalyticsOnline = 'umb_analyticsOnline'; //TABELA ANALYTICS ONLINE
        //------------------------------------------------------------------------------
        public $analyticsDate = 'analytics_date'; //CAMPO ANALYTICS -> field date
        public $analyticsUsers = 'analytics_users'; //CAMPO ANALYTICS -> field users
        public $analyticsViews = 'analytics_views'; //CAMPO ANALYTICS -> field views
        public $analyticspages = 'analytics_pages'; //CAMPO ANALYTICS -> field pages
        #
        public $analyticsAgentName = 'analyticsAgent_name'; //CAMPO ANALYTICSAGENTS -> field name
        public $analyticsAgentViews = 'analyticsAgent_views'; //CAMPO ANALYTICSAGENTS -> field views
        #
        public $analyticsOnline_session = 'analyticsOnline_session'; //CAMPO ANALYTICSONLINE -> field session
        public $analyticsOnline_startView = 'analyticsOnline_startView'; //CAMPO ANALYTICSONLINE -> field stertView
        public $analyticsOnline_endView = 'analyticsOnline_endView'; //CAMPO ANALYTICSONLINE -> field endView
        public $analyticsOnline_ip = 'analyticsOnline_ip'; //CAMPO ANALYTICSONLINE -> field ip
        public $analyticsOnline_url = 'analyticsOnline_url'; //CAMPO ANALYTICSONLINE -> field url
        public $analyticsOnline_agent = 'analyticsOnline_agent'; //CAMPO ANALYTICSONLINE -> field agent
        public $analyticsOnline_agentName = 'analyticsOnline_agentName'; //CAMPO ANALYTICSONLINE -> field agentName


        function __construct( $Cache = NULL )
        {
            (!isset( $_SESSION )) ? session_start() : NULL;
            $this->CheckSession();
        }


        /**
         * Método principal da classe. 
         * É executado automaticamente ao chamar a classe
         * @param int $Cache = Tempo em que vai durar a sessao do usuario
         */
        private function CheckSession( $Cache = NULL )
        {
            $this->Date = date( 'Y-m-d' );
            $this->Cache = ( ( int ) $Cache ? $Cache : 20 );

            //se nao existir a sessao userOnline, cria essa sessao, senao ele atualiza as informacoes
            if ( empty( $_SESSION[ 'userOnline' ] ) ):
                $this->setTraffic();
                $this->setSession();
                $this->checkBrowser();
                $this->browserUpdate();
                $this->setUserOnline();
            else:
                $this->trafficUpdate();
                $this->sessionUpdate();
                $this->checkBrowser();
                $this->userOnlineUpdate();
            endif;

            $this->Date = NULL;
        }


        /** Inicia a sessao do usuario */
        private function setSession()
        {
            $_SESSION[ 'userOnline' ] = [
                $this->analyticsOnline_session => session_id(),
                $this->analyticsOnline_startView => date( 'Y-m-d H:i:s' ),
                $this->analyticsOnline_endView => date( 'Y-m-d H:i:s', strtotime( "+{$this->Cache}minutes" ) ),
                $this->analyticsOnline_ip => filter_input( INPUT_SERVER, 'REMOTE_ADDR', FILTER_VALIDATE_IP ),
                $this->analyticsOnline_url => filter_input( INPUT_SERVER, 'REQUEST_URI', FILTER_DEFAULT ),
                $this->analyticsOnline_agent => filter_input( INPUT_SERVER, 'HTTP_USER_AGENT', FILTER_DEFAULT ),
                $this->analyticsOnline_agentName => $this->Browser
            ];
        }


        //Atualiza a sessao do usuário
        private function sessionUpdate()
        {
            $_SESSION[ 'userOnline' ][ $this->analyticsOnline_endView ] = date( 'Y-m-d H:i:s', strtotime( "+{$this->Cache}minutes" ) );
            $_SESSION[ 'userOnline' ][ $this->analyticsOnline_url ] = filter_input( INPUT_SERVER, 'REQUEST_URI', FILTER_DEFAULT );
        }


        //Obtem os trafegos do banco de dados
        private function getTraffic()
        {
            global $DB;
            $selectTraffic = $DB;
            $selectTraffic->QRSelect( $this->TableAnalytics, "WHERE {$this->analyticsDate} = :date", "date={$this->Date}" );
            if ( $selectTraffic->getRowCountSelect() ) {
                $this->Traffic = $selectTraffic->getResult()[ 0 ];
            }
        }


        //Verifica e insere o trafego na tabela
        private function setTraffic()
        {
            global $DB;
            $this->getTraffic();
            if ( !$this->Traffic ):
                $ArrSiteViews = [ $this->analyticsDate => $this->Date, $this->analyticsUsers => 1, $this->analyticsViews => 1, $this->analyticspages => 1 ];
                $selectTraffic = $DB;
                $selectTraffic->QRInsert( $this->TableAnalytics, $ArrSiteViews );
            else:
                if ( !$this->getCookie() ):
                    $ArrSiteViews = [ $this->analyticsUsers => $this->Traffic[ $this->analyticsUsers ] + 1, $this->analyticsViews => $this->Traffic[ $this->analyticsViews ] + 1, $this->analyticspages => $this->Traffic[ $this->analyticspages ] + 1 ];
                else:
                    $ArrSiteViews = [ $this->analyticsViews => $this->Traffic[ $this->analyticsViews ] + 1, $this->analyticspages => $this->Traffic[ $this->analyticspages ] + 1 ];
                endif;

                $DB->QRUpdate( $this->TableAnalytics, $ArrSiteViews, "WHERE {$this->analyticsDate} = :date", "date={$this->Date}" );

            endif;
        }


        //Verifica e atualiza os pageviews
        private function trafficUpdate()
        {
            global $DB;
            $this->getTraffic();
            $ArrSiteViews = [ $this->analyticspages => $this->Traffic[ $this->analyticspages ] + 1 ];
            $DB->QRUpdate( $this->TableAnalytics, $ArrSiteViews, "WHERE {$this->analyticsDate} = :date", "date={$this->Date}" );
            $this->Traffic = NULL;
        }


        //Gerenciamento de cookie
        private function getCookie()
        {
            $Cookie = filter_input( INPUT_COOKIE, 'userOnline', FILTER_DEFAULT );
            setcookie( 'userOnline', base64_encode( 'UMBR3LL4' ), time() + 86400 );
            if ( !$Cookie ) {
                return FALSE;
            } else {
                return TRUE;
            }
        }


        /********************************************************************
         ***************************** NAVEGADOR ******************************
         ******************************************************************** */


        private function checkBrowser()
        {
            $this->Browser = $_SESSION[ 'userOnline' ][ $this->analyticsOnline_agent ];

            if ( strpos( $this->Browser, 'Chrome' ) ) {
                $this->Browser = 'Chrome';
            } else if ( strpos( $this->Browser, 'Firefox' ) ) {
                $this->Browser = 'Firefox';
            } else if ( strpos( $this->Browser, 'MSIE' ) ) {
                $this->Browser = 'Explorer';
            } else if ( strpos( $this->Browser, 'Trident/' ) ) {
                $this->Browser = 'Explorer';
            } else if ( strpos( $this->Browser, 'Opera' ) ) {
                $this->Browser = 'Opera';
            } else if ( strpos( $this->Browser, 'Safari' ) ) {
                $this->Browser = 'Safari';
            } else {
                $this->Browser = 'Outros';
            }
        }


        private function browserUpdate()
        {
            global $DB;
            $selectAgent = $DB->QRSelect( $this->TableAnalyticsAgents, "WHERE {$this->analyticsAgentName} = :agent", "agent={$this->Browser}" );
            if ( !$DB->getResult() ):
                $ArrAgent = [$this->analyticsAgentName => $this->Browser, $this->analyticsAgentViews => 1 ];
                $selectAgent = $DB->QRInsert( $this->TableAnalyticsAgents, $ArrAgent );
            else:
                $ArrAgent = [ $this->analyticsAgentViews => $DB->getResult()[ 0 ][ $this->analyticsAgentViews ] + 1 ];
                $DB->QRUpdate( $this->TableAnalyticsAgents, $ArrAgent, "WHERE {$this->analyticsAgentName} = :name", "name={$this->Browser}" );
            endif;
        }


        /******************************************************************
         * ************************** USUARIOS ONLINE **************************
         * ****************************************************************** */
        //Insere o usuario online na tabela
        private function setUserOnline()
        {
            global $DB;
            $sessOnline = $_SESSION[ 'userOnline' ];
            $sessOnline[ $this->analyticsOnline_agentName ] = $this->Browser;
            $insertOnline = $DB->QRInsert( $this->TableAnalyticsOnline, $sessOnline );
        }


        //Atualiza usuario online
        private function userOnlineUpdate()
        {
            global $DB;
            $ArrOnline = [
                $this->analyticsOnline_endView => $_SESSION[ 'userOnline' ][ $this->analyticsOnline_endView ],
                $this->analyticsOnline_url => $_SESSION[ 'userOnline' ][ $this->analyticsOnline_url ]
            ];
            $updateOnline = $DB;
            $updateOnline->QRUpdate( $this->TableAnalyticsOnline, $ArrOnline, "WHERE {$this->analyticsOnline_session} = :session", "session={$_SESSION[ 'userOnline' ][ $this->analyticsOnline_session ]}" );

            if ( !$updateOnline->getRowCountUpdate() ):
                $selectOnline = $DB;
                $selectOnline->QRSelect( $this->TableAnalyticsOnline, "WHERE {$this->analyticsOnline_session} = :onSession", "onSession={$_SESSION[ 'userOnline' ][ $this->analyticsOnline_session ]}" );
                if ( !$selectOnline->getRowCountSelect() ):
                    $this->setUserOnline();
                endif;
            endif;
        }


    }
}