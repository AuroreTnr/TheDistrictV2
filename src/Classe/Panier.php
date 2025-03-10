<?php

namespace App\Classe;

use Symfony\Component\HttpFoundation\RequestStack;

class Panier
{
    public function __construct(private RequestStack $requestStack)
    {
    }

    public function add($plat)
    {


        $panier = $this->requestStack->getSession()->get('panier');

        $panier[$plat->getId()] = [];

        if ($panier[$plat->getId()]) {
            $panier[$plat->getId()] = [
                'object' => $plat,
                'qty' => $panier[$plat->getId()]['qty'] + 1    
            ];
        }else {
            $panier[$plat->getId()] =  [
                'object' => $plat,
                'qty' => 1
            ];
        }



        $this->requestStack->getSession()->set('panier', $panier);

    }

    public function getPanier()
    {
        return $this->requestStack->getSession()->get('panier');
    }


}


