<?php
/**
* MyCripty - classe para criptografar e reverter a criptografia de forma fácil, simples e segura utilizando PHP.
*
* @author Hudolf Jorge Hess
* @version 1.0b
* @link www.hudolfhess.com
*/

namespace Umbrella;

Class Crypt {

    //VariÃ¡veis privadas
    private $msgCriptografada;
    private $msgDescriptografada;

    public function criptografaMensagem($msg) {
        //Converte a mensagem a ser criptografada em array
        $arrayMsg = str_split($msg); //Aqui converto a mensagem em array
        $this->msgCriptografada = "";
        $itemArray = 0;

        //Percorre toda a mensagem
        for($i=0; $i<count($arrayMsg); $i++) {

            $itemArray = ord($arrayMsg[$i]) * 3; //Converte para o codigo da tabela ASC multiplicado por 3

            if($itemArray < 100) {
                $this->msgCriptografada .= "0".$itemArray;
            } else {
                $this->msgCriptografada .= "".$itemArray;
            }

            $itemArray = "";
        }

        return $this->msgCriptografada;
    }

    public function descriptografaMensagem($msg) {
        //Variaveis
        $novaMsg = "";
        $this->msgDescriptografada = "";

        //Transforma os nÃºmeros em array
        $arrayMsg = str_split($msg);

        //Armazena a quantidade de blocos com 3 itens
        $qntBlocos = count($arrayMsg) / 3;

        //Percorre a mensagem e a cada 3 valores adiciona um separador (/)
        //Varivavel de contador
        $cont3 = 1;

        //Montando a novo array da mensagem, dividindo com barra cada 3 caracteres
        for($i=0; $i<count($arrayMsg); $i++) {

            $novaMsg .= $arrayMsg[$i];

            if($cont3 % 3 == 0) {
                $novaMsg .= "/";
            }

            $cont3++;

        }

        //Cria um array com 3 nÃºmeros em cada posiÃ§Ã£o
        $arrayEmBlocos = explode("/", $novaMsg);

        //Percorre o novo array e descriptografa a mensagem
        for($i=0; $i<count($arrayEmBlocos); $i++) {

            $this->msgDescriptografada .= chr($arrayEmBlocos[$i]/3);

        }

        return $this->msgDescriptografada;
    }

} 

//CRIPTOGRAFIA ANTIGA
//class Crypt {
//
//    /**
//    * @var int
//    */
//    public $chave = 55684629;
//
//    /**
//    * @var string
//    */
//    public $add_text = "texto adicional aqui";
//
//    /**
//    * @param string Palavra
//    * @return string
//    */
//    function enc($word){
//       $word .= $this->add_text;
//       $s = strlen($word)+1;
//       $nw = "";
//       $n = $this->chave;
//       for ($x = 1; $x < $s; $x++){
//           $m = $x*$n;
//           if ($m > $s){
//               $nindex = $m % $s;
//           }
//           else if ($m < $s){
//               $nindex = $m;
//           }
//           if ($m % $s == 0){
//               $nindex = $x;
//           }
//           $nw = $nw.$word[$nindex-1];
//       }
//       return $nw;
//    }
//
//    /**
//    * @param string Palavra
//    * @return string
//    */
//    function dec($word){
//       $s = strlen($word)+1;
//       $nw = "";
//       $n = $this->chave;
//       for ($y = 1; $y < $s; $y++){
//           $m = $y*$n;
//           if ($m % $s == 1){
//               $n = $y;
//               break;
//           }
//       }
//       for ($x = 1; $x < $s; $x++){
//           $m = $x*$n;
//           if ($m > $s){
//               $nindex = $m % $s;
//           }
//           else if ($m < $s){
//               $nindex = $m;
//           }
//           if ($m % $s == 0){
//               $nindex = $x;
//           }
//           $nw = $nw.$word[$nindex-1];
//       }
//       $t = strlen($nw) - strlen($this->add_text);
//       return substr($nw, 0, $t);
//    }
//
//}
