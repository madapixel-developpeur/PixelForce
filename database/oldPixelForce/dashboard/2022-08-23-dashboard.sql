create or replace view active_user as 
select *
from user where active;

create or replace view active_clients as
select *
from active_user where json_contains(roles, '"ROLE_CLIENT"', '$');

create or replace view active_coach as 
select * from active_user where json_contains(roles, '"ROLE_COACH"', '$');

create or replace view active_agent as 
select * from active_user where json_contains(roles, '"ROLE_AGENT"', '$');

create or replace view secteur_active as 
select *
from secteur where active;

create or replace view order_secu_valide as 
select os.*, (accomp_montant + prix_produit) * (1 + tva_pourcentage/100) as montant_ttc
from order_secu os where statut = 2;

create or replace view stat_vente_secu_agent as 
select agent_id, secteur_id, count(id) as nbr_ventes, sum(montant_ttc) as ca
from order_secu_valide group by agent_id, secteur_id; 

create or replace view agent_secteur_valide as 
select ase.*, s.type_id as type_secteur_id
from agent_secteur ase 
join secteur_active s on ase.secteur_id = s.id
join active_agent a on ase.agent_id = a.id;

create or replace view stat_vente_secu_tout_agent as 
select ase.id, ase.agent_id, ase.secteur_id, coalesce(sv.nbr_ventes, 0) as nbr_ventes,
coalesce(sv.ca, 0) as ca, ase.type_secteur_id
from (select * from agent_secteur_valide where type_secteur_id = 3) ase left join 
stat_vente_secu_agent sv 
on (ase.agent_id, ase.secteur_id) = (sv.agent_id, sv.secteur_id);

create or replace view order_valide as 
select *
from `order` where status = 2;

create or replace view stat_vente_ecommerce_agent as 
select agent_id, secteur_id, count(id) as nbr_ventes, sum(amount) as ca
from order_valide group by agent_id, secteur_id; 

create or replace view stat_vente_ecommerce_tout_agent as 
select ase.id, ase.agent_id, ase.secteur_id, coalesce(sv.nbr_ventes, 0) as nbr_ventes,
coalesce(sv.ca, 0) as ca, ase.type_secteur_id
from (select * from agent_secteur_valide where type_secteur_id = 1) ase left join 
stat_vente_ecommerce_agent sv 
on (ase.agent_id, ase.secteur_id) = (sv.agent_id, sv.secteur_id);


create or replace view demande_devis_valide as 
select *
from demande_devis where statut = 2;

create or replace view stat_vente_dd_agent as 
select agent_id, secteur_id, count(id) as nbr_ventes, 0 as ca
from demande_devis_valide group by agent_id, secteur_id; 

create or replace view stat_vente_dd_tout_agent as 
select ase.id, ase.agent_id, ase.secteur_id, coalesce(sv.nbr_ventes, 0) as nbr_ventes,
coalesce(sv.ca, 0) as ca, ase.type_secteur_id
from (select * from agent_secteur_valide where type_secteur_id = 2) ase left join 
stat_vente_dd_agent sv 
on (ase.agent_id, ase.secteur_id) = (sv.agent_id, sv.secteur_id);

create or replace view stat_vente_tout_agent as
select * from stat_vente_secu_tout_agent union all 
select * from stat_vente_ecommerce_tout_agent union all 
select * from stat_vente_dd_tout_agent;

create or replace view all_type_order_valide as
select agent_id, secteur_id, client_id, montant_ttc as montant, date_commande from  order_secu_valide
union all
select agent_id, secteur_id, user_id, amount, order_date from order_valide 
union all 
select agent_id, secteur_id, client_id, 0, date_demande from demande_devis_valide;

create or replace view agent_secteur_client_valide as 
select a.agent_id, a.secteur_id, ac.id as client_id
from agent_secteur_valide a join active_clients ac on a.agent_id = ac.client_agent_id;

create or replace view all_type_order_valide_per_client as 
select agent_id, secteur_id, client_id, sum(montant) as montant, count(client_id) as nbr
from all_type_order_valide group by agent_id, secteur_id, client_id;

create or replace view all_type_order_valide_all_client as 
select a.agent_id, a.secteur_id, a.client_id, coalesce(montant, 0) as montant, coalesce(nbr, 0) as nbr
from agent_secteur_client_valide a left join all_type_order_valide_per_client o 
on (a.agent_id, a.secteur_id, a.client_id) = (o.agent_id, o.secteur_id, o.client_id);

create or replace view client_secteur_agent as 
select a.*, ac.nom, ac.prenom, ac.email, ac.username
from all_type_order_valide_all_client a 
join active_clients ac on a.client_id = ac.id;


create or replace view les_mois as 
select 1 as mois, 'Janvier' as mois_str
union all 
select 2 as mois, 'Février' as mois_str
union all 
select 3 as mois, 'Mars' as mois_str
union all 
select 4 as mois, 'Avril' as mois_str
union all 
select 5 as mois, 'Mai' as mois_str
union all 
select 6 as mois, 'Juin' as mois_str
union all 
select 7 as mois, 'Juillet' as mois_str
union all 
select 8 as mois, 'Août' as mois_str
union all 
select 9 as mois, 'Septembre' as mois_str
union all 
select 10 as mois, 'Octobre' as mois_str
union all 
select 11 as mois, 'Novembre' as mois_str
union all 
select 12 as mois, 'Décembre' as mois_str;

create or replace view all_type_order_valide_mois_annee as
select a.*, month(a.date_commande) as mois, year(a.date_commande) as annee
from all_type_order_valide a;

create or replace view all_type_order_valide_gp_mois_annee as 
select agent_id, secteur_id, mois, annee, sum(montant) as montant, count(agent_id) as nbr
from all_type_order_valide_mois_annee group by agent_id, secteur_id, mois, annee;

/*select m.*, coalesce(t.montant, 0) as montant, coalesce(t.nbr, 0) as nbr
from les_mois m left join 
(select * from all_type_order_valide_gp_mois_annee where agent_id = 5 and secteur_id = 1 and annee = 2022
) t on m.mois = t.mois;*/

/*
DELIMITER //
DROP PROCEDURE IF EXISTS getRevenuAnnee //
CREATE PROCEDURE 
  getRevenuAnnee( agentIdParam INT, secteurIdParam INT, anneeParam INT )
BEGIN  
   select m.*, coalesce(t.montant, 0) as montant, coalesce(t.nbr, 0) as nbr
	from les_mois m left join 
	(select * from all_type_order_valide_gp_mois_annee where agent_id = agentIdParam and secteur_id = secteurIdParam and annee = anneeParam
	) t on m.mois = t.mois order by m.mois
   ;  
END 
//
*/   