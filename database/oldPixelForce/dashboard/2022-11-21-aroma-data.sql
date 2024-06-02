INSERT INTO type_secteur
(id, nom)
VALUES(4, 'Aromaforest');

INSERT INTO secteur
(id, type_id, nom, description, active)
VALUES(8, 4, 'Aromaforest', NULL, 1);

INSERT INTO `user`
(id, contact_client_id, client_agent_id, email, username, roles, password, nom, prenom, date_naissance, adresse, numero_securite, rib, photo, six_digit_code, forgotten_pass_token, active, api_token, telephone, created_at, code_postal, lien_calendly, stripe_data, account_status, account_start_date, stripe_customer_id, numero_rue, ville)
VALUES(30, NULL, NULL, 'coacharomaforest@gmail.com', 'coacharomaforest', '["ROLE_COACH"]', '$2y$13$YKwVY3JqHg0qwClKPcBVqOlJjnEO4GvtVGunu1c5nAkUqy.Fy5SCi', 'Coach', 'Aromaforest', '1991-12-30 00:00:00', 'Paris', '123465', '4242424242424242', NULL, NULL, NULL, 1, NULL, NULL, '2022-07-19 07:49:29', NULL, NULL, 'a:0:{}', NULL, NULL, NULL, NULL, NULL);

INSERT INTO coach_secteur
(id, coach_id, secteur_id)
VALUES(10, 30, 8);

INSERT INTO `user`
(id, contact_client_id, client_agent_id, email, username, roles, password, nom, prenom, date_naissance, adresse, numero_securite, rib, photo, six_digit_code, forgotten_pass_token, active, api_token, telephone, created_at, code_postal, lien_calendly, stripe_data, account_status, account_start_date, stripe_customer_id, numero_rue, ville)
VALUES(31, NULL, NULL, 'agentaromaforest@gmail.com', 'agentaromaforest', '["ROLE_AGENT"]', '$2y$13$YKwVY3JqHg0qwClKPcBVqOlJjnEO4GvtVGunu1c5nAkUqy.Fy5SCi', 'Agent', 'Aromaforest', NULL, 'Antananarivo', NULL, NULL, NULL, NULL, NULL, 1, NULL, '0349331431', '2022-07-19 07:58:37', '00101', '', 'a:0:{}', 'Actif', '2022-07-20 06:24:17', NULL, NULL, NULL);

INSERT INTO agent_secteur
(id, agent_id, secteur_id, date_validation, statut)
VALUES(25, 31, 8, '2022-09-01 14:20:05', 1);

INSERT INTO config_secteur
(id, secteur_id, type_secteur_id, nom, val, statut, num)
VALUES(1, NULL, 4, 'TVA', 20.0, 1, 1);

INSERT INTO produit_aroma
(id, nom, description, image, prix, statut, prix_conseille)
VALUES(3, 'RAVINTSARA 10 ml', NULL, NULL, 10.800000, 1, NULL);
INSERT INTO produit_aroma
(id, nom, description, image, prix, statut, prix_conseille)
VALUES(4, 'YLANG YLANG 10 ml', NULL, NULL, 14.250000, 1, NULL);
INSERT INTO produit_aroma
(id, nom, description, image, prix, statut, prix_conseille)
VALUES(5, 'NIAOULI 10 ml', NULL, NULL, 8.000000, 1, NULL);
INSERT INTO produit_aroma
(id, nom, description, image, prix, statut, prix_conseille)
VALUES(6, 'SARO 10 ml', NULL, NULL, 12.500000, 1, NULL);
INSERT INTO produit_aroma
(id, nom, description, image, prix, statut, prix_conseille)
VALUES(7, 'GINGEMBRE FRAIS 5 ml', NULL, NULL, 13.250000, 1, NULL);
INSERT INTO produit_aroma
(id, nom, description, image, prix, statut, prix_conseille)
VALUES(8, 'ZEN&SENS 10 ml', NULL, NULL, 13.000000, 1, NULL);
INSERT INTO produit_aroma
(id, nom, description, image, prix, statut, prix_conseille)
VALUES(9, 'DYNAMIN''&SENS 10 ml', NULL, NULL, 13.000000, 1, NULL);
INSERT INTO produit_aroma
(id, nom, description, image, prix, statut, prix_conseille)
VALUES(10, 'IMMUN''&SENS 10 ml', NULL, NULL, 13.000000, 1, NULL);
INSERT INTO produit_aroma
(id, nom, description, image, prix, statut, prix_conseille)
VALUES(11, 'FRAGRAN''DELICES 10 ml', NULL, NULL, 13.000000, 1, NULL);
INSERT INTO produit_aroma
(id, nom, description, image, prix, statut, prix_conseille)
VALUES(12, 'DIFFUSEUR', NULL, NULL, 50.000000, 1, NULL);


