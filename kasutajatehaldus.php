<?php
session_start();
include("../config.php");

// Funktsioon kasutaja kustutamiseks
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    $sql = "DELETE FROM kasutajad WHERE id = $delete_id";
    mysqli_query($yhendus, $sql);
    $_SESSION['message'] = "Kasutaja edukalt kustutatud!";
    header("Location: kasutajatehaldus.php");
    exit;
}

// Funktsioon kasutaja muutmiseks
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $new_name = $_POST['new_name'];
    // Jätame parooli muutmata, kuna see võib olla tundlik info
    $sql = "UPDATE kasutajad SET nimi='$new_name' WHERE id='$id'";
    mysqli_query($yhendus, $sql);
    $_SESSION['message'] = "Kasutaja edukalt uuendatud!";
    header("Location: kasutajatehaldus.php");
    exit;
}

// Andmebaasist kasutajate lugemine
$sql = "SELECT * FROM kasutajad";
$result = mysqli_query($yhendus, $sql);
$users = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="et">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kasutajate haldus</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>
<body>
    <div class="container">
        <h1>Kasutajate haldus</h1>
        <?php if (isset($_SESSION['message'])): ?>
            <div class="alert alert-success"><?php echo $_SESSION['message']; unset($_SESSION['message']); ?></div>
        <?php endif; ?>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nimi</th>
                    <th>Tegevused</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?php echo $user['id']; ?></td>
                        <td><?php echo $user['nimi']; ?></td>
                        <td>
                            <a href="edit.php?id=<?php echo $user['id']; ?>" class="btn btn-primary">Muuda</a>
                            <a href="kasutajatehaldus.php?delete_id=<?php echo $user['id']; ?>" class="btn btn-danger" onclick="return confirm('Kas oled kindel, et soovid kasutajat kustutada?')">Kustuta</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
