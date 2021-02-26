<?php

function ajoutImage($file, $dir, $nom){
    if(!isset($file['name']) || empty($file['name']))
        throw new Exception('<div class="alert alert-danger">Vous devez ajouter une image </div>');

    if(!file_exists($dir)) mkdir($dir,0777);

    $extension = strtolower(pathinfo($file['name'],PATHINFO_EXTENSION));
    $target_file = $dir. $nom . "_". $file['name'];
    
    if(!getimagesize($file["tmp_name"]))
        throw new Exception('<div class="alert alert-danger">Le fichier n\'est pas une image</div>');

    if($extension !== "jpg" && $extension !== "jpeg" && $extension !== "png" && $extension !== "gif" && $extension !== "svg")
        throw new Exception('<div class="alert alert-danger">"L\'extension du fichier n\'est pas reconnu"</div>');

    if(file_exists($target_file))
        throw new Exception('<div class="alert alert-danger">Le fichier existe déjà</div>');

    if($file['size'] > 500000)
        throw new Exception('<div class="alert alert-danger">Le fichier est trop volumineux</div>');

    if(!move_uploaded_file($file['tmp_name'], $target_file))
        throw new Exception('<div class="alert alert-danger">L\'ajout de l\'image n\'a pas fonctionné</div>');
    else return ($nom . "_". $file['name']);
}



function deleteImage($folder, $nom) {
    unlink($folder.$nom);   // images/nomImage
}