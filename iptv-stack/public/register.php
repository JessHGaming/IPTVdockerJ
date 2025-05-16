<?php require 'init.php';

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = $_POST['username'] ?? '';
    $pass = $_POST['password'] ?? '';
    $iptvUser = $_POST['iptv_user'] ?? '';
    $iptvPass = $_POST['iptv_pass'] ?? '';

    if ($user && $pass && $iptvUser && $iptvPass) {
        $hash = password_hash($pass, PASSWORD_DEFAULT);
        try {
            $stmt = $db->prepare("INSERT INTO users (username, password, iptv_user, iptv_pass) VALUES (?, ?, ?, ?)");
            $stmt->execute([$user, $hash, $iptvUser, $iptvPass]);
            header("Location: index.php");
            exit;
        } catch (PDOException $e) {
            $error = "Username already exists.";
        }
    } else {
        $error = "All fields required.";
    }
}
?>
<form method="POST">
    <h2>Register</h2>
    <?= $error ? "<p style='color:red;'>$error</p>" : '' ?>
    Username: <input name="username" required><br><br>
    Password: <input name="password" type="password" required><br><br>
    IPTV Username: <input name="iptv_user" required><br><br>
    IPTV Password: <input name="iptv_pass" required><br><br>
    <button>Register</button>
</form>
