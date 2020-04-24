<?php


try {
    $bdd = new PDO('mysql:host=localhost;dbname=test_web;charset=utf8', 'root', '');
} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}


$req = $bdd->prepare("SELECT * FROM liste_biens WHERE id = ?");

$req->execute(array($_GET['id']));
