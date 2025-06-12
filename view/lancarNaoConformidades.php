<?php
     session_start();
     include '../conect.php';
     if(!isset($_SESSION['usuario']))
     {
       header('Location: telaLogin.html');
       exit();
     }  
     ?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lançamentos de Não conformidades</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            background-color: #fff6e6;
            padding: 30px;
        }
        .form-container {
            background-color: #fff;
            border-radius: 12px;
            padding: 25px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 30px;
            font-family: Arial, sans-serif;
        }
        th, td {
            border: 1px solid #ccc;
            padding: 8px 12px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
            color: #333;
        }
        tr:nth-child(even) {
            background-color: #fafafa;
        }
        caption {
            caption-side: top;
            text-align: left;
            font-size: 1.2em;
            font-weight: bold;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        
        <h3 class="mb-3"><i class="bi bi-pencil-square"></i>Lançamento Não Conformidades</h3>
        <?php 
            echo '<i class="bi bi-person-circle"></i> Usuário: ' . htmlspecialchars($_SESSION['usuario']);
            ?>
            <br>
            <a href="menu.php" alt="Menu">
                <button type="button" class="btn btn-outline-primary">Menu</button>
            </a>
            <a  href="cadastrarSubInconf.php">
                <button type="button" class="btn btn-outline-primary">Ñ.Conformes</button>
            </a>
             
            <br><br>
             <form action="../processamento/processarPlanoInconf.php" method="POST" class="form-container row g-3 align-items-end">
            <h3>Cadastrar Auditoria:</h3>
    
            <div class="col-md-3">
                <label for="id" class="form-label">Data Inicial</label>
                <input type="date" class="form-control"  name="datainicial" required>
            </div>
            <div class="col-md-3">
                <label for="id" class="form-label">Data Final</label>
                <input type="date" class="form-control" name="datafinal" required>
            </div>
            <div class="col-md-3">
            <label for="Auditor Primário">Auditor Primário:</label>
                <select name="auditorprimario" required>
                    <option></option>
                    <?php
                        $ListarAuditor = $conect->prepare('select nomeauditor from auditor');
                        $ListarAuditor->execute();
                        foreach($ListarAuditor as $listarAuditorPrimario)
                        {   
                            print_r('<option>'.$listarAuditorPrimario[0].'</option>');
                        }
                    ?>
                </select>
            </div>
            <div class="col-md-3">
            <label for="Auditor secundario">Auditor Secundário:</label>
                <select name="auditorsecundario">
                    <option></option>
                    <?php
                        session_start();
                        include '../conect.php';
                        $ListarAuditorSecundario = $conect->prepare('select nomeauditor from auditor');
                        $ListarAuditorSecundario->execute();
                        foreach($ListarAuditorSecundario as $listarAuditorSecundario)
                        {  
                            print_r('<option>'.$listarAuditorSecundario[0].'</option>');
                        }
                    ?>
                </select>
            </div>
            <div class="col-md-3">
            <label for="Auditor Terciario">Auditor Terciário:</label>
                <select name="auditorternario">
                    <option></option>
                    <?php

                        $ListarAuditorTerceiro = $conect->prepare('select nomeauditor from auditor');
                        $ListarAuditorTerceiro->execute();
                        foreach($ListarAuditorTerceiro as $listarAuditorTerceiro)
                        {
                            print_r('<option>'.$listarAuditorTerceiro[0].'</option>');
                        }
                            
                    ?>
                </select>
            </div>
            <div class="col-md-3">
            <label for="gerente">Gerente:</label>
                <select name="gerente" required>
                    <option></option>
                    <?php
                        $ListarGerente = $conect->prepare('select nomegerente from gerente');
                        $ListarGerente->execute();
                        foreach($ListarGerente as $listarValorGernte)
                            print_r('<option>'.$listarValorGernte[0].'</optino>');
                    ?>
                </select>
            </div>
            <div class="col-md-3">
            <label for="empresa">Empresa:</label>
                <select name="nomeempresa" required>
                    <option></option>
                    <?php
                        $ListarEmpresa = $conect->prepare('select nomeempresa from empresa');
                        $ListarEmpresa->execute();
                        foreach($ListarEmpresa as $listarValorEmpresa)
                            print_r('<option>'.$listarValorEmpresa[0].'</optino>');
                    ?>
                </select>
            </div>
            <div class="col-md-3 text-end">
                <button type="submit" class="btn btn-success mt-4">
                    <i class="bi bi-arrow-repeat"></i> Cadastrar
                </button>
            </div>
            
        </form>
        

    </div>
                

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
