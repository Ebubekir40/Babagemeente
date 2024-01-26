<?php
session_start();

require_once 'Beheerders.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $gebruikersnaam = $_POST['gebruikersnaam'];
    $wachtwoord = $_POST['wachtwoord'];

    $beheerders = new Beheerders();
    $beheerderid = $beheerders->validateBeheerder($gebruikersnaam, $wachtwoord);

    if ($beheerderid) {
        // Geldige beheerder, sla de beheerderid op in de sessie
        $_SESSION['beheerderid'] = $beheerderid;
        header("Location: beheerdersdashboard.php");
        exit();
    } else {
        // Ongeldige inloggegevens
        $error = "Ongeldige inloggegevens. Probeer het opnieuw.";
    }
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Beheerderspagina - Inloggen</title>
</head>
<body>
    <h2>Inloggen</h2>
    <?php if (isset($error)) { echo "<p style='color: red;'>$error</p>"; } ?>
    <form action="beheerderspagina.php" method="post">
        Gebruikersnaam: <input type="text" name="gebruikersnaam" required><br>
        Wachtwoord: <input type="password" name="wachtwoord" required><br>
        <input type="submit" value="Inloggen">
    </form>
</body>
</html>
