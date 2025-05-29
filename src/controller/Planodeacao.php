<?php
    namespace App\controller;
    

    class Planodeacao
    {   public $conectarClasse;

        public function __construct(){
            require_once __DIR__ . '/../../conect.php';
            global $conect;
            $this->conectarClasse = $conect;
        }
        

        public function alterarDataEnvio($id,$dataenvio)
        {  
            $updatePl =$this->conectarClasse->prepare('
            update planodeacao
            set dtenviopl = :dtenviopl
            where idplano = :id
            ');
            $updatePl->bindParam(':id', $id);
            $updatePl->bindParam(':dtenviopl',$dataenvio);
            $updatePl->execute();
            echo 'Alterção realizada com sucesso';

            
        }
        public function alterarDataRecebido($id,$datarecebido){

            $updatePl =$this->conectarClasse->prepare('
            update planodeacao
            set dtrecebidopl = :dtrecebidopl
            where idplano = :id
            ');
            $updatePl->bindParam(':id', $id);
            $updatePl->bindParam(':dtrecebidopl',$datarecebido);
            $updatePl->execute();
            
        }

        public function inserirPlano
        (
            $id_usuario,
            $id_auditorPri,
            $id_empresa,
            $dt_inicio,
            $dt_fim,
            $dtenvi = null,
            $dtrecebidopl = null,
            $ncAtivo
        )
        {
            $inserir = $this->conectarClasse->prepare
            ('
                insert into planodeacao (id_usuario, id_auditor, id_empresa, dtinicio, dtfim, dtenviopl, dtrecebidopl, ncativo)
                values (:id_usuario, :id_auditorprim, :id_empresa, :dt_inicio, :dfim, :dtenvio, :dtrecebido, :ncativo)
            ');
            $inserir->bindParam(':id_usuario', $id_usuario);
            $inserir->bindParam(':id_auditorprim', $id_auditorPri);
            $inserir->bindParam(':id_empresa', $id_empresa);
            $inserir->bindParam(':dt_inicio', $dt_inicio);
            $inserir->bindParam(':dfim', $dt_fim);
            $inserir->bindParam(':dtenvio', $dtenvi);
            $inserir->bindParam(':dtrecebido', $dtrecebidopl);
            $inserir->bindParam(':ncativo', $ncAtivo);
            $inserir->execute();
            //echo 'OK PLANO';

        }
        public function desativarPlano($idpre)
        {
            $desativar = $this->conectarClasse->prepare(
                '
                    update planodeacao
                    set ncativo = "n"
                    where idplano = :idpre
                '
            );
            $desativar->bindParam(':idpre', $idpre);
            $desativar->execute();
        }
    }

    

?>