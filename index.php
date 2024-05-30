<?php

//Arquivo index responsável pela inicialização do sistema
require 'vendor/autoload.php';

//require 'rotas.php';

$dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
var_dump($dados);
echo '<hr>';
$set =[];
foreach ($dados as $chave => $valor){
    $set[] = "{$chave} = :{$valor}";
    var_dump($set);
    echo '<hr>';
}
$set = implode(', ', $set);
var_dump($set);
echo '<hr>';
$query = "UPDATE categoria SET {$set} WHERE id = 14";
var_dump($query);
echo '<hr>';
?>
UPDATE `categoria` SET `title` = 'teste 4', `content` = 'teste 4', `status` = '1' WHERE `categoria`.`id` = 14;
<hr>
<form method="post">
    <input type="text" name="nome">
    <input type="text" name="email">
    <input type="text" name="idade">
    <input type="submit" >
</form>




