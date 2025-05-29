<?php

    session_start();
   
    require __DIR__ . '/../vendor/autoload.php';
    use App\controller\Planodeacao;
    use App\controller\Prenaoconf;
    include '../conect.php';

    $dataInicio = $_POST['datainicial'];
    $dataFim = $_POST['datafinal'];
    $nomeEmpresa = $_POST['nomeempresa'];
    $nomeGerente = $_POST['gerente'];
    $nomeAudPri = $_POST['auditorprimario'];
    $nomeAudSec = $_POST['auditorsecundario'] ?? '';
    $nomeAudTerc = $_POST['auditorternario'] ?? '';
    $pendetePre = 's';
    $ativarAud = 's';
    $dataEnvio = null;
    $dataRecebido = null;
    $ncAtivo = 's';


    //chaves estrangeiras: usuario/
    $buscarUsuario = $conect->prepare('select idusuario from usuario where login  = :usuario');
    $buscarUsuario->bindParam(':usuario',  $_SESSION['usuario']);
    $buscarUsuario->execute();
    $capturarChaveEstrangeira = $buscarUsuario->fetch();

    $buscarLoja = $conect->prepare('select idempresa from empresa where nomeempresa  = :nomeempresa');
    $buscarLoja->bindParam(':nomeempresa',  $nomeEmpresa);
    $buscarLoja->execute();
    $capturarChaveEstrangeiraEmpresa= $buscarLoja->fetch();

    
    $buscarGerente = $conect->prepare('select idgerente from gerente where nomegerente  = :nomegerente');
    $buscarGerente->bindParam(':nomegerente',  $nomeGerente);
    $buscarGerente->execute();
    $capturarChaveEstrangeiraGerente = $buscarGerente->fetch();

    $buscarAudPri = $conect->prepare('select idauditor from auditor where nomeauditor  = :nomeauditor');
    $buscarAudPri ->bindParam(':nomeauditor',  $nomeAudPri);
    $buscarAudPri->execute();
    $capturarChaveAudPri = $buscarAudPri->fetch();

    $buscarAudSec = $conect->prepare('select idauditor from auditor where nomeauditor  = :nomeaudisec');
    $buscarAudSec->bindParam(':nomeaudisec',  $nomeAudSec);
    $buscarAudSec->execute();
    $capturarChaveAudSec = $buscarAudSec->fetch();
    if(!$capturarChaveAudSec)
    {
        $capturarChaveAudSec[0] = 0;
    }

    $buscarAudTerc = $conect->prepare('select idauditor from auditor where nomeauditor  = :nomeauditerc');
    $buscarAudTerc->bindParam(':nomeauditerc',  $nomeAudTerc);
    $buscarAudTerc->execute();
    $capturarChaveAudTerc = $buscarAudTerc->fetch();
     if(!$capturarChaveAudTerc)
    {
        $capturarChaveAudTerc[0] = 0;
    }

    $buscarLigacao = $conect->prepare
    ('
        select 
        empg.idempger
        from empresagerente empg
        inner join empresa emp on emp.idempresa = empg.id_empresa
        inner join gerente g on g.idgerente = empg.id_gerente
        where emp.nomeempresa = :nomeempresa and g.nomegerente = :nomegerente  
    ');
    $buscarLigacao->bindParam(':nomeempresa', $nomeEmpresa);
    $buscarLigacao->bindParam(':nomegerente', $nomeGerente);
    $buscarLigacao->execute();
    $capturarIdLigacao = $buscarLigacao->fetch();

/*echo $dataInicio;
echo $dataFim;
echo $nomeEmpresa;
echo $nomeGerente;
echo $nomeAudPri;
echo $nomeAudSec;
echo $nomeAudTerc;*/

if($dataInicio > $dataFim){
    die ('DATA INÍCIO NÃO PODE SE MAIOR QUE DATA FIM!!!');

}else
{
    if(!$capturarIdLigacao){
        die ('GERENTE NÃO TEM LIGAÇÃO COM A EMPRESA');
    }else{
            $inserirPlano = new Planodeacao();
            $inserirPlano->inserirPlano(
                                            $capturarChaveEstrangeira[0],
                                            $capturarChaveAudPri[0],
                                            $capturarChaveEstrangeiraEmpresa[0],
                                            $dataInicio,
                                            $dataFim,
                                            $dataEnvio,
                                            $dataRecebido,
                                            $ncAtivo
                                        );
        }
    
}
// chave primaria plano
$listarChavePlano = $conect->prepare('select max(idplano) from planodeacao');
$listarChavePlano->execute();
$captarChavePlano = $listarChavePlano->fetch();

$inserirFollowp = $conect->prepare
('
    insert into followup (id_planodeacao) values (:idplano)
');
$inserirFollowp->bindParam(':idplano', $captarChavePlano[0]);
$inserirFollowp->execute();

$inserirfPrenaoconformidades = new Prenaoconf();
$inserirfPrenaoconformidades->inserirPreNaoConf(
    $dataInicio, 
    $dataFim, 
    $capturarChaveAudPri[0],
    $capturarChaveAudSec[0],
    $capturarChaveAudTerc[0],
    $pendetePre,
    $captarChavePlano[0],
    $capturarIdLigacao[0],
    $ativarAud
);


?>