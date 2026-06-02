<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
require_once "conn.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title        = mysqli_real_escape_string($conn, $_POST['title']);
    $release_year = mysqli_real_escape_string($conn, $_POST['release_year']);
    $writer       = mysqli_real_escape_string($conn, $_POST['writer']);
    $description  = mysqli_real_escape_string($conn, $_POST['description']);
    $cover_image  = mysqli_real_escape_string($conn, $_POST['cover_image']);

   
    $urow = mysqli_fetch_assoc(mysqli_query($conn, "SELECT user_id FROM $tablelogin WHERE username='" . mysqli_real_escape_string($conn, $_SESSION['username']) . "'"));
    $last_updated_by = $urow ? $urow['user_id'] : 1;
    $updated_at = date('Y-m-d H:i:s');

    mysqli_query($conn, "INSERT INTO $tablelog (title, release_year, writer, description, cover_image, last_updated_by, updated_at)
                         VALUES ('$title','$release_year','$writer','$description','$cover_image','$last_updated_by','$updated_at')");
    $_SESSION['status'] = "✔ COMIC '$title' SUCCESSFULLY ADDED!";
    header('Location: index.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Batman DB — Add Comic</title>
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
        <h1>ADD COMIC</h1>
        <p class="sub">ADD A NEW COMIC TO THE BATMAN DATABASE</p>
        <div class="divider"></div>
    </div>
    <div style="margin-bottom:1.5rem;">
        <a href="index.php" class="btn-bat">← BACK TO REGISTRY</a>
    </div>
    <div class="form-card">
        <div class="alert alert-info">⚡ ALL FIELDS MARKED * ARE REQUIRED</div>
        <form name="frminfo" action="" method="POST">
            <div class="form-group">
                <label>TITLE *</label>
                <input type="text" name="title" placeholder="Comic title" required>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label>RELEASE YEAR *</label>
                    <input type="number" name="release_year" placeholder="e.g. 1986" min="1939" max="2099" required>
                </div>
                <div class="form-group">
                    <label>WRITER *</label>
                    <input type="text" name="writer" placeholder="Writer name" required>
                </div>
            </div>
            <div class="form-group">
                <label>COVER IMAGE FILENAME</label>
                <input type="text" name="cover_image" placeholder="e.g. dark_knight.jpg">
            </div>
            <div class="form-group">
                <label>DESCRIPTION *</label>
                <textarea name="description" placeholder="Comic description..." required
                          style="width:100%;background:rgba(20,24,36,0.9);border:1px solid rgba(253,255,0,0.2);
                                 color:var(--bat-yellow);padding:0.7rem 1rem;font-family:'Russo One',sans-serif;
                                 font-size:0.9rem;border-radius:3px;outline:none;min-height:100px;resize:vertical;"></textarea>
            </div>
            <div class="form-actions">
                <input type="reset"  class="btn-bat danger"  value="✕ CLEAR">
                <input type="submit" class="btn-bat success" value="⚡ ADD COMIC">
            </div>
        </form>
    </div>
</div>

<?php include("js.php"); ?>
</body>
</html>
