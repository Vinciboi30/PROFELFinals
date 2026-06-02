<?php
session_start();
if (!isset($_SESSION['username'])) { header("Location: login.php"); exit(); }
include("conn.php");

$tables = [
    'comics'   => ['label'=>'COMICS',           'db'=>'comics',            'pk'=>'comic_id',  'icon'=>'📚',
                   'cols'=>['comic_id'=>'ID','title'=>'TITLE','release_year'=>'YEAR','writer'=>'WRITER','description'=>'DESCRIPTION','last_updated_by'=>'UPDATED BY','updated_at'=>'UPDATED AT']],
    'movies'   => ['label'=>'LIVE ACTION MOVIES','db'=>'live action movies','pk'=>'movie_id',  'icon'=>'🎬',
                   'cols'=>['movie_id'=>'ID','title'=>'TITLE','release_year'=>'YEAR','director'=>'DIRECTOR','actor'=>'ACTOR','description'=>'DESCRIPTION','last_updated_by'=>'UPDATED BY','updated_at'=>'UPDATED AT']],
    'animated' => ['label'=>'ANIMATED SERIES',   'db'=>'animated series',  'pk'=>'series_id', 'icon'=>'📺',
                   'cols'=>['series_id'=>'ID','title'=>'TITLE','start_year'=>'START','end_year'=>'END','description'=>'DESCRIPTION','last_updated_by'=>'UPDATED BY','updated_at'=>'UPDATED AT']],
    'artworks' => ['label'=>'ARTWORKS',          'db'=>'artworks',         'pk'=>'artwork_id','icon'=>'🖼️',
                   'cols'=>['artwork_id'=>'ID','title'=>'TITLE','quote'=>'QUOTE','description'=>'DESCRIPTION','last_updated_by'=>'UPDATED BY','updated_at'=>'UPDATED AT']],
];

$t   = isset($_GET['table']) && array_key_exists($_GET['table'], $tables) ? $_GET['table'] : 'comics';
$cfg = $tables[$t];

$search = '';
$where  = '';
if (isset($_POST['search']) && !empty($_POST['key'])) {
    $search = mysqli_real_escape_string($conn, $_POST['key']);
    $where  = "WHERE title LIKE '%$search%'";
}

