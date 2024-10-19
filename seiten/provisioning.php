<?php
    //array für die server und ihre spezifikationen
  
    $smallSpecs = array("cores" => 4, "ram" => 32768, "ssd" => 4000);
    $mediumSpecs = array("cores" => 8, "ram" => 65536, "ssd" => 8000);
    $bigSpecs = array("cores" => 16, "ram" => 131072, "ssd" => 16000);

    //array für die preise der komponente

    $corePriceList = array("1" => 5, "2" => 10, "4" => 18, "8" => 30, "16" => 45);
    $ramPriceList = array("512" => 5, "1024" => 10, "2048" => 20, "4096" => 40, "8192" => 80, "16384" => 160, "32768" => 320);
    $ssdPriceList = array("10" => 5, "20" => 10, "40" => 20, "80" => 40, "240" => 120, "500" => 250, "1000" => 500);

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>| - OmniCloud - |</title>
    <link rel="stylesheet" href="../css/provisioning.css" />
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
        
    <main class="container">
      <div class="container-margin-provisioning">
        <h2 class="provisioning-title">Unsere Server, deine Auswahl</h2>
        <section class="provisioning-section-container">
          <div class="provisioning-section-container-padding">
            <form method="POST" action="provisioning.php" class="provisioning-section-form">
              <div class="provisioning-section">
                <h3>Wählen Sie die Anzahl CPU Kerne:</h3>
                <!--Schleife für CPU, RAM, SSD um die Radio buttons zu erstellen-->
                <?php foreach ($corePriceList as $key => $value) : ?>
                  <div class="provisioning-checkbox-label-container">
                    <input type="radio" name="CPU" value="<?php echo $key;?>" checked />
                    <label for="CPU"><?php echo $key; ?></label>
                    <p><?php echo $value; "Kerne" ?> CHF</p>
                  </div>
                <?php endforeach; ?> 
            </div>
            <div class="provisioning-section">
            <h3>Wählen Sie die RAM grösse:</h3>
                <?php foreach ($ramPriceList as $key => $value) : ?>
                  <div class="provisioning-checkbox-label-container">
                    <input type="radio" name="RAM" value="<?php echo $key; ?>" checked />
                    <label for="RAM"><?php echo $key. " MB"; ?></label>
                  <p><?php echo $value; "MB"; ?> CHF</p>
                </div>
                <?php endforeach; ?> 
                </div>
                <div class="provisioning-section">
                <h3>Wählen Sie den SSD Speicher:</h3>
                <?php foreach ($ssdPriceList as $key => $value) : ?>
                  <div class="provisioning-checkbox-label-container">
                    <input type="radio" name="SSD" value="<?php echo $key; ?>" checked/>
                    <label for="SSD"><?php echo $key. " GB"; ?></label>
                  <p><?php echo $value; "GB" ?> CHF</p>
                </div>
                <?php endforeach; ?> 
                </div>     
          </div>
        <section>
        <section class="provisioning-bottom-container">
          <div class="confirm-button-container">
            <button type="submit" name="submit" value="create">Kaufen</button>
        </div>
      </form>
    </section>    
    </main>
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

<?php
    
    
    //Explodiert die Datei vms.text und holt die werte in der File

    $virtualMachines = explode("\r\n", file_get_contents("../vms.txt"));

    // für jedes element in der feil wird geprüft zu welchem server es passt

    foreach ($virtualMachines as $vm) {
        $userInfo = explode(",", $vm);
        if (!empty($userInfo[0])) {
            $serverType = $userInfo[array_key_last($userInfo)];

            if ($serverType == "Small") {
                $smallSpecs["cores"] -= $userInfo[1];
                $smallSpecs["ram"] -= $userInfo[2];
                $smallSpecs["ssd"] -= $userInfo[3];
            } else if ($serverType == "Medium") {
                $mediumSpecs["cores"] -= $userInfo[1];
                $mediumSpecs["ram"] -= $userInfo[2];
                $mediumSpecs["ssd"] -= $userInfo[3];
            } else if ($serverType == "Big") {
                $bigSpecs["cores"] -= $userInfo[1];
                $bigSpecs["ram"] -= $userInfo[2];
                $bigSpecs["ssd"] -= $userInfo[3];
            }
        }
    }

    //prüft ob die werte gesetzt sind und erstellt eine virtuelle maschine in einem server und passt jeweils and dem server an

    if (isset($_POST["submit"]) && $_POST["submit"] == "create") {
        if (isset($_POST["CPU"]) && isset($_POST["RAM"]) && isset($_POST["SSD"])) {
            $cpu = $_POST["CPU"];
            $ram = $_POST["RAM"];
            $ssd = $_POST["SSD"];

            function createVirtualMachine($id, $cpu, $ram, $ssd, $serverType) {
                $fileString = file_get_contents("../vms.txt");
                $fileString .= "$id,$cpu,$ram,$ssd,$serverType\r\n";
                file_put_contents("../vms.txt", $fileString);
            }

            if ($cpu <= $smallSpecs["cores"] && $ram <= $smallSpecs["ram"] && $ssd <= $smallSpecs["ssd"]) {
                createVirtualMachine(time(), $cpu, $ram, $ssd, "Small");
            } else if ($cpu <= $mediumSpecs["cores"] && $ram <= $mediumSpecs["ram"] && $ssd <= $mediumSpecs["ssd"]) {
                createVirtualMachine(time(), $cpu, $ram, $ssd, "Medium");
            } else if ($cpu <= $bigSpecs["cores"] && $ram <= $bigSpecs["ram"] && $ssd <= $bigSpecs["ssd"]) {
                createVirtualMachine(time(), $cpu, $ram, $ssd, "Big");
            } else {
                echo '<script>alert("Leider ist auf keinem Server genügend Speicherplatz vorhanden, um diese virtuelle Maschine zu erstellen.")</script>';
            }
        }
    }  
?>
