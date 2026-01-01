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
if(isset($_GET['id']))
    {
       $id = htmlspecialchars(trim($_GET['id']));

       if(empty($id))
        {
            header('location: list.php?id=false');
            exit();
        }
        else
        {
            require '../../connexion.php';
            $sql = 'SELECT e.*,m.nom_module FROM examen e JOIN module m ON e.id_module = m.id_module WHERE e.id_examen = :i';
            $stmt = $pdo -> prepare($sql);
            $stmt -> execute([':i'=>$id]);
            $exam = $stmt -> fetch(PDO::FETCH_ASSOC);

            if (!$exam)
                {
                    header('location: list.php?exam=false');
                    exit();
                }
            else
                {
                   ?>
<div class="container">
    <h2 class="mb-4 alert alert-info">Modifer examen</h2>
    <form action="" method="post">
      <div class="mb-3">
        <label for="type" class="form-label">Type examen</label>
        <input type="text" class="form-control" id="type" name="type" value="<?= htmlspecialchars(trim($exam['type_examen'])) ?>">
      </div>

      <div class="mb-3">
        <label for="date" class="form-label">Date examen</label>
        <input type="date" class="form-control" name="date" id="date" value="<?= htmlspecialchars(trim($exam['date_examen'])) ?>">
      </div>

      <div class="mb-3">
        <label for="salle" class="form-label">Salle examen</label>
        <input type="text" class="form-control" id="salle" name="salle" value="<?= htmlspecialchars(trim($exam['salle_examen'])) ?>">
      </div>

      <div class="mb-3">
        <label for="module" class="form-label">Module Examen</label>
        <select class="form-select" id="module" name="module">
            <option value="<?= $exam['id_module'] ?>">Current exam module : <?= $exam['nom_module'] ?></option>
                    <?php
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

      

      <button type="submit" class="btn btn-primary">Enregistrer les Modifications</button>
      <a href="list.php" class="btn btn-secondary">Annuler</a>
    </form>
</div>                   
                   

<?php
                    
            }    
        }

    if($_SERVER['REQUEST_METHOD'] == 'POST')
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
                    if(empty($salle))
                        {
                            $err[] = 'salle obligatoire';
                        }
                    if(empty($module))
                        {
                            $err[] = 'module obligatoire';
                        }     
                    if(empty($date))
                        {
                            $err[] = 'date obligatoire';
                        }
                    elseif (preg_match('/^(\d{4})-(0[1-9]|1[0-2])-(0[1-9]|[12]\d|3[01])$/', $date, $matches))
                        {
                            $year = $matches[1];
                            $month = $matches[2];
                            $day = $matches[3];

                            if (!checkdate((int)$month, (int)$day, (int)$year))
                                {
                                    $err[] = "inValid date";
                                } 
                        }
                    else
                        {
                            $err[] = 'date formatninvalid';
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
                            $d = $date;
                            $t = $type;
                            $m = $module;
                            $s = $salle;
                            try
                            {
                                $sql = 'UPDATE examen SET type_examen = :t ,date_examen = :d ,salle_examen = :s,id_module = :m WHERE id_examen = :ex';
                                $stmt = $pdo -> prepare($sql);
                                $stmt -> execute([':t'=>$t,':d'=>$d,':s'=>$s,':m'=>$m,':ex'=>$id]);
                                echo'<div class="alert alert-success mt-3">Exam modifier avec success!!</div>';  
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