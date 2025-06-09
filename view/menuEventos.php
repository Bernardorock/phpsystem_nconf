<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Menu Principal - AudCheck</title>

  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- FontAwesome -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

  <style>
    body {
      background: linear-gradient(135deg, #fff2e0, #ffffff);
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 20px;
    }

    .menu-container {
      background: #ffffff;
      padding: 30px;
      border-radius: 20px;
      box-shadow: 0 8px 30px rgba(255, 140, 0, 0.25);
      width: 100%;
      max-width: 500px;
      text-align: center;
    }

    .logo {
      margin-bottom: 20px;
    }

    .logo img {
      max-width: 120px;
    }

    .menu-title {
      color: #ff8c00;
      font-size: 26px;
      font-weight: bold;
      margin-bottom: 30px;
    }

    .list-group-item {
      background-color: #fff7ee;
      border: 1px solid #ffcc99;
      margin-bottom: 10px;
      border-radius: 8px;
      font-size: 18px;
      display: flex;
      align-items: center;
      transition: background-color 0.3s ease, color 0.3s ease;
      color: #333;
      padding: 12px 20px;
    }

    .list-group-item:hover {
      background-color: #ff8c00;
      color: white;
    }

    .list-group-item i {
      margin-right: 10px;
      font-size: 20px;
    }

    .logout-button {
      background-color: #ff8c00;
      color: white;
      border: none;
      padding: 12px 20px;
      border-radius: 8px;
      cursor: pointer;
      font-size: 16px;
      margin-top: 20px;
      width: 100%;
      transition: background-color 0.3s ease;
    }

    .logout-button:hover {
      background-color: #e67600;
    }

    .user-info {
      font-size: 14px;
      margin-bottom: 10px;
      color: #666;
    }

    /* Responsividade extra */
    @media (max-width: 600px) {
      .menu-container {
        padding: 20px;
      }
      .menu-title {
        font-size: 22px;
      }
      .list-group-item {
        font-size: 16px;
      }
    }
  </style>
</head>

<body>

  <div class="menu-container">

    <!-- LOGO (se quiser usar imagem real, troque o conteúdo abaixo) -->
    <div class="logo">
      <i class="fas fa-solar-panel fa-3x" style="color: #ff8c00;"></i>
    </div>

    <div class="user-info">
      <?php
        session_start();
        echo 'Usuário: ' . $_SESSION['usuario'];
      ?>
    </div>

    <h1 class="menu-title">Menu Eventos</h1>

    
      <div class="list-group">
        <a href="lancarNaoConformidades.php" class="list-group-item list-group-item-action">
          <i class="fa-regular fa-bell"></i> Lançamentos de Auditorias
        </a>
        <a href="lancamentoDivergencia.html" class="list-group-item list-group-item-action">
          <i class="fa fa-file-text" aria-hidden="true"></i> Lançamentos de Divergências
        </a>
        <a href="cadastrarPl.php" class="list-group-item list-group-item-action">
          <i class="fa-solid fa-a"></i> Plano de Ação
        </a>
        <a href="AlterarFollowup.php" class="list-group-item list-group-item-action">
          <i class="fa-solid fa-copy"></i> Followup
        </a>
    
    <form action="menu.php" method="get">
      <button type="submit" class="logout-button">
        <i class="fas fa-sign-out-alt"></i> Retornar
      </button>
    </form>

  </div>

  <!-- Bootstrap Script -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>