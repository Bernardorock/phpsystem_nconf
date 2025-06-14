<?php
    session_start();

    include '../conect.php';
    require __DIR__ . '/../vendor/autoload.php';
    use App\controller\Prenaoconf;
    use App\controller\Planodeacao;
    use App\controller\Followup;
    $_POST['numerodaauditoria'] = $_SESSION['idpre'];
    $manipularPre = new Prenaoconf();
    $manipularPlano = new Planodeacao();
    $manipularFl = new Followup();
    
    $manipularPre->listarNaoPendente($_POST['numerodaauditoria']);
    $manipularPlano->desativarPlano($_POST['numerodaauditoria']);
    $manipularFl->desativarFl($_POST['numerodaauditoria']);
    unset($_SESSION['idpre']);
    header('Location: ', $_SERVER['PHP_SELF']);
    exit;

?>