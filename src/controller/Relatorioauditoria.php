<?php

namespace App\controller;

class Relatorioauditoria
{
    public $conectarClasse;

    function __construct()
    {
        require_once dirname(__DIR__, 2) . '/conect.php';
        global $conect;
        $this->conectarClasse = $conect;
    }

    public function buscaData($data)
    {
        $sql = 
        "
         select 
            pre.dtinicial,
            pre.dtfinal,
            aud.nomeauditor,
            aud2.nomeauditor,
            aud3.nomeauditor,
            emp.nomeempresa,
            ger.nomegerente,
            pre.dtfinal - pre.dtinicial as diasemauditoria
            from pre_nconformidade pre
            inner join auditor aud on aud.idauditor = pre.id_auditorpri
            left join auditor aud2 on aud2.idauditor = pre.id_auditorsec
            left join auditor aud3 on aud3.idauditor = pre.id_auditorter
            inner join empresagerente empger on empger.idempger = pre.idempgr
            left join empresa emp on emp.idempresa = empger.id_empresa
  left join gerente ger on ger.idgerente = empger.id_gerente
            where pre.dtinicial = :dat and pre.pendente = 'n'
        ";
        $listarBuscarDatas = $this->conectarClasse->prepare($sql);
        $listarBuscarDatas->bindParam(':dat', $data);
        $listarBuscarDatas->execute();

        foreach($listarBuscarDatas as $listaDatas)
        {  
            echo '<ul>';
    echo '<li><strong>DATA INICIAL:</strong> ' . $listaDatas[0] . '</li>';
    echo '<li><strong>DATA FINAL:</strong> ' . $listaDatas[1] . '</li>';
    echo '<li><strong>AUDITOR PRINCIPAL:</strong> ' . $listaDatas[2] . '</li>';
    echo '<li><strong>AUDITOR SECUNDÁRIO:</strong> ' . $listaDatas[3] . '</li>';
    echo '<li><strong>AUDITOR TERCIÁRIO:</strong> ' . $listaDatas[4] . '</li>';
    echo '<li><strong>GERENTE:</strong> ' . $listaDatas[5] . '</li>';
    echo '<li><strong>LOJA:</strong> ' . $listaDatas[6] . '</li>';
    echo '<li><strong>DIAS EM AUDITORIA:</strong> ' . $listaDatas[7] . '</li>';
    echo '</ul><hr>';
        
        }
    }
    public function listarGerente($ger)
    {
        $sqlGer = 
        '
         select 
            pre.dtinicial,
            pre.dtfinal,
            aud.nomeauditor,
            aud2.nomeauditor,
            aud3.nomeauditor,
            emp.nomeempresa,
            ger.nomegerente,
            pre.dtfinal - pre.dtinicial as diasemauditoria
            from pre_nconformidade pre
            inner join auditor aud on aud.idauditor = pre.id_auditorpri
            left join auditor aud2 on aud2.idauditor = pre.id_auditorsec
            left join auditor aud3 on aud3.idauditor = pre.id_auditorter
            inner join empresagerente empger on empger.idempger = pre.idempgr
            left join empresa emp on emp.idempresa = empger.id_empresa
            left join gerente ger on ger.idgerente = empger.id_gerente
            where ger.nomegerente = :ger
        ';
        $listarBuscarGerente = $this->conectarClasse->prepare($sqlGer);
        $listarBuscarGerente->bindParam(':ger', $ger);
        $listarBuscarGerente->execute();

        foreach($listarBuscarGerente as $listaGerente)
        {  
            echo '<ul>';
        echo '<li><strong>DATA INICIAL:</strong> ' . $listaGerente[0] . '</li>';
        echo '<li><strong>DATA FINAL:</strong> ' . $listaGerente[1] . '</li>';
        echo '<li><strong>AUDITOR PRINCIPAL:</strong> ' . $listaGerente[2] . '</li>';
        echo '<li><strong>AUDITOR SECUNDÁRIO:</strong> ' . $listaGerente[3] . '</li>';
        echo '<li><strong>AUDITOR TERCIÁRIO:</strong> ' . $listaGerente[4] . '</li>';
        echo '<li><strong>GERENTE:</strong> ' . $listaGerente[5] . '</li>';
        echo '<li><strong>LOJA:</strong> ' . $listaGerente[6] . '</li>';
        echo '<li><strong>DIAS EM AUDITORIA:</strong> ' . $listaGerente[7] . '</li>';
        echo '</ul><hr>';
        
        }
    }
    public function listarLojas($loja)
    {
         $sqlLoja = 
        '
         select 
            pre.dtinicial,
            pre.dtfinal,
            aud.nomeauditor,
            aud2.nomeauditor,
            aud3.nomeauditor,
            emp.nomeempresa,
            ger.nomegerente,
            pre.dtfinal - pre.dtinicial as diasemauditoria
            from pre_nconformidade pre
            inner join auditor aud on aud.idauditor = pre.id_auditorpri
            left join auditor aud2 on aud2.idauditor = pre.id_auditorsec
            left join auditor aud3 on aud3.idauditor = pre.id_auditorter
            inner join empresagerente empger on empger.idempger = pre.idempgr
            left join empresa emp on emp.idempresa = empger.id_empresa
            left join gerente ger on ger.idgerente = empger.id_gerente
            where emp.nomeempresa = :emp
        ';
        $listarBuscarEmpresa = $this->conectarClasse->prepare($sqlLoja);
        $listarBuscarEmpresa->bindParam(':emp', $loja);
        $listarBuscarEmpresa->execute();

        foreach($listarBuscarEmpresa as $listaEmpresa)
        {  
            echo '<ul>';
        echo '<li><strong>DATA INICIAL:</strong> ' . $listaEmpresa[0] . '</li>';
        echo '<li><strong>DATA FINAL:</strong> ' . $listaEmpresa[1] . '</li>';
        echo '<li><strong>AUDITOR PRINCIPAL:</strong> ' . $listaEmpresa[2] . '</li>';
        echo '<li><strong>AUDITOR SECUNDÁRIO:</strong> ' . $listaEmpresa[3] . '</li>';
        echo '<li><strong>AUDITOR TERCIÁRIO:</strong> ' . $listaEmpresa[4] . '</li>';
        echo '<li><strong>GERENTE:</strong> ' . $listaEmpresa[5] . '</li>';
        echo '<li><strong>LOJA:</strong> ' . $listaEmpresa[6] . '</li>';
        echo '<li><strong>DIAS EM AUDITORIA:</strong> ' . $listaEmpresa[7] . '</li>';
        echo '</ul><hr>';
        
        }
    }
    public function listarAuditor($aud)
    {
         $sqlAuditoria = 
        "
         select 
            pre.dtinicial,
            pre.dtfinal,
            aud.nomeauditor,
            aud2.nomeauditor,
            aud3.nomeauditor,
            emp.nomeempresa,
            ger.nomegerente,
            pre.dtfinal - pre.dtinicial as diasemauditoria
            from pre_nconformidade pre
            inner join auditor aud on aud.idauditor = pre.id_auditorpri
            left join auditor aud2 on aud2.idauditor = pre.id_auditorsec
            left join auditor aud3 on aud3.idauditor = pre.id_auditorter
            inner join empresagerente empger on empger.idempger = pre.idempgr
           left join empresa emp on emp.idempresa = empger.id_empresa
            left join gerente ger on ger.idgerente = empger.id_gerente
            where aud.nomeauditor = :aud and pre.pendente = 'n'
        ";
        $listarBuscarAuditor = $this->conectarClasse->prepare($sqlAuditoria);
        $listarBuscarAuditor->bindParam(':aud', $aud);
        $listarBuscarAuditor->execute();

        foreach($listarBuscarAuditor as $listaAuditor)
        {  
            echo '<ul>';
            echo '<li><strong>DATA INICIAL:</strong> ' . $listaAuditor[0] . '</li>';
            echo '<li><strong>DATA FINAL:</strong> ' . $listaAuditor[1] . '</li>';
            echo '<li><strong>AUDITOR PRINCIPAL:</strong> ' . $listaAuditor[2] . '</li>';
            echo '<li><strong>AUDITOR SECUNDÁRIO:</strong> ' . $listaAuditor[3] . '</li>';
            echo '<li><strong>AUDITOR TERCIÁRIO:</strong> ' . $listaAuditor[4] . '</li>';
            echo '<li><strong>GERENTE:</strong> ' . $listaAuditor[5] . '</li>';
            echo '<li><strong>LOJA:</strong> ' . $listaAuditor[6] . '</li>';
            echo '<li><strong>DIAS EM AUDITORIA:</strong> ' . $listaAuditor[7] . '</li>';
            echo '</ul><hr>';
        }
    }

}
