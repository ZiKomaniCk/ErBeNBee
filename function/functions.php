<?php


function changeNavbar()
{
    $goodUrl = "/index.php";
    $fineurl = "/pages/php/recherche.php";
    $urlresa = "/pages/php/reservationsBiens.php";
    $urlco = "/pages/php/connexion.php";
    $urlinsc = "/pages/php/inscriptions.php";
    $conc = '';
    if ($_SERVER['SCRIPT_NAME'] == $goodUrl) {
        if(isset($_SESSION['nom']) and isset($_SESSION['prenom']))
        {
            $conc .= '<div class="dropdown" id="example-dropdown">
            <button type="button" class="btn primary dropdown-trigger">' .
            $_SESSION['nom'] . ' ' . $_SESSION['prenom'] . '
            </button>
            <div class="dropdown-content white">
            <a class="dropdown-item" href="pages/php/profil.php?id=' . $_SESSION['id'] . '">Votre profil</a>
            <a class="dropdown-item" href="pages/php/compte.php?id=' . $_SESSION['id'] . '">Votre compte</a>
            <a class="dropdown-item" href="pages/php/biens.php?id=' . $_SESSION['id'] . '">Vos biens</a>
            <a class="dropdown-item" href="pages/php/deconnection.php">Déconnexion</a>        
            </div>
            </div>';
        }else{
            $conc .= '<strong> <a class="navbar-link" href="pages/php/inscriptions.php">Inscription</a> </strong>
            <strong class="connexion-navbar"> <a class="navbar-link" href="pages/php/connexion.php">Connexion</a> </strong>';
        }
    } else{
        if($_SERVER['SCRIPT_NAME'] == $fineurl OR $_SERVER['SCRIPT_NAME'] == $urlresa OR $_SERVER['SCRIPT_NAME'] == $urlco OR $_SERVER['SCRIPT_NAME'] == $urlinsc)
        {
            if(isset($_SESSION['nom']) and isset($_SESSION['prenom']))
            {
                
                $conc .= '<div class="dropdown" id="example-dropdown">
                <button type="button" class="btn primary dropdown-trigger">' .
                $_SESSION['nom'] . ' ' . $_SESSION['prenom'] . '
                </button>
                <div class="dropdown-content white">
                <a class="dropdown-item" href="../../pages/php/profil.php?id=' . $_SESSION['id'] . '">Votre profil</a>
                <a class="dropdown-item" href="../../pages/php/compte.php?id=' . $_SESSION['id'] . '">Votre compte</a>
                <a class="dropdown-item" href="../../pages/php/biens.php?id=' . $_SESSION['id'] . '">Vos biens</a>
                <a class="dropdown-item" href="../../pages/php/deconnection.php">Déconnexion</a>        
                </div>
                </div>';
            }else{
                $conc .= '<strong> <a class="navbar-link" href="../../pages/php/inscriptions.php">Inscription</a> </strong>
                <strong class="connexion-navbar"> <a class="navbar-link" href="../../pages/php/connexion.php">Connexion</a> </strong>';
            }
        }
    }
    return $conc;
}

// Functions Inscription //

function postInscription()
{
    $conc = '';
    try {
        $bdd = new PDO('mysql:host=localhost;dbname=test_web;charset=utf8', 'root', '');
    } catch (Exception $e) {
        die('Erreur : ' . $e->getMessage());
    }
    
    $req = $bdd->prepare('INSERT INTO inscription SET email=:email, mdp=:mdp, prenom=:prenom, nom=:nom, avatar=:avatar');
    $req->execute(['email' => $_POST['email'], 'mdp' => $_POST['mdp'], 'prenom' => $_POST['prenom'], 'nom' => $_POST['nom'], 'avatar' => "default.jpg"]);
    
    $conc .= 'Votre compte a bien été crée';
    $req->closeCursor();
    return $conc;
}

function getInscription()
{
    if (isset($_POST['ajout'])) {
        $conc = '';
        try {
            $bdd = new PDO('mysql:host=localhost;dbname=test_web;charset=utf8', 'root', '');
        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }
        
        $reponse = $bdd->query('SELECT email FROM inscription');
        
        while ($donnees = $reponse->fetch()) {
            // $conc .= $donnees['email'] . '<br />';
            if ($donnees['email'] == $_POST['email']) {
                $conc = 'pas';
                
                
                return $conc;
            break;
        }
    }
    
    $conc = 'Tout est bon';
    
    $reponse->closeCursor();
    return $conc;
}
}