$query = mysqli_query($conn, "SELECT * FROM `{$cfg['db']}` $where ORDER BY {$cfg['pk']} DESC");
$total = mysqli_num_rows(mysqli_query($conn, "SELECT {$cfg['pk']} FROM `{$cfg['db']}`"));
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Batman DB — <?php echo $cfg['label']; ?></title>
    <?php include("css.php"); ?>
    <style>
        .dashboard-wrap { display:flex; min-height:calc(100vh - 70px); max-width:1200px; margin:2rem auto; gap:1.5rem; padding:0 2rem; }
        .sidebar { width:200px; flex-shrink:0; background:var(--bat-card); border:1px solid rgba(253,255,0,0.12); border-radius:8px; padding:1.5rem 0; display:flex; flex-direction:column; gap:0.3rem; height:fit-content; }
        .sidebar-label { font-family:'Anton',sans-serif; font-size:0.65rem; letter-spacing:3px; color:var(--bat-gold); padding:0 1.2rem; margin-bottom:0.5rem; }
        .sidebar-link { display:flex; align-items:center; gap:0.7rem; padding:0.7rem 1.2rem; font-family:'Anton',sans-serif; font-size:0.82rem; letter-spacing:1px; color:#8090a8; text-decoration:none; border-left:3px solid transparent; transition:all 0.15s; }
        .sidebar-link:hover { color:var(--bat-yellow); background:rgba(253,255,0,0.05); border-left-color:var(--bat-yellow); }
        .sidebar-link.active { color:var(--bat-yellow); background:rgba(253,255,0,0.07); border-left-color:var(--bat-yellow); }
        .sidebar-link .icon { font-size:1rem; width:20px; text-align:center; }
        .sidebar-divider { border:none; border-top:1px solid rgba(253,255,0,0.08); margin:0.5rem 1.2rem; }
        .dash-main { flex:1; display:flex; flex-direction:column; gap:1.2rem; }
        @media(max-width:768px){ .dashboard-wrap{flex-direction:column;padding:0 1rem;} .sidebar{width:100%;} }
    </style>
</head>
<body>
<nav>
    <div class="nav-inner">
        <div class="nav-brand">
            <img src="../img/BatmanLogo5.png" alt="Batman" style="width:120px; margin-bottom:0.5rem;">
            <div class="nav-title">BATMAN DATABASE<span><?php echo $cfg['icon'].' '.$cfg['label']; ?></span></div>
        </div>
        <div class="nav-user">
            <span class="username-badge"><?php echo strtoupper($_SESSION['username']); ?></span>
            <a href="../index.php" class="btn-bat" style="padding:0.35rem 0.9rem;font-size:0.8rem;">🌐 WEBSITE</a>
            <a href="logout.php" class="btn-bat danger" style="padding:0.35rem 0.9rem;font-size:0.8rem;">LOGOUT</a>
        </div>
    </div>
</nav>

<div class="dashboard-wrap">
    <!-- SIDEBAR -->
    <aside class="sidebar">
        <div class="sidebar-label">NAVIGATION</div>
        <a href="index.php" class="sidebar-link"><span class="icon">🏠</span> DASHBOARD</a>
        <hr class="sidebar-divider">
        <div class="sidebar-label">TABLES</div>
        <a href="manage.php?table=comics"   class="sidebar-link <?php echo $t==='comics'  ?'active':''; ?>"><span class="icon">📚</span> COMICS</a>
        <a href="manage.php?table=movies"   class="sidebar-link <?php echo $t==='movies'  ?'active':''; ?>"><span class="icon">🎬</span> LIVE ACTION</a>
        <a href="manage.php?table=animated" class="sidebar-link <?php echo $t==='animated'?'active':''; ?>"><span class="icon">📺</span> ANIMATED</a>
        <a href="manage.php?table=artworks" class="sidebar-link <?php echo $t==='artworks'?'active':''; ?>"><span class="icon">🖼️</span> ARTWORKS</a>
        <hr class="sidebar-divider">
        <a href="../index.php" class="sidebar-link"><span class="icon">🌐</span> WEBSITE</a>
        <a href="logout.php" class="sidebar-link" style="color:#ff4444;"><span class="icon">🚪</span> LOGOUT</a>
    </aside>

    <!-- MAIN -->
    <div class="dash-main">
        <?php if (isset($_SESSION['status'])): ?>
            <div class="alert alert-success"><?php echo $_SESSION['status']; unset($_SESSION['status']); ?></div>
        <?php endif; ?>

        <div class="page-header" style="text-align:left;margin-bottom:0;">
            <h1 style="font-size:2rem;"><?php echo $cfg['icon'].' '.$cfg['label']; ?></h1>
            <p class="sub"><?php echo $total; ?> RECORDS IN DATABASE</p>
            <div class="divider" style="margin:0.5rem 0 0;"></div>
        </div>

        <div class="action-bar">
            <a href="record_add.php?table=<?php echo $t; ?>" class="btn-bat success">+ ADD RECORD</a>
            <form method="POST" style="display:flex;gap:0;flex:1;max-width:360px;margin-left:auto;">
                <input type="text" name="key" placeholder="SEARCH BY TITLE..."
                       value="<?php echo htmlspecialchars($search); ?>"
                       style="flex:1;background:rgba(40,46,60,0.9);border:2px solid rgba(253,255,0,0.3);border-right:none;color:var(--bat-yellow);padding:0.5rem 1rem;font-family:'Russo One',sans-serif;font-size:0.85rem;border-radius:3px 0 0 3px;outline:none;">
                <button type="submit" name="search" class="btn-bat" style="border-radius:0 3px 3px 0;padding:0.5rem 1rem;">🔍</button>
            </form>
        </div>

        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <?php foreach ($cfg['cols'] as $col => $lbl): ?>
                            <th><?php echo $lbl; ?></th>
                        <?php endforeach; ?>
                        <th>ACTIONS</th>
                    </tr>
                </thead>
                <tbody>
                <?php if (mysqli_num_rows($query) === 0): ?>
                    <tr><td colspan="<?php echo count($cfg['cols'])+1; ?>" class="empty-state">— NO RECORDS FOUND —</td></tr>
                <?php else: while ($row = mysqli_fetch_assoc($query)): ?>
                    <tr>
                        <?php foreach ($cfg['cols'] as $col => $lbl): ?>
                            <td><?php
                                $val = htmlspecialchars($row[$col] ?? '');
                                if ($col === $cfg['pk']) echo '<span class="id-col">#'.$val.'</span>';
                                elseif (strpos($col,'year') !== false||$col==='start_year'||$col==='end_year') echo '<span class="course-badge">'.$val.'</span>';
                                elseif ($col==='quote'||$col==='description') echo '<span style="opacity:.7;font-size:0.8rem;">'.mb_substr($val,0,60).(mb_strlen($val)>60?'…':'').'</span>';
                                elseif ($col==='last_updated_by') echo '<span style="color:var(--bat-gold);font-size:0.85rem;">User #'.$val.'</span>';
                                elseif ($col==='updated_at') echo '<span style="font-size:0.8rem;opacity:.7;">'.$val.'</span>';
                                else echo $val;
                            ?></td>
                        <?php endforeach; ?>
                        <td>
                            <div class="actions-cell">
                                <a href="record_edit.php?table=<?php echo $t; ?>&sid=<?php echo $row[$cfg['pk']]; ?>" class="action-btn edit">✏ EDIT</a>
                                <a href="record_delete.php?table=<?php echo $t; ?>&sid=<?php echo $row[$cfg['pk']]; ?>"
                                   class="action-btn del"
                                   onclick="return confirm('DELETE THIS RECORD?');">🗑 DELETE</a>
                            </div>
                        </td>
                    </tr>
                <?php endwhile; endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php include("js.php"); ?>
</body>
</html>
