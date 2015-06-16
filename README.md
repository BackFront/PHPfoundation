# PHPfoundation #

## Arquivo de Configuração ##
Para configurar a rota do projeto, banco de dados, etc.
Vá até o arquivo ( .iniSis/iniSys.php ). Lá voce poderá configurar
a constante 'SUBDIR' caso o projeto não esteja na pasta raiz.
> *default:* '<blanck>'

## Instruções para rodar a fixture ##
- Configure a conexão do bando de dados no arquivo ( .iniSis/iniSys.php )
- Rode o arquivo(criar_fixture.php)
- Execute a index.php

>PS: O arquivo SQL do banco de dados encontra-se na pasta ( .iniSis/php_fundation.sql )

## Instruções para acessar o painel admin ##
- /*caminho_base*/painel
- **Login:** admin@logar.com
- **Senha:** logar123


----------------

Foi criado uma classe para manipulação do banco com PDO, essa classe encontra-se na pasta
./.Class/Umbrella/Database.class.php


Todas as demais classes foram desenvolvidas por mim mesmo! rsrs
