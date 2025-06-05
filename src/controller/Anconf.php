<?php
namespace App\controller;
use PDO;

class Anconf
{
    public $conectarClasse;

    function __construct()
    {
        require_once dirname(__DIR__, 2) . '/conect.php';
        global $conect;
        $this->conectarClasse = $conect;
    }

    public function InserirAnConf($idpl,$idnc,$nome, $vlrcobrado, $obs)
    {   $ncAtivo = 's';
        $inserirAn = $this->conectarClasse->prepare(
            '   insert into an_cadastrarinconf (idpre, idplano, nomeconf, vlrcobrado, ncativo, observacao)
                values (:idpl, :idno, :nome, :vlr, :ncativo, :observacao)
            ');
        $inserirAn->bindParam(':idpl', $idpl);
        $inserirAn->bindParam(':idno', $idnc);
        $inserirAn->bindParam(':nome', $nome);
        $inserirAn->bindParam(':vlr', $vlrcobrado);
        $inserirAn->bindParam(':ncativo',$ncAtivo);
        $inserirAn->bindParam(':observacao', $obs);
        $inserirAn->execute();
        
    }

    public function listarAnconf($idpre)
    {   
       
            $listarValores = $this->conectarClasse->prepare('
                select nomeconf, vlrcobrado from an_cadastrarinconf where idpre = :idpre

            ');
            $listarValores->bindParam(':idpre', $idpre);
            $listarValores->execute();
            foreach($listarValores as $valor){
                echo $valor[0] . " // " . $valor[1];
                echo '<br>';
            }
                
                

       
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