INSERT INTO implantation_mere_aroma
(id, statut)
VALUES(3, 1);
INSERT INTO implantation_mere_aroma
(id, statut)
VALUES(4, 1);


INSERT INTO implantation_aroma
(id, nom, description, image, statut, reassort, qte_elmt, remise, mere_id)
VALUES(5, 'IMPLANTATION N°1', NULL, NULL, 1, 0, 5, 20.00, 3);
INSERT INTO implantation_aroma
(id, nom, description, image, statut, reassort, qte_elmt, remise, mere_id)
VALUES(6, 'IMPLANTATION N°2', NULL, NULL, 1, 0, 10, 25.00, 3);
INSERT INTO implantation_aroma
(id, nom, description, image, statut, reassort, qte_elmt, remise, mere_id)
VALUES(7, 'IMPLANTATION N°3', NULL, NULL, 1, 0, 15, 30.00, 3);
INSERT INTO implantation_aroma
(id, nom, description, image, statut, reassort, qte_elmt, remise, mere_id)
VALUES(8, 'IMPLANTATION N°1', NULL, NULL, 1, 1, 4, 40.00, 3);
INSERT INTO implantation_aroma
(id, nom, description, image, statut, reassort, qte_elmt, remise, mere_id)
VALUES(9, 'IMPLANTATION N°2', NULL, NULL, 1, 1, 7, 50.00, 3);
INSERT INTO implantation_aroma
(id, nom, description, image, statut, reassort, qte_elmt, remise, mere_id)
VALUES(10, 'IMPLANTATION N°3', NULL, NULL, 1, 1, 10, 60.00, 3);
INSERT INTO implantation_aroma
(id, nom, description, image, statut, reassort, qte_elmt, remise, mere_id)
VALUES(11, 'DIFFUSEUR N°1', NULL, NULL, 1, 0, 5, 20.00, 4);
INSERT INTO implantation_aroma
(id, nom, description, image, statut, reassort, qte_elmt, remise, mere_id)
VALUES(12, 'DIFFUSEUR N°2', NULL, NULL, 1, 0, 10, 30.00, 4);
INSERT INTO implantation_aroma
(id, nom, description, image, statut, reassort, qte_elmt, remise, mere_id)
VALUES(13, 'DIFFUSEUR N°3', NULL, NULL, 1, 0, 15, 40.00, 4);


