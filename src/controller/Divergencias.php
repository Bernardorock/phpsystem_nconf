<?php
    namespace App\controller;
    use PDO;

    class Divergências
    {
        public $conectarClasse;

        function __construct()
        {
            require_once dirname(__DIR__, 2) . '/conect.php';
            global $conect;
            $this->conectarClasse = $conect;
        }
        public function inserirDivergencia ($idpre)
        {
            
        }
    }
?>