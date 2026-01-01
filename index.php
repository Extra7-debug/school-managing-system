<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Système de gestion des stagiaires</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light text-center p-5">

  <h2 class="mb-5 text-primary fw-bold">Système de gestion des stagiaires</h2>

  <div class="container">
    <div class="row justify-content-center gap-4">
      
      <div class="col-md-3 border p-4 bg-white rounded shadow-sm">
        <h5 class="fw-bold">Espace Stagiaire</h5>
        <p class="text-muted">Consultez votre profil et vos notes d’examen.</p>
        <a href="stagiaire/login.php" class="btn btn-outline-primary">Connexion Stagiaire</a>
      </div>

      <div class="col-md-3 border p-4 bg-white rounded shadow-sm">
        <h5 class="fw-bold">Espace Admin</h5>
        <p class="text-muted">Gérez les stagiaires, examens et notes et modules.</p>
        <a href="admin/login.php" class="btn btn-outline-danger">Connexion Admin</a>
      </div>

    </div>
  </div>

</body>
</html>
