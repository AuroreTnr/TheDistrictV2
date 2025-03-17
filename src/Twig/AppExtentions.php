<?php

namespace App\Twig;

use App\Classe\Panier;
use Twig\Extension\AbstractExtension;
use Twig\Extension\GlobalsInterface;
use Twig\TwigFilter;

class AppExtentions extends AbstractExtension implements GlobalsInterface
{

    private $panier;

    public function __construct(Panier $panier)
    {
        $this->panier = $panier;
    } 
    public function getFilters(): array
    {
        return [
            new TwigFilter('price', [$this, 'formatPrice']),
        ];

    }

    public function formatPrice(float $number)
    {

        return number_format($number,'2',',') . ' €';

    }

    public function getGlobals(): array
    {
        return [
            'fullPanierQuantity' => $this->panier->fullPanierQuantity(),
        ];
    }


}



