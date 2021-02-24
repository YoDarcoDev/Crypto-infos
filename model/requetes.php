<?php

require_once 'class/pdo.php';


/**
 * Recupère toutes les infos des cryptos en BDD
 *
 * @return array
 */
function getCryptosBD() {

    // CONNEXION BDD
    $pdo = MonPDO::getPDO();

    $req = "SELECT * FROM produits";
    $resultat = $pdo->prepare($req);
    $resultat->execute();
    return $resultat->fetchAll(PDO::FETCH_ASSOC);
}




/**
 * Récupère le type en fonction de la Crypto
 *
 * @param  mixed $idType
 * @return array
 */
function getNomType($idType) {

    $pdo = MonPDO::getPDO();
    $req = "SELECT libelle FROM type WHERE idType = :idType";
    $resultat = $pdo->prepare($req);
    $resultat->bindvalue(":idType", $idType, PDO::PARAM_INT);
    $resultat->execute();
    return $resultat->fetch(PDO::FETCH_ASSOC);
}



function getCryptoNameToDeleteBD($idCrypto) {

    $pdo = MonPDO::getPDO();
    $req = 'SELECT CONCAT(idProduits, " : ", libelle) as cryptoASupprimer FROM produits WHERE idProduits = :idProduits';
    $traitement = $pdo->prepare($req);
    $traitement->bindvalue(":idProduits", $idCrypto, PDO::PARAM_INT);
    $traitement->execute();
    $resultat = $traitement->fetch(PDO::FETCH_ASSOC);
    return $resultat['cryptoASupprimer'];
}




function deleteCryptoBD($idCrypto) {

    $pdo = MonPDO::getPDO();
    $req = "DELETE FROM produits WHERE idProduits = :idProduits";
    $traitement = $pdo->prepare($req);
    $traitement->bindvalue(":idProduits", $idCrypto, PDO::PARAM_INT);
    return $traitement->execute();
}