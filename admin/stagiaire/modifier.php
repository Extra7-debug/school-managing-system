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

session_start();
if (!isset($_SESSION["admin"]))
{
    header("location:../login.php");
    exit();
}

if(isset($_GET['stg']))
{
    $stg = htmlspecialchars(trim($_GET['stg']));

    if(empty($stg))
        {
            exit('<div class="alert alert-danger mt-3">Cannot search empty Id</div>');

        }
    else
    {
        require "../../connexion.php";
        try
        {
            $sql = "SELECT * FROM stagiaire WHERE id_stg = :i";
            $stmt = $pdo -> prepare($sql);
            $stmt -> execute([":i"=>$stg]);
            $result = $stmt -> fetch(PDO::FETCH_ASSOC);
        }
        catch(PDOException $e)
            {
                echo'<div class="alert alert-danger mt-3">PDO EReeur</div>' . $e -> getMessage();
            }
        if (!$result)
            {
                exit('<div class="alert alert-danger mt-3">stagiaire doesnt exist</div>');
            } 
        else
            {
            ?>

<div class="container">
    <h2 class="mb-4 alert alert-info">Modifer stagiaire info</h2>
    <form action="" method="post" enctype="multipart/form-data">
      <div class="mb-3">
        <label for="nom" class="form-label">Nom stagiaire</label>
        <input type="text" class="form-control" id="nom" name="nom" value="<?= htmlspecialchars(trim($result['nom_stg'])) ?>">
      </div>

      <div class="mb-3">
        <label for="prenom" class="form-label">Prénom stagiaire</label>
        <input type="text" class="form-control" name="prenom" id="prenom" value="<?= htmlspecialchars(trim($result['prénom_stg'])) ?>">
      </div>

      <div class="mb-3">
        <label for="tele" class="form-label">Téléphone stagiaire</label>
        <input type="number" class="form-control" id="tele" name="tele" value="<?= htmlspecialchars(trim($result['téléphone_stg'])) ?>">
      </div>

       <div class="mb-3">
        <label for="login" class="form-label">Login stagiaire</label>
        <input type="text" class="form-control" id="login" name="login" value="<?= htmlspecialchars(trim($result['login_stg'])) ?>">
      </div>

      <div class="mb-3">
        <label for="img" class="form-label">Image stagiaire</label> <br>
        <img src="<?= htmlspecialchars(trim($result['image_stg'])) ?>" alt="IMAGE NOT FOUND" style="width: 100px; height: 70px; border: 3px solid black;">
        <input type="file" class="form-control" id="file" name="image">
      </div>


      <button type="submit" class="btn btn-primary">Enregistrer les Modifications</button>
      <a href="list.php" class="btn btn-secondary">Annuler</a>
    </form>
</div>

<?php
            }    
    }    


if($_SERVER["REQUEST_METHOD"] == "POST")
{
if(isset($_POST["nom"] , $_POST["prenom"] , $_POST["tele"] , $_POST["login"] , $_FILES['image']))
{
    $nom = htmlspecialchars(trim($_POST["nom"]));
    $prenom = htmlspecialchars(trim($_POST["prenom"]));
    $tele = htmlspecialchars(trim($_POST["tele"]));
    $login = htmlspecialchars(trim($_POST["login"]));
    $err = [];




    if($_FILES['image']['error'] === UPLOAD_ERR_OK)
        {
            $image = $_FILES['image'];
            $size = $_FILES['image']['size'];
            $tmp = $image['tmp_name'];
            $name = $image['name'];
            $ext = strtolower(pathinfo($name, PATHINFO_EXTENSION));
            $newName = uniqid() . "." . $ext;
            $destination = "images/" . $newName;

            if($ext !== 'jpg') 
                {
                    $err[] = 'image type must be jpg';
                } 
            else
                {
                            
                    if(!move_uploaded_file($tmp,$destination))
                        {
                            $err[] = 'failed to move image to images';
                        }
                } 
        }
    else
        {
            $err[] = 'image erreur';
        }     


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
    elseif(!ctype_digit($tele))
    {
        $err[] = "telephone doit etre un nombre";
    }
    elseif(!preg_match('/^(0)([5-7])[0-9]{8}$/',$tele))
    {
        $err[] = "Telephone invalid";
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
        $n = $nom;
        $p = $prenom;
        $t = $tele;
        $l = $login;
        $img = $destination;
            
        try
            {
                $sql = "UPDATE stagiaire SET nom_stg = :n,prénom_stg = :p,téléphone_stg = :t,login_stg = :l,image_stg = :img WHERE id_stg = :stg";
                $stmt = $pdo -> prepare($sql);
                $stmt -> execute([":n"=>$n,":p"=>$p,":t"=>$t,":l"=>$l,":img"=>$img,":stg"=>$stg]);
                echo'<div class="alert alert-success mt-3">profile update avec success</div>';
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



</body>
</html>
