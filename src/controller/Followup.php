<?php
namespace App\controller;

class Followup
{
    public $conectarClass;

    function __construct(){

        require_once dirname(__DIR__, 2) . '/conect.php';
        global $conect;
        $this->conectarClass = $conect;

    }

    public function alterarFl($id, $dt, $ob)
    {
        $updateFl = $this->conectarClass->prepare
        ('
            update followup
            set dtrecebimentofl = :dt ,
            observacao = :ob
            where idfolloup = :id
        ');
        $updateFl->bindParam(':dt', $dt);
        $updateFl->bindParam(':id', $id);
        $updateFl->bindParam(':ob', $ob);
        $updateFl->execute();
        echo 'Follow up Lançado com sucesso';
    }




}