function validationAvatarInscription()
{
    $conc = '';
    
    try {
        $bdd = new PDO('mysql:host=localhost;dbname=test_web;charset=utf8', 'root', '');
    } catch (Exception $e) {
        die('Erreur : ' . $e->getMessage());
    }
    
    if (isset($_FILES['avatar']) and !empty($_FILES['avatar']['name'])) {
        
        $extensionValides = array('jpg', 'jepg', 'gif', 'png', 'svg');
        if ($_FILES['avatar']['size'] <= 10000000) {
            $extensionUpload = strtolower(substr(strrchr($_FILES['avatar']['name'], '.'), 1));
            if (in_array($extensionUpload, $extensionValides)) {
                $chemin = "../../membre/avatar/" . $_SESSION['id'] . '.' . $extensionUpload;
                $cheminReq = $_SESSION['id'] . '.' . $extensionUpload;
                $deplacement = move_uploaded_file($_FILES['avatar']['tmp_name'], $chemin);
                if ($deplacement) {
                    $req = $bdd->prepare("UPDATE inscription SET email=:email, mdp=:mdp, prenom=:prenom, nom=:nom, avatar=:avatar, fond=:fond WHERE id=:id");
                    
                    $req->execute(['email' => $_POST['email'], 'mdp' => $_POST['mdp'], 'prenom' => $_POST['prenom'], 'nom' => $_POST['nom'], 'avatar' => "$cheminReq", 'fond' => $_POST['fond'], 'id' => $_GET['id']]);
                } else {
                    $conc .= "Erreur d'importation du fichier. Veuillez réessayer.";
                }
            } else {
                $conc .= 'Votre photo doit etre aux formats suivants: <strong>jpg, jpeg, gif, png, svg</strong>.';
            }
        } else {
            $conc .= 'Votre photo est trop <strong>volumineuse</strong>.';
        }
        return $conc;
    } else {
        $req = $bdd->prepare("UPDATE inscription SET email=:email, mdp=:mdp, prenom=:prenom, nom=:nom, fond=:fond WHERE id=:id");
        
        $req->execute(['email' => $_POST['email'], 'mdp' => $_POST['mdp'], 'prenom' => $_POST['prenom'], 'nom' => $_POST['nom'], 'fond' => $_POST['fond'], 'id' => $_GET['id']]);
        
        return $conc;
    }
    
    $_SESSION['email'] = $_POST['email'];
    $_SESSION['nom'] = $_POST['nom'];
    $_SESSION['prenom'] = $_POST['prenom'];
    $_SESSION['mdp'] = $_POST['mdp'];
    $_SESSION['fond'] = $_POST['fond'];
}

function fullconfig()
{
    $conc = '';
    if (isset($_POST['ajout'])) {
        
        if ($_POST['mdp'] == $_POST['mdps']) {
            if (getInscription() != "pas") {
                $conc .= postInscription();
            } else {
                $conc .= 'Cet email est déjà <strong>utilisé</strong>';
            }
        } else {
            $conc .= "Veuillez saisir un mot de passe qui n'est pas <strong>different</strong> de celui que vous avez inseré <br>.";
        }
    }
    return $conc;
}

// functions Connexion //

function getInscriptionEmailMdp()
{
    if (isset($_POST['demande'])) {
        $conc = '';
        $validation = '';
        try {
            $bdd = new PDO('mysql:host=localhost;dbname=test_web;charset=utf8', 'root', '');
        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }
        $conc .= "<br>";
        $reponse = $bdd->query('SELECT * FROM inscription');
        
        while ($donnees = $reponse->fetch()) {
            if ($donnees['email'] == $_POST['email'] && $donnees['mdp'] == $_POST['mdp']) {
                $conc .= 'Bienvenue ' . $donnees['nom'] . " " . $donnees['prenom'];
                $validation .= 'yes';
                $_SESSION['id'] = $donnees['id'];
                $_SESSION['email'] = $donnees['email'];
                $_SESSION['nom'] = $donnees['nom'];
                $_SESSION['prenom'] = $donnees['prenom'];
                $_SESSION['mdp'] = $donnees['mdp'];
                $_SESSION['avatar'] = $donnees['avatar'];
                $_SESSION['fond'] = $donnees['fond'];
                header("Location: compte.php?id=" . $_SESSION['id']);
            break;
        }
    }
    
    if ($validation != 'yes') {
        $conc .= "Vous n'êtes pas inscrit ? Vous pouvez créer un compte ici : " . "<a class='txt-blue underline' href='inscriptions.php'>S'inscrire</a>";
    }
    
    return $conc;
}
}

// Afficher l'accueil compte //

function onCompteClient()
{
    if (isset($_GET['id'])) {
        $conc = '';
        try {
            $bdd = new PDO('mysql:host=localhost;dbname=test_web;charset=utf8', 'root', '');
        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }
        
        $req = $bdd->prepare("SELECT * FROM inscription WHERE id = ? ");
        
        $req->execute(array($_GET['id']));
        
        
        $userInfo = $req->fetch();
        
        
        if ($userInfo['id'] == $_SESSION['id']) {
            $conc .= '<h1> Informations personnelles  </h1>  <br>';
            $conc .= "<p class='infoperso'> Votre nom : <strong>" . $userInfo['nom'] . "</strong></p> <br>
            <p class='infoperso'>Votre email : <strong>" . $userInfo['email'] . "</strong> </p><br>";
            $conc .= "<p class='infoperso'>Vos fonds : <strong>" . $userInfo['fond'] . " €</strong></p><br>";
            $conc .= "<p class='infoperso'>Votre Avatar : </p><br>";
            $conc .= "<img align='center' src='../../membre/avatar/". $userInfo['avatar'] ."' height='200px' alt='Avatar du compte' class='imageprofil'  ><br>";
            $conc .= "<a class='btn press red infoperso' href='../../pages/php/modificationCompte.php?id=" . $_SESSION['id'] . "'>Modifier votre profil</a>";
        } else {
            if (!empty($_SESSION['id'])) {
                header("Location: compte.php?id=" . $_SESSION['id']);
            } else {
                header("Location: connexion.php");
            }
        }
        
        return $conc;
    }
}



