<?php 
require 'elements/header.php';
require_once 'model/requetes.php';
require_once 'gestionImage.php';


// AJOUTER 
if (isset($_POST['nom'])) {

    $fileImage = $_FILES['logoCrypto'];
    $repertoire = "images/";
    
    try {

        $nomImage = ajoutImage($fileImage, $repertoire, $_POST['nom']);

        $success = ajoutCryptoBD($_POST['nom'], $_POST['libelle'], $_POST['description'], (int)$_POST['idType'], $nomImage );

        if ($success) { ?>
            <div class="alert alert-success" role="alert">
                L'ajout a bien été éffectué
            </div>
        <?php }
        else { ?>
            <div class="alert alert-danger" role="alert">
                L'ajout n'a pas été effectué
            </div>
        <?php }
    }
    catch(Exception $e) {
        echo $e->getMessage();
    }
}



$types = getTypesBD();
?>

<h2 class="text-center mt-5 text-white">Ajouter une nouvelle Crypto Monnaie</h2>

<div class="container">


    <form action="" method="POST" enctype="multipart/form-data">

        <div class="form-group mt-5">
            <label for="nom">Nom : </label>
            <input type="text" name="nom" id="nom" placeholder="Veuillez saisir un nom" class="form-control" required>
        </div>

        <div class="form-group mt-4">
            <label for="libelle">Libelle : </label>
            <input type="text" name="libelle" id="libelle" placeholder="Veuillez saisir un libelle" class="form-control" required>
        </div>

        <div class="form-group mt-4">
            <label for="description">Description de la cryptomonnaie : </label>
            <textarea name="description" class="form-control" required></textarea>
        </div>

        <div class="form-group mt-4">
            <label>Sélectionner un type : </label>
            <select class="form-control btn btn-secondary" name="idType">
                <?php foreach($types as $type) { ?>
                    <option value="<?= $type['idType'] ?>"><?= $type['libelle'] ?></option>
                <?php } ?>
            </select>
        </div>

        <div class="form-group mt-4">
            <label class="text-white">Ajouter un Logo :</label>
            <input type="file" class="form-control-file text-white" name="logoCrypto">
        </div>

        <div>
            <input type="submit" value="Valider" class="btn btn-primary mt-5">
        </div>
    </form>
</div>



<scrip src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></scrip>
</body>
</html>