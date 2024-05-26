<?php

namespace sistema\Controlador\Admin;

use sistema\Nucleo\Controlador;
/**
 * Classe AdminControlador
 *
 * @author Breno Mariano
 */
class AdminControlador extends Controlador
{
    public function __construct()
    {
        parent::__construct('templates/admin/views');
    }
    
}