// Afficher l'accueil profil //


function getProfilUser()
{
    if (isset($_GET['id'])) {
        $conc = "";
        try {
            $bdd = new PDO('mysql:host=localhost;dbname=test_web;charset=utf8', 'root', '');
        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }
        
        $req = $bdd->prepare("SELECT * FROM inscription WHERE id = ? ");
        
        $req->execute(array($_GET['id']));
        
        $userInfo = $req->fetch();
        if ($userInfo['id'] == $_SESSION['id']) {
            $conc .= "<h1>Voici vos biens en locations :</h1><br>";
            $conc .= getBienUser();
        } else {
            if (!empty($_SESSION['id'])) {
                header("Location: ../../pages/php/profil.php?id=" . $_SESSION['id']);
            } else {
                header("Location: ../../pages/php/connexion.php");
            }
        }
        return $conc;
    }
}

function getBienUser()
{
    $conc = '';
    try {
        $bdd = new PDO('mysql:host=localhost;dbname=test_web;charset=utf8', 'root', '');
    } catch (Exception $e) {
        die('Erreur : ' . $e->getMessage());
    }
    
    $req = $bdd->prepare("SELECT * FROM liste_biens where id_user = ? ");
    
    $req->execute(array($_GET['id']));
    
    
    while ($userInfo = $req->fetch()) {
        
        
        $conc .= '<div class="card hoverable-1 rounded-3">';
        $conc .= "<div class='card-header'><h3>" . $userInfo['titre_article'] . "</h3></div>";
        $conc .= '<div class="card-content">';
        $conc .= "<h6>Nombre de personnes accueillable : </h6><p>" . $userInfo['nbr_personnes'] . "</p>";
        $conc .= "<h6>Montant de la nuitée par personnes : </h6><p>" . $userInfo['prix'] . " €</p>";
        $conc .= "<h6>Ville : </h6><p class='textbien'>" . $userInfo['ville'] . "</p>";
        $conc .= "<h6>Adresse : </h6><p class='textbien'>" . $userInfo['adresse'] . "</p>";
        $conc .= "<h6>Description</h6><p>" . $userInfo['descriptions'] . "</p><br>";
        $conc .= "<h6>Photos</h6>"
        . getMainImageBiens($userInfo['id'])
        . "<br>";
        $conc .= '<form  name="bouton" method="post" action="">';
        $conc .= "<input type='hidden' class='btn press red' name='id_bien' value='" . $userInfo['id'] . "'>";
        $conc .= "<a class='btn press blue modifier-bien' href='modificationBiens.php?id=" . $userInfo['id'] . "'>Modifier</a><br>";
        $conc .= "<input type='submit' class='btn press realred supprimer' name='supprimer' value='Supprimer'></form>";
        
        $conc .= '</div> </div> <br>';
    }
    return $conc;
}

function getMainImageBiens($id_bien)
{
    $conc = "";
    $dir    = '../../assets/photos_biens/' . $id_bien;
    $files1 = scandir($dir);
    $conc = '<div class="imagesBiens">';
    if (!empty($files1[2])) {
        $conc .= '<img src="../../assets/photos_biens/' . $id_bien . '/' . $files1[2] . '" class="imagebiens" alt="Photo du bien observé"  height="500px" id="photo1">';
    }
    $conc .= '</div>';
    return $conc;
}
function getMainImageBiensIndex($id_bien)
{
    $conc = "";
    $dir    = 'assets/photos_biens/' . $id_bien;
    $files1 = scandir($dir);
    $conc = '<div class="imagesBiens">';
    if (!empty($files1[2])) {
        $conc .= '<img src="assets/photos_biens/' . $id_bien . '/' . $files1[2] . '" class="imagebiens" alt="Photo du bien observé" height="500px" id="photo1">';
    }
    $conc .= '</div>';
    return $conc;
}

function delReservationById()
{
    if (isset($_POST['supprimer'])){
        
        try {
            $bdd = new PDO('mysql:host=localhost;dbname=test_web;charset=utf8', 'root', '');
        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }
        
        $req = $bdd->prepare('SELECT id FROM reservation WHERE id_bien=?');
        
        $req->execute(array($_POST["id_bien"]));
        
        while ($donnees = $req->fetch()) {
            $id = $donnees['id'];
            $bdd->query("DELETE FROM reservation where id=$id");
        }
    }
}

function bienUserDelete()
{
    
    $conc = '';
    
    if (isset($_POST['supprimer'])) {
        
        
        try {
            $bdd = new PDO('mysql:host=localhost;dbname=test_web;charset=utf8', 'root', '');
        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }
        
        delReservationById();
        $req = $bdd->prepare("DELETE FROM liste_biens where id= :id ");
        
        $req->execute(['id' => $_POST["id_bien"]]);
        delFolder($_POST["id_bien"], "del");
        header("Location: ../../pages/php/biens.php?id=" . $_SESSION['id']);
    }
    
    return $conc;
}


function delFolder($id_bien, $del)
{
    
    $dir = dirname(__FILE__) . '../../assets/photos_biens/' . $id_bien;
    $files1 = scandir($dir);
    foreach ($files1 as $element) {
        if ($element == "." or $element == "..") {
            continue;
        }
        $newDir = $dir . "/" . $element;
        unlink($newDir);
    }
    if ($del == "del") {
        rmdir($dir);
    }
}

