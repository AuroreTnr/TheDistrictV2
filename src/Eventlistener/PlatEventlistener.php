<?php

namespace App\Eventlistener;

use App\Entity\Plat;
use Doctrine\Persistence\Event\LifecycleEventArgs;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Imagick\Driver;
use Symfony\Component\HttpFoundation\File\UploadedFile;


class PlatEventlistener
{

    private $manager; 

    public function __construct(ImageManager $manager)
    {
        $this->manager = $manager;
    }


    public function prePersist(Plat $plat, LifecycleEventArgs $args)
    {
        $entity = $args->getObject();

        if ($entity instanceof Plat) {
            $image = $plat->getImage();
        }

//         // Vérifie si l'image est un fichier téléchargé
        if ($image instanceof UploadedFile) {

//             // Définir le répertoire où l'image originale sera sauvegardée
            $targetDirectory = 'public/asset/uploads/images/plat/';
            $fileName = $image->getClientOriginalName();

//             // Déplacer l'image vers le répertoire de destination
            $image->move($targetDirectory, $fileName);

//             // Créer une instance de ImageManager pour manipuler l'image
            $img = $this->manager->read($targetDirectory . $fileName);

//             // Redimensionner l'image
            $img->scale(300, 300);

//             // Sauvegarder l'image redimensionnée
            $img->save($targetDirectory . $fileName);

//             // Mettre à jour l'entité avec le nom de l'image redimensionnée
            $plat->setImage($fileName);
        }
    }
}



// https://image.intervention.io/v3/modifying/inserting



// /etc/php/8.3/cli/conf.d/20-gd.ini