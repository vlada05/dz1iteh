<?php
include "includes/database.php";

session_start();
$konekcija = Database::getInstance()->getConnection();
$query = 'SELECT * FROM aktivnost ';

if (!empty($_POST["keyword"])) {
    $query .= 'WHERE NazivAktivnosti like "' . $_POST["keyword"] . '%" ';
}
$query .= 'ORDER BY NazivAktivnosti';

$result = $konekcija->query($query);

$output = '';
if (!empty($result)) {
    $output .= '<ul class="list-group">';
    while ($row = $result->fetch_object()) {
        $output .= '<li class="list-group-item list-group-item-action lijevi" id="' . $row->NazivAktivnosti . '">' . $row->NazivAktivnosti . '</li>';
    }
    $output .= '   </ul>';
    echo $output;
}
