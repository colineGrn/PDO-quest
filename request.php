<?php
require_once 'connec.php';

$pdo = new PDO(DSN, USER, PASS);

// Pour afficher les lignes déjà insérées dans la table friend
$query = "SELECT * FROM friend";
$statement = $pdo->query($query);
$friendsArray = $statement->fetchAll(PDO::FETCH_ASSOC);

foreach($friendsArray as $friend) {
    echo $friend['firstname'] . ' ' . $friend['lastname'];
}

// Pour insérer une ligne dans la table friend
$query = "INSERT INTO friend (firstname, lastname) VALUES ('Chandler', 'Bing')";
$statement = $pdo->exec($query);
