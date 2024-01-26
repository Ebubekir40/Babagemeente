<?php
require_once 'klacht.php';
require_once 'hoofd1.php';

if (!isset($_SESSION['beheerderid'])) {
    header("Location: beheerderlogin.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    if (isset($_GET['klachtid'])) {
        $klachtid = $_GET['klachtid'];

        // Maak een nieuw Klachten object
        $klachten = new Klachten();

        // Roep de deleteKlacht functie aan om de klacht te verwijderen
        $klachten->deleteKlacht($klachtid);

        // Redirect naar een andere pagina of geef een succesbericht weer
        header("Location: alleklachten.php");
        exit();
    }
}
?>

