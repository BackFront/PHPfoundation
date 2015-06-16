<script src="//tinymce.cachefly.net/4.1/tinymce.min.js"></script>
<script type="text/javascript">
    tinymce.init({
        selector: "textarea",
        plugins: [
            "advlist autolink lists link image charmap print preview anchor",
            "searchreplace visualblocks code fullscreen",
            "insertdatetime media table contextmenu paste"
        ],
        toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"
    });
</script>
<?php
require_once ('../.iniSis/iniSys.php');
$dados = filter_input_array( INPUT_POST, FILTER_DEFAULT );

if ( !empty( $dados ) ):
    $datas = [
        "pag_name" => $dados[ 'titulo' ],
        "pag_category" => $dados[ 'categoria' ],
        "pag_content" => $dados[ 'conteudo' ],
    ];

    $DB->QRInsert( 'paginas', $datas );
    echo ($DB->getResult()) ? '<div class="alert alert-success" role="alert">Página criada com sucesso!</div>' : '<div class="alert alert-danger" role="alert">Não foi possivel criar a página. Tente novamente</div>';
endif;
?>
<form action="" method="post">
    <div class="form-group">
        <label for="exampleInputEmail1">Titulo da página</label>
        <input type="text" class="form-control" id="exampleInputEmail1" name="titulo">
    </div>

    <div class="form-group">
        <label for="exampleInputEmail2">Categoria</label>
        <input type="text" class="form-control" id="exampleInputEmail2" name="categoria">
    </div>

    <div class="form-group">
        <label for="cntentpage">Conteúdo</label>
        <textarea class="form-control" id="contentpage" rows="3" name="conteudo"></textarea>
    </div>
    <input class="btn btn-default" type="submit" name="enviarsalvar" value="Criar">
</form>