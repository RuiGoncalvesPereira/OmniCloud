<?php

// trennt die daten in der datei vms.text 
$virtualMachines = explode("\r\n", file_get_contents("../vms.txt"));

if (isset($_GET["submit"])) {
    $id = $_GET["submit"];

    $file = explode("\r\n", file_get_contents("../vms.txt"));

    for ($i = 0; $i < sizeof($file) - 1; $i++) {
        // id,cores,ram,ssd,server und löscht
        echo $file[$i];
        $user = explode(",", $file[$i]);
        if (!empty($user[0])) {
            if ($user[0] == $id) {
                echo $file[$i];
                $file[$i] = "";
                echo $id . " wurde Gelöscht";
                break;
            }
        }
    }
    $output = implode("\r\n", $file);
    $output = str_replace("\r\n\r\n", "\r\n", $output);
    file_put_contents("../vms.txt", $output);
}

//es werden alle vms aufgelistet, die im provisioning erstellt wurden

foreach ($virtualMachines as $vm) {
    $userInfo = explode(",", $vm);
    if (!empty($userInfo[0])) {
        echo "<div class='vm-info'>"; 
        echo "<p id='vm-id'>ID: ".$userInfo[0]."</p>";
        echo "<p id='vm-id'>Cores: ".$userInfo[1]. "</p>";
        echo "<p id='vm-id'>RAM: ".$userInfo[2]." MB</p>";
        echo "<p id='vm-id'>SSD: ".$userInfo[3]." GB</p>";
        echo "<p id='vm-id'>Server: ".$userInfo[4]."</p>";
        echo "<form action='dashboard.php' method='get'>
                <button type='submit' value='$userInfo[0]' name='submit' class='delete-btn'>Delete</button> 
              </form>
        ";
        echo "</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>| - OmniCloud - |</title>
    <link type="text/css" rel="stylesheet" href="../css/dashboard.css">
    <link href='https://fonts.googleapis.com/css?family=League Spartan' rel='stylesheet'>
</head>
<body>
    <div class="navbar">
        <div class="navbar-start">
            <img src="../bilder/omnicloud_logo_big.png" alt="Logo" class="logofavicon">
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