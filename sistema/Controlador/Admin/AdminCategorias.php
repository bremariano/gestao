<?php

namespace sistema\Controlador\Admin;

use sistema\Modelo\CategoriaModelo;
use sistema\Modelo\PostModelo;
use sistema\Nucleo\Helpers;

/**
 * Classe AdminCategorias
 *
 * @author Breno Mariano
 */
class AdminCategorias extends AdminControlador
{
    public function listar():void
    {
        $categorias = new CategoriaModelo();
        echo $this->template->renderizar('categorias/listar.html', [
            'categorias' => $categorias->busca()->ordem('title ASC')->resultado(true),
            'total' => [
                'categorias' => $categorias->busca()->total(),
                'categoriasAtiva' => $categorias ->busca(' status = 1 ')->total(),
                'categoriasInativa' => $categorias ->busca(' status = 0 ')->total()
            ]
        ]);
    }

    public function cadastrar():void
    {
        $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        if(isset($dados)){
           if ($this->validarDados($dados)){

               $categoria = new CategoriaModelo();

               $categoria->title = $dados['title'];
               $categoria->content = $dados['content'];
               $categoria->status = $dados['status'];
//               $categoria->cadastrado_em = date('Y-m-d H:i:s');

               if ($categoria->salvar()) {
                   $this->mensagem->sucesso('Categoria cadastrada com sucesso')->flash();
                   Helpers::redirecionar('admin/categorias/listar');
               } else {
                   $this->mensagem->erro($categoria->erro())->flash();
                   Helpers::redirecionar('admin/categorias/listar');
               }
           }
        }

        echo $this->template->renderizar('categorias/formulario.html', [
            'categoria' => $dados
        ]);
    }

    public function editar(int $id):void
    {
        $categoria = (new CategoriaModelo())->buscaPorId($id);

        $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        if(isset($dados)){
           if ($this->validarDados($dados)){
               $categoria = (new CategoriaModelo())->buscaPorId($categoria->id);

               $categoria->title = $dados['title'];
               $categoria->content = $dados['content'];
               $categoria->status = $dados['status'];
               $categoria->atualizado_em = date('Y-m-d H:i:s');

               if ($categoria->salvar()) {
                   $this->mensagem->sucesso('Categoria atualizada com sucesso')->flash();
                   Helpers::redirecionar('admin/categorias/listar');
               } else {
                   $this->mensagem->erro($categoria->erro())->flash();
                   Helpers::redirecionar('admin/categorias/listar');
               }
           }
        }
        echo $this->template->renderizar('categorias/formulario.html', [
            'categoria' => $categoria
        ]);
    }
    private function validarDados(array $dados):bool
    {
        if (empty($dados['title'])) {
            $this->mensagem->alerta('Escreva um título para a Categoria!')->flash();
            return false;
        }
        return true;
    }
    public function deletar(int $id): void
    {
        if (is_int($id)) {
            $categoria = (new CategoriaModelo())->buscaPorId($id);
            $posts = (new PostModelo())->busca("categoria_id = {$categoria->id}")->resultado(true);
            if (!$categoria) {
                $this->mensagem->alerta('A categoria que você está tentando deletar não existe!')->flash();
                Helpers::redirecionar('admin/categorias/listar');
            }
            elseif ($posts){
                $this->mensagem->alerta("A categoria {$categoria->titulo} tem posts cadastrados delete ou altere  os posts!")->flash();
                Helpers::redirecionar('admin/categorias/listar');
            }
            else {
                if ($categoria->deletar()) {
                    $this->mensagem->sucesso('Categoria deletada com sucesso!')->flash();
                    Helpers::redirecionar('admin/categorias/listar');
                }
                elseif ($posts){
                    $this->mensagem->sucesso("A categoria {$categoria->title} tem posts cadastrados, altere os posts antes de deletar!")->flash();
                    Helpers::redirecionar('admin/categorias/listar');
                }
                else {
                    $this->mensagem->erro($categoria->erro())->flash();
                    Helpers::redirecionar('admin/categorias/listar');
                }
            }
        }
//        $deletar = $this->deletar("id = {$this->id}");
    }
}
