<?php

namespace App\Classe;

use App\Entity\Plat;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_CLIENT', message: "Nous sommes désolés, vous ne disposez pas des autorisations nécessaires pour accèder à cette page!")]
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


    public function fullPanierQuantity(){
        $panier = $this->getPanier();
        $quantity = 0;

        if (!isset($panier)) {
            return $quantity;
        }

        foreach ($panier as $plat) {
            $quantity = $quantity + $plat['qty'];
        }

        return $quantity;
    }

    public function getNetTotalWt()
    {
        $panier = $this->getPanier();

        $prix = 0;

        if (!isset($panier)) {
            return $prix;
        }


        foreach ($panier as $plat) {
            $prix = $prix + ($plat['object']->getPriceWt() * $plat['qty']);
        }

        return $prix;
    }


}


