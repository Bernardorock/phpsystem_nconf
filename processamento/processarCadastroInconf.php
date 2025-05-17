<?php
session_start();
include '../conect.php';

$setor = $_POST['set'];
$referencia = $_POST['ref'];
$nomeIncof = $_POST['nomeincof'];
$valor = $_POST['valor']; // em float

$veriricarReferencia = $conect->prepare('select b.ref from setoravaliado a
inner join inconf b on b.id_setoravaliado = a.idsetoravaliado 
where b.ref = :ref and a.nomesetor = :nomesetor
');
$veriricarReferencia->bindParam(':ref', $referencia);
$veriricarReferencia->bindParam(':nomesetor', $setor);
$veriricarReferencia->execute();
$captarReferencia = $veriricarReferencia->fetch();

if(!$captarReferencia)
{
    $buscarUsuario = $conect->prepare('select idusuario from usuario where login  = :usuario');
    $buscarUsuario->bindParam(':usuario',  $_SESSION['usuario']);
    $buscarUsuario->execute();
    $capturarChaveEstrangeira = $buscarUsuario->fetch();

    $buscarsetor = $conect->prepare('select idsetoravaliado from setoravaliado where nomesetor  = :setor');
    $buscarsetor->bindParam(':setor',  $setor);
    $buscarsetor->execute();
    $capturarChaveEstrangeiraSetor = $buscarsetor->fetch();

    $inserirInconf = $conect->prepare
    ('insert into inconf (id_usuario, id_setoravaliado, ref, nomeincof, valor) 
    values (:id_usuario, :id_setoravaliado, :ref, :nomeincof, :valor )');
    $inserirInconf->bindParam(':id_usuario',$capturarChaveEstrangeira[0]);
    $inserirInconf->bindParam(':id_setoravaliado', $capturarChaveEstrangeiraSetor[0]);
    $inserirInconf->bindParam(':ref', $referencia);
    $inserirInconf->bindParam(':nomeincof', $nomeIncof);
    $inserirInconf->bindParam(':valor', $valor);
    $inserirInconf->execute();
    echo 'Incoformidade Cadastrada';
        
        
}else{
    echo 'Inconformidade e Referencia já cadastrada';
}

?>