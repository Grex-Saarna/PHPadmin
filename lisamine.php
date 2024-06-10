<?php
include("config.php");
session_start();

// Kui vorm on esitatud
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $koht = $_POST['koht'];
    $hinnang = $_POST['hinnang'];
    $eesnimi = $_POST['eesnimi']; // Veerunime muudetud 'eesnm' -> 'eesnimi'
    $perenimi = $_POST['perenimi']; // Veerunime muudetud 'perenim' -> 'perenimi'

    // Valmistame ette päringu andmete lisamiseks
    $lisamise_paring = "INSERT INTO koht (koht, hinnang, eesnm, perenim) VALUES ('$koht', '$hinnang', '$eesnimi', '$perenimi')"; // Veerunime muudetud 'eesnm' -> 'eesnimi', 'perenim' -> 'perenimi'

    if (mysqli_query($yhendus, $lisamise_paring)) {
        echo "Andmed lisatud edukalt.";
    } else {
        echo "Viga andmete lisamisel: " . mysqli_error($yhendus);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <title>Lisa koht ja inimene</title>
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
                    <li class="nav-item">
                        <a class="nav-link" href="admin/lisamine.php">Lisamine</a>
                    </li>
                    <?php if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in']): ?>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container">
        <h1>Lisa uus koht ja inimene</h1>
        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <div class="mb-3">
                <label for="koht" class="form-label">Koht</label>
                <input type="text" class="form-control" id="koht" name="koht" required>
            </div>
            <div class="mb-3">
                <label for="hinnang" class="form-label">Hinnang</label>
                <input type="number" class="form-control" id="hinnang" name="hinnang" required>
            </div>
            <div class="mb-3">
                <label for="eesnimi" class="form-label">Eesnimi</label> <!-- Veerunime muudetud 'eesnm' -> 'eesnimi' -->
                <input type="text" class="form-control" id="eesnimi" name="eesnimi" required> <!-- Veerunime muudetud 'eesnm' -> 'eesnimi' -->
            </div>
            <div class="mb-3">
                <label for="perenimi" class="form-label">Perenimi</label> <!-- Veerunime muudetud 'perenim' -> 'perenimi' -->
                <input type="text" class="form-control" id="perenimi" name="perenimi" required> <!-- Veerunime muudetud 'perenim' -> 'perenimi' -->
            </div>
            <button type="submit" class="btn btn-primary">Lisa</button>
        </form>
    </div>
</body>
</html>

<?php mysqli_close($yhendus); ?>
