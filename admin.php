<?php
 require_once 'config.php';
requireAuth('admin');
 if (isset($_GET['del']) && $_GET['del'] != $_SESSION['auth']['id']) {
 $stmt = $pdo->prepare("DELETE FROM utilisateurs WHERE id = ?");
    $stmt->execute([$_GET['del']]);
    header('Location: admin.php'); exit;
}
$users   = $pdo->query("SELECT id, nom, email, role, created_at FROM utilisateurs ORDER BY id DESC")->fetchAll();
$nbUsers= count($users);
$nbTasks     = $pdo->query("SELECT COUNT(*) FROM taches")->fetchColumn();
$nbTasksDone = $pdo->query("SELECT COUNT(*) FROM taches WHERE statut = 'termine'")->fetchColumn();
?>
<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Administration</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<nav class="navbar navbar-dark bg-dark">
  <div class="container-fluid">
    <span class="navbar-brand mb-0 h1">Administration</span>
    <a class="btn btn-sm btn-outline-light" href="tableau.php">Retour</a>
  </div>
</nav>
<div class="container mt-4">
    <div class="row mb-4 text-center">
        <div class="col"><div class="card p-3"><h5><?= $nbUsers ?></h5>utilisateurs</div></div>
        <div class="col"><div class="card p-3"><h5><?= $nbTasks ?></h5>tâches</div></div>
        <div class="col"><div class="card p-3"><h5><?= $nbTasksDone ?></h5>terminées</div></div>
    </div>
    <div class="card">
        <div class="card-header fw-bold">Utilisateurs</div>
        <div class="card-body p-0">
            <table class="table mb-0">
                <thead class="table-light"><tr><th>Nom</th><th>Email</th><th>Rôle</th><th>Date création</th><th></th></tr></thead>
                <tbody>
                <?php foreach ($users as $u): ?>
                    <tr>
                        <td><?= htmlspecialchars($u['nom']) ?></td>
                        <td><?= htmlspecialchars($u['email']) ?></td>
                        <td><span class="badge bg-<?= ($u['role'] === 'admin') ? 'danger' : 'secondary' ?>"><?= $u['role'] ?></span></td>
                        <td><?= date('d/m/Y', strtotime($u['created_at'])) ?></td>
                        <td>
                            <?php if ($u['id'] != $_SESSION['auth']['id']): ?>
                                <a class="btn btn-sm btn-outline-danger" href="admin.php?del=<?= $u['id'] ?>" onclick="return confirm('Supprimer ?')">Suppr</a>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
</body>
</html>