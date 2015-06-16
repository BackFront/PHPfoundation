-- --------------------------------------------------------
-- Servidor:                     127.0.0.1
-- Versão do servidor:           5.6.16 - MySQL Community Server (GPL)
-- OS do Servidor:               Win32
-- HeidiSQL Versão:              8.3.0.4694
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Copiando estrutura do banco de dados para php_fundation
CREATE DATABASE IF NOT EXISTS `php_fundation` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `php_fundation`;


-- Copiando estrutura para tabela php_fundation.paginas
CREATE TABLE IF NOT EXISTS `paginas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pag_name` varchar(50) NOT NULL DEFAULT '0',
  `pag_category` varchar(255) NOT NULL,
  `pag_slug` varchar(255) NOT NULL DEFAULT '0',
  `pag_content` longtext NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=latin1;

-- Copiando dados para a tabela php_fundation.paginas: ~4 rows (aproximadamente)
/*!40000 ALTER TABLE `paginas` DISABLE KEYS */;
INSERT INTO `paginas` (`id`, `pag_name`, `pag_category`, `pag_slug`, `pag_content`) VALUES
	(13, 'Bem vindo ao meu primeiro site!', '', 'home', 'O Lorem Ipsum Ã© um texto modelo da indÃºstria tipogrÃ¡fica e de impressÃ£o. O Lorem Ipsum tem vindo a ser o texto padrÃ£o usado por estas indÃºstrias desde o ano de 1500, quando uma misturou os caracteres de um texto para criar um espÃ©cime de livro. Este texto nÃ£o sÃ³ sobreviveu 5 sÃ©culos, mas tambÃ©m o salto para a tipografia electrÃ³nica, mantendo-se essencialmente inalterada. Foi popularizada nos anos 60 com a disponibilizaÃ§Ã£o das folhas de Letraset, que continham passagens com Lorem Ipsum, e mais recentemente com os programas de publicaÃ§Ã£o como o Aldus PageMaker que incluem versÃµes do Lorem Ipsum.'),
	(14, 'Empresa', '', 'empresa', 'Ã‰ um facto estabelecido de que um leitor Ã© distraÃ­do pelo conteÃºdo legÃ­vel de uma pÃ¡gina quando analisa a sua mancha grÃ¡fica. Logo, o uso de Lorem Ipsum leva a uma distribuiÃ§Ã£o mais ou menos normal de letras, ao contrÃ¡rio do uso de "ConteÃºdo aqui, conteÃºdo aqui", tornando-o texto legÃ­vel. Muitas ferramentas de publicaÃ§Ã£o electrÃ³nica e editores de pÃ¡ginas web usam actualmente o Lorem Ipsum como o modelo de texto usado por omissÃ£o, e uma pesquisa por "lorem ipsum" irÃ¡ encontrar muitos websites ainda na sua infÃ¢ncia. VÃ¡rias versÃµes tÃªm evoluÃ­do ao longo dos anos, por vezes por acidente, por vezes propositadamente (como no caso do humor).'),
	(15, 'Produtos', '', 'produtos', 'Existem muitas variaÃ§Ãµes das passagens do Lorem Ipsum disponÃ­veis, mas a maior parte sofreu alteraÃ§Ãµes de alguma forma, pela injecÃ§Ã£o de humor, ou de palavras aleatÃ³rias que nem sequer parecem suficientemente credÃ­veis. Se vai usar uma passagem do Lorem Ipsum, deve ter a certeza que nÃ£o contÃ©m nada de embaraÃ§oso escondido no meio do texto. Todos os geradores de Lorem Ipsum na Internet acabam por repetir porÃ§Ãµes de texto prÃ©-definido, como necessÃ¡rio, fazendo com que este seja o primeiro verdadeiro gerador na Internet. Usa um dicionÃ¡rio de 200 palavras em Latim, combinado com uma dÃºzia de modelos de frases, para gerar Lorem Ipsum que pareÃ§am razoÃ¡veis. Desta forma, o Lorem Ipsum gerado Ã© sempre livre de repetiÃ§Ã£o, ou de injecÃ§Ã£o humorÃ­stica, etc.'),
	(16, 'ServiÃ§os', '', 'servicos', 'O pedaÃ§o mais habitual do Lorem Ipsum usado desde os anos 1500 Ã© reproduzido abaixo para os interessados. As secÃ§Ãµes 1.10.32 e 1.10.33 do "de Finibus Bonorum et Malorum" do CÃ­cero tambÃ©m estÃ£o reproduzidos na sua forma original, acompanhados pela sua traduÃ§Ã£o em InglÃªs, versÃµes da traduÃ§Ã£o de 1914 por H. Rackham.');
/*!40000 ALTER TABLE `paginas` ENABLE KEYS */;


-- Copiando estrutura para tabela php_fundation.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(130) NOT NULL DEFAULT '0',
  `user_email` varchar(130) NOT NULL DEFAULT '0',
  `user_password` varchar(130) NOT NULL DEFAULT '0',
  `user_cpf` varchar(14) NOT NULL DEFAULT '0',
  `user_rg` varchar(12) NOT NULL DEFAULT '0',
  `user_level` int(11) NOT NULL DEFAULT '0',
  `user_token` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- Copiando dados para a tabela php_fundation.users: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`id`, `user_name`, `user_email`, `user_password`, `user_cpf`, `user_rg`, `user_level`, `user_token`) VALUES
	(1, 'Douglas', 'admin@logar.com', '7091cd0c462554b05eec2e565c0c697404076d93', '11144477735', '44455566600', 100, '357584c1272dca388d99a1fac2fb8d26708a6cdc');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
