<?php   
    namespace App\controller;
    use PDO;
    class Pdf 
    {
        public $conectarClasse;

        function __construct()
        {
            require_once dirname(__DIR__, 2) . '/conect.php';
            global $conect;
            $this->conectarClasse = $conect;
        }

        public function listarCabecario($idpre)
        {
                $sqlNumeroAuditoria = 
            (
                "
                    select 
                    pre.idpre,
                    aud.nomeauditor,
                    aud2.nomeauditor,
                    aud3.nomeauditor,
                    ger.nomegerente,
                    emp.nomeempresa
                    from pre_nconformidade pre
                    inner join auditor aud on aud.idauditor = pre.id_auditorpri
                    left join auditor aud2 on aud2.idauditor = pre.id_auditorsec
                    left join auditor aud3 on aud3.idauditor = pre.id_auditorter
                    inner join empresagerente empger on empger.idempger = pre.idempgr
                    inner join empresa emp on emp.idempresa = empger.id_empresa
                    inner join gerente ger on ger.idgerente = empger.id_gerente
                    where pre.pendente = 'n' and pre.audativa = 's' and pre.idpre = :idpre
                "
            );
            $numeroAuditoria = $this->conectarClasse->prepare($sqlNumeroAuditoria);
            $numeroAuditoria->bindParam(':idpre', $idpre);
            $numeroAuditoria->execute();
            $capitarAuditoria = $numeroAuditoria->fetch();
            
            if(!isset($capitarAuditoria[0]))
            {
                die('AUDITORIA INEXISTENTE OU PENDENTE DE LANÇAMENTO');
            }
            echo '<br>';
            echo "
            Número da Auditoria: {$capitarAuditoria[0]} |
            Auditor 1: {$capitarAuditoria[1]} |
            Auditor 2: {$capitarAuditoria[2]} |
            Auditor 3: {$capitarAuditoria[3]}
            ";
            echo '<br>';
            echo"
            Nome do Gerente: {$capitarAuditoria[4]} |
            Nome da Empresa: {$capitarAuditoria[5]}
            ";
            
        }
        public function nota($idpre)
        {
            $sqlNota = 
            "
                select sum(inc.valor) 
                from inconf inc
                inner join pos_cadastroconf pos on pos.nomeconf = inc.conc
                inner join pre_nconformidade pre on pre.idplano = pos.idplano
                where pos.vlrcobrado = 's' and pos.ncativo = 's' and pre.idpre = :idpre
            ";
            $nota = $this->conectarClasse->prepare($sqlNota);
            $nota->bindParam(':idpre', $idpre);
            $nota->execute();
            $captarNota = $nota->fetch();

            return floatval($captarNota[0]);

        }
        public function listarComDesconto($idpre)
        {
            $sqlDescontos = 
            "
                select 
                inc.ref,
                inc.nomeincof,
                inc.valor
                from inconf inc
                inner join pos_cadastroconf pos on pos.nomeconf = inc.conc
                inner join pre_nconformidade pre on pre.idpre = pos.idplano
                where pos.ncativo = 's' and pos.vlrcobrado = 's' and pre.idpre = :idpre
            ";
            $descontos = $this->conectarClasse->prepare($sqlDescontos);
            $descontos->bindParam(':idpre', $idpre);
            $descontos->execute();
            $captarDescontos = $descontos->fetchAll();

            foreach($captarDescontos as $key => $valores)
            {
                echo $valores[0];
                echo $valores[1];
                echo $valores[2];
                echo '<br>';
                echo '<br>';
            }

            
        }
        public function listarSemDesconto($idpre)     
        {
            $sqlSemDesconto = 
            "
                select 
                inc.ref,
                inc.nomeincof,
                inc.valor
                from inconf inc
                inner join pos_cadastroconf pos on pos.nomeconf = inc.conc
                inner join pre_nconformidade pre on pre.idpre = pos.idplano
                where pos.ncativo = 's' and pos.vlrcobrado = 'n' and pre.idpre = :idpre
            ";
            $sqlSemDesconto = $this->conectarClasse->prepare($sqlSemDesconto);
            $sqlSemDesconto->bindParam(':idpre', $idpre);
            $sqlSemDesconto->execute();
            $captarSemDescontos = $sqlSemDesconto->fetchAll();

            foreach($captarSemDescontos as $valoresSemDescontos)
            {
                echo $valoresSemDescontos[0];
                echo $valoresSemDescontos[1];
                echo $valoresSemDescontos[2];
                echo '<br>';
                echo '<br>';
            }
        }   

    }
?>