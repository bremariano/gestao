<?php

namespace sistema\Modelo;

use sistema\Nucleo\Conexao;

/**
 * Classe CategoriaModelo
 *
 * @author Breno Mariano
 */
class CategoriaModelo
{
   public function busca(): array
    {

//        $query = "SELECT * FROM `categoria`";
//        if(isset($dados['search'])){
//
//            $query .=  " where status = '".$dados['search']."'";
//            $query .=  " OR title like '%$search%'";
//
//        }

        $query = "SELECT * FROM `categoria` WHERE status = 1 ORDER BY id DESC";
        $stmt = Conexao::getInstancia()->query($query);
        $resultado = $stmt->fetchAll();

        return $resultado;        
    }
    
    public function buscaPorId(int $id): bool|object
    {
        $query = "SELECT * FROM `categoria` WHERE id = {$id} ";
        $stmt = Conexao::getInstancia()->query($query);
        $resultado = $stmt->fetch();

        return $resultado; 
    }

    public function armazenar(array $dados):void
    {
        $query = "INSERT INTO `categorias` (`title`, `content`, `status`) VALUES (?, ?, ?)";
        $stmt = Conexao::getInstancia()->prepare($query);
        $stmt->execute([$dados['title'],$dados['content'],$dados['status']]);
    }

    public function atualizar(array $dados, int $id):void
    {
        $query = "UPDATE categorias SET title = ?, content = ?, status = ? WHERE id = {$id} ";
        $stmt = Conexao::getInstancia()->prepare($query);
        $stmt->execute([$dados['title'],$dados['content'],$dados['status']]);
    }
    public function deletar(int $id):void
    {
        $query = "DELETE FROM categoria WHERE `id` = {$id}";
        $stmt = Conexao::getInstancia()->prepare($query);
        $stmt->execute();
    }
    
}
