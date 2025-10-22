<?php
session_start();

// Only process POST requests
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $inputUser = $_POST['username'] ?? '';
    $inputPass = $_POST['password'] ?? '';

    // Load JSON file
    $logins = json_decode(file_get_contents('logins.json'), true);

    $valid = false;
    foreach ($logins as $user) {
        if ($user['username'] === $inputUser && $user['password'] === $inputPass) {
            $valid = true;
            $_SESSION['loggedIn'] = true;
            $_SESSION['username'] = $inputUser;
            break;
        }
    }

    if ($valid) {
        header('Location: dashboard.php');
        exit;
    } else {
        $error = "Invalid username or password";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>Kerflapiac Login</title>
<style>
    body { font-family: Arial,sans-serif; background:#f8f8f8; margin:0; display:flex; justify-content:center; align-items:center; height:100vh; }
    .login-container { background:#fff; padding:2rem; border-radius:10px; box-shadow:0 0 15px rgba(0,0,0,0.1); width:100%; max-width:400px; text-align:center; }
    input { width:100%; padding:.75rem; margin:.5rem 0; border:1px solid #ccc; border-radius:6px; }
    button { width:100%; padding:.75rem; margin-top:1rem; background:#333; color:#fff; border:none; border-radius:6px; cursor:pointer; }
    button:hover { background:#555; }
    .error { color:#c33; margin-top:.8rem; }
</style>
</head>
<body>
<div class="login-container">
    <h1>🔒 Admin Login</h1>
    <?php if (!empty($error)) echo '<p class="error">'.htmlspecialchars($error).'</p>'; ?>
    <form method="post" action="login.php">
        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Login</button>
    </form>
    <a href="index.html" style="display:block; margin-top:1rem; font-size:.9rem;">← Back to Home</a>
</div>
</body>
</html>
