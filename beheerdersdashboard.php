<?php
session_start();
require_once 'hoofd1.php';
require_once 'beheerders.php';

if (!isset($_SESSION['beheerderid'])) {
    header("Location: beheerderlogin.php");
    exit();
}

$beheerders = new Beheerders();
$recenteKlachten = $beheerders->getRecenteKlachten();
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Beheerdersdashboard</title>
    <style>
        body {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        h2 {
            margin-bottom: 20px;
        }

        table {
            width: 50%;
            border-collapse: collapse;
            cursor: pointer;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }

        th {
            background-color: lightseagreen;
        }

        tr:hover {
            background-color: #f5f5f5;
        }

        #klachtenButton {
            margin-top: 20px;
            padding: 10px;
            background-color: lightseagreen;
        }
    </style>
</head>
<body>
<h2>5 recente klachten</h2>

<table id="klachtenTable">
    <tr>
        <th>Klacht ID</th>
        <th>Titel</th>
        <th>Beschrijving</th>
        <th>Datum</th>
        <th>Email</th>
        <th>Latitude</th>
        <th>Longitude</th>

    </tr>


    <?php foreach ($recenteKlachten as $klacht): ?>
        <tr class="klachtRow" data-klachtid="<?php echo $klacht['klachtid']; ?>">
            <td><?php echo $klacht['klachtid']; ?></td>
            <td><?php echo $klacht['titel']; ?></td>
            <td><?php echo $klacht['beschrijving']; ?></td>
            <td><?php echo $klacht['datum']; ?></td>
            <td><?php echo $klacht['Email']; ?></td>
            <td><?php echo $klacht['latitude']; ?></td>
            <td><?php echo $klacht['longitude']; ?></td>

        </tr>
    <?php endforeach; ?>
</table>

<button id="klachtenButton" onclick="window.location.href='alleklachten.php'">Zie alle klachten</button>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        var rows = document.getElementsByClassName('klachtRow');
        Array.from(rows).forEach(function (row) {
            row.addEventListener('click', function () {
                var klachtId = this.getAttribute('data-klachtid');
                window.location.href = 'searchklacht1.php?klachtid=' + klachtId;
            });
        });
    });
</script>

</body>
</html>
