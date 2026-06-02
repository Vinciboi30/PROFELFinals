<?php
session_start();

if (isset($_POST['register'])) {
    require_once "conn.php";

    $username = mysqli_real_escape_string($conn, trim($_POST['username']));
    $password = trim($_POST['password']);
    $confirm  = trim($_POST['confirm_password']);
    $role     = "user"; // default role

    if (empty($username) || empty($password) || empty($confirm)) {
        $error = "PLEASE FILL IN ALL REQUIRED FIELDS.";
    } elseif ($password !== $confirm) {
        $error = "PASSWORDS DO NOT MATCH.";
    } else {
        $check = mysqli_query($conn, "SELECT * FROM $tablelogin WHERE username='$username'");
        if (mysqli_num_rows($check) > 0) {
            $error = "USERNAME ALREADY EXISTS.";
        } else {
            $hashed = hash('sha256', $password);
            // users table: user_id, username, password_hash, role
            $sql = "INSERT INTO $tablelogin (username, password_hash, role)
                    VALUES ('$username', '$hashed', '$role')";
            if (mysqli_query($conn, $sql)) {
                $_SESSION['status'] = "✔ ACCOUNT CREATED. WELCOME TO BATMAN DATABASE.";
                header("Location: login.php");
                exit;
            } else {
                $error = "REGISTRATION FAILED: " . mysqli_error($conn);
            }
        }
    }
    mysqli_close($conn);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Batman DB — Register</title>
    <?php include("css.php"); ?>
</head>
<body>
<div class="auth-wrap">
    <div class="auth-card" style="width:480px">

        <div class="auth-logo">
            <img src="../img/BatmanLogo5.png" alt="Batman" style="width:120px; margin-bottom:0.5rem;">
            <h2>NEW ADMIN</h2>
            <p>REGISTER YOUR ACCOUNT</p>
        </div>

        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>

        <form method="POST" name="formReg">
            <div class="form-group">
                <label>USERNAME *</label>
                <input type="text" name="username" placeholder="Choose a username" required>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label>PASSWORD *</label>
                    <input type="password" name="password" placeholder="Password" required>
                </div>
                <div class="form-group">
                    <label>CONFIRM PASSWORD *</label>
                    <input type="password" name="confirm_password" placeholder="Confirm" required>
                </div>
            </div>
            <div class="form-actions">
                <a href="login.php" class="btn-bat" style="justify-content:center;">← BACK</a>
                <button type="submit" class="btn-bat success" name="register"
                        style="flex:1;justify-content:center;padding:0.8rem;font-size:1rem;">
                    CREATE ACCOUNT
                </button>
            </div>
        </form>

    </div>
</div>
<?php include("js.php"); ?>
</body>
</html>
