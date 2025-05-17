 <?php 
    session_start();
    include '../conect.php';
    require __DIR__ . '/../vendor/autoload.php';
    use App\controller\Anconf;
    $inserirAnConf = new Anconf(); 
    echo "Usuário: " . $_SESSION['usuario'];
            
            
    if ($_SERVER['REQUEST_METHOD'] === 'POST') 
        {
            $acao = $_POST['acao'] ?? '';
            

            if ($acao === 'cadastrar') 
                {
                     $_SESSION['idpre'] = $_POST['numeronc'];

                    $numeroInconforme = $_POST['numeronc'] ?? '';
                    $nomeInconformidade = $_POST['inconformidades'] ?? '';
                    
                    

                    if (!empty($numeroInconforme) && !empty($nomeInconformidade)) 
                    {
                        $_SESSION['idpre'] = $numeroInconforme;
                        // classe que verifica se existe id pendente
                        $inserirAnConf->veriricarId($_SESSION['idpre']);
                       
                        $inserirAnConf->InserirAnConf($numeroInconforme, $numeroInconforme, $nomeInconformidade);
                        header('Location: ' . $_SERVER['PHP_SELF']);
                        exit;
                           
                    }
                } 
          
            }  
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Não Conformidades</title>
    <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- FontAwesome -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f7f9fc;
            margin: 0;
            padding: 20px;
            color: #333;
        }

        h3 {
            margin-top: 40px;
            color: #2c3e50;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            background-color: #fff;
            box-shadow: 0 0 5px rgba(0,0,0,0.1);
        }

        caption {
            caption-side: top;
            font-weight: bold;
            padding: 10px;
            font-size: 1.1em;
        }

        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color:rgb(1, 6, 10);
            color: white;
        }

        tr:nth-child(even) {
            background-color:rgb(17, 1, 1);
        }

        form {
            margin-top: 20px;
            padding: 20px;
            background-color: #ffffff;
            box-shadow: 0 0 5px rgba(0,0,0,0.1);
            border-radius: 5px;
            max-width: 600px;
        }

        label {
            display: block;
            margin-top: 10px;
            font-weight: bold;
        }

        input[type="number"],
        select {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        button {
            background-color: #2ecc71;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 1em;
        }

        button:hover {
            background-color: #27ae60;
        }

        .dados-inconf {
            background-color: #ecf0f1;
            padding: 10px;
            margin-top: 10px;
            border-left: 4px solid #3498db;
        }
    </style>
</head>
<body>
    <h3>Área de Não Conformidades:</h3>
    <a href="menu.php" alt="Menu">
         <button type="button" class="btn btn-outline-primary">Menu</button>
    </a>
    <a href="lancarNaoConformidades.php">
        <button type="button" class="btn btn-outline-primary">Ñ.Conformes</button>
    </a> 
    <a href="/../index.html">
        <button type="button" class="btn btn-outline-danger">Sair</button>
    </a>
    <table>
        <caption>Pendentes de Lançamentos N.C</caption>
        <thead>
            <tr>
                <th>Nº PL</th>
                <th>Nº N.C</th>
                <th>Dt Inicial</th>
                <th>Dt Final</th>
                <th>Auditor 1</th>
                <th>Auditor 2</th>
                <th>Auditor 3</th>
                <th>Empresa</th>
                <th>Gerente</th>
            </tr>
        </thead>
        <tbody>
            <?php
                include '../conect.php';
                //echo 'Usuário: '. $_SESSION['usuario'];
                $listaPendenteNc = $conect->query("
                    SELECT 
                        pl.idplano,
                        pre.idpre,
                        pre.dtinicial,
                        pre.dtfinal,
                        aud.nomeauditor,
                        auds.nomeauditor,
                        audt.nomeauditor,
                        emp.nomeempresa,
                        ger.nomegerente
                    FROM pre_nconformidade pre
                    LEFT JOIN auditor aud ON aud.idauditor = pre.id_auditorpri
                    LEFT JOIN auditor auds ON auds.idauditor = pre.id_auditorsec
                    LEFT JOIN auditor audt ON audt.idauditor = pre.id_auditorter
                    INNER JOIN empresagerente empg ON empg.idempger = pre.idempgr
                    INNER JOIN empresa emp ON emp.idempresa = empg.id_empresa
                    INNER JOIN gerente ger ON ger.idgerente = empg.id_gerente
                    INNER JOIN planodeacao pl ON pl.idplano = pre.idplano
                    WHERE pre.pendente = 's'
                ");

                foreach($listaPendenteNc as $row) {
                    echo "<tr>
                            <th>{$row[0]}</th>
                            <th>{$row[1]}</th>
                            <th>{$row[2]}</th>
                            <th>{$row[3]}</th>
                            <th>{$row[4]}</th>
                            <th>{$row[5]}</th>
                            <th>{$row[6]}</th>
                            <th>{$row[7]}</th>
                            <th>{$row[8]}</th>



                        </tr>";
                    
                }
            ?>
        </tbody>
    </table>

    <h3>Lançamento de N.C</h3>
    <form action="" method="POST">
        <label for="numeronc">Nº N.C:</label>
        <input type="number" name="numeronc" required placeholder="Número N.C">
            
        <label for="inconformidades">Não Conformes:</label>
        <select name="inconformidades">
            <option></option>
            <?php
                $listaInconf = $conect->query('SELECT  CONCAT(ref, " - ", nomeincof, " - ", valor) as descricao FROM inconf');
                foreach($listaInconf as $item) {
                    echo "<option>" . htmlspecialchars($item['descricao']) . "</option>";
                }

            ?>
        </select>
        <button type="submit" name="acao" value="cadastrar">Cadastrar</button>
        
    </form>
  
    

    <h3>Ref - Descrição - Valor:</h3>
    <div class="dados-inconf">
       
        <?php
            if(isset($_SESSION['idpre'])){
                $inserirAnConf->listarAnconf($_SESSION['idpre']);
                
            }else{
                    echo '<p>Nenhuma não conformidade selecionada';
                
            }
            
        ?>
    </div>
    <form action="../processamento/processarUpateAnPos.php" method="POST">
        <?php 
           $captarSessaoIdPre = $_SESSION['idpre'] ?? '';
        ?>
        <button type="submit" name="acao" value="salvar">Salvar</button>
    </form> 
</body>
</html>
