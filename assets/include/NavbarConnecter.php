<!DOCTYPE html>
<html>

<head>
  <title>ErBeNBee | Site de biens en ligne</title>
  <meta name="description" content="ErBeNBee le site communautaire qui vous permet de trouver et mettre vos biens en vente !">
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/css/all.min.css" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/axentix@0.5.0/dist/css/axentix.min.css">
  <link rel="stylesheet" href="../../assets/style/style.css">
</head>

<body class="layout">
  <header>
    <nav class="navbar">
      <strong><a href="../../index.php" class="navbar-brand">ErBeN</a><a href="../../index.php" class="bee-navbar">Bee</a></strong>
      <div class="navbar-menu ml-auto">
        <strong class="navbar-connexion"> <a class="navbar-link" href="../../pages/php/profil.php?id=<?= $_SESSION['id'] ?>">Profil</a> </strong>
        <strong class="navbar-connexion"> <a class="navbar-link" href="../../pages/php/compte.php?id=<?= $_SESSION['id'] ?>">Compte</a> </strong>
        <strong class="navbar-connexion"> <a class="navbar-link" href="../../pages/php/biens.php?id=<?= $_SESSION['id'] ?>">Biens</a> </strong>
        <strong class="navbar-connexion"> <a class="navbar-link" href="../../pages/php/deconnection.php">Déconnexion</a> </strong>
      </div>
    </nav>
  </header>

  <main>