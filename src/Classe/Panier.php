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


        if (isset($panier[$plat->getId()])) {
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

    public function remove()
    {


        return $this->requestStack->getSession()->remove('panier');


    }

    public function less($id)
    {

        $panier = $this->requestStack->getSession()->get('panier');

        if ($panier[$id]['qty'] > 1) {
            $panier[$id]['qty'] = $panier[$id]['qty'] - 1;
        } else {
            unset($panier[$id]);
        }

        $this->requestStack->getSession()->set('panier', $panier);
        

    }

    public function getPanier()
    {
        return $this->requestStack->getSession()->get('panier');
    }


}


