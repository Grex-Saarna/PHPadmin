<?php
$parool = 'gregori';
$sool = 'taiestisuvalinetekst';
$kryp = crypt($parool, $sool);
echo $kryp;
?>
