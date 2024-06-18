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
    public $pasta;

    public function __construct(string $diretorio = null)
    {
        $this->diretorio = $diretorio ?? 'uploads';

        if(!file_exists($this->diretorio) && !is_dir($this->diretorio)){
            mkdir($this->diretorio, 0755);
        }
    }

    public function arquivo(string $pasta = null)
    {
        $this->pasta = $pasta ?? 'arquivos';

        $this->criarPasta();
    }

    public function criarPasta(): void
    {
        if(!file_exists($this->diretorio).DIRECTORY_SEPARATOR.$this->pasta && !is_dir($this->diretorio).DIRECTORY_SEPARATOR.$this->pasta){
            mkdir($this->diretorio.DIRECTORY_SEPARATOR.$this->pasta, 0755);
        }
    }

}
