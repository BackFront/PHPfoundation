<?php
require_once('.iniSis/iniSys.php');

$DB->getConnection()->query(
"CREATE TABLE IF NOT EXISTS `paginas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pag_name` varchar(50) NOT NULL DEFAULT '0',
  `pag_category` varchar(255) NOT NULL,
  `pag_slug` varchar(255) NOT NULL DEFAULT '0',
  `pag_content` longtext NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;");

$home = [
    'pag_name' => "Bem vindo ao meu primeiro site!", 
    'pag_category' => "",
    'pag_slug' => "home", 
    'pag_content' => "O Lorem Ipsum é um texto modelo da indústria tipográfica e de impressão. O Lorem Ipsum tem vindo a ser o texto padrão usado por estas indústrias desde o ano de 1500, quando uma misturou os caracteres de um texto para criar um espécime de livro. Este texto não só sobreviveu 5 séculos, mas também o salto para a tipografia electrónica, mantendo-se essencialmente inalterada. Foi popularizada nos anos 60 com a disponibilização das folhas de Letraset, que continham passagens com Lorem Ipsum, e mais recentemente com os programas de publicação como o Aldus PageMaker que incluem versões do Lorem Ipsum."
];

$empresa = [
    'pag_name' => "Empresa", 
    'pag_category' => "",
    'pag_slug' => "empresa", 
    'pag_content' => "É um facto estabelecido de que um leitor é distraído pelo conteúdo legível de uma página quando analisa a sua mancha gráfica. Logo, o uso de Lorem Ipsum leva a uma distribuição mais ou menos normal de letras, ao contrário do uso de \"Conteúdo aqui, conteúdo aqui\", tornando-o texto legível. Muitas ferramentas de publicação electrónica e editores de páginas web usam actualmente o Lorem Ipsum como o modelo de texto usado por omissão, e uma pesquisa por \"lorem ipsum\" irá encontrar muitos websites ainda na sua infância. Várias versões têm evoluído ao longo dos anos, por vezes por acidente, por vezes propositadamente (como no caso do humor)."
];

$produtos = [
    'pag_name' => "Produtos", 
    'pag_category' => "",
    'pag_slug' => "produtos", 
    'pag_content' => "Existem muitas variações das passagens do Lorem Ipsum disponíveis, mas a maior parte sofreu alterações de alguma forma, pela injecção de humor, ou de palavras aleatórias que nem sequer parecem suficientemente credíveis. Se vai usar uma passagem do Lorem Ipsum, deve ter a certeza que não contém nada de embaraçoso escondido no meio do texto. Todos os geradores de Lorem Ipsum na Internet acabam por repetir porções de texto pré-definido, como necessário, fazendo com que este seja o primeiro verdadeiro gerador na Internet. Usa um dicionário de 200 palavras em Latim, combinado com uma dúzia de modelos de frases, para gerar Lorem Ipsum que pareçam razoáveis. Desta forma, o Lorem Ipsum gerado é sempre livre de repetição, ou de injecção humorística, etc."
];

$servicos = [
    'pag_name' => "Serviços", 
    'pag_category' => "",
    'pag_slug' => "servicos", 
    'pag_content' => "O pedaço mais habitual do Lorem Ipsum usado desde os anos 1500 é reproduzido abaixo para os interessados. As secções 1.10.32 e 1.10.33 do \"de Finibus Bonorum et Malorum\" do Cícero também estão reproduzidos na sua forma original, acompanhados pela sua tradução em Inglês, versões da tradução de 1914 por H. Rackham."
];

$DB->QRInsert('paginas',$home);
echo ($DB->getResult()) ? 'Pagina home criada com sucesso!<br/>' : 'nao foi possivel criar a página home<br/>';

$DB->QRInsert('paginas',$empresa);
echo ($DB->getResult()) ? 'Pagina empresa criada com sucesso!<br/>' : 'nao foi possivel criar a página empresa<br/>';

$DB->QRInsert('paginas',$produtos);
echo ($DB->getResult()) ? 'Pagina produtos criada com sucesso!<br/>' : 'nao foi possivel criar a página produtos<br/>';

$DB->QRInsert('paginas',$servicos);
echo ($DB->getResult()) ? 'Pagina servicos criada com sucesso!<br/>' : 'nao foi possivel criar a página servicos<br/>';
