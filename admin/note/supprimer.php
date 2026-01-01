<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

</head>
<body>
</body>
</html>

<?php
session_start();
if (!isset($_SESSION["admin"]))
{
    header("location:../login.php");
    exit();
}
?>

<?php

if(isset($_GET['id_stg'],$_GET['id_examen']))
{
    $id_s = htmlspecialchars(trim($_GET['id_stg']));
    $id_e = htmlspecialchars(trim($_GET['id_examen']));

    if(empty($id_s))
        {   
            header('location: list.php?erreur=true');
            exit();
        }
    elseif(empty($id_e))
        {
            header('location: list.php?erreur=true');
            exit(); 
        }    
    else
    {
        require "../../connexion.php";
        try
        {   
            $sql = "DELETE FROM notes WHERE id_stg = :i AND id_examen = :e";
            $stmt = $pdo -> prepare($sql);
            $stmt -> execute([":i"=>$id_s,':e'=>$id_e]);
            header('location: list.php?success=true');
            exit();
            
        }
        catch(PDOException $e)
            {
                echo'<div class="alert alert-danger mt-3">PDO EReeur</div>' . $e -> getMessage();
            }
    }
}
?>