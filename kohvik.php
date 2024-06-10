<?php
include("config.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
    $paring = "SELECT * FROM koht WHERE id=41";
    $vastus = mysqli_query($yhendus, $paring);
    //väljastamine
    $rida = mysqli_fetch_assoc($vastus);
    var_dump($rida["kohvik"]);
    ?>
    
    <h1><?php var_dump($rida["kohvik"]); ?>Kohviku hindamine</h1>
</body>
</html>