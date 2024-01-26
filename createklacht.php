<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once 'klacht.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $latitude = $_POST['latitude'];
    $longitude = $_POST['longitude'];

    // Afbeelding verwerken als deze is geüpload
    if ($_FILES['afbeelding']['error'] == 4) {
        // Er is geen afbeelding geüpload, doe hier wat je nodig hebt of laat het leeg
        $afbeelding = null;
    } elseif ($_FILES['afbeelding']['error'] !== UPLOAD_ERR_OK) {
        echo "Er is een fout opgetreden bij het uploaden van de afbeelding: " . $_FILES['afbeelding']['error'];
        exit();
    } else {
        $uploadDirectory = 'uploads/';
        $uploadedFile = $uploadDirectory . basename($_FILES['afbeelding']['name']);

        if (move_uploaded_file($_FILES['afbeelding']['tmp_name'], $uploadedFile)) {
            $afbeelding = $uploadedFile;
        } else {
            echo "Er is een fout opgetreden bij het uploaden van de afbeelding.";
            exit();
        }
    }

    $klachten = new Klachten();
    $klachtInfo = $klachten->createKlacht($_POST['titel'], $_POST['beschrijving'], $_POST['datum'], $_POST['email'], $latitude, $longitude, $afbeelding);

    $message = "Klacht succesvol toegevoegd. Klacht ID: {$klachtInfo['klachtid']} Latitude: {$klachtInfo['latitude']} Longitude: {$klachtInfo['longitude']}";
    header("Location: index.php?message=" . urlencode($message));
    exit();
}
?>
