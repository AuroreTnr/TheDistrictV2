<?php

namespace App\Controller\Account;

use App\Classe\Panier;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class HomeController extends AbstractController
{

    private $entityManagerInterface;

    public function __construct(EntityManagerInterface $entityManagerInterface)
    {
        $this->entityManagerInterface = $entityManagerInterface;    
    }



    #[Route('/compte', name: 'app_account')]
    public function index(Panier $panier): Response
    {
        return $this->render('account/index.html.twig', [
            'panier' => $panier->getPanier(),
        ]);
    }


}