function bienUserModify()
{
    $conc = "";
    if (isset($_POST['modifier'])) {
        
        try {
            
            $bdd = new PDO('mysql:host=localhost;dbname=test_web;charset=utf8', 'root', '');
        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }
        
        
        
        $req = $bdd->prepare("UPDATE liste_biens SET titre_article=:titre_article, prix=:prix, nbr_personnes=:nbr_personnes, descriptions=:descriptions, ville=:ville, adresse=:adresse, id_user=:id_user WHERE id=:id");
        
        $req->execute(["titre_article" => $_POST['titre_article'], "prix" => $_POST['prix'], "nbr_personnes" => $_POST['nbr_personnes'], "descriptions" => $_POST['descriptions'], 'ville'=>$_POST['ville'],'adresse' => $_POST['adresse'], "id_user" => $_SESSION['id'], 'id' => $_GET['id']]);
        
        // header("Location: modificationBiens.php?id=" . $_GET['id']);
        return $conc;
    }
}

function getBienUserModify()
{
    $conc = '';
    try {
        $bdd = new PDO('mysql:host=localhost;dbname=test_web;charset=utf8', 'root', '');
    } catch (Exception $e) {
        die('Erreur : ' . $e->getMessage());
    }
    
    $req = $bdd->prepare("SELECT * FROM liste_biens where id = ? ");
    
    $req->execute(array($_GET['id']));
    
    
    while ($userInfo = $req->fetch()) {
        
        $conc .= '<form  name="bouton" method="POST" action="" enctype="multipart/form-data">';
        $conc .= '<div class="card hoverable-1 rounded-3">';
        $conc .= "<div class='card-header'><br>";
        $conc .= "<input type='text' class='form-control ' name='titre_article' " . 'value="' . $userInfo['titre_article'] . '">';
        $conc .= "</div>";
        $conc .= '<div class="card-content">';
        $conc .= "<p><h6>Ville : </h6>" . "<input type='text' class='form-control ' name='ville' " . 'value="' . $userInfo['ville'] . '"></p>';
        $conc .= "<p><h6>Adresse : </h6>" . "<input type='text' class='form-control ' name='adresse'" . 'value="' . $userInfo['adresse'] . '"></p>';
        $conc .= "<p><h6>Nombre de personnes accueillable : </h6>" . "<input type='text' class='form-control ' name='nbr_personnes' " . 'value="' . $userInfo['nbr_personnes'] . '"></p>';
        $conc .= "<p><h6>Montant de la nuitée par personnes : </h6>" . "<input type='text' class='form-control ' name='prix' " . 'value="' . $userInfo['prix'] . '"></p>';
        $conc .= "<p><h6>Description</h6>" . "<input type='text' class='form-control ' name='descriptions' " . 'value="' . $userInfo['descriptions'] . '"></p><br>';
        $conc .= "<label for='photo_1'>Votre photo 1   </label>";
        $conc .= "<input type='file' name='photo_1' placeholder='Entrez votre photo 1' ><br>";
        $conc .= "<label for='photo_2'>Votre photo 2  </label>";
        $conc .= "<input type='file' name='photo_2' placeholder='Entrez votre photo 2' ><br>";
        $conc .= "<label for='photo_3'>Votre photo 3  </label>";
        $conc .= "<input type='file' name='photo_3' placeholder='Entrez votre photo 3' ><br>";
        $conc .= "<input type='hidden' class='btn press red' name='id_bien' value='" . $userInfo['id'] . "'>";
        $conc .= "<input type='submit' class='btn press blue' name='modifier' value='Modifier'></form>";
        $conc .= '</div> </div> <br>';
    }
    $req->closeCursor();
    return $conc;
}

function getFormBiensInfo()
{
    $conc = '';
    if ($_GET['id'] == $_SESSION['id']) {
        
        
        if (isset($_POST['ajout'])) {
            try {
                $bdd = new PDO('mysql:host=localhost;dbname=test_web;charset=utf8', 'root', '');
            } catch (Exception $e) {
                die('Erreur : ' . $e->getMessage());
            }
            
            $conc .= setPhotosBiens();
            
            // a utiliser pour plus de sécurité dans les inputs : htmlentities()
            
            header("Location: ../../pages/php/biens.php?id=" . $_SESSION['id']);
        }
        
        return $conc;
    } else {
        if (!empty($_SESSION['id'])) {
            header("Location: ../../pages/php/biens.php?id=" . $_SESSION['id']);
        } else {
            header("Location: ../../pages/php/connexion.php");
        }
    }
}

