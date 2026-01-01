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
    <div>Liste des examens</div>
    <a href="../dashboard.php" class="btn btn-outline-light btn-sm">retourn</a>
</div>
<div class="header" style="background-color: white;">
    <a class="btn btn-outline-light btn-success" href="ajouter.php">+ Ajouter un examen</a>
</div>


    
<?php

require "../../connexion.php";

$sql = "SELECT * FROM examen e JOIN module m On e.id_module = m.id_module";
$stmt = $pdo -> prepare($sql);
$stmt -> execute();
$resultat = $stmt -> fetchAll(PDO::FETCH_ASSOC);

if(!$resultat)
  {
    echo'<div class="alert alert-danger container mt-4">No examen enregistrer</div>';
  }
else
  {
?>

<div class="container mt-4">
  <table class="table table-bordered table-striped">
    <thead class="table-dark">
      <tr>
        <th>ID</th>
        <th>Type</th>
        <th>Date</th>
        <th>Salle</th>
        <th>Module</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
        <tr>
            <?php foreach($resultat as $r): ?>

            <td> <?php echo $r["id_examen"]; ?> </td>

            <td> <?php echo $r["type_examen"]; ?> </td>

            <td> <?php echo $r["date_examen"]; ?> </td>

            <td> <?php echo $r["salle_examen"]; ?> </td>

            <td> <?php echo $r["nom_module"]; ?> </td>

            <td>
                <a class="btn btn-primary" href="modifier.php?id=<?= $r["id_examen"] ?>">Modifier</a>
                <a class="btn btn-danger" href="supprimer.php?id=<?= $r["id_examen"] ?>">Supprimer</a>
            </td>
        </tr>
        <?php endforeach; }; ?>
    </tbody>
  </table>
</div>


<?php

if(isset($_GET['erreur']) && $_GET['erreur'] === 'true')
{
echo"<div class='alert alert-danger mt-3'>cannot delete an exam that doesn't exist</div>";
}
if(isset($_GET['success']) && $_GET['success'] === 'true')
{
echo"<div class='alert alert-success mt-3'>Exam delete evec success</div>";
}
if(isset($_GET['id']) && $_GET['id'] === 'false')
{
echo"<div class='alert alert-danger mt-3'>No exam exist</div>";
}
if(isset($_GET['exam']) && $_GET['exam'] === 'false')
{
echo"<div class='alert alert-danger mt-3'>No exam exist</div>";
}


?>













</body>
</html>