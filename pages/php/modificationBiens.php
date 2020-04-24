<?php
session_start();
require_once '../../assets/include/NavbarConnecter.php';
require_once '../../function/functions.php';

?>

<h1>Modification</h1><br>

<?php
echo getBienUserModify();
echo bienUserModify();
?>






<?php
require_once '../../assets/include/footer.html';
?>