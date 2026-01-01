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
if(isset($_GET['id_stg'],$_GET['examen_id'],$_GET['nom_stg'],$_GET['prénom_stg'],$_GET['nom_module']))
    {
       $id_s = htmlspecialchars(trim($_GET['id_stg']));
       $id_e = htmlspecialchars(trim($_GET['examen_id']));
       $nom_s =htmlspecialchars(trim($_GET['nom_stg']));
       $prenom_s =htmlspecialchars(trim($_GET['prénom_stg']));
       $nom_m =htmlspecialchars(trim($_GET['nom_module']));
       
            require '../../connexion.php';
          try
          {
            $sql = 'SELECT * FROM notes WHERE id_stg = :s AND id_examen = :e';
            $stmt = $pdo -> prepare($sql);
            $stmt -> execute([':s'=>$id_s,':e'=>$id_e]);
            $note_stg = $stmt -> fetch(PDO::FETCH_ASSOC);
          }  
          catch(PDOException $e)
          {
            echo'<div class="alert alert-danger mt-3">PDO Erreur</div>'. $e -> getMessage();
          }

            if (!$note_stg)
                {
                    header('location: list.php?note=false');
                    exit();
                }
            else
                {
                   ?>
<div class="container">
    <h2 class="mb-4 alert alert-info text-center">Modifer note</h2>
    <form action="" method="post">

      <div class="mb-3">
        <label for="id" class="form-label">ID Stagiaire:</label>
        <input type="hidden" class="form-control" id="id" name="id_input" value="<?= htmlspecialchars($note_stg['id_stg']) ?>" readonly >
        <p> <?= htmlspecialchars($note_stg['id_stg']) ?></p>
      </div>

      <div class="mb-3">
        <label for="id" class="form-label">Nom Complete Stagiaire:</label>
        <p> <?= htmlspecialchars($nom_s).' '.htmlspecialchars($prenom_s) ?></p>
      </div>

      <div class="mb-3">
        <label for="examen" class="form-label">ID Examen:</label>
        <input type="hidden" class="form-control" id="examen" name="examen_input" value="<?= htmlspecialchars($note_stg['id_examen']) ?>" readonly>
        <p> <?= htmlspecialchars($note_stg['id_examen']) ?></p>
      </div>

      <div class="mb-3">
        <label for="id" class="form-label">Examen module:</label>
        <p> <?= htmlspecialchars($nom_m)?></p>
      </div>

      <div class="mb-3">
        <label for="note" class="form-label">New Note:</label>
        <input type="number" class="form-control" id="note" name="note" value="<?= htmlspecialchars($note_stg['note']) ?>">
      </div>

      <button type="submit" class="btn btn-primary">Enregistrer les Modifications</button>
      <a href="list.php" class="btn btn-secondary">Annuler</a>
    </form>
</div>                   
                   

<?php
                    
            }    

    if($_SERVER['REQUEST_METHOD'] == 'POST')
        {
            if(isset($_POST['id_input'],$_POST['examen_input'],$_POST['note']))
                {
                    $not = htmlspecialchars(trim($_POST['note']));
                    $st = htmlspecialchars(trim($_POST['id_input']));
                    $exa = htmlspecialchars(trim($_POST['examen_input']));
                    $err = [];






                    if(empty($st))
                        {
                            $err[] = 'stagiaire obligatoire';
                        }
                    if(empty($exa))
                        {
                            $err[] = 'exam obligatoire';
                        }
                    if(empty($not))
                        {
                            $err[] = 'note obligatoire';
                        }
                    if(!is_numeric($not))
                        {
                            $err[] = 'note doit etre un nombre';
                        }
                    if($not < 0 || $not > 20)
                        {
                            $err[] = 'note has to be between 0 and 20';
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
                            $n = $not;
                            $s = $st;
                            $e = $exa;
                            try
                            {
                                $sql = 'UPDATE notes SET note = :n WHERE id_stg = :s AND id_examen = :e';
                                $stmt = $pdo -> prepare($sql);
                                $stmt -> execute([':n'=>$n,':s'=>$s,':e'=>$e]);
                                echo'<div class="alert alert-success mt-3">Note modifier avec success!!</div>';  
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