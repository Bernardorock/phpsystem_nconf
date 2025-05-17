<?php
namespace App\controller;

class Anconf
{
    public $conectarClasse;

    function __construct()
    {
        require_once dirname(__DIR__, 2) . '/conect.php';
        global $conect;
        $this->conectarClasse = $conect;
    }

    public function InserirAnConf($idpl,$idnc,$nome)
    {
        $inserirAn = $this->conectarClasse->prepare(
            '   insert into an_cadastrarinconf (idpre, idplano, nomeconf)
                values (:idpl, :idno, :nome)
            ');
        $inserirAn->bindParam(':idpl', $idpl);
        $inserirAn->bindParam(':idno', $idnc);
        $inserirAn->bindParam(':nome', $nome);
        $inserirAn->execute();
        
    }

    public function listarAnconf($idpre)
    {   
       
            $listarValores = $this->conectarClasse->prepare('
                select * from an_cadastrarinconf where idpre = :idpre

            ');
            $listarValores->bindParam(':idpre', $idpre);
            $listarValores->execute();
            foreach($listarValores as $valor)
                echo $valor[3] . '<br>';
       
    }

    public function veriricarId ($idpre)
    {
        $pendente = 's';
        $verificar = $this->conectarClasse->prepare
        ("
            select idpre from pre_nconformidade where idpre = :idpre and pendente = :pendente
        ");
        $verificar->bindParam(':idpre', $idpre);
        $verificar->bindParam(':pendente', $pendente);
        $verificar->execute();
        $captar = $verificar->fetch();

        if((!$captar))
        {   
            die (' ID INEXISTENTE OU NÃO PENDENTE');
        }
        return $captar['idpre'];
        
    }
}   