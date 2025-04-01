<?php


namespace App\Eventlistener;

use App\Entity\Plat;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Intervention\Image\ImageManager;



class PlatEventlistener
{
    private $uploadDir;

    public function __construct(string $uploadDir)
    {
        $this->uploadDir = $uploadDir;
    }

    public function prePersist(Plat $plat, LifecycleEventArgs $args)
    {
        // Événement avant l'insertion d'un plat (création)
        $this->handleImage($plat);
    }

    public function preUpdate(Plat $plat, LifecycleEventArgs $args)
    {
        // Événement avant la mise à jour d'un plat
        $this->handleImage($plat);
    }

    private function handleImage(Plat $plat)
    {
        // Vérifier si une image a été téléchargée
        $imageFile = $plat->getImage(); // Supposons que tu as une méthode getImage() dans ton entité Plat

        if ($imageFile instanceof UploadedFile) {
            // Créer un nom de fichier unique pour l'image
            $filename = uniqid() . '.' . $imageFile->guessExtension();
            $filePath = $this->uploadDir . '/' . $filename;

            // Créer une instance d'ImageManager d'Intervention
            $manager = new ImageManager();

            // Lire l'image
            $image = $manager->make($imageFile->getRealPath());

            // Redimensionner l'image à une hauteur de 300px tout en maintenant le ratio
            $image->resize(null, 300); // La largeur sera calculée automatiquement en fonction du ratio

            // Sauvegarder l'image redimensionnée
            $image->save($filePath);

            // Assigner le chemin du fichier à l'entité Plat
            $plat->setImagePath($filename); // Supposons que tu as une méthode setImagePath() pour stocker le chemin de l'image
        }
    }}