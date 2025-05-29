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
        <h3 class="mb-3"><i class="bi bi-pencil-square"></i>Área Follow up</h3>
        <?php 
            session_start();
            echo '<i class="bi bi-person-circle"></i> Usuário: ' . htmlspecialchars($_SESSION['usuario']);
            ?>
            <a href="menu.php" class="btn btn-primary">Menu</a>
            <br><br>

        <form action="../processamento/processarFollowup.php" method="POST" class="form-container row g-3 align-items-end">
            <div class="col-md-3">
                <label for="id" class="form-label">ID do Evento</label>
                <input type="number" class="form-control" placeholder="ID Followup" name="id" required>
            </div>

            <div class="col-md-3">
                <label for="dtenvio" class="form-label">Data Recebimento Follow up</label>
                <input type="date" class="form-control" name="dtrecebefollowup">
            </div>
            <div class="col-md-3">
                <h5>Observações:</h5>
                <label for="observacao" class="form-label"></label>
                <textarea name="ob" placeholder="255 caracteres"></textarea>
            </div>
            <div class="col-md-3 text-end">
                <button type="submit" class="btn btn-success mt-4">
                    <i class="bi bi-arrow-repeat"></i> Lançar
                </button>
            </div>
        </form>

        <table>
            <caption>Eventos Follow UP (Pendentes)</caption>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Recebimento PA</th>
                    <th>Empresa</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    include '../conect.php';
                    $listar = $conect->query(
                        '
                        select idfolloup as idevento, 
                        p.dtrecebidopl as dtrecebidopl, 
                        emp.nomeempresa  as empresa
                        from followup f
                        inner join planodeacao p on p.idplano = f.id_planodeacao
                        inner join empresa emp on emp.idempresa = p.id_empresa
                        where p.dtrecebidopl is not null and dtrecebimentofl is null 
                        '
                    );
                    foreach($listar as $valorLista) {
                        echo "<tr>
                                <td>{$valorLista['idevento']}</td>
                                <td>{$valorLista['dtrecebidopl']}</td>
                                <td>{$valorLista['empresa']}</td>
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
