<?php
session_start();
include("../config.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nimi = $_POST['nimi'];
    $pass = password_hash($_POST['pass'], PASSWORD_BCRYPT);
    $roll = 1; // Näiteks tavalise kasutaja roll on 1

    $sql = "INSERT INTO kasutajad (nimi, pass, roll) VALUES ('$nimi', '$pass', '$roll')";
    if (mysqli_query($yhendus, $sql)) {
        $_SESSION['message'] = "Kasutaja edukalt registreeritud!";
        header("Location: login.php");
        exit;
    } else {
        $error = "Kasutajanimega on probleem, proovi uuesti.";
    }
}
?>

<!DOCTYPE html>
<html lang="et">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registreerimine</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>
<body>
    <div class="container">
        <h1>Registreerimine</h1>
        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>
        <form action="register.php" method="POST">
            <div class="mb-3">
                <label for="nimi" class="form-label">Kasutajanimi</label>
                <input type="text" class="form-control" id="nimi" name="nimi" required>
            </div>
            <div class="mb-3">
                <label for="pass" class="form-label">Salasõna</label>
                <input type="password" class="form-control" id="pass" name="pass" required>
            </div>
            <button type="submit" class="btn btn-primary">Registreeri</button>
        </form>
    </div>
</body>
</html>
