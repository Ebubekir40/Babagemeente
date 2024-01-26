<?php
require_once 'db.php';

class Beheerders
{
    private $conn;

    public function __construct()
    {
        $dbConnection = new DBConnection();
        $this->conn = $dbConnection->getConnection();
    }

    public function create($gebruikersnaam, $wachtwoord, $voornaam, $achternaam, $email)
    {
        $query = "INSERT INTO beheerders (gebruikersnaam, wachtwoord, voornaam, achternaam, email) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);

        if (!$stmt) {
            die("Voorbereiden mislukt: (" . $this->conn->errno . ") " . $this->conn->error);
        }

        $hashedPassword = password_hash($wachtwoord, PASSWORD_DEFAULT);

        $stmt->bind_param("sssss", $gebruikersnaam, $hashedPassword, $voornaam, $achternaam, $email);

        if ($stmt->execute()) {
            return true;
        } else {
            die("Uitvoeren mislukt: (" . $stmt->errno . ") " . $stmt->error);
        }
    }

    public function validateBeheerder($gebruikersnaam, $wachtwoord)
    {
        $query = "SELECT beheerderid, wachtwoord FROM beheerders WHERE gebruikersnaam = ?";
        $stmt = $this->conn->prepare($query);

        if (!$stmt) {
            die("Voorbereiden mislukt: (" . $this->conn->errno . ") " . $this->conn->error);
        }

        $stmt->bind_param("s", $gebruikersnaam);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $stmt->bind_result($beheerderid, $hashedPassword);
            $stmt->fetch();

            // Controleer het wachtwoord
            if (password_verify($wachtwoord, $hashedPassword)) {
                return $beheerderid; // Geldige beheerder
            }
        }

