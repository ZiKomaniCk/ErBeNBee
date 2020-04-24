<?php
session_start();
require_once '../../assets/include/NavbarConnecter.php';
require_once '../../function/functions.php';
if(isset($_SESSION['id']) )
{
    $goodUrl = "/pages/php/modificationCompte.php?id=" . $_SESSION['id'];
    if (!($_SERVER['REQUEST_URI'] == $goodUrl))
    {
        header("Location: /pages/php/modificationCompte.php?id=" . $_SESSION['id']);
    }
    
    ?>
    <h1>Modification de votre compte</h1><br>
    
    
    
    <form action="" method="post" class="form-material form-connexion" enctype="multipart/form-data">

    <label for="email">Votre Email</label>  
    <input type="email" name="email" class="form-field modifier" pattern=".+@gmail.com"  placeholder="Entrez un email" value="<?php echo $_SESSION['email'] ?>" id="email"><br><br>
    
    <label for="mdp">Votre nouveau mdp</label> 
    <input type="password"  name="mdp" class="form-field modifier"  placeholder="Entrez un mdp" value="<?php echo $_SESSION['mdp'] ?>" id="mdp"><br><br>
    
    <label for="mdps">Vérification de votre mdp</label> 
    <input type="password"  name="mdps" class="form-field modifier" placeholder="Entrez à nouveau votre mdp" value="<?php echo $_SESSION['mdp'] ?>" id="mdps"><br><br>
    
    <label for="prenom">Votre Prenom</label> 
    <input type="text" name="prenom" class="form-field modifier" placeholder="Entrez votre prenom" value="<?php echo $_SESSION['prenom'] ?>" id="prenom"><br><br>
    
    <label for="nom">Votre Nom</label> 
    <input type="text"  name="nom" class="form-field modifier" placeholder="Entrez votre nom" value="<?php echo $_SESSION['nom'] ?>" id="nom"><br>
    
    <label for="fond">Vos fonds</label><br>
    <input type="number" name="fond" class="form-field modifier" placeholder="Entrez vos fonds souhaité" value="<?php echo $_SESSION['fond'] ?>" ><br>  
    
    <label for="avatar">Votre avatar</label><br>
    <input type="file" name="avatar" class="avatar-modifier" placeholder="Entrez votre avatar" ><br>    
    
    <input type="submit" class="btn press red modifier" name="modificationCompte">
    </form>
    
    
    <?php
    
    echo updateInfoCompte();
    
}else {
    header("Location: ../../pages/php/connexion.php");
}


?>

<?php
require_once '../../assets/include/footer.html';
?>