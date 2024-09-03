UPDATE secteur
SET fonctionnalites='["FONCTIONNALITE_COMMON_CONTACT", "FONCTIONNALITE_COMMON_FORMATION", "FONCTIONNALITE_COMMON_AGENDA", "FONCTIONNALITE_COMMON_TRANSACTION", "FONCTIONNALITE_COMMON_RDV", "FONCTIONNALITE_COMMON_AUDIT", "FONCTIONNALITE_STANDARD_PRODUIT", "FONCTIONNALITE_COMMON_VENTE"]'
WHERE id=9;

INSERT INTO secteur
(id, type_id, nom, description, active, couverture, liens, long_description, title, affiche, google_forms, google_forms_response, fonctionnalites)
VALUES(19, 1, 'Innovation', NULL, 1, 'images/secteur/couverture/Groupe de masques 5.png', NULL, NULL, NULL, 'images/secteur/affiche/Digital.jpg', NULL, NULL, '["FONCTIONNALITE_COMMON_CONTACT", "FONCTIONNALITE_COMMON_FORMATION", "FONCTIONNALITE_COMMON_AGENDA", "FONCTIONNALITE_COMMON_TRANSACTION", "FONCTIONNALITE_COMMON_RDV", "FONCTIONNALITE_COMMON_AUDIT", "FONCTIONNALITE_STANDARD_PRODUIT", "FONCTIONNALITE_COMMON_VENTE"]');

INSERT INTO `user`
(id, contact_client_id, client_agent_id, email, username, roles, password, nom, prenom, date_naissance, adresse, numero_securite, rib, photo, six_digit_code, forgotten_pass_token, active, api_token, telephone, created_at, code_postal, lien_calendly, stripe_data, account_status, account_start_date, stripe_customer_id, numero_rue, ville, ambassador_username, parrain_id, `position`, pays, have_seen_sector_video, finished_one_video_formation)
VALUES(67, NULL, NULL, 'coach@innovation.fr', 'innovationcoach', '["ROLE_COACH"]', '$2y$13$rZAaGB28XXD1Rw2HMDR/A.n0RvZTZDk.OqDycV0rlZe/MCCW.US3.', 'Coach', 'Innovation', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NULL, NULL, NULL, NULL, NULL, 'a:0:{}', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 0);
INSERT INTO `user`
(id, contact_client_id, client_agent_id, email, username, roles, password, nom, prenom, date_naissance, adresse, numero_securite, rib, photo, six_digit_code, forgotten_pass_token, active, api_token, telephone, created_at, code_postal, lien_calendly, stripe_data, account_status, account_start_date, stripe_customer_id, numero_rue, ville, ambassador_username, parrain_id, `position`, pays, have_seen_sector_video, finished_one_video_formation)
VALUES(68, NULL, NULL, 'agent1@innovation.fr', 'agent1_innovation', '["ROLE_AGENT"]', '$2y$13$5BYvCPKyuwpowwjU/d5GKuLwMyDzffZuoKCw0jchYEXi/ITgqvY6a', 'Rakotoarivony', 'Princie', NULL, 'IJ6 Anjomakely', NULL, NULL, NULL, NULL, NULL, 1, NULL, '0344252056', '2024-09-03 11:18:20', '102', NULL, 'a:0:{}', 'Actif', '2024-09-03 11:19:12', NULL, NULL, 'Antananarivo', 'innovationcoach', 67, NULL, 'Madagascar', 0, 1);

INSERT INTO coach_secteur
(id, coach_id, secteur_id)
VALUES(19, 67, 19);

INSERT INTO agent_secteur
(id, agent_id, secteur_id, date_validation, statut, current_formation_rank)
VALUES(53, 68, 19, '2024-09-03 11:19:07', 1, NULL);