<?php
    namespace App\controller;

    class Relatorioauditor
    {
        public $conectarClasse;

        function __construct()
        {
            require_once dirname(__DIR__, 2) . '/conect.php';
            global $conect;
            $this->conectarClasse = $conect;
        }

        public function quantidadeAuditdas($dataincial, $datafinal, $auditor)
        {
            $sqlcont = 
            '
                 select count(idpre) from pre_nconformidade pre
                inner join auditor aud on aud.idauditor = pre.id_auditorpri
                where aud.nomeauditor = :auditor
                and pre.dtinicial between :dtini and :dtfim
            ';
            $contarAuditoria = $this->conectarClasse->prepare($sqlcont);
            $contarAuditoria->bindParam(':dtini', $dataincial);
            $contarAuditoria->bindParam(':dtfim', $datafinal);
            $contarAuditoria->bindParam('auditor', $auditor);
            $contarAuditoria->execute();
            $capituararContagem = $contarAuditoria->fetch();

            $resultadoQuantidade = $capituararContagem[0];

            return $resultadoQuantidade;
        }
        public function diasLojas($dataincial, $datafinal, $auditor)
        {
            $sqlLojaDias = 
            ('
                select sum(pre.dtfinal - dtinicial) from pre_nconformidade pre
                inner join auditor aud on aud.idauditor = pre.id_auditorpri
                where aud.nomeauditor = :auditor
                and pre.dtinicial between :dtinicial and :dtfinal 
            ');
            $contarDias = $this->conectarClasse->prepare($sqlLojaDias);
            $contarDias->bindParam(':dtinicial', $dataincial);
            $contarDias->bindParam(':dtfinal',$datafinal);
            $contarDias->bindParam(':auditor', $auditor);
            $contarDias->execute();
            $capturarSomaDias = $contarDias->fetch();

           return $capturarSomaDias[0];

        }
        public function mediaDias($datainicial, $datafinal, $auditor)
        {
            $quantidade = $this->quantidadeAuditdas($datainicial, $datafinal, $auditor);
            $dias = $this->diasLojas($datainicial, $datafinal, $auditor);

            if ($dias > 0) {
                $resultado = $quantidade / $dias;
            } else {
                $resultado = 0; 
            }

            return $resultado;
        }

        public function listarAuditoriaPeriodo($datainicial, $datafinal, $auditor)
        {
            $sqlListarAuditorias = 
            '
                  select 
                    pre.dtinicial,
                    pre.dtfinal,
                    emp.nomeempresa,
                    ger.nomegerente
                    from pre_nconformidade pre
                    inner join auditor aud on aud.idauditor = pre.id_auditorpri
                    inner join empresagerente empg on empg.idempger = pre.idempgr
                    inner join empresa emp on emp.idempresa = empg.id_empresa
                    inner join gerente ger on ger.idgerente = empg.id_gerente
                    where aud.nomeauditor = :auditor
                    and pre.dtinicial between :dtinicial and :dtfinal
            
            ';
            $sqlListar = $this->conectarClasse->prepare($sqlListarAuditorias);
            $sqlListar->bindParam(':dtinicial', $datainicial);
            $sqlListar->bindParam(':dtfinal', $datafinal);
            $sqlListar->bindParam(':auditor', $auditor);
            $sqlListar->execute();

                echo "<ul>";
                foreach($sqlListar as $listar)
                {
                    echo "<li>";
                    echo "Data Inicial: " . $listar['dtinicial'] . " | ";
                    echo "Data Final: " . $listar['dtfinal'] . " | ";
                    echo "Empresa: " . $listar['nomeempresa'] . " | ";
                    echo "Gerente: " . $listar['nomegerente'];
                    echo "</li>";
                }
                echo "</ul>";

        }


       
    }
?>