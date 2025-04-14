# 🍽️ TheDistrictV2

![Symfony](https://img.shields.io/badge/Symfony-000000?style=for-the-badge&logo=symfony&logoColor=white)
![Twig](https://img.shields.io/badge/Twig-FFD600?style=for-the-badge&logo=twig&logoColor=black)
![PHP](https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white)
![React](https://img.shields.io/badge/React-61DAFB?style=for-the-badge&logo=react&logoColor=black)
![Stripe](https://img.shields.io/badge/Stripe-008CDD?style=for-the-badge&logo=stripe&logoColor=white)
![Mailjet](https://img.shields.io/badge/Mailjet-F5A623?style=for-the-badge&logo=mailjet&logoColor=white)
![Bootstrap](https://img.shields.io/badge/Bootstrap-7952B3?style=for-the-badge&logo=bootstrap&logoColor=white)
![Status](https://img.shields.io/badge/Status-En%20cours-yellow?style=for-the-badge)


**TheDistrictV2** est une application web développée avec Symfony permettant la gestion complète d’un site de restauration : présentation des plats, commandes en ligne, gestion des utilisateurs, paiement sécurisé et génération de factures.

## 🚀 Fonctionnalités principales

- 🛍️ **Commande en ligne** avec gestion du panier  
- 💳 **Paiement sécurisé** via [Stripe](https://stripe.com/)  
- 📧 **Envoi d’emails automatiques** (confirmation de commande, etc.) via [Mailjet](https://www.mailjet.com/)  
- 🧾 **Génération de factures en PDF**  
- 📂 **Historique des commandes**  
  - Téléchargement ou impression des factures (client et admin)  
- 🔐 Interfaces **client** et **administrateur**  
- 📱 Interface responsive avec Bootstrap  

## 🧑‍💻 Technologies utilisées

- Symfony  
- PHP 8+  
- Twig  
- Bootstrap  
- JavaScript  
- Stripe API  
- Mailjet API  
- DomPDF  

## ⚙️ Installation

1. Cloner le dépôt :
```bash
   git clone https://github.com/AuroreTnr/TheDistrictV2.git
   cd TheDistrictV2
```

2. Installer les dépendances :
```bash
composer install
npm install
```

3. Copier le fichier .env et renseigner vos identifiants API Stripe et Mailjet :
```bash
cp .env .env.local
```

4. Créer la base de données
```bash
php bin/console doctrine:database:create
php bin/console doctrine:migrations:migrate
```
5. Lancer le serveur
```bash
symfony server:start
```

## 🚧 À venir

- Ajout de **tests unitaires** pour garantir la fiabilité des fonctionnalités clés (PHPUnit).
- Mise en place de **fixtures** pour faciliter le remplissage de la base de données avec des données de test (`doctrine:fixtures:load`).
- Mise en place de l’**API** pour exposer les données (plats, catégories, commandes...).
- Intégration de **React** pour l’affichage dynamique des plats côté front.
- Amélioration de la documentation technique et fonctionnelle.
- Déploiement du projet en production (Docker, hébergement, CI/CD).
- Améliorer le code


## 🙋‍♀️ Auteure
Développé par Aurore Tournier dans le cadre de la formation Concepteur Développeur d’Applications – AFPA 2025.
















