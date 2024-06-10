<?php
session_start();
include("../config.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nimi = $_POST['nimi'];
    $pass = $_POST['pass'];

    $sql = "SELECT * FROM kasutajad WHERE nimi='$nimi'";
    $result = mysqli_query($yhendus, $sql);
    $user = mysqli_fetch_assoc($result);

    if ($user && password_verify($pass, $user['pass'])) {
        $_SESSION['admin_logged_in'] = true;
        header("Location: ../../Tieto/admin/KT.php"); // Muudetud suunamise tee
        exit;
    } else {
        $error = "Vale kasutajanimi või salasõna!";
    }
}
?>

<!DOCTYPE html>
<html lang="et">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admini sisselogimine</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="../index.php">Avaleht</a>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="KT.php">Kasutajate haldus</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="login.php">Admini sisselogimine</a>
                    </li>
                    <?php if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in']): ?>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container">
        <h1>Admini sisselogimine</h1>
        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>
        <?php if (isset($_SESSION['message'])): ?>
            <div class="alert alert-success"><?php echo $_SESSION['message']; unset($_SESSION['message']); ?></div>
        <?php endif; ?>
        <form action="" method="POST">
            <div class="mb-3">
                <label for="nimi" class="form-label">Kasutajanimi</label>
                <input type="text" class="form-control" id="nimi" name="nimi" required>
            </div>
            <div class="mb-3">
                <label for="pass" class="form-label">Salasõna</label>
                <input type="password" class="form-control" id="pass" name="pass" required>
            </div>
            <button type="submit" class="btn btn-primary">Logi sisse</button>
        </form>
        <p>Kui sul pole kontot, <a href="register.php">registreeri siin</a>.</p>
    </div>
</body>
</html>
