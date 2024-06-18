<?php

namespace sistema\Biblioteca;

/**
 * Description of Upload
 *
 * @author Breno Mariano
 */
class Upload {
    public $diretorio;
    public $arquivo;
    public $nome;
    public $subDiretorio;


    public function __construct(string $diretorio = null)
    {
        $this->diretorio = $diretorio ?? 'uploads';

        if(!file_exists($this->diretorio) && !is_dir($this->diretorio)){
            mkdir($this->diretorio, 0755);
        }
    }

    public function arquivo(array $arquivo, string $subDiretorio = null)
    {
        $this->arquivo = $arquivo;

        $this->subDiretorio = $subDiretorio ?? 'arquivos';

        $this->criarSubDiretorio();
        $this->moverArquivo();
    }

    public function criarSubDiretorio(): void
    {
        if(!file_exists($this->diretorio.DIRECTORY_SEPARATOR.$this->subDiretorio) && !is_dir($this->diretorio.DIRECTORY_SEPARATOR.$this->subDiretorio)){
            mkdir($this->diretorio.DIRECTORY_SEPARATOR.$this->subDiretorio, 0755);
        }
    }

    public function moverArquivo(): void
    {
        if(move_uploaded_file($this->arquivo['tmp_name'], $this->diretorio.DIRECTORY_SEPARATOR.$this->subDiretorio.DIRECTORY_SEPARATOR.$this->arquivo['name'])){
            echo $this->arquivo['name'].' foi movido com sucesso';
        }else {
            echo 'Erro ao enviar arquivo';
        }
    }

}
