<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
include("conn.php");

$id    = (int)$_GET['sid'];
$query = mysqli_query($conn, "SELECT * FROM $tablelog WHERE comic_id='$id'");
$row   = mysqli_fetch_array($query);

if (!$row) {
    $_SESSION['status'] = "⚠ COMIC NOT FOUND.";
    header('Location: index.php');
    exit();
}

$title        = $row['title'];
$release_year = $row['release_year'];
$writer       = $row['writer'];
$description  = $row['description'];
$cover_image  = $row['cover_image'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title        = mysqli_real_escape_string($conn, $_POST['title']);
    $release_year = mysqli_real_escape_string($conn, $_POST['release_year']);
    $writer       = mysqli_real_escape_string($conn, $_POST['writer']);
    $description  = mysqli_real_escape_string($conn, $_POST['description']);
    $cover_image  = mysqli_real_escape_string($conn, $_POST['cover_image']);

    $urow = mysqli_fetch_assoc(mysqli_query($conn, "SELECT user_id FROM $tablelogin WHERE username='" . mysqli_real_escape_string($conn, $_SESSION['username']) . "'"));
    $last_updated_by = $urow ? $urow['user_id'] : 1;
    $updated_at = date('Y-m-d H:i:s');

    mysqli_query($conn, "UPDATE $tablelog
                         SET title='$title', release_year='$release_year',
                             writer='$writer', description='$description',
                             cover_image='$cover_image',
                             last_updated_by='$last_updated_by', updated_at='$updated_at'
                         WHERE comic_id='$id'");
    $_SESSION['status'] = "✔ COMIC #$id SUCCESSFULLY UPDATED!";
    header('Location: index.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Batman DB — Edit Comic</title>
    <?php include("css.php"); ?>
</head>
<body>

<nav>
    <div class="nav-inner">
        <div class="nav-brand">
            <svg class="bat-logo-svg" viewBox="0 0 120 75" xmlns="http://www.w3.org/2000/svg">
                <path d="M60 5 C45 5,30 18,20 28 C10 38,0 45,0 55 C10 50,18 42,25 42 C18 52,15 62,20 70 C28 58,35 52,45 50 C48 58,52 65,60 70 C68 65,72 58,75 50 C85 52,92 58,100 70 C105 62,102 52,95 42 C102 42,110 50,120 55 C120 45,110 38,100 28 C90 18,75 5,60 5Z"/>
            </svg>
            <div class="nav-title">BATMAN DATABASE<span>COMICS REGISTRY</span></div>
        </div>
        <div class="nav-user">
            <span>OPERATIVE:</span>
            <span class="username-badge"><?php echo strtoupper($_SESSION['username']); ?></span>
            <a href="../index.php" class="btn-bat" style="padding:0.35rem 0.9rem;font-size:0.8rem;">🌐 WEBSITE</a>
            <a href="logout.php" class="btn-bat danger" style="padding:0.35rem 0.9rem;font-size:0.8rem;">LOGOUT</a>
        </div>
    </div>
</nav>

<div class="main-wrap">
    <div class="page-header">
        <h1>UPDATE COMIC</h1>
        <p class="sub">EDITING COMIC #<?php echo $id; ?> — <?php echo strtoupper(htmlspecialchars($title)); ?></p>
        <div class="divider"></div>
    </div>
    <div style="margin-bottom:1.5rem;">
        <a href="index.php" class="btn-bat">← BACK TO REGISTRY</a>
    </div>
    <div class="form-card">
        <div class="alert alert-info">⚡ EDITING COMIC #<?php echo $id; ?></div>
        <form name="frminfo" action="" method="POST">
            <div class="form-group">
                <label>TITLE *</label>
                <input type="text" name="title" value="<?php echo htmlspecialchars($title); ?>" required>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label>RELEASE YEAR *</label>
                    <input type="number" name="release_year" value="<?php echo htmlspecialchars($release_year); ?>" min="1939" max="2099" required>
                </div>
                <div class="form-group">
                    <label>WRITER *</label>
                    <input type="text" name="writer" value="<?php echo htmlspecialchars($writer); ?>" required>
                </div>
            </div>
            <div class="form-group">
                <label>COVER IMAGE FILENAME</label>
                <input type="text" name="cover_image" value="<?php echo htmlspecialchars($cover_image); ?>">
            </div>
            <div class="form-group">
                <label>DESCRIPTION *</label>
                <textarea name="description" required
                          style="width:100%;background:rgba(20,24,36,0.9);border:1px solid rgba(253,255,0,0.2);
                                 color:var(--bat-yellow);padding:0.7rem 1rem;font-family:'Russo One',sans-serif;
                                 font-size:0.9rem;border-radius:3px;outline:none;min-height:100px;resize:vertical;"><?php echo htmlspecialchars($description); ?></textarea>
            </div>
            <div class="form-actions">
                <a href="index.php" class="btn-bat danger" style="justify-content:center;">✕ CANCEL</a>
                <input type="submit" class="btn-bat success" value="💾 SAVE CHANGES">
            </div>
        </form>
    </div>
</div>

<?php include("js.php"); ?>
</body>
</html>
