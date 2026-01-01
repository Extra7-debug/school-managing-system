<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Espace Stagiaire</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    .navbar-custom {
      background-color: #007bff;
    }
    .nav-link, .navbar-brand {
      color: white !important;
    }
    .card-icon {
      font-size: 48px;
      margin-bottom: 10px;
      color: #6c63ff;
    }
  </style>
</head>
<body>


<?php
session_start();

    if (isset($_SESSION["stagiaire"]))
    {
        $stagiaire = $_SESSION["stagiaire"];
    }
    else
    {
        header("location:login.php");
        exit();
    }

?>







<nav class="navbar navbar-expand-lg navbar-custom">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">Espace Stagiaire</a>
    <div class="collapse navbar-collapse justify-content-end">
      <ul class="navbar-nav">
        <li class="nav-item"><a class="nav-link" href="dashboard.php">Dashboard</a></li>
        <li class="nav-item"><a class="nav-link" href="profil.php">Profil</a></li>
        <li class="nav-item"><a class="nav-link" href="notes.php">Mes Notes</a></li>
        <li class="nav-item"><a class="nav-link text-danger" href="exit.php">Déconnexion</a></li>
      </ul>
    </div>
  </div>
</nav>

<div class="container text-center mt-5">
  <h4>Bonjour, <strong><?php echo $stagiaire["nom_stg"]." ".$stagiaire["prénom_stg"]; ?></strong> !</h4>
  <h2 class="my-4">Bienvenue sur votre tableau de bord</h2>

  <div class="row justify-content-center">
    <div class="col-md-3">
      <div class="card p-3">
        <a href="profil.php" style="text-decoration: none;">
        <div class="card-body">
          <div class="card-icon">👤</div>
          <h5 class="card-title">Profil</h5>
          <p class="card-text">Consultez et modifiez vos informations personnelles.</p>
        </div>
        </a>
      </div>
    </div>

    <div class="col-md-3">
      <div class="card p-3">
        <a href="notes.php" style="text-decoration: none;">
        <div class="card-body">
          <div class="card-icon">📝</div>
          <h5 class="card-title">Mes Notes</h5>
          <p class="card-text">Consultez vos résultats d'examens et vos notes.</p>
        </div>
        </a>
      </div>
    </div>
  </div>
</div>

</body>
</html>
