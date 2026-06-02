<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
include("conn.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Batman DB — Search</title>
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
        <h1>SEARCH COMICS</h1>
        <p class="sub">LOCATE A COMIC IN THE DATABASE</p>
        <div class="divider"></div>
    </div>

    <form action="search.php" method="POST">
        <div class="action-bar">
            <a href="index.php" class="btn-bat">← HOME</a>
            <div class="search-group" style="max-width:500px;margin-left:0;">
                <input type="text" name="key" placeholder="SEARCH BY TITLE OR WRITER..." maxlength="100" required
                       value="<?php echo isset($_POST['key']) ? htmlspecialchars($_POST['key']) : ''; ?>">
                <button type="submit" name="search" class="btn-bat">🔍 SEARCH</button>
            </div>
        </div>
    </form>

    <div class="table-wrapper">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>TITLE</th>
                    <th>RELEASE YEAR</th>
                    <th>WRITER</th>
                    <th>ACTIONS</th>
                </tr>
            </thead>
            <tbody>
            <?php if (isset($_POST['search'])):
                $key     = mysqli_real_escape_string($conn, $_POST['key']);
                // comics table: search by title or writer
                $sql     = "SELECT * FROM $tablelog
                            WHERE title  LIKE '%$key%'
                               OR writer LIKE '%$key%'";
                $results = mysqli_query($conn, $sql);

                if (mysqli_num_rows($results) === 0): ?>
                    <tr><td colspan="5" class="empty-state">— NO COMICS FOUND FOR "<?php echo htmlspecialchars($_POST['key']); ?>" —</td></tr>
                <?php else: while ($row = mysqli_fetch_array($results)): ?>
                    <tr>
                        <td class="id-col">#<?php echo $row['comic_id']; ?></td>
                        <td><?php echo htmlspecialchars($row['title']); ?></td>
                        <td><span class="course-badge"><?php echo $row['release_year']; ?></span></td>
                        <td><?php echo htmlspecialchars($row['writer']); ?></td>
                        <td>
                            <div class="actions-cell">
                                <a href="edit.php?sid=<?php echo $row['comic_id']; ?>" class="action-btn edit">✏ EDIT</a>
                                <a href="delete.php?sid=<?php echo $row['comic_id']; ?>"
                                   class="action-btn del"
                                   onclick="return confirm('REMOVE THIS COMIC FROM THE DATABASE?');">
                                   🗑 DELETE
                                </a>
                            </div>
                        </td>
                    </tr>
                <?php endwhile; endif;
            else: ?>
                <tr><td colspan="5" class="empty-state">— ENTER A TITLE OR WRITER ABOVE TO SEARCH —</td></tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include("js.php"); ?>
</body>
</html>
