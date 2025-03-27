<?php

namespace App\Controller\Account;

use App\Classe\Panier;
use App\Repository\CommandeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use \Mailjet\Resources;

final class HomeController extends AbstractController
{

    private $entityManagerInterface;

    public function __construct(EntityManagerInterface $entityManagerInterface)
    {
        $this->entityManagerInterface = $entityManagerInterface;    
    }



    #[Route('/compte', name: 'app_account')]
    public function index(CommandeRepository $commandeRepository): Response
    {


        $commandes = $commandeRepository->findBy([
            'user' => $this->getUser(),
            'status' => [2,3]
        ]);


        return $this->render('account/index.html.twig', [
            'commandes' => $commandes,
        ]);
    }


}
