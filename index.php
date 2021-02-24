
<?php require 'elements/header.php'; ?>

    

<!-- DIV API BITCOIN PRICE -->
<div class="container mt-5">
   <h2 class="text-warning text-center" id="divPrix"></h2>
</div>



<?php
require_once './model/requetes.php';

// SUPPRESSION DE LA CRYPTO 
// POP-UP SUPPRESSION AVEC TRANSMISSION VIA L'URL
if (isset($_GET['type']) && $_GET['type'] === "suppression") {

    $cryptoNameToDelete = getCryptoNameToDeleteBD($_GET['idCrypto']);
 
    ?>
   
    <div class="alert alert-warning" role="alert">
        Voulez-vous vraiment <b class="text-danger">supprimer</b> l'élément : <b><?= $cryptoNameToDelete ?></b>
        <a href="?delete=<?= $_GET['idCrypto']?>" class="btn btn-danger mx-5">Supprimer</a>
        <a href="index.php" class="btn btn-success">Annuler</a>
    </div>

<?php } 


// SUPPRESSION DE LA CRYPTO EN BDD

if (isset($_GET['delete'])) {
    $success = deleteCryptoBD($_GET['delete']);

    if ($success) { ?>
        <div class="alert alert-success" role="alert">
            La suppression a bien été éffectuée
        </div>
    <?php }
    else { ?>
        <div class="alert alert-danger" role="alert">
            La suppression n'a pas été éffectuée
        </div>
   <?php }
}




// RECUPERATION DES COURS (A REALISER APRES LA SUPPRESSION EN BDD)
$cryptos = getCryptosBD();
?>


<a href="ajout.php" class="btn btn-primary">Ajouter</a>

<!-- DIV INFO CRYPTOS -->
<div class="row mt-5">

    <?php foreach($cryptos as $crypto) { ?>
        <div class="col-4 d-flex justify-content-around ">
            <div class="card my-5">

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

            </div>
        </div>
    <?php } ?> 

</div>



<script src="Api/api.js"></script>


<scrip src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></scrip>
</body>
</html>