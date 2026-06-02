<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
include("conn.php");

$cnt_comics   = mysqli_num_rows(mysqli_query($conn, "SELECT comic_id FROM `comics`"));
$cnt_movies   = mysqli_num_rows(mysqli_query($conn, "SELECT movie_id FROM `live action movies`"));
$cnt_animated = mysqli_num_rows(mysqli_query($conn, "SELECT series_id FROM `animated series`"));
$cnt_artworks = mysqli_num_rows(mysqli_query($conn, "SELECT artwork_id FROM `artworks`"));
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Batman DB — Admin Dashboard</title>
    <?php include("css.php"); ?>
    <style>
        .dashboard-wrap {
            display: flex;
            min-height: calc(100vh - 70px);
            max-width: 1200px;
            margin: 2rem auto;
            gap: 1.5rem;
            padding: 0 2rem;
        }

        .sidebar {
            width: 200px;
            flex-shrink: 0;
            background: var(--bat-card);
            border: 1px solid rgba(253,255,0,0.12);
            border-radius: 8px;
            padding: 1.5rem 0;
            display: flex;
            flex-direction: column;
            gap: 0.3rem;
            height: fit-content;
        }
        .sidebar-label {
            font-family: 'Anton', sans-serif;
            font-size: 0.65rem;
            letter-spacing: 3px;
            color: var(--bat-gold);
            padding: 0 1.2rem;
            margin-bottom: 0.5rem;
        }
        .sidebar-link {
            display: flex;
            align-items: center;
            gap: 0.7rem;
            padding: 0.7rem 1.2rem;
            font-family: 'Anton', sans-serif;
            font-size: 0.82rem;
            letter-spacing: 1px;
            color: #8090a8;
            text-decoration: none;
            border-left: 3px solid transparent;
            transition: all 0.15s;
        }
        .sidebar-link:hover {
            color: var(--bat-yellow);
            background: rgba(253,255,0,0.05);
            border-left-color: var(--bat-yellow);
        }
        .sidebar-link.active {
            color: var(--bat-yellow);
            background: rgba(253,255,0,0.07);
            border-left-color: var(--bat-yellow);
        }
        .sidebar-link .icon { font-size: 1rem; width: 20px; text-align: center; }
        .sidebar-divider {
            border: none;
            border-top: 1px solid rgba(253,255,0,0.08);
            margin: 0.5rem 1.2rem;
        }

        .dash-main { flex: 1; display: flex; flex-direction: column; gap: 1.5rem; }

        .top-tabs {
            display: flex;
            gap: 0.75rem;
        }
        .top-tab {
            flex: 1;
            background: var(--bat-card);
            border: 1px solid rgba(253,255,0,0.12);
            border-radius: 6px;
            padding: 1rem;
            text-align: center;
            text-decoration: none;
            transition: all 0.2s;
            cursor: pointer;
        }
        .top-tab:hover {
            border-color: var(--bat-yellow);
            box-shadow: 0 0 16px rgba(253,255,0,0.1);
            transform: translateY(-2px);
        }
        .top-tab .tab-icon { font-size: 1.5rem; }
        .top-tab .tab-name {
            font-family: 'Anton', sans-serif;
            font-size: 0.7rem;
            letter-spacing: 1px;
            color: var(--bat-gold);
            margin-top: 0.3rem;
        }
        .top-tab .tab-count {
            font-family: 'Bangers', cursive;
            font-size: 1.6rem;
            color: var(--bat-yellow);
            letter-spacing: 1px;
        }

        .dash-panel {
            background: var(--bat-card);
            border: 1px solid rgba(253,255,0,0.12);
            border-radius: 8px;
            padding: 1.5rem;
        }
        .dash-panel h2 {
            font-family: 'Bangers', cursive;
            font-size: 1.4rem;
            color: var(--bat-yellow);
            letter-spacing: 2px;
            margin-bottom: 1rem;
            border-bottom: 1px solid rgba(253,255,0,0.1);
            padding-bottom: 0.6rem;
        }

        .quick-actions { display: flex; flex-direction: column; gap: 0.6rem; }
        .qa-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0.7rem 1rem;
            background: rgba(255,255,255,0.03);
            border: 1px solid rgba(253,255,0,0.07);
            border-radius: 5px;
            transition: background 0.15s;
        }
        .qa-row:hover { background: rgba(253,255,0,0.05); }
        .qa-label {
            display: flex;
            align-items: center;
            gap: 0.6rem;
            font-family: 'Anton', sans-serif;
            font-size: 0.85rem;
            letter-spacing: 1px;
            color: #c0cce0;
        }
        .qa-label .icon { font-size: 1.1rem; }
        .qa-btns { display: flex; gap: 0.4rem; }
        .qa-btn {
            font-family: 'Anton', sans-serif;
            font-size: 0.7rem;
            letter-spacing: 1px;
            padding: 0.3rem 0.7rem;
            border: 1px solid;
            border-radius: 3px;
            text-decoration: none;
            transition: all 0.15s;
        }
        .qa-btn.view  { border-color: var(--bat-gold); color: var(--bat-gold); }
        .qa-btn.view:hover  { background: var(--bat-gold); color: var(--bat-dark); }
        .qa-btn.add   { border-color: #44ff88; color: #44ff88; }
        .qa-btn.add:hover   { background: #44ff88; color: var(--bat-dark); }

        .welcome-text {
            font-family: 'Russo One', sans-serif;
            font-size: 0.9rem;
            color: #8090a8;
            line-height: 1.7;
        }
        .welcome-text strong { color: var(--bat-yellow); }

        @media(max-width:768px){
            .dashboard-wrap { flex-direction: column; padding: 0 1rem; }
            .sidebar { width: 100%; flex-direction: row; flex-wrap: wrap; padding: 1rem; }
            .top-tabs { flex-wrap: wrap; }
            .top-tab { min-width: 120px; }
        }
    </style>
</head>
<body>
<nav>
    <div class="nav-inner">
        <div class="nav-brand">
            <img src="../img/BatmanLogo5.png" alt="Batman" style="width:120px; margin-bottom:0.5rem;">
            <div class="nav-title">BATMAN DATABASE<span>ADMIN DASHBOARD</span></div>
        </div>
        <div class="nav-user">
            <span>OPERATIVE:</span>
            <span class="username-badge"><?php echo strtoupper($_SESSION['username']); ?></span>
            <a href="../index.php" class="btn-bat" style="padding:0.35rem 0.9rem;font-size:0.8rem;">🌐 WEBSITE</a>
            <a href="logout.php" class="btn-bat danger" style="padding:0.35rem 0.9rem;font-size:0.8rem;">LOGOUT</a>
        </div>
    </div>
</nav>

<?php if (isset($_SESSION['status'])): ?>
    <div style="max-width:1200px;margin:1rem auto;padding:0 2rem;">
        <div class="alert alert-success"><?php echo $_SESSION['status']; unset($_SESSION['status']); ?></div>
    </div>
<?php endif; ?>

<div class="dashboard-wrap">

    <!-- SIDEBAR -->
    <aside class="sidebar">
        <div class="sidebar-label">NAVIGATION</div>
        <a href="index.php" class="sidebar-link active">
            <span class="icon">🏠</span> DASHBOARD
        </a>
        <hr class="sidebar-divider">
        <div class="sidebar-label">TABLES</div>
        <a href="manage.php?table=comics" class="sidebar-link">
            <span class="icon">📚</span> COMICS
        </a>
        <a href="manage.php?table=movies" class="sidebar-link">
            <span class="icon">🎬</span> LIVE ACTION
        </a>
        <a href="manage.php?table=animated" class="sidebar-link">
            <span class="icon">📺</span> ANIMATED
        </a>
        <a href="manage.php?table=artworks" class="sidebar-link">
            <span class="icon">🖼️</span> ARTWORKS
        </a>
        <hr class="sidebar-divider">
        <a href="../index.php" class="sidebar-link">
            <span class="icon">🌐</span> WEBSITE
        </a>
        <a href="logout.php" class="sidebar-link" style="color:#ff4444;">
            <span class="icon">🚪</span> LOGOUT
        </a>
    </aside>

    <!-- MAIN -->
    <div class="dash-main">

        <!-- TOP TABS — 4 table counts -->
        <div class="top-tabs">
            <a href="manage.php?table=comics" class="top-tab">
                <div class="tab-icon">📚</div>
                <div class="tab-count"><?php echo $cnt_comics; ?></div>
                <div class="tab-name">COMICS</div>
            </a>
            <a href="manage.php?table=movies" class="top-tab">
                <div class="tab-icon">🎬</div>
                <div class="tab-count"><?php echo $cnt_movies; ?></div>
                <div class="tab-name">LIVE ACTION</div>
            </a>
            <a href="manage.php?table=animated" class="top-tab">
                <div class="tab-icon">📺</div>
                <div class="tab-count"><?php echo $cnt_animated; ?></div>
                <div class="tab-name">ANIMATED</div>
            </a>
            <a href="manage.php?table=artworks" class="top-tab">
                <div class="tab-icon">🖼️</div>
                <div class="tab-count"><?php echo $cnt_artworks; ?></div>
                <div class="tab-name">ARTWORKS</div>
            </a>
        </div>

        <div class="dash-panel">
            <h2>⚡ QUICK ACTIONS</h2>
            <div class="quick-actions">
                <div class="qa-row">
                    <span class="qa-label"><span class="icon">📚</span> COMICS</span>
                    <div class="qa-btns">
                        <a href="manage.php?table=comics"          class="qa-btn view">VIEW ALL</a>
                        <a href="record_add.php?table=comics"      class="qa-btn add">+ ADD</a>
                    </div>
                </div>
                <div class="qa-row">
                    <span class="qa-label"><span class="icon">🎬</span> LIVE ACTION MOVIES</span>
                    <div class="qa-btns">
                        <a href="manage.php?table=movies"          class="qa-btn view">VIEW ALL</a>
                        <a href="record_add.php?table=movies"      class="qa-btn add">+ ADD</a>
                    </div>
                </div>
                <div class="qa-row">
                    <span class="qa-label"><span class="icon">📺</span> ANIMATED SERIES</span>
                    <div class="qa-btns">
                        <a href="manage.php?table=animated"        class="qa-btn view">VIEW ALL</a>
                        <a href="record_add.php?table=animated"    class="qa-btn add">+ ADD</a>
                    </div>
                </div>
                <div class="qa-row">
                    <span class="qa-label"><span class="icon">🖼️</span> ARTWORKS</span>
                    <div class="qa-btns">
                        <a href="manage.php?table=artworks"        class="qa-btn view">VIEW ALL</a>
                        <a href="record_add.php?table=artworks"    class="qa-btn add">+ ADD</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="dash-panel">
            <h2>🦇 WELCOME, <?php echo strtoupper($_SESSION['username']); ?></h2>
            <p class="welcome-text">
                You are logged in to the <strong>Batman Database Admin Panel</strong>.<br>
                Use the <strong>sidebar</strong> or the <strong>quick actions</strong> above to manage any of the 4 tables.<br>
                Click <strong>VIEW ALL</strong> to browse records, or <strong>+ ADD</strong> to insert a new entry.
            </p>
        </div>

    </div><!-- end dash-main -->
</div><!-- end dashboard-wrap -->

<?php include("js.php"); ?>
</body>
</html>
