<?php
require_once 'Beheerders.php';
require_once 'hoofd.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $gebruikersnaam = $_POST['gebruikersnaam'];
    $wachtwoord = $_POST['wachtwoord'];
    $voornaam = $_POST['voornaam'];
    $achternaam = $_POST['achternaam'];
    $email = $_POST['email'];

    $beheerders = new Beheerders();

    // Check if the username is already in use for administrators
    if (!$beheerders->gebruikersnaamInGebruikVoorBeheerders($gebruikersnaam)) {
        // Check if the email address has the correct domain
        if (endsWith($email, "@gemeentebabalar.nl")) {
            // Attempt to create the administrator
            if ($beheerders->create($gebruikersnaam, $wachtwoord, $voornaam, $achternaam, $email)) {
                header("Location: beheerderlogin.php?success=1"); // Redirect to login with success flag
                exit();
            } else {
                $message = "Registratie mislukt. Probeer het opnieuw.";
            }
        } else {
            $message = "Registratie mislukt. Vraag hulp bij werkgever.";
        }
    } else {
        $message = "Deze gebruikersnaam is al in gebruik. Kies een andere.";
    }
}

function endsWith($haystack, $needle) {
    return substr($haystack, -strlen($needle)) === $needle;
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Registratiepagina</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
          rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>

<body>
<div class="container">
    <h2>Registratie</h2>
    <?php if (isset($message)) : ?>
        <div class="alert alert-danger" role="alert">
            <?php echo $message; ?>
        </div>
    <?php endif; ?>

    <form action="beheerderregister.php" method="post">
        <div class="mb-3">
            <label for="gebruikersnaam" class="form-label">Gebruikersnaam:</label>
            <input type="text" class="form-control" id="gebruikersnaam" name="gebruikersnaam" required>
        </div>
        <div class="mb-3">
            <label for="wachtwoord" class="form-label">Wachtwoord:</label>
            <input type="password" class="form-control" id="wachtwoord" name="wachtwoord" required>
        </div>
        <div class="mb-3">
            <label for="voornaam" class="form-label">Voornaam:</label>
            <input type="text" class="form-control" id="voornaam" name="voornaam" required>
        </div>
        <div class="mb-3">
            <label for="achternaam" class="form-label">Achternaam:</label>
            <input type="text" class="form-control" id="achternaam" name="achternaam" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">E-mail:</label>
            <input type="text" class="form-control" id="email" name="email" required>
        </div>
        <button type="submit" class="btn btn-lightseagreen">Registreren</button>
    </form>
</div>
</body>
</html>
