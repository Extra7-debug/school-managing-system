<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Connexion Stagiaire</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light d-flex justify-content-center align-items-center vh-100">


<div class="card shadow p-4" style="min-width: 350px;">
  <h4 class="text-light text-center bg-black mb-4 w-100 py-2">Connexion Administrateur</h4>
  <form action="" method="POST">
    <div class="mb-3">
      <label for="login" class="form-label">Identifiant</label>
      <input type="text" name="login" id="login" class="form-control" required>
    </div>

    <div class="mb-3">
      <label for="mot_de_passe" class="form-label">Mot de passe</label>
      <input type="password" name="password" id="mdp" class="form-control" required>
    </div>

    <button type="submit" class="btn btn-primary w-100 mb-2">Se connecter</button>
    <a class="btn btn-danger w-100" href="../index.php">Return</a>
  </form>
</div>



<?php

session_start();
if ($_SERVER["REQUEST_METHOD"] =="POST")
{
    if(isset($_POST["login"],$_POST["password"]))
    {
        $login = htmlspecialchars(trim($_POST["login"]));
        $mdp = htmlspecialchars(trim($_POST["password"]));

        $err = [];

        if(empty($login))
        {
            $err[] = "mode de pass required!";
        };
        if(empty($mdp))
        {
            $err[] = "password required!";
        };
        if(!empty($err))
        {
            echo "<div class=' alert alert-danger'><ul>";
            foreach($err as $e)
            {
                echo "<li>".$e."</li>";
            }
            echo "</ul></div>";

        }
        else
        {
            require "../connexion.php";

            try
              {
                  $sql = "SELECT * FROM administrateur WHERE login_admin = :l AND mot_de_passe_admin = :m";
                  $stmt = $pdo -> prepare($sql);
                  $stmt -> execute([":l"=>$login,":m"=>$mdp]);
                  $admin = $stmt -> fetch(PDO::FETCH_ASSOC);

                  if($admin)
                  {
                    $_SESSION['admin'] = $admin;
                    header("location:dashboard.php");
                    exit();
                  }
                  else
                  {
                    echo"<div class=' alert alert-danger m-4' >Admin doesn't exist</div>";
                  }
              }
            catch(PDOException $e)
              {
                echo"Erreur a l'execution". $e -> getMessage();
              }









        }









    }
}










?>




</body>
</html>
