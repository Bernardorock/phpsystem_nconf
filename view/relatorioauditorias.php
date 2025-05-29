<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Relatórios - Auditorias</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #fffaf3;
      padding: 20px;
    }

    h3 {
      color: #d35400;
    }

    label {
      display: block;
      margin-top: 15px;
      font-weight: bold;
      color: #a04000;
    }

    select, input[type="date"], button {
      padding: 10px;
      width: 300px;
      max-width: 100%;
      margin-top: 5px;
      border: 1px solid #ccc;
      border-radius: 5px;
      font-size: 16px;
    }

    button {
      background-color: #f39c12;
      color: white;
      border: none;
      cursor: pointer;
      margin-top: 20px;
    }

    button:hover {
      background-color: #e67e22;
    }

    .campo {
      display: none;
      margin-top: 15px;
    }
  </style>
</head>
<body>
  <h3>Relatórios de Auditorias</h3>
  <a href="menu.php">Menu</a>
  <form method="GET">
    <label for="filtro">Escolha o filtro:</label>
    <select id="filtro" name="select" required>
      <option value="">-- Selecione --</option>
      <option value="data">Data</option>
      <option value="gerente">Gerente</option>
      <option value="empresa">Loja</option>
      <option value="auditor">Auditor</option>
    </select>

    <div id="campo-data" class="campo">
      <label for="data">Escolha a data:</label>
      <input type="date" id="data" name="data">
    </div>

    <div id="campo-gerente" class="campo">
      <label for="gerente">Selecione o gerente:</label>
      <select id="gerente" name="gerente">
        <option>-- Selecione --</option>
        <?php
          session_start();
          include '../conect.php';
          $ListarGerente = $conect->prepare('SELECT nomegerente FROM gerente');
          $ListarGerente->execute();
          foreach($ListarGerente as $listarValorGerente) {
              echo '<option>' . htmlspecialchars($listarValorGerente[0]) . '</option>';
          }
        ?>
      </select>
    </div>

    <div id="campo-loja" class="campo">
      <label for="loja">Selecione a loja:</label>
      <select id="loja" name="loja">
        <option>-- Selecione --</option>
        <?php
          $ListarEmpresa = $conect->prepare('SELECT nomeempresa FROM empresa');
          $ListarEmpresa->execute();
          foreach($ListarEmpresa as $listarValorEmpresa) {
              echo '<option>' . htmlspecialchars($listarValorEmpresa[0]) . '</option>';
          }
        ?>
      </select>
    </div>

    <div id="campo-auditor" class="campo">
      <label for="auditor">Selecione o auditor:</label>
      <select id="auditor" name="auditor">
        <option>-- Selecione --</option>
        <?php
          $listaarAuditor = $conect->prepare('select nomeauditor from auditor');
          $listaarAuditor->execute();
          foreach($listaarAuditor as $valorAuditor)
          {
            print_r('<option>'. htmlspecialchars($valorAuditor[0]).'</option>');
          }
        ?>
      </select>
    </div>

    <button type="submit">Filtrar</button>
  </form>

  <script>
    const selectFiltro = document.getElementById("filtro");

    const campos = {
      data: document.getElementById("campo-data"),
      gerente: document.getElementById("campo-gerente"),
      empresa: document.getElementById("campo-loja"),
      auditor: document.getElementById("campo-auditor")
    };

    selectFiltro.addEventListener("change", function () {
      Object.values(campos).forEach(campo => campo.style.display = "none");
      const escolha = this.value;
      if (campos[escolha]) {
        campos[escolha].style.display = "block";
      }
    });
  </script>

  <?php
    require __DIR__ . '../../vendor/autoload.php';
    use App\controller\Relatorioauditoria;

    if (isset($_GET['select'])) {
      $selecao = $_GET['select'];
      $relatorio = new Relatorioauditoria();

      switch ($selecao) {
        case "data":
          $relatorio->buscaData($_GET['data'] ?? '');
          break;
        case "gerente":
          $relatorio->listarGerente($_GET['gerente'] ?? '');
          break;
        case "empresa":
          $relatorio->listarLojas($_GET['loja'] ?? '');
          break;
        case "auditor":
          $relatorio->listarAuditor($_GET['auditor'] ?? '');
          break;
      }
    }
  ?>
</body>
</html>
