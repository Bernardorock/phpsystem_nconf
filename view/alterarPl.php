<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alterações Plano de Ação</title>

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
        <h3 class="mb-3"><i class="bi bi-pencil-square"></i> Alteração de Evento</h3>
        <?php 
            session_start();
            echo '<i class="bi bi-person-circle"></i> Usuário: ' . htmlspecialchars($_SESSION['usuario']);
            ?>
            <br><br>

        <form action="../processamento/processarAlteracaoPl.php" method="POST" class="form-container row g-3 align-items-end">
            <div class="col-md-3">
                <label for="id" class="form-label">ID do Evento</label>
                <input type="number" class="form-control" placeholder="ID para alteração" name="id" required>
            </div>

            <div class="col-md-3">
                <label for="dtenvio" class="form-label">Data de Envio</label>
                <input type="date" class="form-control" name="dtenvio">
            </div>

            <div class="col-md-3">
                <label for="dtrecebimento" class="form-label">Data de Recebimento</label>
                <input type="date" class="form-control" name="dtrecebido">
            </div>

            <div class="col-md-3 text-end">
                <button type="submit" class="btn btn-success mt-4">
                    <i class="bi bi-arrow-repeat"></i> Alterar
                </button>
            </div>
        </form>

        <table>
            <caption>Eventos Cadastrados (Pendentes)</caption>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Início</th>
                    <th>Fim</th>
                    <th>Auditor</th>
                    <th>Empresa</th>
                    <th>Data Envio</th>
                    <th>Data Recebimento</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    include '../conect.php';
                    $listar = $conect->query(
                        '
                        SELECT
                            p.idplano AS id,
                            p.dtinicio AS Início_Auditoria,
                            p.dtfim AS Fim_Auditoria,
                            a.nomeauditor AS Nome_Auditor,
                            e.nomeempresa AS Nome_Empresa,
                            p.dtenviopl AS Data_Envio,
                            p.dtrecebidopl AS Data_Recebimento
                        FROM planodeacao p
                        INNER JOIN auditor a ON a.idauditor = p.id_auditor
                        INNER JOIN empresa e ON e.idempresa = p.id_empresa
                        WHERE (p.dtenviopl IS NULL OR p.dtrecebidopl IS NULL)
                        '
                    );
                    foreach($listar as $valorLista) {
                        echo "<tr>
                                <td>{$valorLista['id']}</td>
                                <td>{$valorLista['Início_Auditoria']}</td>
                                <td>{$valorLista['Fim_Auditoria']}</td>
                                <td>{$valorLista['Nome_Auditor']}</td>
                                <td>{$valorLista['Nome_Empresa']}</td>
                                <td>{$valorLista['Data_Envio']}</td>
                                <td>{$valorLista['Data_Recebimento']}</td>
                              </tr>";
                    }
                ?>
            </tbody>
        </table>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
