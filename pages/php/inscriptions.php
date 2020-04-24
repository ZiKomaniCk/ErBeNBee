<?php
require_once '../../assets/include/navbar.php';
require_once '../../function/functions.php';
?>

<h1>Inscription</h1>


<form action="inscriptions.php" method="post" class="form-material form-inscription" enctype="multipart/form-data">
    <input type="email" class="form-field form-inscription"  name="email" pattern=".+@gmail.com" placeholder="Entrez un email" required>
    <input type="password" class="form-field form-inscription" name="mdp"  placeholder="Entrez un mdp" required>
    <input type="password" class="form-field form-inscription" name="mdps"  placeholder="Entrez à nouveau votre mdp" required>
    <input type="text" class="form-field form-inscription" name="prenom"  placeholder="Entrez votre prenom" required>
    <input type="text" class="form-field form-inscription" name="nom"  placeholder="Entrez votre nom" required>
    <input type="submit" class="btn press red inscription" name="ajout">
</form>

<?php
    
    echo fullconfig();

?>





<?php
    require_once '../../assets/include/footer.html';
?>