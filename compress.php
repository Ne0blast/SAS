<?php
    // Permet de compresser tous les jpg d'un répertoire

    $directory = "storage/galerie/";

    $files = scandir($directory);
    
    // Supression des anciens fichiers compressés
    foreach($files as $f)
    {
        // Si l'on ne pointe pas vers les dossiers "." et ".."
        if($f != "." && $f != "..")
        {
            $name = substr($f, 0, strpos($f, "."));
            $extension = substr($f, strpos($f, "."), strlen($f));
        }
        
        // Si les fichiers ont bien l'extension ".jpg"
        if($extension == ".jpg" || $extension == ".JPG")
        {
            // Si le fichier n'est pas déjà compressé
            if(strrpos($f, "compressed"))
            {
                unlink($directory.$f);
                
                echo "Supression du fichier".$f." !<br />";
            }
        }
    }
    
    // Compression des fichiers
    foreach($files as $f)
    {
        // Si l'on ne pointe pas vers les dossiers "." et ".."
        if($f != "." && $f != "..")
        {
            $name = substr($f, 0, strpos($f, "."));
            $extension = substr($f, strpos($f, "."), strlen($f));
            
            // Si les fichiers ont bien l'extension ".jpg"
            if($extension == ".jpg" || $extension == ".JPG")
            {
                // Si le fichier n'est pas déjà compressé
                if(!strrpos($f, "compressed"))
                {
                    $img = imagecreatefromjpeg($directory.$f);
                    imagejpeg($img, $directory.$name."_compressed".$extension, 0);
                    
                    echo "Compression du fichier $name !<br />";
                }
            }
        }
    }
?>