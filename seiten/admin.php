<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>| - OmniCloud - |</title>
    <link rel="stylesheet" href="../css/admin.css">
    <link href='https://fonts.googleapis.com/css?family=League Spartan' rel='stylesheet'>
</head>
<body>
    <div class="navbar">
        <div class="navbar-start">
            <img src="../bilder/omnicloud_logo_big.png" alt="Logo" class="logo">
            <span>OmniCloud</span>
        </div>
        <div class="navbar-links">
            <a href="../index.php">Home</a>    
            <a href="provisioning.php">Dienste</a>
            <a href="dashboard.php">Dashboard</a>
            <a href="uberuns.php">Über uns</a>
            <a href="admin.php">Admin</a>
        </div>
    </div>

<?php

//preiseliste array von den verschiedenen komponenten
$corePriceList = array("1" => 5, "2" => 10, "4" => 18, "8" => 30, "16" => 45);
$ramPriceList = array("512" => 5, "1024" => 10, "2048" => 20, "4096" => 40, "8192" => 80, "16384" => 160, "32768" => 320);
$ssdPriceList = array("10" => 5, "20" => 10, "40" => 20, "80" => 40, "240" => 120, "500" => 250, "1000" => 500);

//daten von der datei werden geholt, komponente die ausgwöhlt wurden werden angezeigt, summiert auch die kosten der komponenten

$virtualMachines = explode("\r\n", file_get_contents("../vms.txt"));
$totalCost = 0;
echo "<div class='vm-list'>";
foreach ($virtualMachines as $vm) {
    $userInfo = explode(",", $vm);
    if (!empty($userInfo[0])) {
        $vmCost = $corePriceList[$userInfo[1]] + $ramPriceList[$userInfo[2]] + $ssdPriceList[$userInfo[3]];
        $totalCost += $vmCost;
        echo "<div class='vm-info'>";
        echo "<p id='vm-id'>ID: ".$userInfo[0]."</p>";
        echo "<p id='vm-id'>Cores: ".$userInfo[1]. "</p>";
        echo "<p id='vm-id'>RAM: ".$userInfo[2]." MB</p>";
        echo "<p id='vm-id'>SSD: ".$userInfo[3]." GB</p>";
        echo "<p id='vm-id'>Preis: ".$vmCost." CHF</p>";
        echo "</div>";
    }
}
echo "</div>";
echo "<div class='total-cost'><h2>Gesamtumsatz</h2><p>".$totalCost ." CHF</p></div>";
?>
    <footer>
        <div class="footer-info">
            <div>
                <p>Copyright &copy; 2023 OmniCloud AG</p>
                <a href="impressum.php">Impressum</a>
            </div>
        </div>
    </footer>
</body>
</html>