INSERT INTO implantation_elmt_aroma
(id, mere_id, produit_id, statut, qte_gratuit)
VALUES(9, 5, 3, 1, 1);
INSERT INTO implantation_elmt_aroma
(id, mere_id, produit_id, statut, qte_gratuit)
VALUES(10, 5, 4, 1, 1);
INSERT INTO implantation_elmt_aroma
(id, mere_id, produit_id, statut, qte_gratuit)
VALUES(11, 5, 5, 1, 1);
INSERT INTO implantation_elmt_aroma
(id, mere_id, produit_id, statut, qte_gratuit)
VALUES(12, 5, 6, 1, 1);
INSERT INTO implantation_elmt_aroma
(id, mere_id, produit_id, statut, qte_gratuit)
VALUES(13, 5, 7, 1, 1);
INSERT INTO implantation_elmt_aroma
(id, mere_id, produit_id, statut, qte_gratuit)
VALUES(14, 5, 8, 1, 2);
INSERT INTO implantation_elmt_aroma
(id, mere_id, produit_id, statut, qte_gratuit)
VALUES(15, 5, 9, 1, 2);
INSERT INTO implantation_elmt_aroma
(id, mere_id, produit_id, statut, qte_gratuit)
VALUES(16, 5, 10, 1, 2);
INSERT INTO implantation_elmt_aroma
(id, mere_id, produit_id, statut, qte_gratuit)
VALUES(17, 5, 11, 1, 2);
INSERT INTO implantation_elmt_aroma
(id, mere_id, produit_id, statut, qte_gratuit)
VALUES(18, 6, 3, 1, 3);
INSERT INTO implantation_elmt_aroma
(id, mere_id, produit_id, statut, qte_gratuit)
VALUES(19, 6, 4, 1, 3);
INSERT INTO implantation_elmt_aroma
(id, mere_id, produit_id, statut, qte_gratuit)
VALUES(20, 6, 5, 1, 3);
INSERT INTO implantation_elmt_aroma
(id, mere_id, produit_id, statut, qte_gratuit)
VALUES(21, 6, 6, 1, 3);
INSERT INTO implantation_elmt_aroma
(id, mere_id, produit_id, statut, qte_gratuit)
VALUES(22, 6, 7, 1, 3);
INSERT INTO implantation_elmt_aroma
(id, mere_id, produit_id, statut, qte_gratuit)
VALUES(23, 6, 8, 1, 3);
INSERT INTO implantation_elmt_aroma
(id, mere_id, produit_id, statut, qte_gratuit)
VALUES(24, 6, 9, 1, 3);
INSERT INTO implantation_elmt_aroma
(id, mere_id, produit_id, statut, qte_gratuit)
VALUES(25, 6, 10, 1, 3);
INSERT INTO implantation_elmt_aroma
(id, mere_id, produit_id, statut, qte_gratuit)
VALUES(26, 6, 11, 1, 3);
INSERT INTO implantation_elmt_aroma
(id, mere_id, produit_id, statut, qte_gratuit)
VALUES(27, 7, 3, 1, 4);
INSERT INTO implantation_elmt_aroma
(id, mere_id, produit_id, statut, qte_gratuit)
VALUES(28, 7, 4, 1, 4);
INSERT INTO implantation_elmt_aroma
(id, mere_id, produit_id, statut, qte_gratuit)
VALUES(29, 7, 5, 1, 4);
INSERT INTO implantation_elmt_aroma
(id, mere_id, produit_id, statut, qte_gratuit)
VALUES(30, 7, 6, 1, 4);
INSERT INTO implantation_elmt_aroma
(id, mere_id, produit_id, statut, qte_gratuit)
VALUES(31, 7, 7, 1, 4);
INSERT INTO implantation_elmt_aroma
(id, mere_id, produit_id, statut, qte_gratuit)
VALUES(32, 7, 8, 1, 4);
INSERT INTO implantation_elmt_aroma
(id, mere_id, produit_id, statut, qte_gratuit)
VALUES(33, 7, 9, 1, 4);
INSERT INTO implantation_elmt_aroma
(id, mere_id, produit_id, statut, qte_gratuit)
VALUES(34, 7, 10, 1, 4);
INSERT INTO implantation_elmt_aroma
(id, mere_id, produit_id, statut, qte_gratuit)
VALUES(35, 7, 11, 1, 4);
INSERT INTO implantation_elmt_aroma
(id, mere_id, produit_id, statut, qte_gratuit)
VALUES(36, 8, 3, 1, 0);
INSERT INTO implantation_elmt_aroma
(id, mere_id, produit_id, statut, qte_gratuit)
VALUES(37, 8, 4, 1, 0);
INSERT INTO implantation_elmt_aroma
(id, mere_id, produit_id, statut, qte_gratuit)
VALUES(38, 8, 5, 1, 0);
INSERT INTO implantation_elmt_aroma
(id, mere_id, produit_id, statut, qte_gratuit)
VALUES(39, 8, 6, 1, 0);
INSERT INTO implantation_elmt_aroma
(id, mere_id, produit_id, statut, qte_gratuit)
VALUES(40, 8, 7, 1, 0);
INSERT INTO implantation_elmt_aroma
(id, mere_id, produit_id, statut, qte_gratuit)
VALUES(41, 8, 8, 1, 0);
INSERT INTO implantation_elmt_aroma
(id, mere_id, produit_id, statut, qte_gratuit)
VALUES(42, 8, 9, 1, 0);
INSERT INTO implantation_elmt_aroma
(id, mere_id, produit_id, statut, qte_gratuit)
VALUES(43, 8, 10, 1, 0);
INSERT INTO implantation_elmt_aroma
(id, mere_id, produit_id, statut, qte_gratuit)
VALUES(44, 8, 11, 1, 0);
INSERT INTO implantation_elmt_aroma
(id, mere_id, produit_id, statut, qte_gratuit)
VALUES(45, 9, 3, 1, 0);
INSERT INTO implantation_elmt_aroma
(id, mere_id, produit_id, statut, qte_gratuit)
VALUES(46, 9, 4, 1, 0);
INSERT INTO implantation_elmt_aroma
(id, mere_id, produit_id, statut, qte_gratuit)
VALUES(47, 9, 5, 1, 0);
INSERT INTO implantation_elmt_aroma
(id, mere_id, produit_id, statut, qte_gratuit)
VALUES(48, 9, 6, 1, 0);
INSERT INTO implantation_elmt_aroma
(id, mere_id, produit_id, statut, qte_gratuit)
VALUES(49, 9, 7, 1, 0);
INSERT INTO implantation_elmt_aroma
(id, mere_id, produit_id, statut, qte_gratuit)
VALUES(50, 9, 8, 1, 0);
INSERT INTO implantation_elmt_aroma
(id, mere_id, produit_id, statut, qte_gratuit)
VALUES(51, 9, 9, 1, 0);
INSERT INTO implantation_elmt_aroma
(id, mere_id, produit_id, statut, qte_gratuit)
VALUES(52, 9, 10, 1, 0);
INSERT INTO implantation_elmt_aroma
(id, mere_id, produit_id, statut, qte_gratuit)
VALUES(53, 9, 11, 1, 0);
INSERT INTO implantation_elmt_aroma
(id, mere_id, produit_id, statut, qte_gratuit)
VALUES(54, 10, 3, 1, 0);
INSERT INTO implantation_elmt_aroma
(id, mere_id, produit_id, statut, qte_gratuit)
VALUES(55, 10, 4, 1, 0);
INSERT INTO implantation_elmt_aroma
(id, mere_id, produit_id, statut, qte_gratuit)
VALUES(56, 10, 5, 1, 0);
INSERT INTO implantation_elmt_aroma
(id, mere_id, produit_id, statut, qte_gratuit)
VALUES(57, 10, 6, 1, 0);
INSERT INTO implantation_elmt_aroma
(id, mere_id, produit_id, statut, qte_gratuit)
VALUES(58, 10, 7, 1, 0);
INSERT INTO implantation_elmt_aroma
(id, mere_id, produit_id, statut, qte_gratuit)
VALUES(59, 10, 8, 1, 0);
INSERT INTO implantation_elmt_aroma
(id, mere_id, produit_id, statut, qte_gratuit)
VALUES(60, 10, 9, 1, 0);
INSERT INTO implantation_elmt_aroma
(id, mere_id, produit_id, statut, qte_gratuit)
VALUES(61, 10, 10, 1, 0);
INSERT INTO implantation_elmt_aroma
(id, mere_id, produit_id, statut, qte_gratuit)
VALUES(62, 10, 11, 1, 0);
INSERT INTO implantation_elmt_aroma
(id, mere_id, produit_id, statut, qte_gratuit)
VALUES(63, 11, 12, 1, 0);
INSERT INTO implantation_elmt_aroma
(id, mere_id, produit_id, statut, qte_gratuit)
VALUES(64, 12, 12, 1, 0);
INSERT INTO implantation_elmt_aroma
(id, mere_id, produit_id, statut, qte_gratuit)
VALUES(65, 13, 12, 1, 0);
