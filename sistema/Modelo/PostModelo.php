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
    public function categoria(): ?CategoriaModelo
    {
        if ($this->categoria_id){
            return (new CategoriaModelo())->buscaPorId($this->id);
        }

return null;
    }

    public function usuario(): ?UsuarioModelo
    {
        if ($this->usuario_id){
            return (new UsuarioModelo())->buscaPorId($this->usuario_id);
        }

        return null;
    }
}