function setPhotosBiens()
{
    $conc = '';
    if ($_GET['id'] == $_SESSION['id']) {
        
        
        if (isset($_POST['ajout'])) {
            try {
                $bdd = new PDO('mysql:host=localhost;dbname=test_web;charset=utf8', 'root', '');
            } catch (Exception $e) {
                die('Erreur : ' . $e->getMessage());
            }
            
            $conc .= verifyPhoto("photo_1"); // verify photo 1
            $conc .= verifyPhoto("photo_2"); // verify photo 2
            $conc .= verifyPhoto("photo_3"); // verify photo 2
            
            
            
            
            $req = $bdd->prepare('INSERT INTO liste_biens SET titre_article=:titre_article, prix=:prix, nbr_personnes=:nbr_personnes, descriptions=:descriptions, ville=:ville, adresse=:adresse, id_user=:id_user');
            $req->execute(['titre_article' => $_POST['titre_article'], 'prix' => $_POST['prix'], 'nbr_personnes' => $_POST['nbr_personnes'], 'descriptions' => $_POST['descriptions'], 'ville' => $_POST['ville'], 'adresse' => $_POST['adresse'], 'id_user' => $_SESSION['id']]);
            $idBiens = $bdd->lastInsertId();
            
            $path = "../../assets\photos_biens/" . $idBiens;
            mkdir($path, 0700);
            
            $conc .= moveImagesBiens("photo_1", $idBiens);
            $conc .= moveImagesBiens("photo_2", $idBiens);
            $conc .= moveImagesBiens("photo_3", $idBiens);
            // htmlentities()
            
            $conc .= 'Votre bien a bien été mis en vente';
            
            
        }
        
        return $conc;
    } else {
        if (!empty($_SESSION['id'])) {
            header("Location: ../../pages/php/biens.php?id=" . $_SESSION['id']);
        } else {
            header("Location: ../../pages/php/connexion.php");
        }
    }
}

function moveImagesBiens($namePhoto, $idBiens)
{
    $extensionUpload = strtolower(substr(strrchr($_FILES[$namePhoto]['name'], '.'), 1));
    $chemin = "../../assets/photos_biens/" . $idBiens . "/" .  $idBiens . "_" . $namePhoto . '.' . $extensionUpload;
    $deplacement = move_uploaded_file($_FILES[$namePhoto]['tmp_name'], $chemin);
}



function verifyPhoto($photo)
{
    $conc = '';
    try {
        $bdd = new PDO('mysql:host=localhost;dbname=test_web;charset=utf8', 'root', '');
    } catch (Exception $e) {
        die('Erreur : ' . $e->getMessage());
    }
    
    $extensionValides = array('jpg', 'jpeg', 'gif', 'png', 'svg');
    if ($_FILES[$photo]['size'] <= 10000000) {
        $extensionUpload = strtolower(substr(strrchr($_FILES[$photo]['name'], '.'), 1));
        if (in_array($extensionUpload, $extensionValides)) {
            return true;
        } else {
            $conc .= 'Votre photo doit etre au format <strong>jpg, jpeg, gif, png, svg</strong>';
        }
    } else {
        $conc .= 'Votre photo est trop <strong>volumineuse</strong>';
    }
    return $conc;
}

// a enlever
function trylastid()
{
    $conc = '';
    try {
        $bdd = new PDO('mysql:host=localhost;dbname=test_web;charset=utf8', 'root', '');
    } catch (Exception $e) {
        die('Erreur : ' . $e->getMessage());
    }
    $req = $bdd->query("SELECT id FROM liste_biens order by id asc");
    // $conc .= $req->insert_id;
    
    while ($donnees = $req->fetch()) {
        
        $id = $donnees['id'];
    }
    
    $req->closeCursor();
    // $conc .= $bdd::LAST_INSERT_ID();
    
    return $conc;
}
// Fin de a enlever


// fonction concernant le fond //

function getFondId()
{
    $conc = '';
    try {
        $bdd = new PDO('mysql:host=localhost;dbname=test_web;charset=utf8', 'root', '');
    } catch (Exception $e) {
        die('Erreur : ' . $e->getMessage());
    }
    $req = $bdd->prepare("SELECT fond FROM inscription where id = ? ");
    $req->execute(array($_SESSION['id']));
    
    $fond = $req->fetch();
    $conc .= $fond['fond'];
    $req->closeCursor();
    
    return $conc;
}


function updateFond($var)
{
    try {
        $bdd = new PDO('mysql:host=localhost;dbname=test_web;charset=utf8', 'root', '');
    } catch (Exception $e) {
        die('Erreur : ' . $e->getMessage());
    }
    
    $req = $bdd->prepare("UPDATE inscription SET fond = ?  where id = ? ");
    
    $req->execute(array($var, $_SESSION['id']));
    $req->closeCursor();
}

//fin fonction fond //


function getFormBiens()
{
    
    $conc = "<h1>Ajouter un nouveau bien :</h1><br>
    <form method='post' class='form-material' enctype='multipart/form-data'>
    <input type='text' class='form-field ajouter-bien' name='titre_article'  placeholder='Entrez un titre article' required>
    <input type='number' class='form-field ajouter-bien' name='prix'  placeholder='Entrez le montant de la nuitée par personnes ' required>
    <input type='number' class='form-field ajouter-bien' name='nbr_personnes'  placeholder='Entrez le nombre de personnes accueillable' required>
    <input type='text' class='form-field ajouter-bien' name='ville'  placeholder='Entrez une Ville' required>
    <input type='text' class='form-field ajouter-bien' name='adresse'  placeholder='Entrez votre adresse' required>
    <textarea type='text' class='form-field ajouter-bien' name='descriptions'  placeholder='Entrez votre descriptions' required></textarea>
    <label for='photo_1'>Votre photo 1   </label>
    <input type='file' name='photo_1' placeholder='Entrez votre photo 1' ><br>
    <label for='photo_2'>Votre photo 2  </label>
    <input type='file' name='photo_2' placeholder='Entrez votre photo 2' ><br>
    <label for='photo_3'>Votre photo 3  </label>
    <input type='file' name='photo_3' placeholder='Entrez votre photo 3' ><br>
    <input type='submit' class='btn press red ajouter-bien' name='ajout'>
    </form>
    <br>";
    return $conc;
}

