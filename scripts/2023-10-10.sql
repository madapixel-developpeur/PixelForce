-- Désactiver Secteur autres que Aromaforest, Pixelsior Buzz Boosters et OrganiGreen
update secteur set active = 0 where id = 1 or id = 2 or id = 3 or id = 4 or id = 5 or id = 6 or id = 7;

-- Créer le secteur Organi Green de type Classique id = 5
insert into secteur (id, type_id, nom, description, active) values (10, 5, 'Organi Green', NULL, 1);

-- Update all null usernames
update user set username = concat('user_', id) where username is null;

-- ALTER TABLE pixelforce.`user` ADD CONSTRAINT user_username_un UNIQUE KEY (username);

insert into pack_category (id, name, description, image, status) values (1, 'Catégorie 1 PACK', NULL, NULL, 1);
insert into pack (id, id_pack_category, name, description, cost, image) values (1, 1, 'Pack 1', 'Description pack 1', 200, NULL);
insert into pack (id, id_pack_category, name, description, cost, image) values (2, 1, 'Pack 2', 'Description pack 2', 500, NULL);
insert into pack (id, id_pack_category, name, description, cost, image) values (3, 1, 'Pack 3', 'Description pack 3', 1000, NULL);
