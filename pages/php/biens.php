<?php
session_start();
require_once '../../assets/include/NavbarConnecter.php';
require_once '../../function/functions.php';
// error_reporting(E_ALL & ~E_WARNING);
?>



<?php 
if(isset($_GET['id']) )
{
    echo getFormBiens();
    echo getBienUser();
    echo getFormBiensInfo(); 
    echo bienUserDelete();
    
}else{
    header("Location: ../../pages/php/connexion.php");
}
?>





<?php
require_once '../../assets/include/footer.html';
?>