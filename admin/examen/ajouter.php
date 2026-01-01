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
    <h2 class="mb-4">➕ Ajouter un examen</h2>
    <form action="" method="post">
      <div class="mb-3">
        <label for="text1" class="form-label">Type d'examen</label>
        <input type="text" class="form-control" id="text1" name="type" placeholder="Ex:Controle continu">
      </div>

      <div class="mb-3">
        <label for="date" class="form-label">Date de l'examen</label>
        <input type="date" class="form-control" name="date" id="date">
      </div>

      <div class="mb-3">
        <label for="text2" class="form-label">Salle</label>
        <input type="text" class="form-control" id="text2" name="salle" placeholder="Ex:Salle A2">
      </div>

      <div class="mb-3">
        <label for="select" class="form-label">Module associe</label>
        <select class="form-select" id="select" name="module">
            <option selected disabled>--Choisir un module--</option>
                    <?php
                        require '../../connexion.php';
                        try
                        {
                            $sql = 'SELECT id_module, nom_module FROM module ORDER BY nom_module';;
                            $stmt = $pdo -> prepare($sql);
                            $stmt -> execute();
                            $module = $stmt -> fetchAll(PDO::FETCH_ASSOC);

                            if($module)
                            {
                                foreach($module as $m):
                                    
                    ?>

            <option value="<?= htmlspecialchars($m["id_module"]) ?>"> <?= htmlspecialchars($m["nom_module"]) ?> </option>
                        
                    
                    <?php endforeach;
                                    
                            }        
                        }catch(PDOException $e)
                        {
                            echo'Erreur de execution' . $e -> getMessage();
                        }
                    ?>
        </select>
      </div>

      <button type="submit" class="btn btn-primary">Enregistrer</button>
      <a href="list.php" class="btn btn-secondary">Annuler</a>
    </form>
</div>

<?php

if ($_SERVER["REQUEST_METHOD"] == "POST")
{
    if(isset($_POST['type'],$_POST['date'],$_POST['salle'],$_POST['module']))
        {
            $type = htmlspecialchars(trim($_POST['type']));
            $date = htmlspecialchars(trim($_POST['date']));
            $salle = htmlspecialchars(trim($_POST['salle']));
            $module = htmlspecialchars(trim($_POST['module']));
            $err = [];


            if(empty($type))
                {
                    $err[] = 'type obligatoire';
                }
            if(empty($date))
                {
                    $err[] = 'date obligatoire';
                }
            if(!preg_match('/^\d{4}-\d{2}-\d{2}$/', $date))
                {
                    $err[] = 'date invalide';
                } 
            if(empty($salle))
                {
                    $err[] = 'salle obligatoire';
                }
            if(empty($module))
                {
                    $err[] = 'module obligatoire';
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
                                $t = $type;
                                $d = $date;
                                $s = $salle;
                                $m = $module;

                                $sql = "INSERT INTO examen (type_examen,date_examen,salle_examen,id_module) 
                                        VALUES (:typex,:datex,:sallex,:modulex)";

                                $stmt = $pdo -> prepare($sql);
                                $stmt -> execute([':typex'=>$t,':datex'=>$d,':sallex'=>$s,':modulex'=>$m]);     

                                echo '<div class="alert alert-success mt-3">Examen ajouté avec succès.</div>';
                            }
                        catch(PDOException $e)
                            {
                                echo"Erreur a l'insertion". $e -> getMessage();
                            } 
                
                }    
                
                    
        };
}

?>
</body>
</html>
