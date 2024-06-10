<?php
include("config.php");
session_start();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>
<body> 

<?php
// Funktsioon keskmise hinnangu arvutamiseks
function keskmine_hinnang($koht_id, $yhendus) {
    $paring = "SELECT AVG(hinnang) AS keskmine FROM koht WHERE id = $koht_id";
    $tulemus = mysqli_query($yhendus, $paring);
    $rida = mysqli_fetch_assoc($tulemus);
    return $rida['keskmine'];
}


// Filtreerimine
$sort_order = "ASC"; // Vaikeväärtus
if(isset($_GET['sort']) && ($_GET['sort'] == 'desc')) {
    $sort_order = "DESC"; // Kui kasutaja soovib kahanevat järjestust
}
?>


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
                    
                    <?php if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in']): ?>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container">
        <h1>Kohad ja Hinnangud</h1>
        <hr>  
        <table class="table">
            <thead>
                <tr>
                    <th>id</th>
                    <th>Kohvik</th>
                    <th>Asukoht</th>
                    <th>Hinne</th>
                    <th>Hindajate arv</th>
                </tr>
            </thead>
            <tbody>
                
                <?php
                $hinnang_lehel = 10; // Muudetud 5-lt 10-le
                //lehtede arvutamine
                $hinnang_kokku_paring = "SELECT COUNT(*) FROM koht";
                $lehtede_vastus = mysqli_query($yhendus, $hinnang_kokku_paring);
                $hinnang_kokku = mysqli_fetch_array($lehtede_vastus);
                $lehti_kokku = $hinnang_kokku[0];
                $lehti_kokku = ceil($lehti_kokku/$hinnang_lehel);
                //kasutaja valik
                if (isset($_GET['leht'])) {
                    $leht = $_GET['leht'];
                } else {
                    $leht = 1;
                }
                
                $start = ($leht-1) * $hinnang_lehel;
                
                $paring = "SELECT * FROM koht ORDER BY hinnang $sort_order LIMIT $start, $hinnang_lehel";
                $vastus = mysqli_query($yhendus, $paring);
                //väljastamine
                while ($rida = mysqli_fetch_assoc($vastus)){
                    echo '<tr>';
                    echo '<td>'.$rida['id'].'</td>';
                    echo '<td><a href="kohvik.php?id='.$rida['id'].'">'.$rida['kohvik'].'</a></td>';
                    echo '<td>'.$rida['asukoht'].'</td>';
                    echo '<td>'.$rida['hinnang'].'</td>';
                    echo '<td>'.$rida['hindajate_arv'].'</td>';
                    echo '</tr>';
                }
                ?>
            </tbody>
        </table>
        <!-- Filtreerimise lingid -->
        <a href="?sort=asc">Kasvav järjestus</a>
        <a href="?sort=desc">Kahanev järjestus</a>
        <!-- kuvame lingid -->
        <?php
        $eelmine = $leht - 1;
        $jargmine = $leht + 1;
        if ($leht>1) {
            echo "<a href=\"?leht=$eelmine\">Eelmine</a> ";
        }
        if ($lehti_kokku >= 1)
        {
            for ($i=1; $i<=$lehti_kokku ; $i++) { 
                if ($i==$leht) {
                    echo "<b><a href=\"?leht=$i\">$i</a></b> ";
                } else {
                    echo "<a href=\"?leht=$i\">$i</a> ";
                }
            }
        }
        if ($leht<$lehti_kokku) {
            echo "<a href=\"?leht=$jargmine\">Järgmine</a> ";
        }
        ?>
        <?php
        $yhendus->close();
        ?>   
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
</body>
</html>
