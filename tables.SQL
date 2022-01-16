CREATE TABLE item (
                      id int(11) NOT NULL,
                      liste_id int(11) NOT NULL,
                      nom text NOT NULL,
                      descr text DEFAULT NULL,
                      img text DEFAULT NULL,
                      url text DEFAULT NULL,
                      tarif decimal(5,2) DEFAULT NULL,
                      cagnotte int(11) DEFAULT NULL,
                      PRIMARY KEY (id),
                      foreign key (liste_id) references liste(no)
);

INSERT INTO `item` (`id`, `liste_id`, `nom`, `descr`, `img`, `url`, `tarif`, `cagnotte`) VALUES
                                                                                             (1, 2, 'Champagne', 'Bouteille de champagne + flutes + jeux à gratter', 'champagne.jpg', '', '20.00', NULL),
                                                                                             (2, 2, 'Musique', 'Partitions de piano à 4 mains', 'musique.jpg', '', '25.00', NULL),
                                                                                             (3, 2, 'Exposition', 'Visite guidée de l’exposition ‘REGARDER’ à la galerie Poirel', 'poirelregarder.jpg', '', '14.00', NULL),
                                                                                             (4, 3, 'Goûter', 'Goûter au FIFNL', 'gouter.jpg', '', '20.00', NULL),
                                                                                             (5, 3, 'Projection', 'Projection courts-métrages au FIFNL', 'film.jpg', '', '10.00', NULL),
                                                                                             (6, 2, 'Bouquet', 'Bouquet de roses et Mots de Marion Renaud', 'rose.jpg', '', '16.00', NULL),
                                                                                             (7, 2, 'Diner Stanislas', 'Diner à La Table du Bon Roi Stanislas (Apéritif /Entrée / Plat / Vin / Dessert / Café / Digestif)', 'bonroi.jpg', '', '60.00', NULL),
                                                                                             (8, 3, 'Origami', 'Baguettes magiques en Origami en buvant un thé', 'origami.jpg', '', '12.00', NULL),
                                                                                             (9, 3, 'Livres', 'Livre bricolage avec petits-enfants + Roman', 'bricolage.jpg', '', '24.00', NULL),
                                                                                             (10, 2, 'Diner  Grand Rue ', 'Diner au Grand’Ru(e) (Apéritif / Entrée / Plat / Vin / Dessert / Café)', 'grandrue.jpg', '', '59.00', NULL),
                                                                                             (11, 0, 'Visite guidée', 'Visite guidée personnalisée de Saint-Epvre jusqu’à Stanislas', 'place.jpg', '', '11.00', NULL),
                                                                                             (12, 2, 'Bijoux', 'Bijoux de manteau + Sous-verre pochette de disque + Lait après-soleil', 'bijoux.jpg', '', '29.00', NULL),
                                                                                             (19, 0, 'Jeu contacts', 'Jeu pour échange de contacts', 'contact.png', '', '5.00', NULL),
                                                                                             (22, 0, 'Concert', 'Un concert à Nancy', 'concert.jpg', '', '17.00', NULL),
                                                                                             (23, 1, 'Appart Hotel', 'Appart’hôtel Coeur de Ville, en plein centre-ville', 'apparthotel.jpg', '', '56.00', NULL),
                                                                                             (24, 2, 'Hôtel d\'Haussonville', 'Hôtel d\'Haussonville, au coeur de la Vieille ville à deux pas de la place Stanislas', 'hotel_haussonville_logo.jpg', '', '169.00', NULL),
                                                                                             (25, 1, 'Boite de nuit', 'Discothèque, Boîte tendance avec des soirées à thème & DJ invités', 'boitedenuit.jpg', '', '32.00', NULL),
                                                                                             (26, 1, 'Planètes Laser', 'Laser game : Gilet électronique et pistolet laser comme matériel, vous voilà équipé.', 'laser.jpg', '', '15.00', NULL),
                                                                                             (27, 1, 'Fort Aventure', 'Découvrez Fort Aventure à Bainville-sur-Madon, un site Accropierre unique en Lorraine ! Des Parcours Acrobatiques pour petits et grands, Jeu Mission Aventure, Crypte de Crapahute, Tyrolienne, Saut à l\'élastique inversé, Toboggan géant... et bien plus encore.', 'fort.jpg', '', '25.00', NULL),
                                                                                             (55, 2, 'Objet quelconque', NULL, NULL, NULL, NULL, NULL),
                                                                                             (56, 13, '', '', NULL, NULL, '14.00', NULL),
                                                                                             (57, 13, '', '', NULL, NULL, '999.99', NULL),
                                                                                             (58, 13, 'moyen tier', '', NULL, NULL, '999.99', NULL),
                                                                                             (59, 16, 'erz', '', NULL, NULL, '50.00', NULL),
                                                                                             (60, 16, 'moins bien', 'nul', NULL, NULL, '2.00', NULL),
                                                                                             (61, 16, 'gtrf', '', NULL, NULL, '12.00', NULL),
                                                                                             (62, 18, 'THE item', 'tro bi1', NULL, NULL, '999.99', 75),
                                                                                             (64, 17, 'gtrf', '', NULL, NULL, '12.00', NULL),
                                                                                             (65, 17, 'zert', '', NULL, NULL, '1.00', NULL),
                                                                                             (66, 17, 'dkqzpdk', '', NULL, NULL, '42.00', NULL),
                                                                                             (69, 18, 'l&#39;item du test', '', NULL, NULL, '150.00', 0),
                                                                                             (70, 22, 'super item', '', NULL, NULL, '999.99', NULL),
                                                                                             (71, 22, 'encore un', '', NULL, NULL, '1.00', NULL),
                                                                                             (72, 23, 'super item', '', NULL, NULL, '999.99', NULL),
                                                                                             (73, 23, 'encore un', '1', NULL, NULL, '1.00', NULL);



