<?php require 'init.php';

if (!isset($_SESSION['user'])) {
    header("Location: index.php");
    exit;
}

$user = $_SESSION['user'];
$iptvUrl = "http://hi-world.me/get.php?username={$user['iptv_user']}&password={$user['iptv_pass']}&type=m3u_plus&output=ts";
?>
<h2>Welcome <?= htmlspecialchars($user['username']) ?></h2>
<video id="video" width="640" height="360" controls autoplay></video>
<script src="https://cdn.jsdelivr.net/npm/hls.js@latest"></script>
<script>
    const video = document.getElementById('video');
    const stream = "<?= $iptvUrl ?>";
    if (Hls.isSupported()) {
        const hls = new Hls();
        hls.loadSource(stream);
        hls.attachMedia(video);
    } else {
        video.src = stream;
    }
</script>
<br><a href="logout.php">Logout</a>
<?php if ($user['role'] === 'admin'): ?>
    <br><a href="admin.php">Admin Panel</a>
<?php endif; ?>
