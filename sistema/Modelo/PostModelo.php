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
    
    public function pesquisa(string $busca): array
    {
        $query = "SELECT * FROM ".self::Tabela." WHERE status = 1 AND titulo LIKE '%{$busca}%' ";
        $stmt = Conexao::getInstancia()->query($query);
        $resultado = $stmt->fetchAll();

        return $resultado;        
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
