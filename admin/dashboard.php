<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Tableau de bord - Administrateur</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    .card {
      color: white;
    }
    .header {
      background-color: #343a40;
      color: white;
      padding: 10px 20px;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }
    .dashboard-title {
      text-align: center;
      margin: 30px 0;
    }
    .card-blue { background-color: #007bff; }
    .card-green { background-color: #28a745; }
    .card-yellow { background-color: #ffc107; color: black; }
    .card-red { background-color: #dc3545; }
  </style>
</head>
<body>




<?php
session_start();

if(!isset($_SESSION["admin"]))
    {
      header("location: login.php");
      exit();
    }
?>



  <div class="header">
    <div>Espace Administrateur</div>
    <a href="exit.php" class="btn btn-outline-light btn-sm">Déconnexion</a>
  </div>

  <h2 class="dashboard-title">Tableau de bord</h2>

  <div class="container">
    <div class="row text-center g-4">
      <div class="col-md-3">
        <div class="card card-blue p-3">
          <div class="card-body">
            <h5 class="card-title">Stagiaires</h5>
            <p class="card-text">Gérer les informations des stagiaires.</p>
            <a href="stagiaire/list.php" class="btn btn-light">Accéder</a>
          </div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="card card-green p-3">
          <div class="card-body">
            <h5 class="card-title">Modules</h5>
            <p class="card-text">Gérer les modules en ajoutant de nouveaux.</p>
            <a href="module/list.php" class="btn btn-light">Accéder</a>
          </div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="card card-yellow p-3">
          <div class="card-body">
            <h5 class="card-title">Examens</h5>
            <p class="card-text">Programmer et consulter les examens.</p>
            <a href="examen/list.php" class="btn btn-light">Accéder</a>
          </div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="card card-red p-3">
          <div class="card-body">
            <h5 class="card-title">Notes</h5>
            <p class="card-text">Ajouter et gérer les notes des stagiaires.</p>
            <a href="note/list.php" class="btn btn-light">Accéder</a>
          </div>
        </div>
      </div>
    </div>
  </div>

</body>
</html>
