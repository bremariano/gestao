<?php

//Arquivo index responsável pela inicialização do sistema
require 'vendor/autoload.php';

//require 'rotas.php';


$arquivo = $_FILES;

r($arquivo);
echo $arquivo['arquivo'] ['name'];
echo '<hr>'; 
?>
<form method="post" enctype="multipart/form-data">
<input type="file" name="arquivo">
<button>enviar</button>
</form>

