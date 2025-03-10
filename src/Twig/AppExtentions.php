<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class AppExtentions extends AbstractExtension
{

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
}



