<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Relatórios</title>
  <link rel=”stylesheet” href=”https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.css“>
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
    .pdf-button {
  display: inline-flex;
  align-items: center;
  gap: 8px;
  padding: 12px 20px;
  background-color: #dc2626; /* vermelho suave */
  color: white;
  border: none;
  border-radius: 8px;
  font-weight: 600;
  font-size: 15px;
  cursor: pointer;
  box-shadow: 0 4px 8px rgba(0,0,0,0.1);
  transition: background-color 0.3s, transform 0.2s;
}

.pdf-button:hover {
  background-color:rgb(235, 88, 88);
  transform: translateY(-1px);
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
  $valorFixo = 's';
  echo '<p><strong>Loja:</strong> ' . htmlspecialchars($nomeEmpresa) . ' &nbsp; | &nbsp; <strong>Gerente:</strong> ' . htmlspecialchars($nomeGerente) . ' &nbsp; | &nbsp; <strong>Gerente Auditor:</strong> Alexandre Cordeiro</p><br>';

  // Consulta da nota
  $sqlconsultaNota = "
    select sum(inc.valor)
    from inconf inc
    inner join pos_cadastroconf pos on pos.nomeconf = inc.conc
    inner join pre_nconformidade pre on pre.idplano = pos.idplano
    inner join empresagerente empg on empg.idempger = pre.idempgr
    inner join empresa emp on emp.idempresa = empg.id_empresa
    inner join gerente ger on ger.idgerente = empg.id_gerente
    where pre.dtinicial = :date
    and ger.nomegerente = :ger and emp.nomeempresa = :emp
    and pos.vlrcobrado = :valor
    and pos.ncativo = :valor
    and pos.ncativo = 's'
    order by inc.idiconf
  ";
  $sqlNota = $conect->prepare($sqlconsultaNota);
  $sqlNota->bindParam(':date', $dataAuditoria);
  $sqlNota->bindParam(':ger', $nomeGerente);
  $sqlNota->bindParam(':emp', $nomeEmpresa);
  $sqlNota->bindParam(':valor', $valorFixo );
  $sqlNota->execute();
  $captarNota = $sqlNota->fetchColumn();
  $notaFinal = notaMaxima - floatval($captarNota);

  echo "<p><strong>Nota Não Conformidades:</strong> " . number_format($captarNota, 2, ',', '.') . "</p>";
  echo "<p><strong>Nota Inicial:</strong> 10.00</p>";
  echo "<p><strong>Nota Final:</strong> " . number_format($notaFinal, 2, ',', '.') . "</p><br>";

  // Consulta das não conformidades com descontos
  $sqlBusca = 
  "
     select
    pos.nomeconf
    from pos_cadastroconf pos
    inner join pre_nconformidade pre on pre.idpre = pos.idplano
    inner join empresagerente empre on empre.idempger = pre.idempgr
    inner join empresa emp on emp.idempresa = empre.id_empresa
    inner join gerente g on g.idgerente = empre.id_gerente
    where pre.dtinicial = :date
    and emp.nomeempresa = :emp
    and g.nomegerente = :ger
    and pos.ncativo = 's' and vlrcobrado = 's'
    group by pos.nomeconf 
  ";
  $listarBuscaDesconto = $conect->prepare($sqlBusca);
  $listarBuscaDesconto->bindParam(':date', $dataAuditoria);
  $listarBuscaDesconto->bindParam(':emp', $nomeEmpresa);
  $listarBuscaDesconto->bindParam(':ger', $nomeGerente);
  $listarBuscaDesconto->execute();

  if ($listarBuscaDesconto->rowCount() > 0) {
    echo '
      <table>
        <thead>
          <tr>
            <th>Não Conformidade (Descontos em notas)</th>
          </tr>
        </thead>
        <tbody>
    ';
    foreach ($listarBuscaDesconto as $resultado) {
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
    // Consulta das não conformidades sem desconto
  $sqlBuscaSemDesconto = 
  "
     select
    pos.nomeconf
    from pos_cadastroconf pos
    inner join pre_nconformidade pre on pre.idpre = pos.idplano
    inner join empresagerente empre on empre.idempger = pre.idempgr
    inner join empresa emp on emp.idempresa = empre.id_empresa
    inner join gerente g on g.idgerente = empre.id_gerente
    where pre.dtinicial = :date
    and emp.nomeempresa = :emp
    and g.nomegerente = :ger
    and pos.ncativo = 's' and vlrcobrado = 'n'
    group by pos.nomeconf 
  ";
  $listarBuscaSemDesconto = $conect->prepare($sqlBuscaSemDesconto);
  $listarBuscaSemDesconto->bindParam(':date', $dataAuditoria);
  $listarBuscaSemDesconto->bindParam(':emp', $nomeEmpresa);
  $listarBuscaSemDesconto->bindParam(':ger', $nomeGerente);
  $listarBuscaSemDesconto->execute();

  if ($listarBuscaSemDesconto->rowCount() > 0) {
    echo '
      <br><br>
      <table>
        <thead>
          <tr>
            <th>Não Conformidade (Sem desconto)</th>
          </tr>
        </thead>
        <tbody>
    ';
    foreach ($listarBuscaSemDesconto as $resultadoSemDesconto) {
      echo '
        <tr>
          <td>' . htmlspecialchars($resultadoSemDesconto['nomeconf']) . '</td>
        </tr>
      ';
    }
    echo '</tbody></table>';
    
  }

}
?>



</form>
  </div>
  <form method="POST" action="gerarPdf.php" target="_blank" style="margin-top: 30px;">
  <input type="hidden" name="dtauditoria" value="<?= isset($_GET['dtauditoria']) ? htmlspecialchars($_GET['dtauditoria']) : '' ?>">
  <input type="hidden" name="gerente" value="<?= isset($_GET['gerente']) ? htmlspecialchars($_GET['gerente']) : '' ?>">
  <input type="hidden" name="nomeempresa" value="<?= isset($_GET['nomeempresa']) ? htmlspecialchars($_GET['nomeempresa']) : '' ?>">

  <button type="submit" class="pdf-button">
    📄 Gerar PDF
  </button>
</body>
</html>



