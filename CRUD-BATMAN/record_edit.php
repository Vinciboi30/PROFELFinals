<?php
session_start();
if (!isset($_SESSION['username'])) { header("Location: login.php"); exit(); }
include("conn.php");

$tableMap = [
    'comics'   => ['db'=>'comics',           'pk'=>'comic_id'],
    'movies'   => ['db'=>'live action movies','pk'=>'movie_id'],
    'animated' => ['db'=>'animated series',  'pk'=>'series_id'],
    'artworks' => ['db'=>'artworks',         'pk'=>'artwork_id'],
];
$t   = isset($_GET['table']) && array_key_exists($_GET['table'], $tableMap) ? $_GET['table'] : 'comics';
$cfg = $tableMap[$t];
$id  = (int)$_GET['sid'];

$urow = mysqli_fetch_assoc(mysqli_query($conn, "SELECT user_id FROM users WHERE username='".mysqli_real_escape_string($conn,$_SESSION['username'])."'"));
$uid  = $urow ? $urow['user_id'] : 1;
$now  = date('Y-m-d H:i:s');

$row = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM `{$cfg['db']}` WHERE `{$cfg['pk']}`='$id'"));
if (!$row) { $_SESSION['status']="⚠ RECORD NOT FOUND."; header("Location: manage.php?table=$t"); exit(); }

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    if ($t === 'comics') {
        $year  = mysqli_real_escape_string($conn, $_POST['release_year']);
        $writer= mysqli_real_escape_string($conn, $_POST['writer']);
        $desc  = mysqli_real_escape_string($conn, $_POST['description']);
        $cover = mysqli_real_escape_string($conn, $_POST['cover_image']);
        mysqli_query($conn,"UPDATE `comics` SET title='$title',release_year='$year',writer='$writer',description='$desc',cover_image='$cover',last_updated_by='$uid',updated_at='$now' WHERE comic_id='$id'");
    } elseif ($t === 'movies') {
        $year  = mysqli_real_escape_string($conn, $_POST['release_year']);
        $dir   = mysqli_real_escape_string($conn, $_POST['director']);
        $actor = mysqli_real_escape_string($conn, $_POST['actor']);
        $desc  = mysqli_real_escape_string($conn, $_POST['description']);
        $poster= mysqli_real_escape_string($conn, $_POST['poster']);
        $src   = mysqli_real_escape_string($conn, $_POST['source_material']);
        mysqli_query($conn,"UPDATE `live action movies` SET title='$title',release_year='$year',director='$dir',actor='$actor',source_material='$src',description='$desc',poster='$poster',last_updated_by='$uid',updated_at='$now' WHERE movie_id='$id'");
    } elseif ($t === 'animated') {
        $start = mysqli_real_escape_string($conn, $_POST['start_year']);
        $end   = mysqli_real_escape_string($conn, $_POST['end_year']);
        $desc  = mysqli_real_escape_string($conn, $_POST['description']);
        $poster= mysqli_real_escape_string($conn, $_POST['poster']);
        mysqli_query($conn,"UPDATE `animated series` SET title='$title',start_year='$start',end_year='$end',description='$desc',poster='$poster',last_updated_by='$uid',updated_at='$now' WHERE series_id='$id'");
    } elseif ($t === 'artworks') {
        $image = mysqli_real_escape_string($conn, $_POST['image']);
        $quote = mysqli_real_escape_string($conn, $_POST['quote']);
        mysqli_query($conn,"UPDATE `artworks` SET title='$title',image='$image',quote='$quote',last_updated_by='$uid',updated_at='$now' WHERE artwork_id='$id'");
    }
    $_SESSION['status'] = "✔ RECORD #$id UPDATED!";
    header("Location: manage.php?table=$t"); exit();
}

