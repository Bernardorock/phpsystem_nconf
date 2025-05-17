<?php
session_start();
require __DIR__ . '/../vendor/autoload.php';
use App\controller\Followup;


include '../conect.php';
$id = $_POST['id'];
$dtrecebido = $_POST['dtrecebefollowup'];
$ob = $_POST['ob'];
$verificarId = $conect->prepare('
select idfolloup from followup where idfolloup = :id and dtrecebimentofl is null ');
$verificarId->bindParam(':id', $id);
$verificarId->execute();
$captarId = $verificarId->fetch();

if(!$captarId){
    echo 'ID inexistente ou já lançado';
}else{
    $alterarFollowup = new Followup();
    $alterarFollowup->alterarFl($id, $dtrecebido, $ob);
}
