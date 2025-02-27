USE `the_district_v2_db`;

-- Structure de la table `categorie`

INSERT INTO `categorie` (libelle, image, active) VALUES
('Burger','asset/img/cat_img/burger_cat.jpg', 1),
('Pizza','asset/img/cat_img/pizza_cat.jpg', 1),
('pate','asset/img/cat_img/pasta_cat_4.jpg', 1),
('salade','asset/img/cat_img/salade_cat.jpg', 1),
('sandwish','asset/img/cat_img/sandwish_cat.jpg', 1),
('veggie','asset/img/cat_img/veggie_cat.jpg', 1),
('wrap','asset/img/cat_img/wrap_cat.jpg', 1),
('asiatique','asset/img/cat_img/asiatique_cat.jpg', 1);


INSERT INTO `plat` (libelle, description, prix, image, categorie_id, active) VALUES
('Burger charolais', 'Rustique et delicieux hamburger charolais.', 9.90, 'asset/img/food_img/burger/burger-charolais.jpg', 13, 1),
('Cheesburger', 'Delicieux et fondant cheesburger.', 7.60, 'asset/img/food_img/burger/cheesburger.jpg', 13, 1),
('Burger classique', 'L indémodable classique.', 6.00, 'asset/img/food_img/burger/hamburger.jpg', 13, 1),

('Pizza chorizo', 'La classique chorizo.', 6.00, 'asset/img/food_img/pizza/pizza-chorizo.jpg', 14, 1),
('Pizza basilic', 'Au basilic frais.', 6.20, 'asset/img/food_img/pizza/pizza-fromage-basilic.jpg', 14, 1),
('Pizza saumon', 'Au saumon sauvage.', 8.00, 'asset/img/food_img/pizza/pizza-salmon.png', 14, 1),

('Pâte legumes', 'Délicieuse pâte aux légumes frais.', 6.00, 'asset/img/food_img/pasta/spaghetti-legumes.jpg', 15, 1),
('Lasagne pâte fraiche', 'Au boeuf frais.', 6.20, 'asset/img/food_img/pasta/lasagnes_viande.jpg', 15, 1),

('Salade fraicheur', 'La salade la plus demandée.', 6.00, 'asset/img/food_img/salade/salade-fraicheur.jpg', 16, 1),
('Salade composee', 'Délicieusement fraiche.', 6.20, 'asset/img/food_img/salade/salade-composee.jpg', 16, 1),
('Salade du chef', 'Délicieusement salade fraiche.', 6.40, 'asset/img/food_img/salade/salade-du-chef.jpg', 16, 1),

('Sandwish roti crudite', 'Le sandwish le plus demandé.', 4.50, 'asset/img/food_img/sandwish/sandwish-roti-crudite.jpg', 17, 1),
('Sandwish fromage', 'Délicieusement fromage de brebis.', 6.20, 'asset/img/food_img/sandwish/sandwish-fromage.jpg', 17, 1),
('Maxi sandwish', 'Le sandwish à emporter partout.', 3.40, 'asset/img/food_img/sandwish/maxi-sandwish.jpg', 17, 1),

('Bouillon de legumes', 'Le bouillon aux petits légumes de notre potagé.', 4.50, 'asset/img/food_img/veggie/bouillon-legume.jpg', 18, 1),
('Burger veggie', 'Délicieusement burger aux haricot rouge.', 6.20, 'asset/img/food_img/veggie/burger-veggie.jpg', 18, 1),
('Poêlée du chef', 'La poêlée du chef la plus gourmande de notre carte.', 3.40, 'asset/img/food_img/veggie/poelee-du-chef.jpg', 18, 1),

('Wrap crudite', 'Le passe partout.', 4.50, 'asset/img/food_img/wrap/wrap-crudite.jpg', 19, 1),
('Wrap mexicain', 'Délicieusement wrap spicy.', 6.20, 'asset/img/food_img/wrap/wrap-mexicain.jpg', 19, 1),
('Wrap poulet', 'Délicieux wrap avec du poulet  Français, élévé en libertée.', 7.40, 'asset/img/food_img/wrap/wrap-poulet.jpg', 19, 1),

('Ravioli', 'Délicieux ravioli au boeuf.', 7.50, 'asset/img/food_img/asiatique-food/ravioli.jpg', 20, 1),
('Riz cantonais', 'Délicieusement riz.', 5.20, 'asset/img/food_img/asiatique-food/riz-cantonais.jpg', 20, 1),
('Soupe asiatique', 'Délicieuse soupe.', 8.40, 'asset/img/food_img/asiatique-food/soupe-asiatique.jpg', 20, 1),
('Sushi', 'Délicieuse sushi.', 9.90, 'asset/img/food_img/asiatique-food/sushi.jpg', 20, 1);





-- INSERT INTO `commande` (id_plat, quantite, total, date_commande, etat, nom_client, telephone_client, email_client, adresse_client) 
-- VALUES
-- (1, 3, 15.15, '2025-01-11', 'Livrée', 'Julien Lefort', '0622334455', 'julien.lefort@email.com', '10 rue des Champs Elysées, 75008 Paris'),
-- (2, 2, 15.20, '2025-01-10', 'En préparation', 'Claire Dupont', '0698765432', 'claire.dupont@email.com', '19 avenue Montaigne, 75008 Paris'),
-- (3, 4, 24.00, '2025-01-12', 'Livrée', 'David Boucher', '0656789123', 'david.boucher@email.com', '21 rue de la Paix, 75002 Paris'),
-- (4, 1, 6.00, '2025-01-11', 'En cours', 'Nathalie Vasseur', '0645789234', 'nathalie.vasseur@email.com', '43 rue de la Bastille, 75011 Paris'),
-- (5, 5, 31.50, '2025-01-12', 'Livrée', 'Michel Legrand', '0666789101', 'michel.legrand@email.com', '76 rue du Faubourg Saint-Antoine, 75012 Paris'),
-- (1, 2, 10.10, '2025-01-10', 'En préparation', 'Caroline Lemoine', '0681234567', 'caroline.lemoine@email.com', '30 rue de la République, 75003 Paris'),
-- (3, 3, 18.00, '2025-01-07', 'Livrée', 'Xavier Martin', '0623345567', 'xavier.martin@email.com', '7 avenue de la Concorde, 75008 Paris'),
-- (4, 1, 6.00, '2025-01-11', 'En préparation', 'François Guérin', '0654321098', 'francois.guerin@email.com', '25 rue de la Tour, 75007 Paris'),
-- (5, 3, 18.60, '2025-01-06', 'Livrée', 'Amandine Lefevre', '0776543210', 'amandine.lefevre@email.com', '10 rue des Lilas, 75012 Paris');