        return false; // Ongeldige beheerder
    }

    public function gebruikersnaamInGebruikVoorBeheerders($gebruikersnaam)
    {
        return $this->gebruikersnaamInGebruik($gebruikersnaam, 'beheerders');
    }

    public function gebruikersnaamInGebruik($gebruikersnaam)
    {
        $query = "SELECT beheerderid FROM beheerders WHERE gebruikersnaam = ?";
        $stmt = $this->conn->prepare($query);

        if (!$stmt) {
            die("Voorbereiden mislukt: (" . $this->conn->errno . ") " . $this->conn->error);
        }

        $stmt->bind_param("s", $gebruikersnaam);
        $stmt->execute();
        $stmt->store_result();

        return ($stmt->num_rows > 0);
    }


    public function zoekKlachtOpId($klachtid)
    {
        $query = "SELECT klachtid, titel, beschrijving, datum, Email, latitude, longitude FROM klachten WHERE klachtid = ?";
        $stmt = $this->conn->prepare($query);

        if (!$stmt) {
            die("Voorbereiden mislukt: (" . $this->conn->errno . ") " . $this->conn->error);
        }

        $stmt->bind_param("i", $klachtid); // 'i' staat voor integer
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            return $result->fetch_assoc(); // Retourneer de gevonden klacht
        } else {
            return null; // Geen klacht gevonden met het opgegeven ID
        }
    }

    public function getRecenteKlachten()
    {
        $query = "SELECT klachtid, titel, beschrijving, datum, Email, latitude, longitude FROM klachten ORDER BY datum DESC LIMIT 5";
        $stmt = $this->conn->prepare($query);

        if (!$stmt) {
            die("Voorbereiden mislukt: (" . $this->conn->errno . ") " . $this->conn->error);
        }

        $stmt->execute();
        $result = $stmt->get_result();

        $recenteKlachten = array();

        while ($row = $result->fetch_assoc()) {
            $recenteKlachten[] = $row;
        }

        return $recenteKlachten;
    }


    public function getAlleKlachten()
    {
        $query = "SELECT klachtid, titel, beschrijving, datum, Email, latitude, longitude FROM klachten";
        $stmt = $this->conn->prepare($query);

        if (!$stmt) {
            die("Voorbereiden mislukt: (" . $this->conn->errno . ") " . $this->conn->error);
        }

        $stmt->execute();
        $result = $stmt->get_result();

        $alleKlachten = array();

        while ($row = $result->fetch_assoc()) {
            $alleKlachten[] = $row;
        }

        return $alleKlachten;
    }
    public function updateBeheerderVoornaam($beheerderid, $nieuweVoornaam)
    {
        $query = "UPDATE beheerders SET voornaam = ? WHERE beheerderid = ?";
        $stmt = $this->conn->prepare($query);

        if (!$stmt) {
            die("Voorbereiden mislukt: (" . $this->conn->errno . ") " . $this->conn->error);
        }

        $stmt->bind_param("si", $nieuweVoornaam, $beheerderid);

        if ($stmt->execute()) {
            return true;
        } else {
            $error = "Uitvoeren mislukt: (" . $stmt->errno . ") " . $stmt->error;
            return $error;
        }
    }
    public function updateBeheerderAchternaam($beheerderid, $nieuweAchternaam)
    {
        $query = "UPDATE beheerders SET achternaam = ? WHERE beheerderid = ?";
        $stmt = $this->conn->prepare($query);

        if (!$stmt) {
            die("Voorbereiden mislukt: (" . $this->conn->errno . ") " . $this->conn->error);
        }

        $stmt->bind_param("si", $nieuweAchternaam, $beheerderid);

        if ($stmt->execute()) {
            return true;
        } else {
            $error = "Uitvoeren mislukt: (" . $stmt->errno . ") " . $stmt->error;
            return $error;
        }
    }
    public function updateBeheerderEmail($beheerderid, $nieuweEmail)
    {
        $query = "UPDATE beheerders SET email = ? WHERE beheerderid = ?";
        $stmt = $this->conn->prepare($query);

        if (!$stmt) {
            die("Voorbereiden mislukt: (" . $this->conn->errno . ") " . $this->conn->error);
        }

        $stmt->bind_param("si", $nieuweEmail, $beheerderid);

        if ($stmt->execute()) {
            return true;
        } else {
            $error = "Uitvoeren mislukt: (" . $stmt->errno . ") " . $stmt->error;
            return $error;
        }
    }
    public function zoekBeheerderOpId($beheerderid)
    {
        $query = "SELECT beheerderid, gebruikersnaam, voornaam, achternaam, email FROM beheerders WHERE beheerderid = ?";
        $stmt = $this->conn->prepare($query);

        if (!$stmt) {
            die("Voorbereiden mislukt: (" . $this->conn->errno . ") " . $this->conn->error);
        }

        $stmt->bind_param("i", $beheerderid); // 'i' staat voor integer
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            return $result->fetch_assoc(); // Retourneer de gevonden beheerdergegevens
        } else {
            return null; // Geen beheerder gevonden met het opgegeven ID
        }
    }

    public function updateBeheerderGegevens($beheerderid, $nieuweVoornaam, $nieuweAchternaam, $nieuweEmail)
    {
        // ... (bestaande update code blijft ongewijzigd)
    }

    // ...

    public function updateBeheerderGebruikersnaam($beheerderid, $nieuweGebruikersnaam)
    {
        $query = "UPDATE beheerders SET gebruikersnaam = ? WHERE beheerderid = ?";
        $stmt = $this->conn->prepare($query);

        if (!$stmt) {
            die("Voorbereiden mislukt: (" . $this->conn->errno . ") " . $this->conn->error);
        }

        $stmt->bind_param("si", $nieuweGebruikersnaam, $beheerderid);

        if ($stmt->execute()) {
            return true;
        } else {
            $error = "Uitvoeren mislukt: (" . $stmt->errno . ") " . $stmt->error;
            return $error;
        }
    }

    public function updateBeheerderWachtwoord($beheerderid, $nieuwWachtwoord)
    {
        $hashedPassword = password_hash($nieuwWachtwoord, PASSWORD_DEFAULT);

        $query = "UPDATE beheerders SET wachtwoord = ? WHERE beheerderid = ?";
        $stmt = $this->conn->prepare($query);

        if (!$stmt) {
            die("Voorbereiden mislukt: (" . $this->conn->errno . ") " . $this->conn->error);
        }

        $stmt->bind_param("si", $hashedPassword, $beheerderid);

        if ($stmt->execute()) {
            return true;
        } else {
            $error = "Uitvoeren mislukt: (" . $stmt->errno . ") " . $stmt->error;
            return $error;
        }
    }
}
?>
