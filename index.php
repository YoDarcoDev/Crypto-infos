
<?php require 'elements/header.php'; ?>

    

<!-- DIV API BITCOIN PRICE -->
<div class="container mt-5">
   <h2 class="text-warning text-center" id="divPrix"></h2>
</div>



<?php
require_once './model/requetes.php';
require_once 'gestionImage.php';


// VERIFICATION SUPPRESSION AVEC TRANSMISSION VIA L'URL (POPUP)
if (isset($_GET['type']) && $_GET['type'] === "suppression") {
    $cryptoNameToDelete = getCryptoNameToDeleteBD($_GET['idCrypto']); ?>
   
    <div class="alert alert-warning" role="alert">
        Voulez-vous vraiment <b class="text-danger">supprimer</b> l'élément : <b><?= $cryptoNameToDelete ?></b>
        <a href="?delete=<?= $_GET['idCrypto']?>" class="btn btn-danger mx-5">Supprimer</a>
        <a href="index.php" class="btn btn-success">Annuler</a>
    </div>
<?php 
} 


// SUPPRESSION EN BDD
if (isset($_GET['delete'])) {

    // SUPPRIME L'IMAGE DU DOSSIER IMAGES
    $imageToDelete = getImageToDelete($_GET['delete']);
    deleteImage("images/", $imageToDelete);
    // SUPPRIME LES INFOS 
    $success = deleteCryptoBD($_GET['delete']);

    if ($success) { ?>
        <div class="alert alert-success" role="alert">
            La suppression a bien été éffectuée
        </div>
    <?php }
    else { ?>
        <div class="alert alert-danger" role="alert">
            La suppression n'a pas été effectuée
        </div>
   <?php }
}


// MODIFICATION 
if (isset($_POST['type']) && $_POST['type'] === "modificationEtape2") {

    // MODIFIER IMAGE SUPPRESSION
    $nomNouvelleImage = "";
    if ($_FILES['logoCrypto']['name'] !== "") {

        $imageToDelete = getImageToDelete($_POST['idCrypto']);
        deleteImage("images/", $imageToDelete);

        // MODIFIER IMAGE AJOUT
        $fileImage = $_FILES['logoCrypto'];
        $repertoire = "images/";
        
        try {
            // NOUVEAU NOM DE L'IMAGE
            $nomNouvelleImage = ajoutImage($fileImage, $repertoire, $_POST['nomCrypto']);
        }
        catch(Exception $e) {
            echo $e->getMessage();
        }
    }

    $success = modifierCryptoBD($_POST['idCrypto'], $_POST['nomCrypto'], $_POST['libelleCrypto'], $_POST['descriptionCrypto'], $_POST['idType'], $nomNouvelleImage);


    if ($success) { ?>
        <div class="alert alert-success" role="alert">
            La modification a bien été éffectuée
        </div>
    <?php }
    else { ?>
        <div class="alert alert-danger" role="alert">
            La modification n'a pas été effectuée
        </div>
   <?php }
}



// RECUPERATION DES COURS (A REALISER APRES LA SUPPRESSION EN BDD)
$cryptos = getCryptosBD();
$types = getTypesBD();
?>



