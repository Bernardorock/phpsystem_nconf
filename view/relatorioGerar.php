<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Relatórios</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
  <style>
    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
      font-family: 'Inter', sans-serif;
    }

    body {
      background-color: #f1f5f9;
      padding: 40px 20px;
    }

    h2 {
      text-align: center;
      color: #1e293b;
      margin-bottom: 30px;
      font-size: 28px;
    }

    .container {
      display: flex;
      flex-wrap: wrap;
      gap: 40px;
      max-width: 1200px;
      margin: auto;
    }

    .form-container {
      background-color: #fff;
      padding: 30px;
      border-radius: 16px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.08);
      width: 100%;
      max-width: 320px;
      display: flex;
      flex-direction: column;
      gap: 16px;
    }

    .form-container label {
      font-weight: 600;
      color: #1e293b;
    }

    .form-container input,
    .form-container select {
      padding: 12px;
      border: 1px solid #cbd5e1;
      border-radius: 8px;
      background-color: #f8fafc;
      transition: border-color 0.3s;
    }

    .form-container input:focus,
    .form-container select:focus {
      outline: none;
      border-color: #3b82f6;
      background-color: #fff;
    }

    .form-container button {
      padding: 12px;
      background-color: #3b82f6;
      color: #fff;
      font-weight: bold;
      border: none;
      border-radius: 8px;
      cursor: pointer;
      transition: background-color 0.3s;
    }

    .form-container button:hover {
      background-color: #2563eb;
    }

    .results {
      flex: 1;
      background-color: #fff;
      padding: 30px;
      border-radius: 16px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.08);
      overflow-x: auto;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      font-size: 15px;
    }

    thead {
      background-color: #e2e8f0;
      color: #0f172a;
    }

    th, td {
      text-align: left;
      padding: 12px;
      border-bottom: 1px solid #cbd5e1;
    }

    p {
      font-size: 15px;
      color: #334155;
    }

    @media (max-width: 768px) {
      .container {
        flex-direction: column;
      }
    }
  </style>
</head>
<body>
  <h2>Relatórios</h2>
    
  <div class="container">
   
    <form method="GET" class="form-container">  
      <label for="dataauditoria">Data Auditoria</label>
      <input type="date" name="dtauditoria" required placeholder="Data auditoria">

      <label for="gerente">Gerente</label>
      <select name="gerente" required>
        <option value="">Selecione...</option>
        <?php
          include '../conect.php';
          $ListarGerente = $conect->prepare('select nomegerente from gerente');
          $ListarGerente->execute();
          foreach($ListarGerente as $listarValorGernte)
            echo '<option>' . htmlspecialchars($listarValorGernte[0]) . '</option>';
        ?>
      </select>

      <label for="empresa">Empresa</label>
      <select name="nomeempresa" required>
        <option value="">Selecione...</option>
        <?php
          session_start();
          include '../conect.php';
          $ListarEmpresa = $conect->prepare('select nomeempresa from empresa');
          $ListarEmpresa->execute();
          foreach($ListarEmpresa as $listarValorEmpresa)
            echo '<option>' . htmlspecialchars($listarValorEmpresa[0]) . '</option>';
        ?>
      </select>

      <button type="submit">Pesquisar</button>
      <a href="menu.php">Menu</a>
    </form>

    <div class="results">
<?php
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['dtauditoria'], $_GET['nomeempresa'], $_GET['gerente'])) {

  include "../conect.php";
  define('notaMaxima', 10.00);

  $dataAuditoria = $_GET['dtauditoria'];
  $nomeEmpresa = $_GET['nomeempresa'];
  $nomeGerente = $_GET['gerente'];

  echo '<p><strong>Loja:</strong> ' . htmlspecialchars($nomeEmpresa) . ' &nbsp; | &nbsp; <strong>Gerente:</strong> ' . htmlspecialchars($nomeGerente) . ' &nbsp; | &nbsp; <strong>Gerente Auditor:</strong> Alexandre Cordeiro</p><br>';

  // Consulta da nota
  $sqlconsultaNota = "
    SELECT SUM(inc.valor)
    FROM inconf inc
    INNER JOIN pos_cadastroconf pos ON pos.nomeconf = CONCAT(inc.ref, ' - ', inc.nomeincof, ' - ', inc.valor)
    INNER JOIN pre_nconformidade pre ON pre.idpre = pos.idpre
    INNER JOIN empresagerente empr ON empr.idempger = pre.idempgr
    INNER JOIN empresa emp ON emp.idempresa = empr.id_empresa
    INNER JOIN gerente ger ON ger.idgerente = empr.id_gerente
    WHERE pre.dtinicial BETWEEN :date AND :date
      AND ger.nomegerente = :ger
      AND emp.nomeempresa = :emp
  ";
  $sqlNota = $conect->prepare($sqlconsultaNota);
  $sqlNota->bindParam(':date', $dataAuditoria);
  $sqlNota->bindParam(':ger', $nomeGerente);
  $sqlNota->bindParam(':emp', $nomeEmpresa);
  $sqlNota->execute();
  $captarNota = $sqlNota->fetchColumn();
  $notaFinal = notaMaxima - floatval($captarNota);

  echo "<p><strong>Nota Não Conformidades:</strong> " . number_format($captarNota, 2, ',', '.') . "</p>";
  echo "<p><strong>Nota Inicial:</strong> 10.00</p>";
  echo "<p><strong>Nota Final:</strong> " . number_format($notaFinal, 2, ',', '.') . "</p><br>";

  // Consulta das não conformidades
  $sqlBusca = "
    SELECT pos.nomeconf 
    FROM inconf inc
    INNER JOIN pos_cadastroconf pos ON pos.nomeconf = CONCAT(inc.ref, ' - ', inc.nomeincof, ' - ', inc.valor)
    INNER JOIN pre_nconformidade pre ON pre.idpre = pos.idpre
    INNER JOIN empresagerente empr ON empr.idempger = pre.idempgr
    INNER JOIN empresa emp ON emp.idempresa = empr.id_empresa
    INNER JOIN gerente ger ON ger.idgerente = empr.id_gerente
    WHERE pre.dtinicial BETWEEN :date AND :date
      AND emp.nomeempresa = :emp
      AND ger.nomegerente = :ger
    GROUP BY pos.nomeconf
  ";
  $listarBusca = $conect->prepare($sqlBusca);
  $listarBusca->bindParam(':date', $dataAuditoria);
  $listarBusca->bindParam(':emp', $nomeEmpresa);
  $listarBusca->bindParam(':ger', $nomeGerente);
  $listarBusca->execute();

  if ($listarBusca->rowCount() > 0) {
    echo '
      <table>
        <thead>
          <tr>
            <th>Não Conformidade</th>
          </tr>
        </thead>
        <tbody>
    ';
    foreach ($listarBusca as $resultado) {
      echo '
        <tr>
          <td>' . htmlspecialchars($resultado['nomeconf']) . '</td>
        </tr>
      ';
    }
    echo '</tbody></table>';
  } else {
    echo '<p style="color: #dc2626;">Nenhum resultado encontrado para os filtros informados.</p>';
  }
}
?>
    </div>
  </div>
</body>
</html>



