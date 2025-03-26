<?php

namespace App\Controller\Admin;

use App\Entity\Commande;
use EasyCorp\Bundle\EasyAdminBundle\Attribute\AdminAction;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\HttpFoundation\Response;

class CommandeCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Commande::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            // the labels used to refer to this entity in titles, buttons, etc.
            ->setEntityLabelInSingular('Commande')
            ->setEntityLabelInPlural('Commandes')
        ;
    }

    public function configureActions(Actions $actions): Actions
    {
        $show = Action::new('Afficher')
            ->linkToCrudAction('show');

        return $actions
            ->add(Crud::PAGE_INDEX, $show)
            ->remove(Crud::PAGE_INDEX, Action::NEW)
            ->remove(Crud::PAGE_INDEX, Action::EDIT)
            ->remove(Crud::PAGE_INDEX, Action::DELETE);

        
    }


    #[AdminAction(routePath: '{entityId}/custom-action', routeName: 'custom_action')]
    public function show(AdminContext $context): Response
    {
        
        $commande = $context->getEntity()->getInstance();

        return $this->render('admin/commande.html.twig', [
            'commandes' => $commande
        ]);


    }
    

    
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            DateField::new('date_commande')->setLabel('Date'),
            NumberField::new('status')->setLabel('Status commande')->setTemplatePath('admin/status.html.twig'),
            AssociationField::new('user')->setLabel('Client'),
            TextField::new('nomTransporteur')->setLAbel('Transporteur'),
            NumberField::new('totalTva')->setLabel('Total TVA')->setNumDecimals(2),
            NumberField::new('totalWt')->setLabel('Total TTC')->setNumDecimals(2),
        ];
    }
    
}
