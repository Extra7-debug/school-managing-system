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

if(isset($_GET['module']))
{
    $module = htmlspecialchars(trim($_GET['module']));

    if(empty($module))
        {   
            header('location: list.php?erreur=true');
            exit();

        }
    else
    {
        require "../../connexion.php";
        try
        {   
            $sql1 = "DELETE FROM module WHERE id_module = :i";
            $sql2 = "DELETE FROM notes WHERE id_examen IN (SELECT id_examen FROM examen WHERE id_module = :i)";
            $sql3 = "DELETE FROM examen WHERE id_module = :i";
            
            $stmt1 = $pdo -> prepare($sql1);
            $stmt2 = $pdo -> prepare($sql2);
            $stmt3 = $pdo -> prepare($sql3);
            
            $stmt1 -> execute([":i"=>$module]);
            $stmt2 -> execute([":i"=>$module]);
            $stmt3 -> execute([":i"=>$module]);
            
           
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