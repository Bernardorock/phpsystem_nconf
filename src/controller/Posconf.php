<?php
namespace App\controller;
use PDO;

class Posconf 
{
    public $conectarClasse;

    function __construct()
    {
        require_once dirname(__DIR__, 2) . '/conect.php';
        global $conect;
        $this->conectarClasse = $conect;
    }

    public function atulizarPos($idpos, $descricao, $vlrcobrado, $observacao, $ncativo)
    {
        $atualizar = $this->conectarClasse->prepare
        (
            '
                update pos_cadastroconf
                set nomeconf = :nomeconf, vlrcobrado = :vlrcobrado, observacao = :observacao, ncativo = :ncativo
                where idpos = :idpos
            '
        );
        $atualizar->bindParam(':idpos', $idpos);
        $atualizar->bindParam(':nomeconf',$descricao);
        $atualizar->bindParam(':vlrcobrado', $vlrcobrado);
        $atualizar->bindParam(':observacao', $observacao);
        $atualizar->bindParam(':ncativo', $ncativo);
        $atualizar->execute();
        echo 'AUDITORIA ATUALIZADA';
    }

    // inserir na tabela pos_cadastroconf

    public function inserirPos($idplano, $nomeconf, $vlrcobrado, $observacao)
        
    {   $ncAtivo = 's';
        $listar = $this->conectarClasse->prepare 
        (    'insert into pos_cadastroconf 
            (idplano, nomeconf, vlrcobrado, ncativo, observacao)

            values(:idplano, :nomeconf, :vlrcobrado, :ncativo, :observacao)
            '
        );
        $listar->bindParam(':idplano', $idplano);
        $listar->bindParam(':nomeconf', $nomeconf);
        $listar->bindParam(':vlrcobrado', $vlrcobrado);
        $listar->bindParam(':ncativo', $ncAtivo);
        $listar->bindParam(':observacao', $observacao);
        $listar->execute();
    }

    public function excluirPos($idpos)
    {

    }
}