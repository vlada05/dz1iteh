<?php
include "includes/database.php";

session_start();
$konekcija = Database::getInstance()->getConnection();
$query = "SELECT r.Id as 'id',a.NazivAktivnosti as 'aktivnost',r.VremePocetka as 'vremePocetka',r.VremeZavrsetka as 'vremeZavrsetka',r.Opis as 'opis' 
            FROM raspored r join aktivnost a on r.AktivnostId =a.AktivnostId WHERE KorisnikId=" . $_SESSION['id'];

if (isset($_POST['txtPolje']) && $_POST['txtPolje'] != '') {
    $query .= " AND (a.NazivAktivnosti LIKE '%" . $_POST['txtPolje'] . "%' OR r.VremePocetka LIKE '%" . $_POST['txtPolje'] . "%')";
}
$result = $konekcija->query($query);

$output = '<table class="table table-striped table=bordered"
        <tr>
            <th> Activity </th>
            <th> Start time </th>
            <th> End time </th>
            <th> Description </th>
            <th> Edit </th>
            <th> Delete </th>
        </tr>
        ';

while ($row = $result->fetch_object()) {
    $output .= '
            <tr>
                <td>' . $row->aktivnost . '</td>
                <td>' . $row->vremePocetka . '</td>
                <td>' . $row->vremeZavrsetka . '</td>
                <td>' . $row->opis . '</td>
                <td>
                    <button type="button" name="edit" class="btn 
                    btn-primary btn-xs edit" id="'
        . $row->id . '">Edit</button>
                </td>
                <td>
                    <button type="button" name="delete" class="btn 
                    btn-danger btn-xs delete" id="'
        . $row->id . '">Delete</button>
                    </td>
            </tr>
            ';
}


$output .= '</table>';

echo $output;
