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

if(isset($_GET['stg']))
{
    $stg = htmlspecialchars(trim($_GET['stg']));

    if(empty($stg))
        {   
            header('location: list.php?erreur=true');
            exit();

        }
    else
    {
        require "../../connexion.php";
        try
        {
            $sql1 = "DELETE FROM notes WHERE id_stg = :i";
            $sql2 = "DELETE FROM stagiaire WHERE id_stg = :i";
            
            $stmt1 = $pdo -> prepare($sql1);
            $stmt2 = $pdo -> prepare($sql2);
            
            $stmt1 -> execute([":i"=>$stg]);
            $stmt2 -> execute([":i"=>$stg]);
            
           
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