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

-- Copiando estrutura para tabela php_fundation.paginas
CREATE TABLE IF NOT EXISTS `paginas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pag_name` varchar(50) NOT NULL DEFAULT '0',
  `pag_category` varchar(255) NOT NULL,
  `pag_slug` varchar(255) NOT NULL DEFAULT '0',
  `pag_content` longtext NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

-- Copiando dados para a tabela php_fundation.paginas: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `paginas` DISABLE KEYS */;
INSERT INTO `paginas` (`id`, `pag_name`, `pag_category`, `pag_slug`, `pag_content`) VALUES
	(1, 'Bem vindo ao meu primeiro site!', '', 'home', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum. '),
	(2, 'Empresa', '', 'empresa', 'Eiiitaaa Mainhaaa!! Esse Lorem ipsum ? s? na sacanageeem!! E que abund?ncia meu irm?o viuu!! Assim voc? vai matar o papai. S? digo uma coisa, Domingo ela n?o vai! Danadaa!! Vem minha odalisca, agora faz essa cobra coral subir!!! Pau que nasce torto, Nunca se endireita. Tchannn!! Tchannn!! Tu du du p???! Eu gostchu muitchu, heinn! danadinha! Mainhaa! Agora use meu lorem ipsum ordin?ria!!! Olha o quibeee! rema, rema, ordin?ria!'),
	(3, 'Produtos', '', 'produtos', 'Mas que abund?ncia meu irm?ooo!!! Esse ? seu Layout danadaaa!??? Sabe de nada inocente!! Vem, vem, vem ordin?ria, provar do meu dend?!! Eu gostxuu muitxuu desse seu Layout!! Et? danadaaaa!! T? t?o lindo que vou falar em ingl?s s? pra voc? mainhaaa!! Know nothing innocent. Ordinary!! Txhann Txhann, Txu txu tu paaa!! Damned. Only in Slutty!! Abundance that my borther!! Tchan, Tchan, Tchan...Tu tu tu pa!!!!  .'),
	(4, 'Serviços', '', 'servicos', 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for \'lorem ipsum\' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).');
/*!40000 ALTER TABLE `paginas` ENABLE KEYS */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
