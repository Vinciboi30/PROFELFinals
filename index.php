<?php
// ─── Connect to batman_db ───────────────────────────────────────────────────
$server   = "localhost";
$username = "root";
$password = "";
$dbname   = "batman_db";

$conn = mysqli_connect($server, $username, $password, $dbname)
    or die("Cannot connect to Batman database.");

// ─── Fetch Comics ───────────────────────────────────────────────────────────
$comics_result = mysqli_query($conn, "SELECT * FROM `comics` ORDER BY release_year ASC");
$comics = [];
while ($row = mysqli_fetch_assoc($comics_result)) {
    $comics[] = $row;
}

// ─── Fetch Live Action Movies ───────────────────────────────────────────────
$movies_result = mysqli_query($conn, "SELECT * FROM `live action movies` ORDER BY release_year ASC");
$movies = [];
while ($row = mysqli_fetch_assoc($movies_result)) {
    $movies[] = $row;
}

// ─── Fetch Animated Series ──────────────────────────────────────────────────
$animated_result = mysqli_query($conn, "SELECT * FROM `animated series` ORDER BY start_year ASC");
$animated = [];
while ($row = mysqli_fetch_assoc($animated_result)) {
    $animated[] = $row;
}

// ─── Fetch Artworks ─────────────────────────────────────────────────────────
$artworks_result = mysqli_query($conn, "SELECT * FROM `artworks` ORDER BY artwork_id ASC");
$artworks = [];
while ($row = mysqli_fetch_assoc($artworks_result)) {
    $artworks[] = $row;
}

