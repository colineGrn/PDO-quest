<?php
require_once 'connec.php';

$pdo = new PDO(DSN, USER, PASS);

//Liste les "friends" contenus dans la base, sous la forme d'une liste HTML

$query = "SELECT * FROM friend";
$statement = $pdo->query($query);
$friendsArray = $statement->fetchAll(PDO::FETCH_ASSOC);
?>

<h1>Friends:</h1>
<?php foreach($friendsArray as $friend) { ?>
        <ul>
            <li>
                <?= $friend['firstname'] . ' ' . $friend['lastname']; ?>
            </li>
        </ul>
    <?php
} ?>

<!-- Crée un formulaire simple disposant des champs obligatoires Firstname et Lastname -->

<form action="" method="post">
    <div>
        <label for="firstname">First name: </label>
        <br>
        <input type="text" id="firstname" name="firstname">
    </div>
    <br>
    <div>
        <label for="lastname">Last name: </label>
        <br>
        <input type="text" id="lastname" name="lastname">
    </div>
    <br>
    <button>Submit</button>
</form>

<?php

if ($_SERVER["REQUEST_METHOD"] === 'POST') {
    $newFriend = array_map('trim', $_POST);
    $errors = [];

    // Validate data
    if (empty($newFriend['firstname'])) {
        $errors[] = 'First name is required';
    }
    if (empty($newFriend['lastname'])) {
        $errors[] = 'Last name is required';
    }
    if (strlen($newFriend['firstname']) > 45) {
        $errors[] = 'The first name should be less than 45 characters';
    }
    if (strlen($newFriend['lastname']) > 45) {
        $errors[] = 'The last name should be less than 45 characters';
    }
    if (empty($errors)) {
        // On récupère les informations saisies précédemment dans le formulaire
        $firstname = trim($_POST['firstname']);
        $lastname = trim($_POST['lastname']);

// On prépare notre requête d'insertion
        $query = 'INSERT INTO friend (firstname, lastname) VALUES (:firstname, :lastname)';
        $statement = $pdo->prepare($query);

// On lie les valeurs saisies dans le formulaire à nos placeholders
        $statement->bindValue(':firstname', $firstname, PDO::PARAM_STR);
        $statement->bindValue(':lastname', $lastname, PDO::PARAM_STR);

        $statement->execute();

        header('Location: return.php');
    }
}