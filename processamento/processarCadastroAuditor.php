<?php
session_start();
include '../conect.php';
$nomeAuditor = $_POST['nome'];
//print_r($nomeAuditor);

$consultarAuditor = $conect->prepare('select nomeauditor from auditor where nomeauditor = :nome');
$consultarAuditor->bindParam(':nome',$nomeAuditor);
$consultarAuditor->execute();
$captarAuditor = $consultarAuditor->fetch();

if(!$captarAuditor){
    $buscarUsuario = $conect->prepare('select idusuario from usuario where login  = :usuario');
    $buscarUsuario->bindParam(':usuario',  $_SESSION['usuario']);
    $buscarUsuario->execute();
    $capturarChaveEstrangeira = $buscarUsuario->fetch();
   
    $inserirAuditor = $conect->prepare('insert into auditor (nomeauditor, id_usuario) values(:nomeauditor, :id_usuario)');
    $inserirAuditor->bindParam(':nomeauditor', $nomeAuditor);
    $inserirAuditor->bindParam(':id_usuario', $capturarChaveEstrangeira[0]);
    $inserirAuditor->execute();
    echo 'Auditor Cadastrado!';
}else{
    echo 'Auidor já cadastrado';
}
?>