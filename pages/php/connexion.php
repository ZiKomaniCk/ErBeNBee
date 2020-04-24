<?php
session_start();
require_once '../../assets/include/navbar.php';
require_once '../../function/functions.php';
?>

<h1>Connexion</h1>

<form action="connexion.php" method="post" class="form-material form-connexion">
    <input type="email" name="email" class="form-field form-connexion" placeholder="Entrez un email">
    <input type="password" name="mdp" class="form-field form-connexion" placeholder="Entrez un mdp">
    <input type="submit" class="btn press red connexion" name="demande">
</form>


<?php


echo getInscriptionEmailMdp();



?>






<?php
require_once '../../assets/include/footer.html';
?>