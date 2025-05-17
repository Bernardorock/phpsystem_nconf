<?php
session_start();
require __DIR__ . '/../vendor/autoload.php';
use App\controller\Planodeacao;
include '../conect.php';
$id = $_POST['id'];
$dtenvio = $_POST['dtenvio'];
$dtrecebido = $_POST['dtrecebido'];

// verificando se o id está pendente
$idPendente = $conect->prepare
('
    select idplano from planodeacao
    where (dtenviopl is null or dtrecebidopl is null)
    and idplano = :id;
');
$idPendente->bindParam(':id', $id);
$idPendente->execute();
$captarId = $idPendente->fetch();



if(!$captarId){
    echo 'ID sem pendência';
}else{
    $alterar = new Planodeacao();
    $alterar->alterarDataEnvio($id, $dtenvio);
    if($dtrecebido == null)
    {
        $dtrecebido = null;
        $alterardatarecibo = new Planodeacao();
        $alterardatarecibo->alterarDataRecebido($id, $dtrecebido);
    
     }else{
        $alterardatarecibo = new Planodeacao();
        $alterardatarecibo->alterarDataRecebido($id, $dtrecebido);
     }
}

