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
}
