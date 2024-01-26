<?php
require_once 'hoofd.php';
require_once 'middenpagina.php';
require_once 'voet.php';

require_once 'klacht.php';
$klachten = new Klachten();
$klachten->verwijderOudeKlachten();
?>