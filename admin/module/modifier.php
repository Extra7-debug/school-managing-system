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


<?php
if(isset($_GET['module']))
    {
       $module = htmlspecialchars(trim($_GET['module']));

       if(empty($module))
        {
            header('location: list.php?module=false');
            exit();
        }
        else
        {
            require '../../connexion.php';
            $sql = 'SELECT * FROM module WHERE id_module = :m';
            $stmt = $pdo -> prepare($sql);
            $stmt -> execute([':m'=>$module]);
            $modules = $stmt -> fetch(PDO::FETCH_ASSOC);

            if (!$modules)
                {
                    header('location: list.php?module=false');
                    exit();
                }
            else
                {
                   ?>
<div class="container">
    <h2 class="mb-4 alert alert-info">Modifer module</h2>
    <form action="" method="post">
      <div class="mb-3">
        <label for="nom" class="form-label">Nom de module</label>
        <input type="text" class="form-control" id="nom" name="nom" value="<?= htmlspecialchars(trim($modules['nom_module'])) ?>">
      </div>

      <div class="mb-3">
        <label for="type" class="form-label">Type de module</label>
        <input type="text" class="form-control" name="type" id="type" value="<?= htmlspecialchars(trim($modules['type_module'])) ?>">
      </div>

      <div class="mb-3">
        <label for="masse" class="form-label">Masse horaire</label>
        <input type="number" class="form-control" id="masse" name="masse" value="<?= htmlspecialchars(trim($modules['masse_horaire_module'])) ?>">
      </div>

      <button type="submit" class="btn btn-primary">Enregistrer les Modifications</button>
      <a href="list.php" class="btn btn-secondary">Annuler</a>
    </form>
</div>                   
                   

<?php
                    
            }    
        }

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
                            $err[] = 'nom de module est obligatoire';
                        }
                    if(empty($type))
                        {
                            $err[] = 'type de module est obligatoire';
                        } 
                    if(empty($masse))
                        {
                            $err[] = 'masse horaire de module est obligatoire';
                        }
                    if(!ctype_digit($masse))
                        {
                            $err[] = 'masse horaire doit etre un nombre';
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
                            $t = $type;
                            $m = $masse;
                            try
                            {
                                $sql = 'UPDATE module SET nom_module = :n ,type_module = :t ,masse_horaire_module = :m WHERE id_module = :mo';
                                $stmt = $pdo -> prepare($sql);
                                $stmt -> execute([':n'=>$n,':t'=>$t,':m'=>$m,'mo'=>$module]);
                                echo'<div class="alert alert-success mt-3">Module modifier avec success!!</div>';  
                            }
                            catch(PDOException $e)
                            {
                                echo'<div class="alert alert-danger mt-3">PDO Erreur</div>'. $e -> getMessage();
                            }
      
                        }       


                }
        }    
    }
else
    {
        header('location:list.php?access=false');
        exit();
    }    
?>








    
</body>
</html>