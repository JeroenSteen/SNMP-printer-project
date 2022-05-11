<?php
require("vendor/autoload.php");

snmp_read_mib($_SERVER['MIBDIRS'].'SNMPv2-SMI.txt');

$generalPrintersConfigs = json_decode(file_get_contents("./configs/general_printers.json"), true);
$specificPrintersConfigs = json_decode(file_get_contents("./configs/specific_printers.json"), true);

foreach($specificPrintersConfigs as $specificPrintersConfigKey => $specificPrintersConfig) {
    
    $printer = new Printer(
        array_merge($generalPrintersConfigs, $specificPrintersConfig)
    );

    try {

        echo "<h3>Printer-IP: ".$printer->getIPAddress()."</h3>";
        echo "<h3>Factory-ID: ".$printer->getFactoryId()."</h3>";
        echo "<h3>Vendor name: ".$printer->getVendorName()."</h3>";
        echo "<h3>Serial number: ".$printer->getSerialNumber()."</h3>";

        echo "<h3>Black-white prints: ".$printer->getNumberOfPrintedBlacks()."</h3>";
        echo "<h3>Color prints: ".$printer->getNumberOfPrintedColors()."</h3>";
        echo "<h3>Total prints: ".$printer->getNumberOfPrintedPapers()."</h3>";

        echo "<h2>Toner levels:</h2>";
        echo "<strong style='background: cyan; color: black;'>Cyan [C]:</strong> ".$printer->getCyanTonerLevel()."%</br>";
        echo "<strong style='background: magenta; color: black;'>Magenta [M]:</strong> ".$printer->getMagentaTonerLevel()."%</br>";
        echo "<strong style='background: yellow; color: black;'>Yellow [Y]:</strong> ".$printer->getYellowTonerLevel()."%</br>";
        echo "<strong style='background: black; color: white;'>Black [K1]:</strong> : ".$printer->getBlackTonerFirstLevel()."%</br>";
        echo "<strong style='background: black; color: white;'>Black [K2]:</strong> ".$printer->getBlackTonerSecondLevel()."%</br>";

        echo "<h2>Drum levels:</h2>";
        echo "<strong style='background: cyan; color: black;'>Cyan [C]:</strong> ".$printer->getCyanDrumLevel()."%</br>";
        echo "<strong style='background: magenta; color: black;'>Magenta [M]:</strong> ".$printer->getMagentaDrumLevel()."%</br>";
        echo "<strong style='background: yellow; color: black;'>Yellow [Y]:</strong> ".$printer->getYellowDrumLevel()."%</br>";
        echo "<strong style='background: black; color: white;'>Black [K]:</strong> : ".$printer->getBlackDrumLevel()."%</br>";

        echo "<h2>Supply levels:</h2>";
        echo "<strong style='background: grey; color: black;'>Waste:</strong> ".$printer->getWasteContainerLevel()."</br>";
        echo "<strong style='background: grey; color: black;'>Fuser:</strong> ".$printer->getFuserAssemblyLevel()."%</br>";

    } catch(Exception $e) {

        echo $e->getMessage();

    }
    
}