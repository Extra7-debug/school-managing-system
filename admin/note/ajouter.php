<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Document</title>
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

    <div class="container">
    <h2 class="mb-4">➕ Ajouter une note</h2>
    <form action="" method="post">
      

     <div class="mb-3">
        <label for="stagiaire" class="form-label">Stagiaire</label>
        <select class="form-select" id="stagiaire" name="stagiaire">
            <option selected disabled>--Selectionnez un stagiaire--</option>
                    <?php
                        require '../../connexion.php';
                        try
                        {
                            $sql = 'SELECT id_stg, nom_stg FROM stagiaire';;
                            $stmt = $pdo -> prepare($sql);
                            $stmt -> execute();
                            $stagiaire = $stmt -> fetchAll(PDO::FETCH_ASSOC);

                            if($stagiaire)
                            {
                                foreach($stagiaire as $stg):
                                    
                    ?>

            <option value="<?= htmlspecialchars($stg["id_stg"]) ?>"> <?= htmlspecialchars($stg["nom_stg"]) ?> </option>
                        
                    
                    <?php endforeach;
                                    
                            }        
                        }catch(PDOException $e)
                        {
                            echo'Erreur de execution' . $e -> getMessage();
                        }
                    ?>
        </select>
      </div>

      <div class="mb-3">
        <label for="examen" class="form-label">Examen</label>
        <select class="form-select" id="examen" name="examen">
            <option selected disabled>--Selectionnez un examen--</option>
                    <?php
                        require '../../connexion.php';
                        try
                        {
                            $sql = 'SELECT e.id_examen, m.nom_module FROM examen e JOIN module m ON e.id_module = m.id_module';;
                            $stmt = $pdo -> prepare($sql);
                            $stmt -> execute();
                            $examen = $stmt -> fetchAll(PDO::FETCH_ASSOC);

                            if($examen)
                            {
                                foreach($examen as $ex):
                                    
                    ?>

            <option value="<?= htmlspecialchars($ex["id_examen"]) ?>"> <?= htmlspecialchars($ex["nom_module"]) ?> </option>
                        
                    
                    <?php endforeach;
                                    
                            }        
                        }catch(PDOException $e)
                        {
                            echo'Erreur de execution' . $e -> getMessage();
                        }
                    ?>
        </select>
      </div>

      <div class="mb-3">
        <label for="note" class="form-label">Note (0 - 20)</label>
        <input type="text" class="form-control" id="note" name="note">
      </div>

      <button type="submit" class="btn btn-primary">Ajouter</button>
      <a href="list.php" class="btn btn-secondary">Annuler</a>
    </form>
</div>


<?php

if($_SERVER["REQUEST_METHOD"] == "POST")
{
    if(isset($_POST["stagiaire"],$_POST["examen"],$_POST["note"]))
        {
            $stagiaire = htmlspecialchars(trim($_POST["stagiaire"]));
            $examen = htmlspecialchars(trim($_POST["examen"]));
            $note = htmlspecialchars(trim($_POST["note"]));
            $err = [];



            if(empty($stagiaire))
                {
                    $err[] = "stagiaire obligatoire";
                }
            if(empty($examen))
                {
                    $err[] = "please choose an examen";
                }
            if(empty($note))
                {
                    $err[] = "note obligatoire";
                }
            elseif(!is_numeric($note))
                {
                    $err[] = "note has to be a number";
                }
            elseif($note > 20 || $note < 0)
                {
                    $err[] = "note has to be between 0 and 20!";
                }    
            
                


            if(!empty($err))
                {
                    echo'<div class="alert alert-danger mt-3"><ul class="mb-0">';
                    foreach($err as $e)
                        {
                            echo'<li>'. htmlspecialchars($e).'</li>';
                        }
                    echo'</ul></div>';    
                }
            else
                {
                    require "../../connexion.php";

                    $s = $stagiaire;
                    $e = $examen;
                    $n = $note;

                    $sql1 ='SELECT id_stg,id_examen FROM notes WHERE id_stg = :s AND id_examen = :e';
                    $stmt1 = $pdo -> prepare($sql1);
                    $stmt1 -> execute([':s'=>$s,':e'=>$e]);
                    $exist = $stmt1 -> fetch(PDO::FETCH_ASSOC);

                    if($exist)
                    {
                        echo '<div class="alert alert-warning mt-3">⚠️ Ce stagiaire a déjà une note pour cet examen.</div>';
                    }
                    else
                    {
                        $sql = "INSERT INTO notes (id_stg,id_examen,note)
                                VALUES (:s,:e,:n)";
                        $stmt = $pdo -> prepare($sql);
                        $stmt -> execute([':s'=>$s,':e'=>$e,':n'=>$n]);
                        echo '<div class="alert alert-success mt-3">✅note ajouté avec succès.</div>';
                    }
                }        
        }
}

?>
</body>
</html>