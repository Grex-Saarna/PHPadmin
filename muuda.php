<?php
include ("config.php");
session_start();

if(isset($_GET['id'])) {
    $id = $_GET['id'];

    // Kui vorm on esitatud
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Töötle vormi andmed
        // Näiteks, kui soovite muuta rea välja "koht"
        $uus_koht = $_POST['uus_koht'];

        // Tee muudatus andmebaasis
        $muuda_paring = "UPDATE koht SET koht='$uus_koht' WHERE id=$id";
        if (mysqli_query($yhendus, $muuda_paring)) {
            echo "Kirje muudetud edukalt";
        } else {
            echo "Viga: " . mysqli_error($yhendus);
        }
    }

    // Näita vormi andmetega, mida saab muuta
    $paring = "SELECT * FROM koht WHERE id=$id";
    $tulemus = mysqli_query($yhendus, $paring);
    $rida = mysqli_fetch_assoc($tulemus);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php">Avaleht</a>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="KT.php">Kasutajate haldus</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="admin/login.php">Admini sisselogimine</a>
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
        <h1>Muuda rida</h1>
        <form method="post" action="">
            <div class="mb-3">
                <label for="uus_koht" class="form-label">Uus koht:</label>
                <input type="text" class="form-control" id="uus_koht" name="uus_koht" value="<?php echo $rida['koht']; ?>">
            </div>
            <button type="submit" class="btn btn-primary">Salvesta muudatused</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
</body>
</html>

<?php
} else {
    echo "ID puudub";
}
?>
