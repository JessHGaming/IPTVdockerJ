<?php require 'init.php';

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = $_POST['username'] ?? '';
    $pass = $_POST['password'] ?? '';

    $stmt = $db->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$user]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($row && password_verify($pass, $row['password'])) {
        $_SESSION['user'] = $row;
        header("Location: dashboard.php");
        exit;
    } else {
        $error = "Invalid credentials";
    }
}
?>
<form method="POST">
    <h2>Login</h2>
    <?= $error ? "<p style='color:red;'>$error</p>" : '' ?>
    Username: <input name="username" required><br><br>
    Password: <input name="password" type="password" required><br><br>
    <button>Login</button>
    <p>Or <a href="register.php">Register</a></p>
</form>
