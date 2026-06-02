<?php
session_start();
$error = '';

if (isset($_POST['login'])) {
    require_once "conn.php";

    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = hash('sha256', $_POST['password']);

    $sql    = "SELECT * FROM $tablelogin WHERE username='$username' AND password_hash='$password'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) === 1) {
        $user = mysqli_fetch_assoc($result);
        $_SESSION['username'] = $username;
        $_SESSION['role']     = $user['role'];
        header('Location: index.php');
        exit;
    } else {
        $error = "INVALID USERNAME AND/OR PASSWORD.";
    }
    mysqli_close($conn);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Batman DB — Login</title>
    <?php include("css.php"); ?>
</head>
<body>
<div class="auth-wrap">
    <div class="auth-card">

        <div class="auth-logo">
            <img src="../img/BatmanLogo5.png" alt="Batman" style="width:120px; margin-bottom:0.5rem;">
            <h2>BATMAN DATABASE</h2>
            <p>REGISTRY SYSTEM</p>
        </div>

        <?php if (!empty($error)): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>

        <?php if (isset($_SESSION['status'])): ?>
            <div class="alert alert-success"><?php echo $_SESSION['status']; unset($_SESSION['status']); ?></div>
        <?php endif; ?>

        <form name="frmLogin" action="" method="POST">
            <div class="form-group">
                <label>USERNAME</label>
                <input type="text" name="username" placeholder="Enter username" required autocomplete="off">
            </div>
            <div class="form-group">
                <label>PASSWORD</label>
                <input type="password" name="password" placeholder="Enter password" required>
            </div>
            <div class="form-actions">
                <input type="submit" class="btn-bat success" name="login" value="⚡ ACCESS SYSTEM"
                       style="flex:1;justify-content:center;padding:0.8rem;font-size:1rem;">
            </div>
            <div style="text-align:center;margin-top:1.2rem;">
                <span style="font-family:'Anton',sans-serif;font-size:0.8rem;letter-spacing:1px;color:var(--bat-gold);">
                    NO ACCOUNT? <a class="auth-link" href="register.php">REGISTER HERE</a>
                </span>
            </div>
            <div style="text-align:center;margin-top:0.8rem;">
                <a href="../index.php" style="font-family:'Anton',sans-serif;font-size:0.8rem;letter-spacing:1px;color:#8090b0;text-decoration:none;display:inline-flex;align-items:center;gap:0.4rem;transition:color 0.2s;"
                   onmouseover="this.style.color='#fdff00'" onmouseout="this.style.color='#8090b0'">
                    ← BACK TO MAIN WEBSITE
                </a>
            </div>
        </form>

    </div>
</div>
<?php include("js.php"); ?>
</body>
</html>
