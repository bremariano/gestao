<?php

namespace sistema\Controlador\Admin;
use sistema\Modelo\PostModelo;
use sistema\Modelo\UsuarioModelo;
use sistema\Nucleo\Sessao;
use sistema\Nucleo\Helpers;

/**
 * Classe AdminDashboard
 *
 * @author Breno Mariano
 */
class AdminDashboard extends AdminControlador
{
    /**
     * Home do admin
     * @return void
     */
    public function dashboard():void
    {
        $posts = new PostModelo();
        $usuario = new UsuarioModelo();

        echo $this->template->renderizar('dashboard.html',[
            'posts' => [
                'total' => $posts->busca()->total(),
                'ativo' => $posts->busca('status = 1')->total(),
                'inativo' => $posts->busca('status = 0')->total(),
            ],
             'usuarios' => [
        'total' => $usuario->busca()->total(),
        'ativo' => $usuario->busca('status = 1')->total(),
        'inativo' => $usuario->busca('status = 0')->total(),
    ]
        ]);
    }

    /**
     * Faz logout do usuário
     * @return void
     */
    public function sair():void
    {
$sessao = new Sessao();
$sessao->limpar('usuarioId');
$this->mensagem->informa('Você saiu dopainel de controle!')->flash();
Helpers::redirecionar('admin/login');
    }
}
