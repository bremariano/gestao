<?php
//Arquivo index responsável pela inicialização do sistema
require 'vendor/autoload.php';

//require 'rotas.php';
use sistema\Biblioteca\Upload;

$upload = new Upload('upload');

if (!empty($arquivo = $_FILES)) {
    $arquivo = $_FILES['arquivo'];
    $upload->arquivo($arquivo, 'novo nome', 'imagens');
    if($upload->getResultado()){
        echo 'upload feito com sucesso'. $upload->getResultado();
    }else {
        echo $upload->getErro();
    }

    r($upload);
}

echo '<hr>';
?>

<form method="post" enctype="multipart/form-data">
    <input type="file" name="arquivo">
    <button>Enviar</button>
</form>