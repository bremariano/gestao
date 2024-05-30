<?php

namespace sistema\Modelo;

use sistema\Nucleo\Conexao;
use sistema\Nucleo\Modelo;

/**
 * Classe PostModelo
 *
 * @author Breno Mariano
 */
class PostModelo extends Modelo
{
    const Tabela = 'posts';

    public function __construct()
    {
        parent::__construct('posts');
    }

    public function buscaPorId(int $id): bool|object
    {
        $query = "SELECT * FROM ".self::Tabela." WHERE id = {$id} ";
        $stmt = Conexao::getInstancia()->query($query);
        $resultado = $stmt->fetch();

        return $resultado; 
    }
    
    public function pesquisa(string $busca): array
    {
        $query = "SELECT * FROM ".self::Tabela." WHERE status = 1 AND titulo LIKE '%{$busca}%' ";
        $stmt = Conexao::getInstancia()->query($query);
        $resultado = $stmt->fetchAll();

        return $resultado;        
    }
    
    public function armazenar(array $dados):void
    {

        $query = "INSERT INTO ".self::Tabela." (categoria_id, `titulo`, `texto`, `status`) 
                      VALUES (:categoria_id, :titulo, :texto, :status);";

        $stmt = Conexao::getInstancia()->prepare($query);
        $stmt->execute($dados);
    }

    public function atualizar(array $dados, int $id):void
    {

        $query = "UPDATE ".self::Tabela." SET `categoria_id` = :categoria_id, `titulo` = :titulo, `texto` = :texto, `status` = :status WHERE id = {$id} ";

        $stmt = Conexao::getInstancia()->prepare($query);
        $stmt->execute($dados);
    }
    public function deletar(int $id):void
    {
        $query = "DELETE FROM ".self::Tabela." WHERE `id` = {$id}";
        $stmt = Conexao::getInstancia()->prepare($query);
        $stmt->execute();
    }
    public function total(?string $termo = null):int
    {
        $termo = ($termo ? "WHERE {$termo}" : '');
        $query = "SELECT * FROM posts {$termo}";
        $stmt = Conexao::getInstancia()->prepare($query);
        $stmt->execute();
        return $stmt->rowCount();
    }
    
}