Create table role(
                     roleid int,
                     label varchar(50),
                     auth_level int,
                     primary key (roleid)
);

insert into role values (1, 'Utilisateur', 1);
insert into role values (2,'Createur',5000);
insert into role values (3,'Admin',10000);

Create table user(
                     userid INT AUTO_INCREMENT,
                     username VARCHAR(20) UNIQUE NOT NULL,
                     password VARCHAR(256) NOT NULL,
                     roleid int,
                     PRIMARY KEY (userid),
                     foreign key (roleid) references role(roleid)
);

insert into user (username, password, roleid) values('user','Azertyuiopqs',2);

CREATE TABLE `liste` (
                         no int(11) AUTO_INCREMENT,
                         user_id int(11) NOT NULL,
                         titre varchar(255) COLLATE utf8_unicode_ci NOT NULL,
                         description text COLLATE utf8_unicode_ci DEFAULT NULL,
                         expiration date DEFAULT NULL,
                         token varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
                         token_partage int(11) DEFAULT NULL,
                         publique varchar(1) COLLATE utf8_unicode_ci DEFAULT NULL,
                         primary key (no),
                         FOREIGN KEY (user_id) references user(userid)
);

INSERT INTO `liste` (`no`, `user_id`, `titre`, `description`, `expiration`, `token`, `token_partage`, `publique`) VALUES
                                                                                                                      (1, 1, 'Pour fêter le bac !', 'Pour un week-end à Nancy qui nous fera oublier les épreuves. ', '2018-06-27', 'nosecure1', 0, NULL),
                                                                                                                      (2, 2, 'Liste de mariage d\'Alice et Bob', 'Nous souhaitons passer un week-end royal à Nancy pour notre lune de miel :)', '2018-06-30', 'nosecure2', 0, NULL),
                                                                                                                      (3, 3, 'C\'est l\'anniversaire de Charlie', 'Pour lui préparer une fête dont il se souviendra :)', '2017-12-12', 'nosecure3', 0, NULL),
                                                                                                                      (4, 23, 'Pas terrible', 'nul', NULL, 'Je sais pas', 0, NULL),
                                                                                                                      (5, 23, 'Pas terrible', 'nul', NULL, 'Je sais pas', 0, NULL),
                                                                                                                      (6, 23, 'Pas terrible', 'nul', NULL, 'Je sais pas', 0, NULL),
                                                                                                                      (7, 23, 'Pas terribles', 'nul', NULL, 'Je sais pas', 0, NULL),
                                                                                                                      (8, 1, 'ez', '', NULL, NULL, 0, NULL),
                                                                                                                      (9, 1, ' alert(&#34;Coucou Bilou&#34;);', '', NULL, NULL, 0, NULL),
                                                                                                                      (10, 1, 'grgr&#38;@;,?!§', '', NULL, '?ײG???u)??GD<L\\\0Xn????bQZ\'T?%?', 0, NULL),
                                                                                                                      (11, 1, 'gtyh', '', NULL, '?ԌG㲶o#\Z9??u?d?R?{?R??ټ??o?', 0, NULL),
                                                                                                                      (12, 1, 'gtyhd', '', NULL, 's:32:\"?Qף?+??)?s??|&s?(`?	?-%R??w\";', 0, NULL),
                                                                                                                      (14, 1, 'lllllll', '', NULL, '6705', 0, NULL),
                                                                                                                      (15, 1, 'loik', '', NULL, '8073', 0, NULL),
                                                                                                                      (16, 1, 'liste de test', 'je sais pas', NULL, '3026', 0, NULL),
                                                                                                                      (18, 1, 'gigaga', '', NULL, '3236', 9664, NULL),
                                                                                                                      (19, 1, 'fqoi', 'fzifuh', NULL, '9585', 0, NULL),
                                                                                                                      (20, 1, '3 1', '', NULL, '581', 0, NULL),
                                                                                                                      (21, 1, 'zzfe', '', NULL, '4586', 0, NULL),
                                                                                                                      (23, 1, 'ma grosse liste', 'énorme', NULL, '8569', 0, 'x');




