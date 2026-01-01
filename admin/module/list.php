<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
      .header {
      background-color: #343a40;
      color: white;
      padding: 10px 20px;
      display: flex;
      justify-content: space-between;
      align-items: center; }
</style>
</head>

<body>

<?php
session_start();

if(!isset($_SESSION["admin"]))
    {
      header("location: ../login.php");
      exit();
    }
?>

<div class="header">
    <div>Liste des modules</div>
    <a href="../dashboard.php" class="btn btn-outline-light btn-sm">retourn</a>
</div>
<div class="header" style="background-color: white;">
    <a class="btn btn-outline-light btn-success" href="ajouter.php">+ Ajouter un module</a>
</div>
    
<?php

require "../../connexion.php";

$sql = "SELECT * FROM module";
$stmt = $pdo -> prepare($sql);
$stmt -> execute();
$resultat = $stmt -> fetchAll(PDO::FETCH_ASSOC);

if(!$resultat)
  {
    echo'<div class="alert alert-danger container mt-4">No module exist</div>';
  }
else
  {
  ?>  

<div class="container mt-4">
  <table class="table table-bordered table-striped">
    <thead class="table-dark">
      <tr>
        <th>ID</th>
        <th>Nom</th>
        <th>Type</th>
        <th>Masse horaire (h)</th>
        <th>Action</th>
      </tr>-
    </thead>
    <tbody>
        <tr>
            <?php foreach($resultat as $r): ?>

            <td> <?php echo $r["id_module"]; ?> </td>

            <td> <?php echo $r["nom_module"]; ?> </td>

            <td> <?php echo $r["type_module"]; ?> </td>

            <td> <?php echo $r["masse_horaire_module"]; ?> </td>

            <td>
                <a class="btn btn-primary" href="modifier.php?module=<?= $r["id_module"]; ?>">Modifier</a>
                <a class="btn btn-danger" href="supprimer.php?module=<?= $r["id_module"]; ?>">Supprimer</a>
            </td>
        </tr>
        <?php endforeach;  }; ?>
    </tbody>
  </table>
</div>


<!-- for supprimer and modifier-->
<?php 
if(isset($_GET['erreur']) && $_GET['erreur'] === 'true')
  {
    echo"<div class='alert alert-danger mt-3'>cannot delete a module that doesn't exist</div>";
  }
elseif(isset($_GET['success']) && $_GET['success'] === 'true')
  {
    echo'<div class="alert alert-success mt-3">module supprimer avec success</div>';
  }
  
if(isset($_GET['module']) && $_GET['module'] === "false") 
  {
    echo"<div class='alert alert-danger mt-3'>module doesn't exist</div>";
  }
if(isset($_GET['access']) && $_GET['access'] === "false") 
  {
    echo"<div class='alert alert-danger mt-3'>choose a module to modifie</div>";
  }  
?>













</body>
</html>