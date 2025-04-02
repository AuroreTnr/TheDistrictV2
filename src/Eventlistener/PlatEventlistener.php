<?php

namespace App\Eventlistener;

use App\Entity\Plat;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Exception;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Intervention\Image\Drivers\Imagick\Driver;
use Intervention\Image\ImageManager;



class PlatEventlistener
{

    private $manager; 

    public function __construct()
    {
        $this->manager = new ImageManager(new Driver());
    }


    public function prePersist(LifecycleEventArgs $args)
    {

        $plat = $args->getObject();

        if ($plat instanceof Plat) {
            $image = $plat->getImage();
        }

//         // Vérifie si l'image est un fichier téléchargé
        if ($image instanceof UploadedFile) {

//             // Définir le répertoire où l'image originale sera sauvegardée
            $targetDirectory = 'public/asset/uploads/images/plat/';
            $fileName = $image->getClientOriginalName();

//             // Déplacer l'image vers le répertoire de destination
            $image->move($targetDirectory, $fileName);

            try {
//             // Créer une instance de ImageManager pour manipuler l'image
            $img = $this->manager->read($targetDirectory . $fileName)->scale(300, 300);

//             // Sauvegarder l'image redimensionnée
            $img->save($targetDirectory . $fileName);

              // Mettre à jour l'entité avec le nom de l'image redimensionnée
            $plat->setImage($fileName);

            } catch (Exception $e) {
                throw new \Exception("Error processing image: " . $e->getMessage());            
            }

        }
    }
}



// https://image.intervention.io/v3/modifying/inserting



// /etc/php/8.3/cli/conf.d/20-gd.ini


// https://image.intervention.io/v3/introduction/frameworks#installation-1