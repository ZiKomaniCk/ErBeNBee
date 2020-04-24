<?php
session_start();
require_once '../../assets/include/navbar.php';
?>


<h1>Recherche</h1>



<form action="" method="post" class='form-material'>

<label for="ville-select">Nom ville:</label>
<select name="ville" id="ville-select" class='form-field'>
<option value="">Choisir votre Ville</option>
<?php echo getAllSelect("ville"); ?>
</select>
<br>

<label for="place-select">Nombre de place:</label>
<select name="place" id="place-select" class='form-field'>
<option value="">Choisir votre nombre de place</option>
<?php echo getAllSelect("nbr_personnes"); ?>
</select>
<br>

<label for="prix">Entrez le montant de la nuitée par personnes:</label>
<input type="number" class='form-field' name="prix" id="prix">
<br>
<label for="start">Date d'arrivée:</label>
<input type="date" id="start" name="date_debut"
value="2020-04-22" required>
<br>

<label for="end">Date de départ:</label>
<input type="date" id="end" name="date_fin"
value="2020-04-24" required>
<br>

<input type="submit" value="Filtrer !" class='btn press red ajouter-bien' name="rechercher">

</form>

<?php
    echo requeteRecherche();
?>




<?php
require_once '../../assets/include/footer.html';
?>