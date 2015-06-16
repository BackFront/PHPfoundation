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
$ID = filter_input( INPUT_GET, 'uid', FILTER_DEFAULT );
$dados = filter_input_array( INPUT_POST, FILTER_DEFAULT );

if ( !empty( $dados ) ):
    $datas = [
        "pag_name" => $dados[ 'titulo' ],
        "pag_category" => $dados[ 'categoria' ],
        "pag_content" => $dados[ 'conteudo' ],
    ];

    $DB->QRUpdate( 'paginas', $datas, "WHERE id=:id", "id={$ID}" );
    echo ($DB->getResult()) ? '<div class="alert alert-success" role="alert">Página salva com sucesso!</div>' : '<div class="alert alert-danger" role="alert">Não foi possivel salvar a página. Tente novamente</div>';
endif;

$DB->QRSelect( "paginas", "WHERE id=:i", "i=$ID" );
$pag = $DB->getResult()[ 0 ];
;
?>
<form action="" method="post">
    <div class="form-group">
        <label for="exampleInputEmail1">Titulo da página</label>
        <input type="text" class="form-control" id="exampleInputEmail1" value="<?php echo$pag[ 'pag_name' ] ?>" name="titulo">
    </div>

    <div class="form-group">
        <label for="exampleInputEmail2">Categoria</label>
        <input type="text" class="form-control" id="exampleInputEmail2" value="<?php echo$pag[ 'pag_category' ] ?>" name="categoria">
    </div>

    <div class="form-group">
        <label for="cntentpage">Conteúdo</label>
        <textarea class="form-control" id="contentpage" rows="3" name="conteudo">
            <?php echo$pag[ 'pag_content' ] ?>
        </textarea>
    </div>
    <input class="btn btn-default" type="submit" name="enviarsalvar" value="Salvar">
</form>