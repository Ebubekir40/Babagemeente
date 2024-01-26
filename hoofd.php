<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gemeentebabalar</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<style>
body {
padding-top: 150px;
}

.navbar {
background-color: white;
box-shadow: 0 4px 2px -2px gray;
}

.navbar-brand img {
max-height: 125px;
}

.navbar-nav {
justify-content: space-between;
}

.navbar-nav.ml-auto {
margin-right: 0;
}

.nav-item {
margin-right: 45px;
}

.navbar-nav .nav-link {
color: lightseagreen !important;
font-size: 20px;
font-weight: bold;
}

.navbar-toggler-icon {
border: 2px solid lightseagreen;
}
</style>
<body>
<header>
    <nav class="navbar navbar-expand-lg navbar-light fixed-top">
        <a class="navbar-brand" href="index.php"><img src="nieuwGB.png" alt="Logo"></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="dashboard.php">Dashboard</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="klachtenform.php">Klacht indienen</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="beheerdersdashboard.php">Beheerdersdashboard</a>
                </li>
                <li class="nav-item">
                    <?php
                    // Controleer of de gebruiker is ingelogd voordat de link wordt weergegeven
                    if (isset($_SESSION['beheerderid'])) {
                        echo '<a class="nav-link" href="uitloggen.php">Uitloggen</a>';
                    }
                    ?>
                </li>
            </ul>
        </div>
    </nav>
</header>
</body>

</html>
