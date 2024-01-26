<?php
session_start();

require_once 'hoofd.php';
require_once 'Beheerders.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $gebruikersnaam = $_POST['gebruikersnaam'];
    $wachtwoord = $_POST['wachtwoord'];

    $beheerders = new Beheerders();
    $beheerderid = $beheerders->validateBeheerder($gebruikersnaam, $wachtwoord);

    if ($beheerderid) {
        // Valid administrator, store the administrator ID in the session
        $_SESSION['beheerderid'] = $beheerderid;
        header("Location: beheerdersdashboard.php");
        exit();
    } else {

        $error = "Ongeldige inloggegevens. Probeer het opnieuw.";
    }
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Inloggen</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
          rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>
<body>
<div class="container">
    <h2>Inloggen</h2>
    <?php if (isset($error)) { echo "<p style='color: red;'>$error</p>"; } ?>
    <form action="beheerderlogin.php" method="post">
        <div class="mb-3">
            <label for="gebruikersnaam" class="form-label">Gebruikersnaam:</label>
            <input type="text" class="form-control" id="gebruikersnaam" name="gebruikersnaam" required>
        </div>
        <div class="mb-3">
            <label for="wachtwoord" class="form-label">Wachtwoord:</label>
            <input type="password" class="form-control" id="wachtwoord" name="wachtwoord" required>
        </div>
        <button type="submit" class="btn btn-primary">Inloggen</button>
    </form>

    <p>Nog geen beheerdersaccount? <a href="beheerderregister.php">Registreer hier</a>.</p>
</div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
</body>
</html>
