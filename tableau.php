<?php
require_once 'config.php';
requireAuth();
?>
<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Tableau de bord</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<nav class="navbar navbar-dark bg-dark">
  <div class="container-fluid">
    <span class="navbar-brand mb-0 h1">Gestion des tâches</span>
    <span class="text-white me-3">Bonjour <?= htmlspecialchars($_SESSION['auth']['nom']) ?></span>
    <a class="btn btn-sm btn-outline-light" href="logout.php">Déconnexion</a>
  </div>
</nav>
<div class="container mt-4">
  <div class="list-group">
    <a href="taches.php"  class="list-group-item list-group-item-action">Gérer mes tâches</a>
    <?php if ($_SESSION['auth']['role'] === 'admin'): ?>
      <a href="admin.php" class="list-group-item list-group-item-action">Administration utilisateurs</a>
    <?php endif; ?>
  </div>
</div>
</body>
</html>