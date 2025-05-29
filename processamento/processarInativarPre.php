<?php
    session_start();

    include '../conect.php';
    require __DIR__ . '/../vendor/autoload.php';
    use App\controller\Prenaoconf;
    use App\controller\Planodeacao;
    $idPre = $_GET['idpre'] ?? '';
    $manipularPre = new Prenaoconf();
    $manipularPlano = new Planodeacao();

    $manipularPre->listarNaoPendente($idPre);
    $manipularPlano->desativarPlano($idPre);

?>