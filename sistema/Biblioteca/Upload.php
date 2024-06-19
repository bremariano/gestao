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
    public $tamanho;
    public $resultado;
    public $erro;

    public function getResultado(): ?string
    {
        return $this->resultado;
    }

    public function getErro(): ?string
    {
        return $this->erro;
    }


    public function __construct(string $diretorio = null)
    {
        $this->diretorio = $diretorio ?? 'uploads';

        if(!file_exists($this->diretorio) && !is_dir($this->diretorio)){
            mkdir($this->diretorio, 0755);
        }
    }

    public function arquivo(array $arquivo, string $nome = null, string $subDiretorio = null, int $tamanho = null)
    {
        $this->arquivo = $arquivo;

        $this->$nome = $nome ?? pathinfo($this->arquivo['name'], PATHINFO_FILENAME);

        $this->subDiretorio = $subDiretorio ?? 'arquivos';

        $extensao = pathinfo($this->arquivo['name'], PATHINFO_EXTENSION);
        $this->tamanho = $tamanho ?? 1;

        $extensoesValidas = [
            'pdf',
            'png',
            'docx'
            ];

        $tiposValidos = [
            'application/pdf',
            'text/plain',
            'image/png',
            'image/jpeg'
        ];

        if (!in_array($extensao, $extensoesValidas)){
            $this->erro = 'extensão não permitida. vc só pode enviar .' .implode('.', $extensoesValidas);
        }elseif (!in_array($this->arquivo['type'], $tiposValidos)){
            $this->erro = 'Tipo de arquivo não permitido';
        }
        elseif ($this->arquivo['size'] > $this->tamanho * (1024*1024) ){
            $this->erro = "arquivo muito grande, permitido {$this->tamanho}MB seu arquivo tem {$this->arquivo['size']}";
        }
        else{
            $this->criarSubDiretorio();
            $this->renomearArquivo();
            $this->moverArquivo();
        }

    }

    public function criarSubDiretorio(): void
    {
        if(!file_exists($this->diretorio.DIRECTORY_SEPARATOR.$this->subDiretorio) && !is_dir($this->diretorio.DIRECTORY_SEPARATOR.$this->subDiretorio)){
            mkdir($this->diretorio.DIRECTORY_SEPARATOR.$this->subDiretorio, 0755);
        }
    }

    public function renomearArquivo():void
    {
       $arquivo = $this->nome.strrchr($this->arquivo['name'], '.');
       if (file_exists($this->diretorio.DIRECTORY_SEPARATOR.$this->subDiretorio.DIRECTORY_SEPARATOR.$arquivo)){
           $arquivo = $this->nome.'-'.uniqid().strrchr($this->arquivo['name'], '.');
       }
       $this->nome = $arquivo;
    }
    public function moverArquivo(): void
    {
        if(move_uploaded_file($this->arquivo['tmp_name'], $this->diretorio.DIRECTORY_SEPARATOR.$this->subDiretorio.DIRECTORY_SEPARATOR.$this->arquivo['name'])){
           $this->resultado = $this->nome;
        }else {
            $this->resultado = null;
            $this->erro = 'Erro ao enviar arquivo';
        }
    }

}
