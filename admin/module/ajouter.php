<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>



<?php
session_start();
if(!isset($_SESSION['admin']))
    {
        header('location: ../login.php');
        exit();
    }
?>


<div class="container">
    <h2 class="mb-4">➕ Ajouter un module</h2>
    <form action="" method="post">
      <div class="mb-3">
        <label for="nom" class="form-label">Nom de module</label>
        <input type="text" class="form-control" id="nom" name="nom" placeholder="Module Nom">
      </div>

      <div class="mb-3">
        <label for="type" class="form-label">type de module</label>
        <input type="text" class="form-control" name="type" id="type" placeholder="Module Type">
      </div>

      <div class="mb-3">
        <label for="masse" class="form-label">Masse horaire</label>
        <input type="number" class="form-control" name="masse" id="masse"  placeholder="Masse Horaire de Module">
      </div>


      <button type="submit" class="btn btn-primary">Enregistrer</button>
      <a href="list.php" class="btn btn-secondary">Annuler</a>
    </form>
</div>


<?php

if($_SERVER['REQUEST_METHOD'] == 'POST')
    {
        if(isset($_POST['nom'],$_POST['type'],$_POST['masse']))
            {
                $nom = htmlspecialchars(trim($_POST['nom']));
                $type = htmlspecialchars(trim($_POST['type']));
                $masse = htmlspecialchars(trim($_POST['masse']));
                $err = [];




                if(empty($nom))
                    {
                        $err[] = 'nom obligatoire';
                    }
                if(empty($type))
                    {
                        $err[] = 'type obligatoire';
                    }
                if(empty($masse))
                    {
                        $err[] = 'masse horaire obligatoire';
                    }
                elseif(!is_numeric($masse))
                    {
                        $err[] = 'masse horaire doit etre un nombre';
                    }  


                if(!empty($err))
                    {
                        echo'<div class="alert alert-danger mt-3"><ul class="mb-0">';
                        foreach($err as $e)
                            {
                                echo'<li>' . htmlspecialchars(trim($e)) . '</li>';
                            }
                        echo'</ul></div>';   
                    }
                else
                    {
                        require '../../connexion.php';

                        $n = $nom;
                        $t = $type;
                        $m = $masse;

                        try
                            {
                                $sql = 'INSERT INTO module (nom_module,type_module,masse_horaire_module)
                                        VALUES (:n,:t,:m)';
                                $stmt = $pdo -> prepare($sql);
                                $stmt -> execute([':n'=>$n,':t'=>$t,':m'=>$m]);  

                                echo'<div class="alert alert-success mt-3">Module ajouter avec success!!!</div>';      
                            }
                        catch(PDOException $e)
                            {
                                echo'<div class="alert alert-danger mt-3">PDO Exception Erreur!!</div>', $e -> getMessage();
                            }    
                    }        


            }
    }

?>
</body>
</html>