<?php
session_start();
require_once dirname(__DIR__, 1) . '/conect.php';
require __DIR__ . '/../vendor/autoload.php';
use App\controller\Posconf;
$incluir = new Posconf();
$audAtiva = 's';
$_POST['numerodaauditoria'] = $_SESSION['idpre'];

// verificar se numero da auditoria está ativa ou existe

$listar = $conect->prepare('select idpre from pre_nconformidade 
where audativa = :audativa and idpre = :idpre');
$listar->bindParam(':idpre', $_POST['numerodaauditoria']);
$listar->bindParam(':audativa', $audAtiva);
$listar->execute();
$capturar = $listar->fetch();

if(!isset($capturar[0]))
{
   echo 'AUDITORIA INEXISTENTE OU NÃO PENDENTE';
}else
{
    $incluir->inserirPos
    (
        $_POST['numerodaauditoria'],
        $_POST['inconformidades'],
        $_POST['cobrarnota'],
        $_POST['observacao']
    );
    echo  'OCORRÊNCIA INSERIDA';
    unset($_SESSION['idpre']);
    header('Location: ','/../view/alterarLancamentoPre.php');
    exit;
}
