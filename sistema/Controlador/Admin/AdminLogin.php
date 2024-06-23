<?php

namespace sistema\Controlador\Admin;

use sistema\Nucleo\Controlador;
use sistema\Nucleo\Helpers;
use sistema\Modelo\UsuarioModelo;
use sistema\Controlador\UsuarioControlador;

/**
 * Classe AdminLogin
 *
 * @author Breno Mariano
 */
class AdminLogin extends Controlador
{
    public function __construct()
    {
        parent::__construct('templates/admin/views');

    }

    public function login(): void
    {
        $usuario = UsuarioControlador::usuario();
        if ($usuario && $usuario->level == 3) {
            Helpers::redirecionar('admin/dashboard');
        }
        $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        if (isset($dados)) {
            if (in_array('', $dados)) {
                $this->mensagem->alerta('Todos os campos são obrigatórios!')->flash();
            } else {
                $usuario = (new UsuarioModelo())->login($dados, 3);
                if ($usuario) {
                    Helpers::redirecionar('admin/login');
                }
            }
        }
        echo $this->template->renderizar('login.html', array());
    }
//    private function checarDados(array $dados):bool
//    {
//        if (empty($dados['email'])){
//            $this->mensagem->alerta('O campo de e-mail é obrigatório!')->flash();
//            return false;
//        }
//        if (empty($dados['senha'])){
//            $this->mensagem->alerta('O campo de senha é obrigatório!')->flash();
//            return false;
//        }
//        return true;
//    }
}