function getAllBiens()
{
    $conc = '';
    try {
        $bdd = new PDO('mysql:host=localhost;dbname=test_web;charset=utf8', 'root', '');
    } catch (Exception $e) {
        die('Erreur : ' . $e->getMessage());
    }
    
    $req = $bdd->query("SELECT * FROM liste_biens");
    
    
    
    while ($InfoBien = $req->fetch()) {
        
        $conc .= '<div class="card hoverable-1 rounded-2">';
        $conc .= "<div class='card-header'><h3>" . $InfoBien['titre_article'] . "</h3></div>";
        $conc .= '<div class="card-content">';
        $conc .= "<h6>Nombre de personnes accueillable : </h6><p class='textbien'>" . $InfoBien['nbr_personnes'] . "</p>";
        $conc .= "<h6>Montant de la nuitée par personnes : </h6><p class='textbien'>" . $InfoBien['prix'] . " €</p>";
        $conc .= "<h6>Ville : </h6><p class='textbien'>" . $InfoBien['ville'] . "</p>";
        $conc .= "<h6>Adresse : </h6><p class='textbien'>" . $InfoBien['adresse'] . "</p>";
        $conc .= "<h6>Description :</h6><p class='textbien'>" . $InfoBien['descriptions'] . "</p>";
        $conc .= "<h6>Photo :</h6>" . getMainImageBiensIndex($InfoBien['id']) . "</<a>";
        $conc .= '<form  name="bouton" method="post" action="">';
        $conc .= "<input type='hidden' class='btn press red' name='id_bien' value='" . $InfoBien['id'] . "'>";
        $conc .= "<a class='btn press red index' name='reserver' href='pages/php/reservationsBiens.php?id=" . $InfoBien['id'] . "' >Voir le Bien</a></form>";
        $conc .= '</div> </div> <br>';
    }
    return $conc;
}

function getBiensBySearch($search)
{
    $conc = '';
    try {
        $bdd = new PDO('mysql:host=localhost;dbname=test_web;charset=utf8', 'root', '');
    } catch (Exception $e) {
        die('Erreur : ' . $e->getMessage());
    }
    
    $req = $bdd->query("SELECT * FROM liste_biens WHERE titre_article LIKE '%$search%'");
    
    while ($InfoBien = $req->fetch()) {
        
        $conc .= '<div class="card hoverable-1 rounded-2">';
        $conc .= "<div class='card-header'><h3>" . $InfoBien['titre_article'] . "</h3></div>";
        $conc .= '<div class="card-content">';
        $conc .= "<h6>Nombre de personnes accueillable : </h6><p>" . $InfoBien['nbr_personnes'] . "</p>";
        $conc .= "<h6>Montant de la nuitée par personnes :</h6><p>" . $InfoBien['prix'] . " €</p>";
        $conc .= "<h6>Ville : </h6><p class='textbien'>" . $InfoBien['ville'] . "</p>";
        $conc .= "<h6>Adresse : </h6><p class='textbien'>" . $InfoBien['adresse'] . "</p>";
        $conc .= "<h6>Description :</h6><p>" . $InfoBien['descriptions'] . "</p>";
        $conc .= "<h6>Photo :</h6>" . getMainImageBiensIndex($InfoBien['id']) . "</<a>";
        $conc .= '<form  name="bouton" method="post" action="">';
        $conc .= "<input type='hidden' class='btn press red' name='id_bien' value='" . $InfoBien['id'] . "'>";
        $conc .= "<a class='btn press red' name='reserver' href='pages/php/reservationsBiens.php?id=" . $InfoBien['id'] . "' >Voir le Bien</a></form>";
        $conc .= '</div> </div> <br>';
    }
    return $conc;
}

function getBienReservation()
{
    $conc = '';
    try {
        $bdd = new PDO('mysql:host=localhost;dbname=test_web;charset=utf8', 'root', '');
    } catch (Exception $e) {
        die('Erreur : ' . $e->getMessage());
    }
    
    $req = $bdd->prepare("SELECT * FROM liste_biens WHERE id = ?");
    
    $req->execute(array($_GET['id']));
    
    
    $InfoBien = $req->fetch();
    
    $conc .= '<div class="card hoverable-1 rounded-3">';
    $conc .= "<div class='card-header'><h3>" . $InfoBien['titre_article'] . "</h3></div>";
    $conc .= '<div class="card-content">';
    $conc .= "<h6>Nombre de personnes accueillable : </h6><p>" . $InfoBien['nbr_personnes'] . "</p>";
    $conc .= "<h6>Montant de la nuitée par personnes : </h6><p>" . $InfoBien['prix'] . " €</p>";
    $conc .= "<h6>Ville : </h6><p class='textbien'>" . $InfoBien['ville'] . "</p>";
    $conc .= "<h6>Adresse : </h6><p class='textbien'>" . $InfoBien['adresse'] . "</p>";
    $conc .= "<h6>Description</h6><p>" . $InfoBien['descriptions'] . "</p>";
    $conc .= "<h6>Photos :</h6><p>" . getAllImagesBiens($InfoBien['path_photo']) . "</p>";
    $conc .= "<input type='hidden' class='btn press red' name='id_bien' value='" . $InfoBien['id'] . "'>";
    $conc .= "<input type='submit' class='btn press red' name='reserver' value='Reserver'></form>";
    $conc .= '</div> </div> <br>';
    
    return $conc;
}

