<?php

namespace sistema\Controlador\Admin;

use sistema\Modelo\PostModelo;
use sistema\Modelo\CategoriaModelo;
use sistema\Nucleo\Helpers;
use Verot\Upload\Upload;

/**
 * Classe AdminPosts
 *
 * @author Breno Mariano
 */
class AdminPosts extends AdminControlador
{

    private string $capa;

    /**
     * Lista posts
     * @return void
     */
    public function listar(): void
    {
        $pesquisar = null;
        if (isset($_POST['pesquisar'])) {
            $pesquisar = "titulo like '%" . $_POST['pesquisar'] . "%'";
        }


        $post = new PostModelo();

        echo $this->template->renderizar('posts/listar.html', [
            'posts' => $post->busca($pesquisar)->ordem('status ASC, id DESC')->resultado(true),
            'total' => [
                'posts' => $post->total(),
                'postsAtivo' => $post->busca('status = 1')->total(),
                'postsInativo' => $post->busca('status = 0')->total()
            ]
        ]);
    }

    /**
     * Cadastra posts
     * @return void
     */
    public function cadastrar(): void
    {
        $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        if (isset($dados)) {

            if ($this->validarDados($dados)) {
                $post = new PostModelo();

                $post->usuario_id = $this->usuario->id;
                $post->categoria_id = $dados['categoria_id'];
                $post->slug = Helpers::slug($dados['titulo']);
                $post->titulo = $dados['titulo'];
                $post->texto = $dados['texto'];
                $post->status = $dados['status'];
                $post->capa = $this->capa ?? null;

                if ($post->salvar()) {
                    $this->mensagem->sucesso('Post cadastrado com sucesso')->flash();
                    Helpers::redirecionar('admin/posts/listar');
                } else {
                    $this->mensagem->erro($post->erro())->flash();
                    Helpers::redirecionar('admin/posts/listar');
                }
            }
        }

        echo $this->template->renderizar('posts/formulario.html', [
            'categorias' => (new CategoriaModelo())->busca('status = 1')->resultado(true),
            'post' => $dados
        ]);
    }

    /**
     * Edita post pelo ID
     * @param int $id
     * @return void
     */
    public function editar(int $id): void
    {
        $post = (new PostModelo())->buscaPorId($id);

        $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        if (isset($dados)) {

            if ($this->validarDados($dados)) {
                $post = (new PostModelo())->buscaPorId($id);

                $post->usuario_id = $this->usuario->id;
                $post->categoria_id = $dados['categoria_id'];
                $post->slug = Helpers::slug($dados['titulo']);
                $post->titulo = $dados['titulo'];
                $post->texto = $dados['texto'];
                $post->status = $dados['status'];
                $post->atualizado_em = date('Y-m-d H:i:s');

                if (!empty($_FILES['capa'])) {
                    if ($post->capa && file_exists("uploads/imagens/{$post->capa}")) {
                        unlink("uploads/imagens/{$post->capa}");
                        unlink("uploads/imagens/thumbs/{$post->capa}");
                    }
                    $post->capa = $this->capa ?? null;
                }

                if ($post->salvar()) {
                    $this->mensagem->sucesso('Post atualizado com sucesso')->flash();
                    Helpers::redirecionar('admin/posts/listar');
                } else {
                    $this->mensagem->erro($post->erro())->flash();
                    Helpers::redirecionar('admin/posts/listar');
                }
            }
        }

        echo $this->template->renderizar('posts/formulario.html', [
            'post' => $post,
            'categorias' => (new CategoriaModelo())->busca('status = 1')->resultado(true)
        ]);
    }

    /**
     * Valida os dados do formulário
     * @param array $dados
     * @return bool
     */
    public function validarDados(array $dados): bool
    {

        if (empty($dados['titulo'])) {
            $this->mensagem->alerta('Escreva um título para o Post!')->flash();
            return false;
        }
        if (empty($dados['texto'])) {
            $this->mensagem->alerta('Escreva um texto para o Post!')->flash();
            return false;
        }

        if (!empty($_FILES['capa'])) {
            $upload = new Upload($_FILES['capa'], 'pt_BR');
            if ($upload->uploaded) {
                $titulo = $upload->file_new_name_body = Helpers::slug($dados['titulo']);
                $upload->jpeg_quality = 90;
                $upload->image_convert = 'jpg';
                $upload->process('uploads/imagens/');

                if ($upload->processed) {
                    $this->capa = $upload->file_dst_name;
                    $upload->file_new_name_body = $titulo;
                    $upload->image_resize = true;
                    $upload->image_x = 540;
                    $upload->image_y = 304;
                    $upload->jpeg_quality = 70;
                    $upload->image_convert = 'jpg';
                    $upload->process('uploads/imagens/thumbs/');
                    $upload->clean();
                } else {
                    $this->mensagem->alerta($upload->error)->flash();
                    return false;
                }
            }
        }

        return true;
    }

    /**
     * Deleta posts por ID
     * @param int $id
     * @return void
     */
    public function deletar(int $id): void
    {
        if (is_int($id)) {
            $post = (new PostModelo())->buscaPorId($id);
            if (!$post) {
                $this->mensagem->alerta('O post que você está tentando deletar não existe!')->flash();
                Helpers::redirecionar('admin/posts/listar');
            } else {
                if ($post->deletar()) {

                    if ($post->capa && file_exists("uploads/imagens/{$post->capa}")) {
                        unlink("uploads/imagens/{$post->capa}");
                        unlink("uploads/imagens/thumbs/{$post->capa}");
                    }

                    $this->mensagem->sucesso('Post deletado com sucesso!')->flash();
                    Helpers::redirecionar('admin/posts/listar');
                } else {
                    $this->mensagem->erro($post->erro())->flash();
                    Helpers::redirecionar('admin/posts/listar');
                }
            }
        }
    }

}
