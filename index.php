<?php
//Arquivo index responsável pela inicialização do sistema
require 'vendor/autoload.php';

if (!empty($arquivo = $_FILES)) {
    $handle = new \Verot\Upload\Upload($_FILES['arquivo']);
    if ($handle->uploaded) {
        $handle->file_new_name_body = 'image_resized';
        $handle->image_resize = true;
        $handle->image_x = 100;
        $handle->image_ratio_y = true;
        $handle->process('uploads/imagens/');
        if ($handle->processed) {
            echo 'upload feito com sucesso';
            $handle->clean();
        } else {
            echo 'error : ' . $handle->error;
        }
    }
}




//require 'rotas.php';
//use sistema\Biblioteca\Upload;
//
//$upload = new Upload('upload');
//
//if (!empty($arquivo = $_FILES)) {
//    $arquivo = $_FILES['arquivo'];
//    $upload->arquivo($arquivo, 'novo nome', 'imagens');
//    if($upload->getResultado()){
//        echo 'upload feito com sucesso'. $upload->getResultado();
//    }else {
//        echo $upload->getErro();
//    }
//
//    r($upload);
//}

echo '<hr>';
?>

<form method="post" enctype="multipart/form-data">
    <input type="file" name="arquivo">
    <button>Enviar</button>
</form>