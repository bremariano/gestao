<?php

//Arquivo index responsável pela inicialização do sistema
require 'vendor/autoload.php';

//require 'rotas.php';
use sistema\Biblioteca\Upload;

$upload = new Upload('Upload');
$upload->arquivo('imagens');
r($upload);
var_dump($upload);
if(!empty($arquivo = $_FILES)){
    
}
?>
<form method="post" enctype="multipart/form-data">
<input type="file" name="arquivo">
<button>enviar</button>
</form>

