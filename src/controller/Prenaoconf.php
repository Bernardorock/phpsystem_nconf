<?php
    namespace App\controller;

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
           $id_geremp

        )
        {
            
            $inserirPre = $this->conectarClasse->prepare('
                insert into pre_nconformidade (dtinicial, dtfinal, id_auditorpri, id_auditorsec, id_auditorter, pendente, idplano, idempgr)
                values (:dtin, :dtfin, :idaudp, :idauds, :idaudt, :pend, :idplano, :idpgemp )
            ');
            $inserirPre->bindParam(':dtin', $dt_inicial);
            $inserirPre->bindParam(':dtfin', $dt_final);
            $inserirPre->bindParam(':idaudp', $id_auditorpri);
            $inserirPre->bindParam(':idauds', $id_auditorsec);
            $inserirPre->bindParam(':idaudt', $id_auditorter);
            $inserirPre->bindParam(':pend', $pendente);
            $inserirPre->bindParam(':idplano', $idplano);
            $inserirPre->bindParam(':idpgemp', $id_geremp);
            $inserirPre->execute();
            echo 'AUDITORIA CRIADA COM SUCESSO!';
        }
    }
?>