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
    <div>Liste des notes</div>
    <a href="../dashboard.php" class="btn btn-outline-light btn-sm">retourn</a>
</div>
<div class="header" style="background-color: white;">
    <a class="btn btn-outline-light btn-success" href="ajouter.php">+ Ajouter un note</a>
</div>

    
<?php

require "../../connexion.php";

$sql = "SELECT s.id_stg,s.nom_stg,s.prénom_stg,m.nom_module,e.id_examen,e.type_examen,n.note FROM stagiaire s 
        JOIN notes n ON s.id_stg = n.id_stg 
        JOIN examen e ON n.id_examen = e.id_examen 
        JOIN module m ON e.id_module = m.id_module 
        ORDER BY s.nom_stg ";
$stmt = $pdo -> prepare($sql);
$stmt -> execute();
$resultat = $stmt -> fetchAll(PDO::FETCH_ASSOC);

if(!$resultat)
    {
       echo'<div class="alert alert-danger  container mt-4">‼️No note exist</div>';
    }

else
{
  ?>

<div class="container mt-4">
  <table class="table table-bordered table-striped">
    <thead class="table-dark">
      <tr>
        <th>Stagiaire</th>
        <th>Module</th>
        <th>Examen</th>
        <th>Note</th>
        <th>Action</th>
      </tr>-
    </thead>
    <tbody>
        <tr>
            <?php foreach($resultat as $r): ?>

            <td> <?php echo $r["nom_stg"]; ?> </td>

            <td> <?php echo $r["nom_module"]; ?> </td>

            <td> <?php echo $r["type_examen"]; ?> </td>

            <td> <?php echo $r["note"]; ?> </td>

            <td>
                <a class="btn btn-primary" href="modifier.php?id_stg=<?= $r['id_stg']?>&nom_stg=<?= $r['nom_stg']?>&prénom_stg=<?= $r['prénom_stg']?>&examen_id=<?= $r['id_examen']?>&nom_module=<?= $r['nom_module']?>">Modifier</a>
                <a class="btn btn-danger" href="supprimer.php?id_stg=<?= $r["id_stg"] ?>&id_examen=<?= $r["id_examen"] ?>">Supprimer</a>
            </td>
        </tr>
        <?php endforeach; }; ?>
    </tbody>
  </table>
</div>

<!-- for supprimer -->
<?php 
if(isset($_GET['erreur']) && $_GET['erreur'] === 'true')
  {
    echo'<div class="alert alert-danger mt-3">‼️cannot delete from empty Id</div>';
  }
elseif(isset($_GET['success']) && $_GET['success'] === 'true')
  {
    echo'<div class="alert alert-success mt-3">✅note supprimer avec success</div>';
  }  
?>


</body>
</html>