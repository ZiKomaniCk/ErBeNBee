<?php
session_start();
require_once 'function/functions.php';
?>
<!DOCTYPE html>
<html>

<head>
    <title>ErBeNBee | Site de biens en ligne</title>
    <link rel="shortcut icon" type="image/png" href="assets/icone/favicon.png">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="ErBeNBee le site communautaire qui vous permet de trouver et mettre vos biens en vente !">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/css/all.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/axentix@0.5.0/dist/css/axentix.min.css">
    <link rel="stylesheet" href="assets/style/style.css">
</head>

<body class="layout">
    <header>
        <nav class="navbar primary">
            <strong><a href="index.php" class="navbar-brand">ErBeN</a><a href="index.php" class="bee-navbar">Bee</a></strong>
            <div class="navbar-menu ml-auto">
                <strong><a class="navbar-link" href="pages/php/recherche.php">Recherche</a></strong>
                <?php echo changeNavbar(); ?> 
            </div>
        </nav>
    </header>


    <main>

<form action="" method="GET" class="form-material form-connexion">
  <div>
    <input id="search_bar" class="form-field form-recherche"  type="text" placeholder="Un bien en tête ?" name="search">
  </div>
  <div>
    <input type="submit" class="btn press red recherche" value="Rechercher">
  </div>
</form>

<?php
if (isset($_GET['search'])) {
  echo getBiensBySearch($_GET['search']);
} else {
  echo getAllBiens();
}


?>


<?php
require_once 'assets/include/footer.html';
?>