$labels = ['comics'=>'📚 COMICS','movies'=>'🎬 LIVE ACTION MOVIES','animated'=>'📺 ANIMATED SERIES','artworks'=>'🖼️ ARTWORKS'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Batman DB — Edit Record</title>
    <?php include("css.php"); include("image_picker.php"); ?>
</head>
<body>
<nav>
    <div class="nav-inner">
        <div class="nav-brand">
            <svg class="bat-logo-svg" viewBox="0 0 120 75" xmlns="http://www.w3.org/2000/svg">
                <path d="M60 5 C45 5,30 18,20 28 C10 38,0 45,0 55 C10 50,18 42,25 42 C18 52,15 62,20 70 C28 58,35 52,45 50 C48 58,52 65,60 70 C68 65,72 58,75 50 C85 52,92 58,100 70 C105 62,102 52,95 42 C102 42,110 50,120 55 C120 45,110 38,100 28 C90 18,75 5,60 5Z"/>
            </svg>
            <div class="nav-title">BATMAN DATABASE<span>EDIT RECORD</span></div>
        </div>
        <div class="nav-user">
            <span class="username-badge"><?php echo strtoupper($_SESSION['username']); ?></span>
            <a href="../index.php" class="btn-bat" style="padding:0.35rem 0.9rem;font-size:0.8rem;">🌐 WEBSITE</a>
            <a href="logout.php" class="btn-bat danger" style="padding:0.35rem 0.9rem;font-size:0.8rem;">LOGOUT</a>
        </div>
    </div>
</nav>
<div class="main-wrap">
    <div class="page-header">
        <h1>EDIT — <?php echo $labels[$t]; ?></h1>
        <p class="sub">RECORD #<?php echo $id; ?> — <?php echo strtoupper(htmlspecialchars($row['title'])); ?></p>
        <div class="divider"></div>
    </div>
    <div style="margin-bottom:1.5rem;">
        <a href="manage.php?table=<?php echo $t; ?>" class="btn-bat">← BACK</a>
    </div>
    <div class="form-card" style="max-width:640px;">
        <form method="POST">
            <div class="form-group">
                <label>TITLE *</label>
                <input type="text" name="title" required value="<?php echo htmlspecialchars($row['title']); ?>">
            </div>

            <?php if ($t === 'comics'): ?>
            <div class="form-row">
                <div class="form-group">
                    <label>RELEASE YEAR *</label>
                    <input type="number" name="release_year" min="1939" max="2099" required value="<?php echo $row['release_year']; ?>">
                </div>
                <div class="form-group">
                    <label>WRITER *</label>
                    <input type="text" name="writer" required value="<?php echo htmlspecialchars($row['writer']); ?>">
                </div>
            </div>
            <?php render_image_picker('cover_image', $row['cover_image'] ?? '', 'COVER IMAGE'); ?>
            <div class="form-group">
                <label>DESCRIPTION</label>
                <textarea name="description" style="width:100%;background:rgba(20,24,36,0.9);border:1px solid rgba(253,255,0,0.2);color:var(--bat-yellow);padding:0.7rem 1rem;font-family:'Russo One',sans-serif;font-size:0.9rem;border-radius:3px;outline:none;min-height:100px;resize:vertical;"><?php echo htmlspecialchars($row['description']); ?></textarea>
            </div>

            <?php elseif ($t === 'movies'): ?>
            <div class="form-row">
                <div class="form-group">
                    <label>RELEASE YEAR *</label>
                    <input type="number" name="release_year" min="1900" max="2099" required value="<?php echo $row['release_year']; ?>">
                </div>
                <div class="form-group">
                    <label>DIRECTOR *</label>
                    <input type="text" name="director" required value="<?php echo htmlspecialchars($row['director']); ?>">
                </div>
            </div>
            <div class="form-group">
                <label>ACTOR(S)</label>
                <input type="text" name="actor" value="<?php echo htmlspecialchars($row['actor']); ?>">
            </div>
            <div class="form-group">
                <label>SOURCE MATERIAL (comic_id)</label>
                <input type="number" name="source_material" value="<?php echo $row['source_material']; ?>" min="0">
            </div>
            <?php render_image_picker('poster', $row['poster'] ?? '', 'POSTER IMAGE'); ?>
            <div class="form-group">
                <label>DESCRIPTION</label>
                <textarea name="description" style="width:100%;background:rgba(20,24,36,0.9);border:1px solid rgba(253,255,0,0.2);color:var(--bat-yellow);padding:0.7rem 1rem;font-family:'Russo One',sans-serif;font-size:0.9rem;border-radius:3px;outline:none;min-height:100px;resize:vertical;"><?php echo htmlspecialchars($row['description']); ?></textarea>
            </div>

            <?php elseif ($t === 'animated'): ?>
            <div class="form-row">
                <div class="form-group">
                    <label>START YEAR *</label>
                    <input type="number" name="start_year" min="1900" max="2099" required value="<?php echo $row['start_year']; ?>">
                </div>
                <div class="form-group">
                    <label>END YEAR *</label>
                    <input type="number" name="end_year" min="1900" max="2099" required value="<?php echo $row['end_year']; ?>">
                </div>
            </div>
            <?php render_image_picker('poster', $row['poster'] ?? '', 'POSTER IMAGE'); ?>
            <div class="form-group">
                <label>DESCRIPTION</label>
                <textarea name="description" style="width:100%;background:rgba(20,24,36,0.9);border:1px solid rgba(253,255,0,0.2);color:var(--bat-yellow);padding:0.7rem 1rem;font-family:'Russo One',sans-serif;font-size:0.9rem;border-radius:3px;outline:none;min-height:100px;resize:vertical;"><?php echo htmlspecialchars($row['description']); ?></textarea>
            </div>

            <?php elseif ($t === 'artworks'): ?>
            <?php render_image_picker('image', $row['image'] ?? '', 'ARTWORK IMAGE'); ?>
            <div class="form-group">
                <label>QUOTE</label>
                <textarea name="quote" style="width:100%;background:rgba(20,24,36,0.9);border:1px solid rgba(253,255,0,0.2);color:var(--bat-yellow);padding:0.7rem 1rem;font-family:'Russo One',sans-serif;font-size:0.9rem;border-radius:3px;outline:none;min-height:80px;resize:vertical;"><?php echo htmlspecialchars($row['quote']); ?></textarea>
            </div>
            <?php endif; ?>

            <div class="form-actions">
                <a href="manage.php?table=<?php echo $t; ?>" class="btn-bat danger" style="justify-content:center;">✕ CANCEL</a>
                <input type="submit" class="btn-bat success" value="💾 SAVE CHANGES">
            </div>
        </form>
    </div>
</div>
<?php include("js.php"); ?>
</body>
</html>
