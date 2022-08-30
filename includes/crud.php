<?php

include "database.php";

class CRUD_Operations
{

    public static $konekcija = null;
    private static $instance = null;

    private function __construct()
    {
        self::$konekcija = Database::getInstance()->getConnection();
    }


    public static function getInstance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new CRUD_Operations();
        }

        return self::$instance;
    }

    public function register($ime, $sifra, $email)
    {
        $sql = "INSERT INTO korisnik (ime,sifra, email) VALUES ('" . $ime . "','" . $sifra . "', '" . $email . "')";
        if (self::$konekcija->query($sql)) {
            $id = self::$konekcija->insert_id;
            $_SESSION['id'] = $id;
            $_SESSION['ime'] = $ime;
            echo json_encode(array("statusCode" => 200));
        } else {
            echo json_encode(array("statusCode" => 201));
        }
    }

    public function login($email, $pw)
    {
        $sql = "SELECT * FROM korisnik WHERE email='" . $email . "' AND sifra='" . $pw . "'";
        if ($q = self::$konekcija->query($sql)) {
            if ($q->num_rows == 0) {
                echo json_encode(array("statusCode" => 202));
            } else {
                $red = mysqli_fetch_object($q);
                $_SESSION['id'] = $red->KorisnikId;
                $_SESSION['ime'] = $red->Ime;
                echo json_encode(array("statusCode" => 200));
            }
        } else {
            echo json_encode(array("statusCode" => 201));
        }
    }

    public function insert($activityName, $startingTime, $endingTime, $description)
    {
        $aktivnostid = null;
        $sql = "SELECT * FROM aktivnost WHERE NazivAktivnosti='" . $activityName . "'";
        if ($q = self::$konekcija->query($sql)) {
            if ($q->num_rows == 0) {
                echo "<p>That activity doesn't exist</p>";
                exit();
            } else {
                $red = mysqli_fetch_object($q);
                $aktivnostid = $red->AktivnostId;
            }
        }
        $query = "INSERT INTO raspored(KorisnikId,AktivnostId,VremePocetka,VremeZavrsetka,Opis) 
              VALUES('" . $_SESSION['id'] . "','" . $aktivnostid . "','" . $startingTime . "','" . $endingTime . "','" . $description . "')";
        if (self::$konekcija->query($query)) {
            echo '<p> Activity inserted </p>';
        } else {
            echo '<p> There was an error while inserting activity </p>';
        }
    }
    public function selectOne($id)
    {
        $query = "SELECT a.NazivAktivnosti as 'aktivnost',r.VremePocetka as 'vremePocetka',r.VremeZavrsetka as 'vremeZavrsetka',r.Opis as 'opis' FROM raspored r join aktivnost a on r.AktivnostId =a.AktivnostId WHERE Id =" . $id;
        $result = self::$konekcija->query($query);
        while ($row = $result->fetch_object()) {
            $output['activityName'] = $row->aktivnost;
            $output['startingTime'] = $row->vremePocetka;
            $output['endingTime'] = $row->vremeZavrsetka;
            $output['description'] = $row->opis;
        }

        echo json_encode($output);
    }

    public function edit($activityName, $startingTime, $endingTime, $description, $hidden_id)
    {
        $aktivnostid = null;
        $sql = "SELECT * FROM aktivnost WHERE NazivAktivnosti='" . $activityName . "'";
        if ($q = self::$konekcija->query($sql)) {
            if ($q->num_rows == 0) {
                echo "<p>That activity doesn't exist</p>";
                exit();
            } else {
                $red = mysqli_fetch_object($q);
                $aktivnostid = $red->AktivnostId;
            }
        }
        $query = "UPDATE raspored
		          SET AktivnostId = '" . $aktivnostid . "', 
                  VremePocetka = '" . $startingTime . "' ,
                  VremeZavrsetka = '" . $endingTime . "' ,
                  Opis = '" . $description . "' 
		          WHERE id = '" . $hidden_id . "'
                  ";
        if (self::$konekcija->query($query)) {
            echo '<p>Activity Updated</p>';
        } else {
            echo '<p>Error while updating activity</p>';
        }
    }
    public static function delete($id)
    {
        $query = "DELETE FROM raspored WHERE Id = '" . $id . "'";
        if (self::$konekcija->query($query)) {
            echo '<p>Activity Deleted</p>';
        } else {
            echo '<p>Error while deleting activity/p>';
        }
    }
}
