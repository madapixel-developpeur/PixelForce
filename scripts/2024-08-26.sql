INSERT INTO type_logement
(id, nom)
VALUES(1, 'Maison');
INSERT INTO type_logement
(id, nom)
VALUES(2, 'Appartement');

-- INSERT INTO tag
-- (id, libelle, description, couleur, sort)
-- VALUES(1, 'Intéressé', 'La personne est intéressée à devenir un client', 'success', 1);
-- INSERT INTO tag
-- (id, libelle, description, couleur, sort)
-- VALUES(2, 'Froid', 'La personne n''est pas trop intéressée', 'info', 3);
-- INSERT INTO tag
-- (id, libelle, description, couleur, sort)
-- VALUES(3, 'QUESTION', 'LA PERSONNE A DES QUESTION', 'warning', 4);
-- INSERT INTO tag
-- (id, libelle, description, couleur, sort)
-- VALUES(4, 'SUBVENTION', NULL, 'danger', 5);
INSERT INTO tag
(id, libelle, description, couleur, sort)
VALUES(5, 'Tiède', 'La personne montre un léger intérêt', 'secondary', 2);
UPDATE tag
SET sort=1
WHERE id=1;
UPDATE tag
SET sort=3
WHERE id=2;
UPDATE tag
SET sort=4
WHERE id=3;
UPDATE tag
SET sort=5
WHERE id=4;