<?php
    namespace App\controller;
    use PDO;

    class Prenaoconf 
    {
        public $conectarClasse;

        function __construct(){

            require_once dirname(__DIR__, 2) . '/conect.php';
            global $conect;
            $this->conectarClasse = $conect;
    
        }

        public function inserirPreNaoConf(
           $dt_inicial,
           $dt_final,
           $id_auditorpri,
           $id_auditorsec,
           $id_auditorter,
           $pendente,
           $idplano,
           $id_geremp,
           $ativarauditoria

        )
        {
            
            $inserirPre = $this->conectarClasse->prepare('
                insert into pre_nconformidade (dtinicial, dtfinal, id_auditorpri, id_auditorsec, id_auditorter, pendente, idplano, idempgr, audativa)
                values (:dtin, :dtfin, :idaudp, :idauds, :idaudt, :pend, :idplano, :idpgemp, :audativa )
            ');
            $inserirPre->bindParam(':dtin', $dt_inicial);
            $inserirPre->bindParam(':dtfin', $dt_final);
            $inserirPre->bindParam(':idaudp', $id_auditorpri);
            $inserirPre->bindParam(':idauds', $id_auditorsec);
            $inserirPre->bindParam(':idaudt', $id_auditorter);
            $inserirPre->bindParam(':pend', $pendente);
            $inserirPre->bindParam(':idplano', $idplano);
            $inserirPre->bindParam(':idpgemp', $id_geremp);
            $inserirPre->bindParam(':audativa', $ativarauditoria);
            $inserirPre->execute();
            echo 'AUDITORIA CRIADA COM SUCESSO!';
        }
        public function inativarPre($idrpe) // inativar por completa
        {   $audativa = 'n';
            $inativarAuditoria = $this->conectarClasse->prepare(
                '
                update pre_nconformidade
                set audativa = :audiativa, pendente = :audiativa
                where idpre = :idpre
                '
            );
            $inativarAuditoria->bindParam(':audiativa', $audativa);
            $inativarAuditoria->bindParam(':idpre', $idrpe);
            $inativarAuditoria->execute();
            echo 'ALTERAÇÃO REALIZADA COM SUCESSO!';
        } 
        public function listarNaoPendente($idpre)
        {
            $sql = 
            "
                SELECT 
                    pre.idpre as idpre
                    FROM pre_nconformidade pre
                    LEFT JOIN auditor aud ON aud.idauditor = pre.id_auditorpri
                    LEFT JOIN auditor auds ON auds.idauditor = pre.id_auditorsec
                    LEFT JOIN auditor audt ON audt.idauditor = pre.id_auditorter
                    INNER JOIN empresagerente empg ON empg.idempger = pre.idempgr
                    INNER JOIN empresa emp ON emp.idempresa = empg.id_empresa
                    INNER JOIN gerente ger ON ger.idgerente = empg.id_gerente
                    INNER JOIN planodeacao pl ON pl.idplano = pre.idplano
                    WHERE pre.audativa = 's' and pre.idpre = :idpre
            ";
            $listarNpendentes = $this->conectarClasse->prepare($sql);
            $listarNpendentes->bindParam(':idpre', $idpre);
            $listarNpendentes->execute();
            $captarIdPre = $listarNpendentes->fetch(PDO::FETCH_ASSOC);
            
           if($captarIdPre && !empty($captarIdPre['idpre'])){

                $updatePre = $this->conectarClasse->prepare(
                    'update pre_nconformidade 
                    set audativa = "n"
                    where idpre = :idpre'
                );
                $updatePos = $this->conectarClasse->prepare 
                (
                        'update pos_cadastroconf
                        set ncativo = "n"
                        where idplano = :idpre
                        '
                );
                $updatePos->bindParam(':idpre', $idpre);
                $updatePos->execute();

                $updatePre->bindParam(':idpre', $idpre);
                $updatePre->execute();
                echo 'ADITORIA ATUALIZADA!';
                }
                else
                {
                    die('AUDITORIA NÃO ATIVA!!!');
                }

        }

        
        
    }
?>