
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cryptomonnaies</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<h1 class="text-center p-4 bg-dark text-white">Les différentes cryptomonnaies</h1>
    

<?php

require_once './model/requetes.php';

$cryptos = getCryptosBD();

?>




<div class="container mt-5">
   <h3 class="text-warning text-center" id="divPrix"></h3>
</div>


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
                <div class="col-6 d-flex flex-column align-items-center justify-content-around">
                     
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

                </div>
                

                </div>
                <div class="card-body">
                    <h5 class="card-title mb-4"><?= $crypto['libelle'] ?></h5>
                    <p class="card-text overflow-auto"><?= $crypto['description']?></p>
                    <a href="https://coinmarketcap.com/currencies/<?= $crypto['nom'] ?>" target="_blank" class="btn btn-primary">En savoir plus</a>
                    
                </div>
            </div>
        </div>
    <?php } ?> 

</div>



<script src="Api/api.js"></script>


<scrip src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></scrip>
</body>
</html>