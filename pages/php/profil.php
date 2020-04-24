<?php
    session_start();
    require_once '../../assets/include/NavbarConnecter.php';
    require_once '../../function/functions.php';
?>


<?php 
if(isset($_GET['id']) AND !empty($_SESSION['id']))
{
    echo getProfilUser(); 
    echo bienUserDelete();
    
    
}else{
    header("Location: ../../pages/php/connexion.php");
}
    
?>

<?php
    require_once '../../assets/include/footer.html';
?>