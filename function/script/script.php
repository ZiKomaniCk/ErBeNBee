<?php

$reqValue = $_POST['keywords'];

try {
    $bdd = new PDO('mysql:host=localhost;dbname=test_web;charset=utf8', 'root', '');
} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}

$req = $bdd->query("SELECT id, ville FROM liste_biens WHERE ville LIKE '$reqValue%'");

$tab = [];

while ($donnees = $req->fetch()) {
    $id = $donnees['id'];
    $ville = $donnees['ville'];
    $tab += ["$id" => "$ville"];
}



echo json_encode($tab);
