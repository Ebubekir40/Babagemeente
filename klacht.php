<?php

require_once 'db.php';

class Klachten
{
    private $conn;

    public function __construct()
    {
        $dbConnection = new DBConnection();
        $this->conn = $dbConnection->getConnection();
    }

    public function createKlacht($titel, $beschrijving, $datum, $email, $latitude, $longitude, $afbeelding)
    {
        $latitude = ($latitude !== null) ? $latitude : 0;
        $longitude = ($longitude !== null) ? $longitude : 0;

        $query = "INSERT INTO klachten (titel, beschrijving, datum, email, latitude, longitude, afbeelding) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);

        if (!$stmt) {
            die("Voorbereiden mislukt: (" . $this->conn->errno . ") " . $this->conn->error);
        }

        $stmt->bind_param("ssssdds", $titel, $beschrijving, $datum, $email, $latitude, $longitude, $afbeelding);

        if ($stmt->execute()) {
            $klachtid = $stmt->insert_id;
            return ["klachtid" => $klachtid, "latitude" => $latitude, "longitude" => $longitude];
        } else {
            die("Uitvoeren mislukt: (" . $stmt->errno . ") " . $stmt->error);
        }
    }

    public function verwijderOudeKlachten()
    {
        $vervaltermijn = strtotime("-14 days");
        $vervaltermijnDatum = date("Y-m-d", $vervaltermijn);

        $query = "DELETE FROM klachten WHERE datum < ?";
        $stmt = $this->conn->prepare($query);

        if (!$stmt) {
            die("Voorbereiden mislukt: (" . $this->conn->errno . ") " . $this->conn->error);
        }

        $stmt->bind_param("s", $vervaltermijnDatum);

        if ($stmt->execute()) {
            // Verwijderen van oude klachten succesvol
        } else {
            die("Uitvoeren mislukt: (" . $stmt->errno . ") " . $stmt->error);
        }
    }
    public function deleteKlacht($klachtid)
    {
        $query = "DELETE FROM klachten WHERE klachtid = ?";
        $stmt = $this->conn->prepare($query);

        if (!$stmt) {
            die("Voorbereiden mislukt: (" . $this->conn->errno . ") " . $this->conn->error);
        }

        $stmt->bind_param("i", $klachtid);

        if ($stmt->execute()) {
            // Klacht succesvol verwijderd
        } else {
            die("Uitvoeren mislukt: (" . $stmt->errno . ") " . $stmt->error);
        }
    }
}
?>