function updateInfoCompte()
{
    $conc = '';
    if (isset($_GET['id'])) {
        if (isset($_POST['modificationCompte'])) {
            
            if ($_POST['mdp'] == $_POST['mdps']) {
                
                $conc .= validationAvatarInscription();
            } else {
                $conc .= "Veuillez saisir un mot de passe qui n'est pas <strong>different</strong> de celui que vous avez inseré";
            }
        }
    }
    return $conc;
}

function getAllImagesBiens($path)
{
    $conc = "";
    $dir    = '../../assets/photos_biens/' . $_GET['id'];
    $files1 = scandir($dir);
    foreach ($files1 as $element) {
        if ($element == "." or $element == "..") {
            continue;
        }
        $fullpath = $path . $element;
        $conc .= "<img src='$fullpath' height='100%' width='100%' alt='photo du bien observé' id='photoIndex'>" . ' <br />';
    }
    return $conc;
}


function requeteRecherche()
{
    if(isset($_POST['rechercher']))
    {
        
        $conc = '';
        try {
            $bdd = new PDO('mysql:host=localhost;dbname=test_web;charset=utf8', 'root', '');
        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }
        
        $ville = $_POST['ville'];
        $place = $_POST['place'];
        $prix = $_POST['prix'];
        $date_debut = $_POST['date_debut']; 
        $date_fin = $_POST['date_fin']; 
        
        if($_POST['prix'] == NULL)
        {
            $req = $bdd->query("SELECT *
            FROM liste_biens WHERE 
            NOT EXISTS  (SELECT l.id, titre_article, ville, adresse, nbr_personnes, prix, descriptions
            FROM liste_biens AS l JOIN reservation AS r ON l.id = r.id_bien
            WHERE date_fin >'$date_debut' AND  date_debut < '$date_fin')
            AND ville LIKE '%$ville%' 
            AND nbr_personnes LIKE '%$place%'");
            
        }else{
            
            $req = $bdd->query("SELECT *
            FROM liste_biens WHERE 
            NOT EXISTS  (SELECT l.id, titre_article, ville, adresse, nbr_personnes, prix, descriptions
            FROM liste_biens AS l JOIN reservation AS r ON l.id = r.id_bien
            WHERE date_fin >'$date_debut' AND  date_debut < '$date_fin')
            AND prix <= $prix AND ville LIKE '%$ville%' 
            AND nbr_personnes LIKE '%$place%'");
        }
        
        while ($InfoBien = $req->fetch()) {
            
            $conc .= '<div class="card hoverable-1 rounded-2">';
            $conc .= "<div class='card-header'><h3>" . $InfoBien['titre_article'] . "</h3></div>";
            $conc .= '<div class="card-content">';
            $conc .= "<h6>Nombre de personnes accueillable : </h6><p class='textbien'>" . $InfoBien['nbr_personnes'] . "</p>";
            $conc .= "<h6>Montant de la nuitée par personnes : </h6><p class='textbien'>" . $InfoBien['prix'] . " €</p>";
            $conc .= "<h6>Description :</h6><p class='textbien'>" . $InfoBien['descriptions'] . "</p>";
            $conc .= "<h6>Ville : </h6><p class='textbien'>" . $InfoBien['ville'] . "</p>";
            $conc .= "<h6>Adresse : </h6><p class='textbien'>" . $InfoBien['adresse'] . "</p>";
            $conc .= "<h6>Photo :</h6>" . getMainImageBiens($InfoBien['id']) . "</<a>";
            $conc .= '<form  name="bouton" method="post" action="">';
            $conc .= "<input type='hidden' class='btn press red' name='id_bien' value='" . $InfoBien['id'] . "'>";
            $conc .= "<a class='btn press red' name='reserver' href='../../pages/php/reservationsBiens.php?id=" . $InfoBien['id'] . "' >Voir le Bien</a></form>";
            $conc .= '</div> </div> <br>';
        }
        
        return $conc;
    }
}

function getAllSelect($prametre)
{
    try {
        $bdd = new PDO('mysql:host=localhost;dbname=test_web;charset=utf8', 'root', '');
    } catch (Exception $e) {
        die('Erreur : ' . $e->getMessage());
    }
    $variable = "";
    $reponse = $bdd->query("SELECT DISTINCT $prametre FROM liste_biens");
    while ($donnees = $reponse->fetchObject()) {
        $variable .= '<option value = "' . $donnees->$prametre . '">' . $donnees->$prametre . "</option>";
    }
    $reponse->closeCursor();
    return $variable;
}

function getFormReservation()
{
    try {
        $bdd = new PDO('mysql:host=localhost;dbname=test_web;charset=utf8', 'root', '');
    } catch (Exception $e) {
        die('Erreur : ' . $e->getMessage());
    }
    $req = $bdd->prepare("SELECT liste_biens.nbr_personnes, CURDATE()as c FROM liste_biens WHERE id=?");
    $req->execute(array($_GET['id']));
    $reponse = $req->fetch();
    
    $currentDate = $reponse['c'];
    $nbrpresonnes = $reponse['nbr_personnes'];
    
    $conc = "<form action='' method='post'>";
    //rajouter des labels
    $conc .= "<label for='date'>Date d'arrivé</label>";
    $conc .= "<input type='date' class='form-field form-date' id='start' name='date_debut'  min='$currentDate'  required>";
    //rajouter des labels
    $conc .= "<label for='date'>Date de départ</label>";
    $conc .= "<input type='date' id='end' class='form-field form-date' name='date_fin' min='$currentDate' required>";
    //rajouter des labels
    $conc .= "<label for='nbr_personnes'>Nombre de personnes</label>";
    $conc .= "<input type='number' id='nbr_personnes' class='form-field form-personne' name='nbr_personnes' min='1' max='$nbrpresonnes' required>";
    
    return $conc;
}

function getPossibleReservation()
{
    try {
        $bdd = new PDO('mysql:host=localhost;dbname=test_web;charset=utf8', 'root', '');
    } catch (Exception $e) {
        die('Erreur : ' . $e->getMessage());
    }
    
    
    $req = $bdd->prepare("SELECT * FROM reservation 
    WHERE id_bien=?
    HAVING reservation.date_fin > ? 
    AND reservation.date_debut < ?");
    
    $req->execute(array($_GET['id'], $_POST['date_debut'], $_POST['date_fin']));
    $donnees = $req->fetch();
    
    if($donnees['date_debut'])
    {
        return False;
    }else{
        return True; //1
    }
    
}


function testAchatBiens()
{
    $conc = '';
    if (isset($_POST['reserver'])) {
        if (!empty($_SESSION['id'])) {
            
            $fond = getFondId();
            
            try {
                $bdd = new PDO('mysql:host=localhost;dbname=test_web;charset=utf8', 'root', '');
            } catch (Exception $e) {
                die('Erreur : ' . $e->getMessage());
            }
            
            $req = $bdd->prepare("SELECT prix,nbr_personnes FROM liste_biens where id = ? ");
            
            $req->execute(array($_POST['id_bien']));
            
            $bien = $req->fetch();
            
            $req->closeCursor();
            
            
            if($_POST['date_debut'] < $_POST['date_fin'])
            {
                if (($fond < ($bien['prix'] * $_POST['nbr_personnes'] * getDateDiffDates()))) {
                    $conc.= "<div>Prevision du montant : <strong>" . ($bien['prix'] * $_POST['nbr_personnes'] * getDateDiffDates()) . " €</strong></div>";
                    $conc .= '<div class="p-3 my-2 rounded-2 error">' .
                    "Il semblerait que vous n'avez pas assez d'argent sur votre compte, vous pouvez ajouter de l'argent sur votre compte ici : "
                    . "<a href='compte.php?id='><strong class='underline'>Votre Compte</strong></a>"
                    . '</div>';
                } else {
                    if(getPossibleReservation()==1){
                        if(0<$_POST['nbr_personnes'] AND $_POST['nbr_personnes']<=$bien['nbr_personnes'])
                        {
                            $conc.= "<div>Prevision du montant : <strong>" . ($bien['prix'] * $_POST['nbr_personnes'] * getDateDiffDates()) . " €</strong></div>";
                            $fondUpdate = $fond - ($bien['prix'] * $_POST['nbr_personnes'] * getDateDiffDates());
                            $_SESSION['fond'] = $fondUpdate;
                            $conc .= '<div class="p-3 my-2 rounded-2 success">Vous avez reservé ce bien. Vos fonds ont était modifié : <strong>'.$fondUpdate.'</strong></div>';
                            
                            updateFond("$fondUpdate");
                            reqReservation();
                        }else{
                            $conc .= '<div class="p-3 my-2 rounded-2 error">' . "Le nombre de personnes n'est pas valide, veuillez rentré un nombre de personnes valides.". '</div>';
                        }
                    }else{
                        $conc .= '<div class="p-3 my-2 rounded-2 error">' . "Les dates sont déjà prises, veuillez rentré des dates valides.". '</div>';
                    }
                }
            }else{
                $conc .= '<div class="p-3 my-2 rounded-2 error">' . "Les dates ne sont pas valide, veuillez rentré une date de début inférieur à la date de fin". '</div>';
            }
        } else {
            $conc .= '<div class="p-3 my-2 rounded-2 error">' .
            "Vous n'étes pas connecté, pour vous connecter c'est par la : "
            . "<a href='connexion.php'><strong class='underline'>page de connexion</strong></a>" . '</div>';
        }
    }
    return $conc;
}

function reqReservation()
{
    try {
        $bdd = new PDO('mysql:host=localhost;dbname=test_web;charset=utf8', 'root', '');
    } catch (Exception $e) {
        die('Erreur : ' . $e->getMessage());
    }
    
    $req = $bdd->prepare('INSERT INTO reservation SET id_bien=?, id_user=?, date_debut=?, date_fin=?, nbrpersonnes=?');
    $req->execute(array($_GET['id'],$_SESSION['id'], $_POST['date_debut'], $_POST['date_fin'], $_POST['nbr_personnes']));
    
}

function getDateDiffDates()
{
    $date1 = strtotime($_POST['date_fin']);
    $date2 = strtotime($_POST['date_debut']);
    $nbJoursSec = $date1 - $date2;
    $nbJour = $nbJoursSec / 86400;
    return $nbJour;
}