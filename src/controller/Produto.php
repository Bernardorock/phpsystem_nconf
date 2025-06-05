<?php
namespace App\controller;
use PDO;

class Produto
{
    public $conectarClasse;

    function __construct()
    {
        require_once dirname(__DIR__, 2) . '/conect.php';
        global $conect;
        $this->conectarClasse = $conect;
    }

    public function InserirProduto($ref, $descricao)
    {
        //verificar a referência do produto junto ao ERP, se não cadastra.
        $listarProduto = $this->conectarClasse->prepare
        ('select refsankhya from produto where refsankhya = :ref');
        $listarProduto->bindParam(':ref', $ref);
        $listarProduto->execute();
        $captarRef = $listarProduto->fetch();

        if(!$captarRef){
            $inserir = $this->conectarClasse->prepare 
            (
                'insert into produto (refsankhya, nomeproduto)
                values (:ref, :descricao)
                '
            );
            $inserir->bindParam(':ref', $ref);
            $inserir->bindParam(':descricao', $descricao);
            $inserir->execute();
            echo 'CADASTRO REALIZADO';
        }else{
            echo 'PRODUTO JÁ CADASTRADO';
        }
        
    }

    
}