<?php
session_start();
include '../conect.php';
$nomeGerente = $_POST['nomegerente'];
$nomeEmpresa = $_POST['nomeempresa'];
$ativo = 's';

// capturando as chaves primárias das tabelas gerentes e empresas
$chaveGerente = $conect->prepare('select idgerente from gerente where nomegerente = :nome');
$chaveGerente->bindParam(':nome', $nomeGerente);
$chaveGerente->execute();
$captarChaveGerente = $chaveGerente->fetch();

$chaveEmpresa = $conect->prepare('select idempresa from empresa where nomeempresa = :nome');
$chaveEmpresa->bindParam(':nome', $nomeEmpresa);
$chaveEmpresa->execute();
$captarChaveEmpresa = $chaveEmpresa->fetch();

//incluir direto não há regras
$inserirEmpresaGerente = $conect->prepare('
insert into empresagerente (id_empresa, id_gerente, ativo) values
(:idempresa, :idgerente,:ativo)
');
$inserirEmpresaGerente->bindParam(':idempresa', $captarChaveEmpresa[0]);
$inserirEmpresaGerente->bindParam(':idgerente', $captarChaveGerente[0]);
$inserirEmpresaGerente->bindParam(':ativo', $ativo);
$inserirEmpresaGerente->execute();
echo '<strong>'. 'GERENTE ALOCADO COM SUCESSO'.'</strong>';




?>