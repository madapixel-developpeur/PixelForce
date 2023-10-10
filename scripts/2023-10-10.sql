-- Désactiver Secteur autres que Aromaforest, Pixelsior Buzz Boosters et OrganiGreen
update secteur set active = 0 where id = 1 or id = 2 or id = 3 or id = 4 or id = 5 or id = 6 or id = 7;

-- Créer le secteur Organi Green de type Classique id = 5
insert into secteur (id, type_id, nom, description, active) values (10, 5, 'Organi Green', NULL, 1);

-- Update all null usernames
update user set username = concat('user_', id) where username is null;

-- ALTER TABLE pixelforce.`user` ADD CONSTRAINT user_username_un UNIQUE KEY (username);
