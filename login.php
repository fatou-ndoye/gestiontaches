<?php
require_once 'config.php';
$err = '';
if (isset($_POST['connexion'])) {
    $email = trim($_POST['email']);
    $mdp   = $_POST['password'];
    $stmt  = $pdo->prepare("SELECT id, nom, password, role FROM utilisateurs WHERE email = ? LIMIT 1");
    $stmt->execute([$email]);
    $user  = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($user && $user['password'] === sha1($mdp)) {
        $_SESSION['auth'] = [ 'id' => $user['id'], 'nom' => $user['nom'], 'role' => $user['role'] ];
        header('Location: tableau.php');   
        exit;
    } else {
        $err = 'Email ou mot de passe incorrect.';
    }
}
?>
<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Connexion</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        body { background: linear-gradient(120deg , #1a1a1a, #808080, #b3b3b3); min-height: 100vh; }
        .login-container { margin-top: 8%; }
        .login-card { border: none; border-radius: 1rem; box-shadow: 0 4px 12px rgba(0,0,0,.15); }
        .login-card .card-body { padding: 2.5rem; }
        .card-title { color: #0d1b2a !important; }
        .btn-primary { background: linear-gradient(120deg , #1a1a1a, #808080, #b3b3b3); border: none; }
    </style>
</head>
<body>
<div class="container login-container">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <div class="card login-card">
                <div class="card-body">
                    <h3 class="card-title text-center mb-4 fw-bold"><i class="bi bi-bank2 me-2"></i>Connexion</h3>
                    <?php if ($err): ?><div class="alert alert-danger"><?= htmlspecialchars($err) ?></div><?php endif; ?>
                    <form method="POST">
                        <div class="mb-3"><label>Email</label><input type="email" name="email" class="form-control" required></div>
                        <div class="mb-3"><label>Mot de passe</label><input type="password" name="password" class="form-control" required></div>
                        <div class="d-grid"><button class="btn btn-primary" name="connexion"><i class="bi bi-box-arrow-in-right"></i> Se connecter</button></div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>