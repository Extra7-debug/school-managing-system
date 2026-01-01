<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Sample Form</title>
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

<body class="bg-light p-5">

<?php
session_start();

if(!isset($_SESSION["admin"]))
    {
      header("location: ../login.php");
      exit();
    }
?>



<div class="container">
    <h2 class="mb-4">➕ Ajouter un stagiaire</h2>
    <form action="" method="post" enctype="multipart/form-data">
      <div class="mb-3">
        <label for="nom" class="form-label">Nom stagiaire</label>
        <input type="text" class="form-control" id="nom" name="nom" placeholder="nom">
      </div>

      <div class="mb-3">
        <label for="prenom" class="form-label">Prénom stagiaire</label>
        <input type="text" class="form-control" name="prenom" id="prenom" placeholder="prenom">
      </div>

        <div class="mb-3">
            <label class="form-label d-block">Genre stagiaire</label>

            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="genre" id="genre_male" value="male">
                <label class="form-check-label" for="genre_male">Homme</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="genre" id="genre_female" value="female">
                <label class="form-check-label" for="genre_female">Femme</label>
            </div>
        </div>      

      <div class="mb-3">
        <label for="tele" class="form-label">Téléphone stagiaire</label>
        <input type="number" class="form-control" id="tele" name="tele" placeholder="telephone">
      </div>

       <div class="mb-3">
        <label for="login" class="form-label">Login stagiaire</label>
        <input type="text" class="form-control" id="login" name="login" placeholder="login">
      </div>

      <div class="mb-3">
        <label for="mp" class="form-label">mot de passe stagiaire</label>
        <input type="text" class="form-control" id="mp" name="mp" placeholder="mot de pass">
      </div>

        <div class="mb-3">
            <label class="form-label d-block">Box stagiaire</label>

            <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" name="check[]" id="check_male" value="check1">
                <label class="form-check-label" for="check_male">check1</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" name="check[]" id="check_female" value="check2">
                <label class="form-check-label" for="check_female">check2</label>
            </div>
        </div>

      <div class="mb-3">
        <label for="image" class="form-label">Image</label>
        <input type="file" class="form-control" id="image" name="image">
      </div>
      

      <button type="submit" class="btn btn-primary">Enregistrer</button>
      <a href="list.php" class="btn btn-secondary">Annuler</a>
    </form>
</div>

<?php

if ($_SERVER["REQUEST_METHOD"] == "POST")
{
    if(isset($_POST['nom'],$_POST['prenom'],$_POST['tele'],$_POST['login'],$_POST['mp'],$_FILES['image']))
        {
            $nom = htmlspecialchars(trim($_POST['nom']));
            $prenom = htmlspecialchars(trim($_POST['prenom']));
            $tele = htmlspecialchars(trim($_POST['tele']));
            $login = htmlspecialchars(trim($_POST['login']));
            $mp = htmlspecialchars(trim($_POST['mp']));
            $genre = isset($_POST['genre']) ? htmlspecialchars(trim($_POST['genre'])) : '';
            $check = isset($_POST['check']) ? $_POST['check'] : [];
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

            if(empty($nom))
                {
                    $err[] = 'nom obligatoire';
                }
            if(empty($prenom))
                {
                    $err[] = 'prenom obligatoire';
                }
            if(empty($genre))
                {
                    $err[] = 'genre obligatoire';
                }
            if(empty($check))
                {
                    $err[] = 'check obligatoire';
                }            
            if(empty($tele))
                {
                    $err[] = 'telephone obligatoire';
                }
            elseif(!ctype_digit($tele))
                {
                    $err[] = 'telephone doit etre un numbre';
                }    
            elseif(!preg_match('/^0[5-7]\d{8}$/', $tele))
                {
                    $err[] = 'telephone invalid';
                } 
            if(empty($login))
                {
                    $err[] = 'login obligatoire';
                }
            if(empty($mp))
                {
                    $err[] = 'mot de passe obligatoire';
                }        
        
                
                
            if(!empty($err))
                {
                    echo'<div class="alert alert-danger mt-3"><ul class="mb-0">';
                    foreach($err as $e)
                        {
                            echo"<li>". htmlspecialchars($e) ."</li>";
                        }
                    echo'</ul></div>';    
                }
            else
                {
                    require "../../connexion.php";
                        try{ 
                                $n = $nom;
                                $p = $prenom;
                                $t = $tele;
                                $g = $genre;
                                $c = implode(',',$check);
                                $l = $login;
                                $m = $mp;
                                $d = $destination;

                                
                                $sql = "INSERT INTO stagiaire (nom_stg,prénom_stg,téléphone_stg,genre_stg,check_stg,login_stg,mot_de_passe_stg,image_stg) VALUES (:nom,:prenom,:tele,:genre,:checks,:logi,:mp,:img)";
                                $stmt = $pdo -> prepare($sql);
                                $stmt -> execute([':nom'=>$n,':prenom'=>$p,':tele'=>$t,':genre'=>$g,':checks'=>$c,':logi'=>$l,':mp'=>$m,':img'=>$d]);     

                                echo '<div class="alert alert-success mt-3">Stagiaire ajouté avec succès!!!</div>';
                            }
                        catch(PDOException $e)
                            {
                                echo"Erreur a l'execution". $e -> getMessage();
                            } 
                
                }    
                
                    
        };
}
// else
// {
// echo '<div class="alert alert-danger mt-3">gender obligatoir!!!</div>';
// }
    

?>
</body>
</html>