<!-- AFFICHER CARD IMG NOM LIBELLE DESC TYPE -->
<div class="row mt-5">

    <?php foreach($cryptos as $crypto) { ?>
        <div class="col-4 d-flex justify-content-around ">
            <div class="card my-5">


            <!-- TESTER SI ON A PAS RECU L'INFO DE MODIFICATION DANS L'URL -->
            <!-- TESTER SI L'ID DE LA CRYPTO COURANTE EST DIFFERENTE DE CELLE DE L'URL -->
            <?php 
                if (!isset($_GET['type']) || $_GET['type'] !== "modification" || $_GET['idCrypto'] !== $crypto['idProduits']) { ?>

              
                <div class="row mt-4">
                    
                    <!-- COLONNE IMAGE -->
                    <div class="col-6 d-flex justify-content-center align-items-center">
                        <img src="images/<?= $crypto['image'] ?>" id="img-logo" class="card-img-top" alt="logo crypto">
                    </div>

                    
                    <!-- COLONNE NOM ET TYPE -->
                    <div class="col-6 d-flex flex-column align-items-center justify-content-around caract">
                        
                        <!-- BADGE NOM -->
                        <div class="badge bg-secondary">
                            <?= strtoupper($crypto['nom']) ?>
                        </div>


                        <!-- BADGE TYPE -->
                        <?php 
                            $type = getNomType($crypto['idType']);
                            // print_r($type);
                        
                        if ($type['libelle'] === "Smart Contracts") { ?>
                            <div class="badge bg-warning"><?= $type['libelle'] ?></div>
                        <?php } 

                        elseif ($type['libelle'] === "PoW") { ?>
                            <div class="badge bg-danger"><?= $type['libelle'] ?></div>
                        <?php }

                        elseif ($type['libelle'] === "PoS") { ?>
                            <div class="badge bg-success"><?= $type['libelle'] ?></div>
                        <?php } ?>


                        <a href="https://coinmarketcap.com/currencies/<?= $crypto['nom'] ?>" target="_blank" class="badge bg-primary" id="lien">En savoir plus</a>

                    </div>
                </div>

                <div class="card-body">
                    <h5 class="card-title mb-4"><?= $crypto['libelle'] ?></h5>
                    
                    <p class="card-text overflow-auto"><?= $crypto['description']?></p>
                       
                    <!-- BOUTON MODIFIER FORM -->
                    <div class="row mt-5">
                        <form action="" method="GET" class="col-6 text-center" id="modifier">
                            <input type="hidden" name="idCrypto" value="<?= $crypto['idProduits'] ?>">
                            <input type="hidden" name="type" value="modification">
                            <input type="submit" value="Modifier" class="btn btn-primary">
                        </form>

                        <form action="" method="GET" class="col-6 text-center" id="supprimer">
                            <input type="hidden" name="idCrypto" value="<?= $crypto['idProduits'] ?>">
                            <input type="hidden" name="type" value="suppression">
                            <input type="submit" value="Supprimer" class="btn btn-danger">
                        </form>
                    </div>

                </div>
                <?php } 
                

                // MODIFIER CRYPTO AFFICHER FORMULAIRE
                else { ?>
                    <form action="" method="POST" enctype="multipart/form-data">

                        <input type="hidden" name="type" value="modificationEtape2">
                        <input type="hidden" name="idCrypto" value="<?= $crypto['idProduits'] ?>">

                        <div class="row mt-3">

                            <div class="col-6 d-flex justify-content-around align-items-center">
                                <img src="images/<?= $crypto['image'] ?>" id="img-logo" class="card-img-top" alt="logo crypto">
                            </div>
                            <div class="col-6 d-flex justify-content-around align-items-center">
                                <input type="file" class="form-control-file" name="logoCrypto">
                            </div>
                            
                        </div>

                        <!-- MODIFIER INFOS NOM LIBELLE DESC TYPE -->
                        <div class="card-body">
                            
                            <div class="form-group">
                                <label for="nomCrypto">Nom de la crypto :</label>
                                <input type="text" class="form-control mb-2" name="nomCrypto" id="nomCrypto" value="<?= $crypto['nom'] ?>">
                            </div>

                            <div class="form-group">
                                <label for="libelleCrypto">Libelle :</label>
                                <input type="text" class="form-control mb-2" name="libelleCrypto" id="libelleCrypto" value="<?= $crypto['libelle'] ?>">
                            </div>

                            <div class="form-group">
                                <label for="descriptionCrypto">Description :</label>
                                <textarea class="form-control mb-2" name="descriptionCrypto" rows="3" id="descriptionCrypto"><?= $crypto['description'] ?></textarea>
                            </div>

                            <select name="idType" class="form-control mb-3">
                                <?php foreach ($types as $type) {  ?>
                                    <option value="<?= $type['idType'] ?>"
                                        <?php ($type['idType'] === $crypto['idType']) ? "selected" : "" ?>
                                    ><?= $type['libelle'] ?>
                                    </option>
                                <?php } ?>
                            </select>
                       
                            <!-- BOUTON MODIFIER - ANNULER FORM -->
                            <div class="row">
                                <div class="col-6 text-center">
                                    <input type="submit" value="Valider" class="btn btn-success">
                                </div>
                                <div class="col-6 text-center">
                                    <input type="submit" value="Annuler" onclick="annulerModification(event)" class="btn btn-danger">
                                </div>
                            </div>
                                    
                        </div>
                    </form>
                <?php } ?>


            </div>
        </div>
    <?php } ?> 
</div>



<script src="Api/api.js"></script>
<script src="form-btn-annuler.js"></script>

<scrip src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></scrip>
</body>
</html>



