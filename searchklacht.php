<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Klachten</title>
    <!-- Voeg de Leaflet CSS toe -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <!-- Optioneel: Voeg aanvullende CSS toe voor de kaartcontainer -->
    <style>
        #map {
            height: 400px;
        }

        /* Voeg deze CSS-stijlen toe voor de button */
        form {
            margin-top: 20px;
        }

        button {
            background-color: lightseagreen;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
        }

        button:hover {
            background-color: lightseagreen;
        }
    </style>
</head>
<body>

<div id="content" class="content">
    <h1>Klacht Details</h1>

    <?php
    require_once 'hoofd1.php';
    require_once 'beheerders.php';

    if (!isset($_SESSION['beheerderid'])) {
        header("Location: beheerderlogin.php");
        exit();
    }

    if (isset($_GET['klachtid'])) {
        $klachtid = $_GET['klachtid'];

        $beheerders = new Beheerders();
        $gevondenKlacht = $beheerders->zoekKlachtOpId($klachtid);

        if ($gevondenKlacht) {
            // Toon de gevonden klachtgegevens
            echo "Klacht ID: " . $gevondenKlacht['klachtid'] . "<br>";
            echo "Titel: " . $gevondenKlacht['titel'] . "<br>";
            echo "Beschrijving: " . $gevondenKlacht['beschrijving'] . "<br>";
            echo "Datum: " . $gevondenKlacht['datum'] . "<br>";
            echo "E-mail: " . $gevondenKlacht['Email'] . "<br>";

            // Voeg de Leaflet JavaScript toe
            echo '<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>';
            // Voeg de kaartcontainer toe
            echo '<div id="map" style="height: 400px;"></div>';
            // Voeg JavaScript toe om de kaart te initialiseren
            echo '<script>
                        var map = L.map("map").setView([' . $gevondenKlacht['latitude'] . ', ' . $gevondenKlacht['longitude'] . '], 13);
                        L.tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
                            attribution: "© OpenStreetMap contributors"
                        }).addTo(map);

                        var marker = L.marker([' . $gevondenKlacht['latitude'] . ', ' . $gevondenKlacht['longitude'] . '])
                            .bindPopup("<b>' . $gevondenKlacht['titel'] . '</b><br>' . $gevondenKlacht['beschrijving'] . '")
                            .addTo(map);
                    </script>';


            echo '<form action="deleteklacht.php" method="GET">
                      <input type="hidden" name="klachtid" value="' . $gevondenKlacht['klachtid'] . '">
                      <button type="submit">Verwijder Klacht</button>
                  </form>';
        } else {
            echo "Geen klacht gevonden met het opgegeven ID.";
        }
    } else {
        echo "Geen klacht ID opgegeven.";
    }
    ?>
</div>

</body>
</html>
