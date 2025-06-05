<?php
session_start();
require_once dirname(__DIR__, 1) . '/conect.php';
require __DIR__ . '/../vendor/autoload.php';
use App\controller\Posconf;
$atualizar = new Posconf();

//verificando se o número da ocorrencia é da auditoria correspondente;

$listar = $conect->prepare('select idplano from pos_cadastroconf where idpos = :ocorrencia ');
$listar->bindParam(':ocorrencia', $_POST['ocorrencia']);
$listar->execute();
$capitar = $listar->fetch();

if(!isset($capitar[0]))
{
    echo 'OCORRÊNICA NÃO CORRESPONDE AO NÚMERO DE AUDITORIA';
}else{
    $atualizar->atulizarPos
    (
        $_POST['ocorrencia'],
        $_POST['inconformidades'],
        $_POST['cobrarnota'],
        $_POST['observacao']
        
        
    );
    unset($_SESSION['idpre']);
    header('Location: '. '/../view/alterarLancamentoPre.php');
    exit;
}