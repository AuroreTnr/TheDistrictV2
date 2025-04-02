<?php
// Charge le fichier autoload de Composer
require 'vendor/autoload.php';

use Intervention\Image\Drivers\Imagick\Driver;
use Intervention\Image\ImageManager;

// Crée une instance de ImageManager avec le driver 'gd'
$manager = new ImageManager(new Driver());

// Essaie de redimensionner une image
try {
    $image = $manager->read('asset/uploads/plat/2025-04-02-d7041a3a95be60739439b47ab7b88e91e71e77d8.jpg')->scale(300, 300);
    $image->save('asset/uploads/plat/imageresized.jpg');
    echo "Image resized successfully!";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
