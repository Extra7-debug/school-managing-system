<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Modifier mon profil</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    .navbar-custom {
      background-color: #007bff;
    }
    .nav-link, .navbar-brand {
      color: white !important;
    }
    .form-container {
      max-width: 600px;
      margin: 50px auto;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
      border-radius: 8px;
    }
    .form-header {
      background-color: #007bff;
      color: white;
      padding: 15px;
      border-top-left-radius: 8px;
      border-top-right-radius: 8px;
      text-align: center;
      font-weight: bold;
    }
  </style>
</head>
<body>

<?php

use BcMath\Number;

session_start();
if (!isset($_SESSION["stagiaire"]))
{
    header("location:login.php");
    exit();
}

$id = $_SESSION["stagiaire"]["id_stg"];

require "../connexion.php";

$sql = "SELECT * FROM stagiaire WHERE id_stg = :i";
$stmt = $pdo -> prepare($sql);
$stmt -> execute([":i"=>$id]);
$result = $stmt -> fetch(PDO::FETCH_ASSOC);

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

<div class="form-container bg-white">
  <div class="form-header">
    Modifier mon profil
  </div>
  <form action="" method="POST" class="p-4" enctype="multipart/form-data">

    <div class="mb-3">
      <label for="nom" class="form-label">image</label> <br>
      <img src="../admin/stagiaire/<?= $result["image_stg"]  ?>" alt="NO image was found"  class="img-thumbnail" style="max-width: 150px;">
    </div>

    <div class="mb-3">
      <label for="nom" class="form-label">Nom</label>
      <input type="text" class="form-control" id="nom" name="nom" value="<?= $result["nom_stg"] ?>">
    </div>

    <div class="mb-3">
      <label for="prenom" class="form-label">Prénom</label>
      <input type="text" class="form-control" id="prenom" name="prénom" value="<?= $result["prénom_stg"] ?>">
    </div>

    <div class="mb-3">
      <label for="telephone" class="form-label">Téléphone</label>
      <input type="text" class="form-control" id="telephone" name="téléphone" value="<?= $result["téléphone_stg"] ?>">
    </div>

    <div class="mb-3">
      <label for="login" class="form-label">Login</label>
      <input type="text" class="form-control" id="login" name="login" value="<?= $result["login_stg"] ?>">
    </div>

      <button type="submit" class="btn btn-primary w-100" name="profil_update">Update Profile</button>
  </form>

  <form action="" method="POST" class="p-4">

    <h6 class="text-primary mt-4">Modifier le mot de passe</h6>

    <div class="mb-3">
      <label for="newPass" class="form-label">Nouveau mot de passe</label>
      <input type="password" class="form-control" id="newPass" name="newpass">
    </div>

    <div class="mb-3">
      <label for="confirmPass" class="form-label">Confirmer le mot de passe</label>
      <input type="password" class="form-control" id="confirmPass" name="confirmpass">
    </div>

    <button type="submit" class="btn btn-primary w-100" name="password_update">Update mot de passe</button>
  </form>
</div>


<?php


if($_SERVER["REQUEST_METHOD"] == "POST")
{
if(isset($_POST["nom"] , $_POST["prénom"] , $_POST["téléphone"] , $_POST["login"]))
{
  if(isset($_POST['profil_update']))
  {
    $nom = htmlspecialchars(trim($_POST["nom"]));
    $prenom = htmlspecialchars(trim($_POST["prénom"]));
    $tele = htmlspecialchars(trim($_POST["téléphone"]));
    $login = htmlspecialchars(trim($_POST["login"]));
    $err = [];



    if (empty($nom))
    {
        $err[] = "nom obligatoire";
    }
    if (empty($prenom))
    {
        $err[] = "prenom obligatoire";
    }
    if (empty($tele))
    {
        $err[] = "telephone obligatoire";
    }
    elseif(!is_numeric($tele))
    {
        $err[] = "invalide telephone";
    }
    elseif(!preg_match('/^06\d{8})$/',$tele))
    {
      $err[] = "telephone non morocain";
    }
    if (empty($login))
    {
        $err[] = "login obligatoire";
    }
    if(!empty($err))
    {
        echo"<div class=' alert alert-danger mx-auto' ><ul>";
        foreach($err as $e)
        {
            echo"<li>$e</li>";
        }
        echo"</ul></div>";
    }
    else
    {   
        $ids = $_SESSION['stagiaire']["id_stg"];
        $n = $nom;
        $p = $prenom;
        $t = $tele;
        $l = $login;
      try
      {

      
        $sql = "UPDATE stagiaire SET nom_stg = :n,prénom_stg = :p,téléphone_stg = :t,login_stg = :l WHERE id_stg = :id";
        $stmt = $pdo -> prepare($sql);
        $stmt -> execute([":n"=>$n,":p"=>$p,":t"=>$t,":l"=>$l,":id"=>$ids]);
          header('location:profil.php?p_success=true');
      }catch(PDOException $e)
      {
          echo'<div class="alert alert-danger mt-3">PDO Erreur</div>'. $e -> getMessage();
      }
    }
  }
}
}

if($_SERVER['REQUEST_METHOD'] == 'POST')
  {
    if(isset($_POST['newpass'],$_POST['confirmpass']))
      {
        if(isset($_POST['password_update']))
        {

          $new = htmlspecialchars(trim($_POST['newpass']));
          $confirm = htmlspecialchars(trim($_POST['confirmpass']));
          $err = [];



          if(empty($new))
            {
              $err[] = 'new password obligatoire';
            }
          if(empty($confirm))
            {
              $err[] = 'confirm password obligatoire';
            }  
          if($new != $confirm)
            {
              $err[] = "passwords do not match"; 
            }
          if(!empty($err))
            {
                echo"<div class=' alert alert-danger mx-auto' ><ul>";
                foreach($err as $e)
                {
                    echo"<li>$e</li>";
                }
                echo"</ul></div>";
            }
          else
            {
                $ids = $_SESSION['stagiaire']["id_stg"];
                $n = $new;
                try
                {
                  $sql = 'UPDATE stagiaire SET mot_de_passe_stg = :n WHERE id_stg = :ids';
                  $stmt = $pdo -> prepare($sql);
                  $stmt -> execute([':n'=>$n,':ids'=>$ids]);
                  header('location:profil.php?m_success=true');
                }
                catch(PDOException $e)
                {
                  echo'<div class="alert alert-danger mt-3">PDO Erreur</div>'. $e -> getMessage();
                }
            }
        }    
      }
  }
?>


<?php
if(isset($_GET['p_success']) && $_GET['p_success'] === 'true')
  {
    echo'<div class="alert alert-success mt-3">profile update avec success</div>';
  }
if(isset($_GET['m_success']) && $_GET['m_success'] === 'true')
  {
    echo'<div class="alert alert-success mt-3">mot de passe update avec success</div>';
  }
?>






</body>
</html>







