<!DOCTYPE html>
<html lang="PT">
	<head>
		<title>PHP Foundation</title>
		<meta charset="UTF-8" />
		
		<link rel="stylesheet" href="css/bootstrap.min.css"/>
		<link rel="stylesheet" href="css/style.css"/>
		<script type="text/javascript" src="js/bootstrap.min.js"></script>
	</head>
	<body>
		<div class="container">
			<div class="row">
				<nav class="collapse navbar-collapse bs-navbar-collapse">
					<ul class="nav navbar-nav">
						<li><a href="?nav=">Home</a></li>
						<li><a href="?nav=empresa">Empresa</a></li>
						<li><a href="?nav=produto">Produtos</a></li>
						<li><a href="?nav=servicos">Serviços</a></li>
						<li><a href="?nav=contato">Contato</a></li>
					</ul>
				</nav>
  			</div>
  			<div class="row content">
				<?php
				$getexe = filter_input( INPUT_GET, 'nav', FILTER_DEFAULT );
				
				if ( !empty( $getexe ) ):
				    $includepatch = __DIR__ . '\\pg-' . strip_tags( trim( $getexe ) . '.php' );
				else:
				    $includepatch = __DIR__ . '\\home.php';
				endif;
				
				if ( file_exists( $includepatch ) ):
				    require_once($includepatch);
				else:
				    echo "<div>";
				    	echo "<h1>Conteudo não encontrado</h1>";
				    echo "</div>";
				endif; ?>
				
			</div>
			<footer class="row>
				<p align="center">Todos os direitos reservados - <?php echo date('Y'); ?></p>
			</footer>
		</div>
	</body>
</html>