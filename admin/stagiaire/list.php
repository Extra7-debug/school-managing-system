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
    <div>Liste des stagiaires</div>
    <a href="../dashboard.php" class="btn btn-outline-light btn-sm">retourn</a>
</div>
<div class="header" style="background-color: white;">
    <a class="btn btn-outline-light btn-success" href="ajouter.php">+ Ajouter un stagiaire</a>
</div>

<?php

require "../../connexion.php";

$sql = "SELECT * FROM stagiaire";
$stmt = $pdo -> prepare($sql);
$stmt -> execute();
$resultat = $stmt -> fetchAll(PDO::FETCH_ASSOC);


if(!$resultat)
    {
      echo'<div class="alert alert-danger  container mt-4">No stagiaire exist</div>';
    }
else
{ ?>

<div class="container mt-4">
  <table class="table table-bordered table-striped">
    <thead class="table-dark">
      <tr>
        <th>ID</th>
        <th>Nom</th>
        <th>Prénom</th>
        <th>Téléphone</th>
        <th>Genre</th>
        <th>Login</th>
        <th>Image</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
        <tr>
            <?php foreach($resultat as $r): ?>

            <td> <?php echo $r["id_stg"]; ?> </td>

            <td> <?php echo $r["nom_stg"]; ?> </td>

            <td> <?php echo $r["prénom_stg"]; ?> </td>

            <td> <?php echo $r["téléphone_stg"]; ?> </td>

            <td> <?php echo $r["genre_stg"]; ?> </td>

            <td> <?php echo $r["login_stg"]; ?> </td>

            <td> <img src="<?php echo $r["image_stg"]; ?>" alt="No image was found" style="width: 100px; height: 70px">  </td>

            <td>
                <a class="btn btn-primary" href="modifier.php?stg=<?= $r['id_stg'] ?>">Modifier</a>
                <a class="btn btn-danger" href="supprimer.php?stg=<?= $r['id_stg'] ?>">Supprimer</a>
            </td>
        </tr>
        <?php endforeach; };  ?>
    </tbody>
  </table>
</div>

<!-- for supprimer -->
<?php 
if(isset($_GET['erreur']) && $_GET['erreur'] === 'true')
  {
    echo'<div class="alert alert-danger mt-3">cannot delete from empty Id</div>';
  }
elseif(isset($_GET['success']) && $_GET['success'] === 'true')
  {
    echo'<div class="alert alert-success mt-3">Stagiaire supprimer avec success</div>';
  }  
?>









</body>
</html>