<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Klacht Details</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <style>
        #map {
            height: 400px;
        }
    </style>
</head>
<body>

<h1>Klachten</h1>

<?php
require_once 'beheerders.php';
require_once 'hoofd1.php';

if (!isset($_SESSION['beheerderid'])) {
    header("Location: beheerderlogin.php");
    exit();
}


error_reporting(E_ALL);
ini_set('display_errors', 1);

if (isset($_GET['klachtid'])) {
    $klachtid = $_GET['klachtid'];

    $beheerders = new Beheerders();
    $gevondenKlacht = $beheerders->zoekKlachtOpId($klachtid);

    if ($gevondenKlacht) {
        echo "Klacht ID: " . $gevondenKlacht['klachtid'] . "<br>";
        echo "Titel: " . $gevondenKlacht['titel'] . "<br>";
        echo "Beschrijving: " . $gevondenKlacht['beschrijving'] . "<br>";
        echo "Datum: " . $gevondenKlacht['datum'] . "<br>";
        echo "E-mail: " . $gevondenKlacht['Email'] . "<br>";

        echo '<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>';
        echo '<div id="map" style="height: 400px;"></div>';
        echo '<script>
                        var map = L.map("map").setView([' . $gevondenKlacht['latitude'] . ', ' . $gevondenKlacht['longitude'] . '], 13);
                        L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
                            attribution: "© OpenStreetMap contributors"
                        }).addTo(map);
                        L.marker([' . $gevondenKlacht['latitude'] . ', ' . $gevondenKlacht['longitude'] . ']).addTo(map)
                            .bindPopup("Locatie van de klacht");
                    </script>';

        echo '<script>
                        document.addEventListener("DOMContentLoaded", function() {
                            var klachtIdInput = document.getElementById("klachtid");
                            klachtIdInput.value = ' . $gevondenKlacht['klachtid'] . ';
                            document.getElementById("searchForm").submit();
                        });
                    </script>';
    } else {
        echo "Geen klacht gevonden met het opgegeven ID.";
    }
}
?>

<form id="searchForm" action="searchklacht.php" method="GET">
    <label for="klachtid">Voer klacht ID in:</label>
    <input type="text" id="klachtid" name="klachtid">
    <input type="submit" value="Zoeken">
</form>

</body>
</html>