mysqli_close($conn);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>The Batman Collection</title>
    <link rel="icon" type="image/png" href="img/batmanlogo4.jpeg">
    <link href="https://fonts.googleapis.com/css2?family=Bangers&family=Anton&family=Russo+One&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="ADARLOSTYLES.css">
    <style>
        .empty-state-msg {
            text-align: center;
            padding: 3rem 1rem;
            color: #6070a0;
            font-family: 'Anton', sans-serif;
            letter-spacing: 2px;
        }
        .empty-state-msg .empty-icon { font-size: 3rem; margin-bottom: 1rem; }
        .empty-state-msg h3 { font-size: 1.2rem; color: #8090b0; margin-bottom: 0.5rem; }
        .empty-state-msg p { font-size: 0.85rem; color: #505870; }
        .empty-state-msg a { color: #fdff00; text-decoration: none; border-bottom: 1px solid rgba(253,255,0,0.4); }
        .empty-state-msg a:hover { color: #fff; }
    </style>
</head>
<body>
    <nav>
        <div class="nav-container">
            <div class="nav-logo">
                <img src="img/BatmanLogo5.png" alt="Batman Logo">
            </div>
            <ul>
                <li><a href="#" onclick="showPage('home')">HOME</a></li>
                <li><a href="#" onclick="showPage('bio')">BIOGRAPHY</a></li>
                <li><a href="#" onclick="showPage('artwork')">ARTWORKS</a></li>
                <li><a href="CRUD-BATMAN/login.php" style="color:#fdff00;border:1px solid #fdff00;padding:4px 12px;border-radius:3px;">⚙ ADMIN</a></li>
            </ul>
        </div>
    </nav>

    <div class="container">

        <!-- HOME PAGE -->
        <div id="home" class="page active">
            <h1>THE BATMAN COLLECTION</h1>
            <div class="hero">
                <h2>THE ULTIMATE BATMAN ARCHIVE</h2>
                <p>Your complete gateway to exploring the Dark Knight's most iconic stories, unforgettable villains, and legendary appearances across all media. Immerse yourself in the rich tapestry of Batman's universe - from groundbreaking graphic novels that redefined superhero storytelling, to cinematic masterpieces that brought Gotham to life on the silver screen, to award-winning animated series that captivated generations.</p>
            </div>
            <div class="selection-container">
                <div class="selection-box" onclick="showCarousel('comics')">
                    <img src="img/comics1.JPG" alt="Comics">
                    <div class="selection-content"><h2>COMICS</h2></div>
                </div>
                <div class="selection-box" onclick="showCarousel('movies')">
                    <img src="img/liveaction1.JPG" alt="Live Action">
                    <div class="selection-content"><h2>LIVE ACTION</h2></div>
                </div>
                <div class="selection-box" onclick="showCarousel('animated')">
                    <img src="img/animated1.JPG" alt="Animated Series">
                    <div class="selection-content"><h2>ANIMATED SERIES</h2></div>
                </div>
            </div>
        </div>

        <!-- COMICS CAROUSEL — pulled from DB -->
        <div id="comics-carousel" class="page carousel-section">
            <h1>COMIC BOOKS & GRAPHIC NOVELS</h1>
            <button class="return-button" onclick="showPage('home')">← RETURN TO CATEGORIES</button>
            <?php if (empty($comics)): ?>
                <div class="empty-state-msg">
                    <div class="empty-icon">📚</div>
                    <h3>NO COMICS ADDED YET</h3>
                    <p>Add comics through the <a href="CRUD-BATMAN/login.php">admin panel</a> and they will appear here.</p>
                </div>
            <?php else: ?>
            <div class="carousel-container">
                <button class="carousel-nav prev" onclick="changeSlide('comics', -1)">‹</button>
                <div class="carousel-wrapper">
                    <div class="carousel-track" id="comics-track">
                        <?php foreach ($comics as $comic):
                            $raw = $comic['cover_image'] ?? '';
                            $img = !empty($raw) ? (strpos($raw,'img/') === 0 ? htmlspecialchars($raw) : 'img/'.htmlspecialchars($raw)) : 'img/comics1.JPG';
                            $title = strtoupper(htmlspecialchars($comic['title']));
                            $desc  = htmlspecialchars($comic['description']) . ' — Written by ' . htmlspecialchars($comic['writer']) . ' (' . $comic['release_year'] . ')';
                        ?>
                        <div class="carousel-item" data-title="<?= $title ?>" data-desc="<?= $desc ?>">
                            <div class="carousel-box">
                                <img src="<?= $img ?>" alt="<?= $title ?>">
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <button class="carousel-nav next" onclick="changeSlide('comics', 1)">›</button>
            </div>
            <div class="carousel-description">
                <h3 id="comics-title">Title Here</h3>
                <p id="comics-desc">Description will appear here.</p>
            </div>
            <?php endif; ?>
        </div>

        <!-- MOVIES CAROUSEL — pulled from DB -->
        <div id="movies-carousel" class="page carousel-section">
            <h1>LIVE ACTION MOVIES</h1>
            <button class="return-button" onclick="showPage('home')">← RETURN TO CATEGORIES</button>
            <?php if (empty($movies)): ?>
                <div class="empty-state-msg">
                    <div class="empty-icon">🎬</div>
                    <h3>NO MOVIES ADDED YET</h3>
                    <p>Add live action movies through the <a href="CRUD-BATMAN/login.php">admin panel</a> and they will appear here.</p>
                </div>
            <?php else: ?>
            <div class="carousel-container">
                <button class="carousel-nav prev" onclick="changeSlide('movies', -1)">‹</button>
                <div class="carousel-wrapper">
                    <div class="carousel-track" id="movies-track">
                        <?php foreach ($movies as $movie):
                            $raw = $movie['poster'] ?? '';
                            $img = !empty($raw) ? (strpos($raw,'img/') === 0 ? htmlspecialchars($raw) : 'img/'.htmlspecialchars($raw)) : 'img/movie1.JPG';
                            $title = strtoupper(htmlspecialchars($movie['title'])) . ' (' . $movie['release_year'] . ')';
                            $desc  = htmlspecialchars($movie['description']) . ' — Directed by ' . htmlspecialchars($movie['director']) . '. Starring: ' . htmlspecialchars($movie['actor']) . '.';
                        ?>
                        <div class="carousel-item" data-title="<?= $title ?>" data-desc="<?= $desc ?>">
                            <div class="carousel-box">
                                <img src="<?= $img ?>" alt="<?= $title ?>">
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <button class="carousel-nav next" onclick="changeSlide('movies', 1)">›</button>
            </div>
            <div class="carousel-description">
                <h3 id="movies-title">Title Here</h3>
                <p id="movies-desc">Description will appear here.</p>
            </div>
            <?php endif; ?>
        </div>

        <!-- ANIMATED CAROUSEL — pulled from DB -->
        <div id="animated-carousel" class="page carousel-section">
            <h1>ANIMATED SERIES</h1>
            <button class="return-button" onclick="showPage('home')">← RETURN TO CATEGORIES</button>
            <?php if (empty($animated)): ?>
                <div class="empty-state-msg">
                    <div class="empty-icon">📺</div>
                    <h3>NO ANIMATED SERIES ADDED YET</h3>
                    <p>Add animated series through the <a href="CRUD-BATMAN/login.php">admin panel</a> and they will appear here.</p>
                </div>
            <?php else: ?>
            <div class="carousel-container">
                <button class="carousel-nav prev" onclick="changeSlide('animated', -1)">‹</button>
                <div class="carousel-wrapper">
                    <div class="carousel-track" id="animated-track">
                        <?php foreach ($animated as $series):
                            $raw = $series['poster'] ?? '';
                            $img = !empty($raw) ? (strpos($raw,'img/') === 0 ? htmlspecialchars($raw) : 'img/'.htmlspecialchars($raw)) : 'img/animated2.JPG';
                            $title = strtoupper(htmlspecialchars($series['title']));
                            $years = $series['start_year'] . '–' . $series['end_year'];
                            $desc  = htmlspecialchars($series['description']) . ' (' . $years . ')';
                        ?>
                        <div class="carousel-item" data-title="<?= $title ?>" data-desc="<?= $desc ?>">
                            <div class="carousel-box">
                                <img src="<?= $img ?>" alt="<?= $title ?>">
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <button class="carousel-nav next" onclick="changeSlide('animated', 1)">›</button>
            </div>
            <div class="carousel-description">
                <h3 id="animated-title">Title Here</h3>
                <p id="animated-desc">Description will appear here.</p>
            </div>
            <?php endif; ?>
        </div>

        <!-- BIOGRAPHY PAGE (unchanged) -->
        <div id="bio" class="page">
            <h1>BATMAN BIOGRAPHY</h1>
            <div class="bio-images">
                <div class="bio-image-box">
                    <div class="image-placeholder"><img src="img/thebatman.png" alt="Batman"></div>
                    <p>Batman</p>
                </div>
                <div class="bio-image-box">
                    <div class="image-placeholder"><img src="img/brucewayne.jpg" alt="Bruce Wayne"></div>
                    <p>Bruce Wayne</p>
                </div>
            </div>
            <h3>Character Profile</h3>
            <div class="profile-grid">
                <div class="profile-item"><strong>Real Name:</strong> <span>Bruce Wayne</span></div>
                <div class="profile-item"><strong>Alias:</strong> <span>The Dark Knight, The Caped Crusader, The World's Greatest Detective</span></div>
                <div class="profile-item"><strong>Base of Operations:</strong> <span>Gotham City</span></div>
                <div class="profile-item"><strong>Occupation:</strong> <span>CEO of Wayne Enterprises, Vigilante</span></div>
                <div class="profile-item"><strong>Abilities:</strong> <span>Peak Human Conditioning, Master Detective, Expert Martial Artist, Genius-Level Intellect</span></div>
                <div class="profile-item"><strong>Equipment:</strong> <span>Batsuit, Utility Belt, Batarangs, Batmobile, Various Gadgets</span></div>
                <div class="profile-item"><strong>First Appearance:</strong> <span>Detective Comics #27 (May 1939)</span></div>
                <div class="profile-item"><strong>Affiliations:</strong> <span>Justice League, Batman Family, Wayne Enterprises, Outsiders</span></div>
            </div>
            <div class="bio-section">
                <h3>Origin Story</h3>
                <p>Bruce Wayne witnessed the murder of his parents, Thomas and Martha Wayne, in Crime Alley when he was just eight years old. This traumatic event shaped his entire life and set him on the path to becoming Batman.</p>
                <p>After years of training around the world in various martial arts, detective techniques, and sciences, Bruce returned to Gotham City. He chose the bat as his symbol to strike fear into the hearts of criminals, transforming himself into the Dark Knight.</p>
                <p>Operating from the Batcave beneath Wayne Manor, Batman wages a one-man war on crime, refusing to kill but using fear, intelligence, and cutting-edge technology to protect Gotham City from its darkest threats.</p>
            </div>
            <div class="bio-section">
                <h3>Creators</h3>
                <p><strong>Bob Kane</strong> - Credited as Batman's creator, Kane was the artist who first designed the character in 1939.</p>
                <p><strong>Bill Finger</strong> - For decades uncredited, Bill Finger was the true creative force behind Batman. He conceived the costume design, Gotham City, the Batcave, and many iconic villains like the Joker, Penguin, and Riddler.</p>
            </div>
        </div>

        <!-- ARTWORKS PAGE — pulled from DB -->
        <div id="artwork" class="page">
            <h1>ARTWORKS & POSTERS</h1>
            <?php if (empty($artworks)): ?>
                <div class="empty-state-msg">
                    <div class="empty-icon">🖼️</div>
                    <h3>NO ARTWORKS ADDED YET</h3>
                    <p>Add artworks through the <a href="CRUD-BATMAN/login.php">admin panel</a> and they will appear here.</p>
                </div>
            <?php else: ?>
            <div class="artwork-grid">
                <?php foreach ($artworks as $art):
                    $raw = $art['image'] ?? '';
                    $img = !empty($raw) ? (strpos($raw,'img/') === 0 ? htmlspecialchars($raw) : 'img/'.htmlspecialchars($raw)) : 'img/artwork1.jpg';
                    $title = htmlspecialchars($art['title']);
                    $quote = htmlspecialchars($art['quote']);
                ?>
                <div class="artwork-card">
                    <div class="artwork-placeholder">
                        <img src="<?= $img ?>" alt="<?= $title ?>">
                    </div>
                    <div class="artwork-caption">
                        <h4><?= $title ?></h4>
                        <p>"<?= $quote ?>"</p>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
        </div>

        <!-- FEEDBACK PAGE (unchanged) -->
        <div id="feedback" class="page">
            <h1>FEEDBACK</h1>
            <p style="text-align: center; color: #988829; margin-bottom: 2rem;">Help us improve the Batman Universe website with your comments and suggestions</p>
            <div class="feedback-form">
                <form id="feedbackForm">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" id="name" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" required>
                    </div>
                    <div class="form-group">
                        <label for="comment">Comments & Suggestions</label>
                        <textarea id="comment" required></textarea>
                    </div>
                    <button type="submit">SUBMIT FEEDBACK</button>
                </form>
            </div>
            <div class="feedback-list" id="feedbackList">
                <h2>Recent Feedback</h2>
            </div>
        </div>

    </div><!-- end .container -->

    <footer>
        <div class="footer-content">
            <div class="footer-left">
                <h3>ABOUT THIS WEBSITE</h3>
                <p>The Batman Collection is a comprehensive digital archive dedicated to celebrating the legacy of the Dark Knight. This website showcases the evolution of Batman across multiple media formats, from his debut in 1939 to modern interpretations.</p>
                <p>Created as a tribute to one of the most iconic superheroes in pop culture history, this collection serves as a resource for fans, researchers, and anyone fascinated by the world of Gotham City.</p>
            </div>
            <div class="feedback-section">
                <h3>HELP US IMPROVE</h3>
                <p>Share your suggestions</p>
                <form id="footerFeedbackForm" class="footer-feedback-form">
                    <div class="footer-form-group">
                        <input type="text" id="footer-name" placeholder="Your Name" required>
                    </div>
                    <div class="footer-form-group">
                        <input type="email" id="footer-email" placeholder="Your Email" required>
                    </div>
                    <div class="footer-form-group">
                        <textarea id="footer-suggestion" placeholder="Your suggestions..." required></textarea>
                    </div>
                    <button type="submit">SEND FEEDBACK</button>
                </form>
            </div>
        </div>
        <div class="footer-info">
            <p>&copy; 2026 The Batman Universe | CS/IT ELEC1/ES101 Final Project</p>
            <p>Batman and all related characters are property of DC Comics</p>
        </div>
    </footer>

    <script src="ADARLOSCRIPT.js"></script>
</body>
</html>
