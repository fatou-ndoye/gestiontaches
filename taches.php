<?php
require_once 'config.php';
requireAuth();
$userId = $_SESSION['auth']['id'];
if (isset($_POST['save'])) {
    $titre = trim($_POST['titre']);
    $desc  = trim($_POST['description']);
    $id    = $_POST['id'] ?? null;
    if ($titre === '') $err = "Titre obligatoire";
    else {
        if ($id) {
            $stmt = $pdo->prepare("UPDATE taches SET titre=?, description=?, statut=? WHERE id=? AND user_id=?");
            $stmt->execute([$titre, $desc, $_POST['statut'], $id, $userId]);
        } else {
            $stmt = $pdo->prepare("INSERT INTO taches(titre,description,user_id) VALUES (?,?,?)");
            $stmt->execute([$titre, $desc, $userId]);
        }
        header('Location: taches.php'); exit;
    }
}
if (isset($_GET['del'])) {
    $stmt = $pdo->prepare("DELETE FROM taches WHERE id=? AND user_id=?");
    $stmt->execute([$_GET['del'], $userId]);
    header('Location: taches.php'); exit;
}
if (isset($_GET['done'])) {
    $stmt = $pdo->prepare("UPDATE taches SET statut='termine' WHERE id=? AND user_id=?");
    $stmt->execute([$_GET['done'], $userId]);
    header('Location: taches.php'); exit;
}
$stmt = $pdo->prepare("SELECT * FROM taches WHERE user_id=? ORDER BY created_at DESC");
$stmt->execute([$userId]);
$taches = $stmt->fetchAll();
$edit = null;
if (isset($_GET['edit'])) {
    $stmt = $pdo->prepare("SELECT * FROM taches WHERE id=? AND user_id=?");
    $stmt->execute([$_GET['edit'], $userId]);
    $edit = $stmt->fetch();
}
?>
<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Mes tâches</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<nav class="navbar navbar-dark bg-dark">
  <div class="container-fluid">
    <span class="navbar-brand mb-0 h1">Mes tâches</span>
    <a class="btn btn-sm btn-outline-light" href="tableau.php">Retour</a>
  </div>
</nav>
<div class="container mt-4">
    <?php if (isset($err)): ?><div class="alert alert-danger"><?= $err ?></div><?php endif; ?>
    <div class="card mb-4">
        <div class="card-header fw-bold"><?= $edit ? 'Éditer' : 'Nouvelle' ?> tâche</div>
        <div class="card-body">
            <form method="POST">
                <input type="hidden" name="id" value="<?= $edit['id'] ?? '' ?>">
                <div class="mb-3"><label>Titre</label><input class="form-control" name="titre" value="<?= htmlspecialchars($edit['titre'] ?? '') ?>" required></div>
                <div class="mb-3"><label>Description</label><textarea class="form-control" name="description" rows="2"><?= htmlspecialchars($edit['description'] ?? '') ?></textarea></div>
                <?php if ($edit): ?>
                    <div class="mb-3">
                        <label>Statut</label>
                        <select class="form-select" name="statut">
                            <option value="en_cours" <?= ($edit['statut'] === 'en_cours') ? 'selected' : '' ?>>En cours</option>
                            <option value="termine"  <?= ($edit['statut'] === 'termine') ? 'selected' : '' ?>>Terminé</option>
                        </select>
                    </div>
                <?php endif; ?>
                <button class="btn btn-primary" name="save">Enregistrer</button>
                <?php if ($edit): ?><a class="btn btn-secondary" href="taches.php">Annuler</a><?php endif; ?>
            </form>
        </div>
    </div>
    <div class="card">
        <div class="card-header fw-bold">Liste des tâches</div>
        <div class="card-body p-0">
            <table class="table mb-0">
                <thead class="table-light"><tr><th>Titre</th><th>Description</th><th>Statut</th><th width="190"></th></tr></thead>
                <tbody>
                <?php foreach ($taches as $t): ?>
                    <tr>
                        <td><?= htmlspecialchars($t['titre']) ?></td>
                        <td><?= nl2br(htmlspecialchars($t['description'])) ?></td>
                        <td>
                            <?php if ($t['statut'] === 'termine'): ?><span class="badge bg-success">Terminé</span><?php else: ?><span class="badge bg-warning text-dark">En cours</span><?php endif; ?>
                        </td>
                        <td>
                            <?php if ($t['statut'] !== 'termine'): ?><a class="btn btn-sm btn-outline-success" href="taches.php?done=<?= $t['id'] ?>">Terminer</a><?php endif; ?>
                            <a class="btn btn-sm btn-outline-primary" href="taches.php?edit=<?= $t['id'] ?>">Modifier</a>
                            <a class="btn btn-sm btn-outline-danger" href="taches.php?del=<?= $t['id'] ?>" onclick="return confirm('Supprimer ?')">Suppr</a>
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