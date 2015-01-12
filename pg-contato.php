<h1>Contato</h1>

	<?php
	$getexe = filter_input( INPUT_POST, 'enviar', FILTER_DEFAULT );
	
	if ( isset( $getexe ) ):
		
		extract($_POST);
		?>
		<p class="bg-info">
			Você acaba de enviar-nos uma mensagem com as seguintes informações: <br/>
			<b>Nome:</b> <?=$nome?><br/>
			<b>Email:</b> <?=$email?><br/>
			<b>Assunto:</b> <?=$assunto?><br/>
			<b>Mensagem:</b> <?=$mensagem?><br/>
		</p>
	<?php
	endif; ?>

<div class="row">
	<div class="col-md-12">
		
		
		
		
		
		
		
		<form action="" method="post">
			<div class="form-group">
		    	<label for="exampleInputEmail1">Nome</label>
		    	<input type="text" class="form-control" name="nome" placeholder="Digite seu Nome aqui">
		    </div>
		  <div class="form-group">
		    <label for="exampleInputEmail1">Email</label>
		    <input type="email" class="form-control" name="email" placeholder="Digite seu Email aqui">
		  </div>
		  <div class="form-group">
		    <label for="exampleInputPassword1">Assunto</label>
		    <input type="text" class="form-control" name="assunto" placeholder="Digite o assunto aqui">
		  </div>
		  <div class="form-group">
		  		<label for="exampleInputPassword1">Mensagem</label>
		    	<textarea class="form-control" rows="3" name="mensagem" placeholder="Digite sua mensagem"></textarea>
		  </div>
		  <button type="submit" name="enviar" class="btn btn-default">Enviar</button>
		</form>
	</div>
</div>