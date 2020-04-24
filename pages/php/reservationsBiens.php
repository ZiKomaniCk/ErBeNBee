<?php
session_start();
require_once(realpath( __DIR__ . '/../../assets/include/navbar.php'));
require_once(realpath( __DIR__ .'/../../function/functions.php'));


?>



<h1>Reservations</h1><br>



<?php 
    echo getFormReservation();
    echo testAchatBiens();
    echo getBienReservation();
?>



<?php
require_once(realpath( __DIR__ .'/../../assets/include/footer.html'));
?>