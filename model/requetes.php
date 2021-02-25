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
 * Recupère tous les types en BDD
 *
 * @return array
 */
function getTypesBD() {

    $pdo = MonPDO::getPDO();
    $req = "SELECT * FROM type";
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



/**
 * Récupère l'id et le libelle de la crypto à supprimer
 *
 * @param int $idCrypto
 * @return mixed $idCrypto et $libelle
 */
function getCryptoNameToDeleteBD($idCrypto) {

    $pdo = MonPDO::getPDO();
    $req = 'SELECT CONCAT(idProduits, " : ", libelle) as cryptoASupprimer FROM produits WHERE idProduits = :idProduits';
    $traitement = $pdo->prepare($req);
    $traitement->bindvalue(":idProduits", $idCrypto, PDO::PARAM_INT);
    $traitement->execute();
    $resultat = $traitement->fetch(PDO::FETCH_ASSOC);
    return $resultat['cryptoASupprimer'];
}




/**
 * Supprime en BDD la crypto grâce à l'id
 *
 * @param  int $idCrypto
 * @return bool 
 */
function deleteCryptoBD($idCrypto) {

    $pdo = MonPDO::getPDO();
    $req = "DELETE FROM produits WHERE idProduits = :idProduits";
    $traitement = $pdo->prepare($req);
    $traitement->bindvalue(":idProduits", $idCrypto, PDO::PARAM_INT);
    return $traitement->execute();
}




/**
 * Modifie Crypto en BDD
 *
 * @param  int $idCrypto
 * @param  string $nom
 * @param  string $libelle
 * @param  string $description
 * @param  int $idType
 * @return bool
 */
function modifierCryptoBD($idCrypto, $nom, $libelle, $description, $idType) {
    
    $pdo = MonPDO::getPDO();
    $req = "UPDATE produits set nom = :nomCrypto, libelle = :libelleCrypto, description = :descriptionCrypto, idType = :idType WHERE idProduits = :idProduits";
    $traitement = $pdo->prepare($req);
    $traitement->bindvalue(":idProduits", $idCrypto, PDO::PARAM_INT);
    $traitement->bindvalue(":nomCrypto", $nom, PDO::PARAM_STR);
    $traitement->bindvalue(":libelleCrypto", $libelle, PDO::PARAM_STR);
    $traitement->bindvalue(":descriptionCrypto", $description, PDO::PARAM_STR);
    $traitement->bindvalue(":idType", $idType, PDO::PARAM_INT);
    return $traitement->execute();
}




/**
 * Ajouter Crypto en BDD
 *
 * @param  string $nom
 * @param  string $libelle
 * @param  string $description
 * @param  int $idType
 * @param  mixed $image
 * @return bool
 */
function ajoutCryptoBD($nom, $libelle, $description, $idType, $image) {
    $pdo = MonPDO::getPDO();
    $req = "INSERT INTO produits (nom, libelle, description, image, idType) VALUES (:nom , :libelle, :description, :image, :type)";
    $traitement = $pdo->prepare($req);
    $traitement->bindvalue(":nom", $nom, PDO::PARAM_STR);
    $traitement->bindvalue(":libelle", $libelle, PDO::PARAM_STR);
    $traitement->bindvalue(":description", $description, PDO::PARAM_STR);
    $traitement->bindvalue(":image", $image, PDO::PARAM_STR);
    $traitement->bindvalue(":type", $idType, PDO::PARAM_INT);
    return $traitement->execute();
}