<?php
$mysqli = new mysqli('localhost','root', '123qwe', "Product_Master");

if ($mysqli->connect_error) {//connetto al database
    die('Errore di connessione (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
    exit();
}
else {
    //echo '<center><p>' . 'Connesso. ' . $mysqli->host_info . '</p></center>';
}

class gestioneprodotti
{
}
