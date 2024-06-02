create or replace view secteur_active as 
select * from secteur where active;

create or replace view stat_vente_agent as
select * from stat_vente_secu_agent union all 
select * from stat_vente_ecommerce_agent union all 
select * from stat_vente_dd_agent;

create or replace view stat_vente_secteur as 
select s.id as secteur_id, coalesce(t.nbr_ventes, 0) as nbr_ventes,
coalesce(t.ca, 0) as ca
from secteur_active s left join 
( select  secteur_id, sum(nbr_ventes) as nbr_ventes, sum(ca) as ca 
from stat_vente_agent group by secteur_id) t on s.id = t.secteur_id;

create or replace view all_type_order_valide_gp_mois_annee_secteur as 
select secteur_id, mois, annee, sum(montant) as montant, count(agent_id) as nbr
from all_type_order_valide_mois_annee group by secteur_id, mois, annee;

/*
DELIMITER //
DROP PROCEDURE IF EXISTS getRevenuAnneeSecteur //
CREATE PROCEDURE 
  getRevenuAnneeSecteur( secteurIdParam INT, anneeParam INT )
BEGIN  
   select m.*, coalesce(t.montant, 0) as montant, coalesce(t.nbr, 0) as nbr
	from les_mois m left join 
	(select * from all_type_order_valide_gp_mois_annee_secteur where secteur_id = secteurIdParam and annee = anneeParam
	) t on m.mois = t.mois order by m.mois
   ;  
END 
//
*/

create or replace view stat_vente_admin as 
select sum(nbr_ventes) as nbr_ventes, sum(ca) as ca 
from stat_vente_agent;


DELIMITER //
DROP PROCEDURE IF EXISTS getRevenuAnneeAll //
CREATE PROCEDURE 
  getRevenuAnneeAll(agentIdParam INT, secteurIdParam INT, anneeParam INT )
BEGIN  
   select m.*, coalesce(t.montant, 0) as montant, coalesce(t.nbr, 0) as nbr
	from les_mois m left join 
	(select mois, sum(montant) as montant, count(agent_id) as nbr
from all_type_order_valide_mois_annee where annee = anneeParam and (secteur_id = secteurIdParam or secteurIdParam <= 0 ) and (agent_id = agentIdParam or agentIdParam <= 0 ) group by mois) t on m.mois = t.mois order by m.mois
   ;  
END 
//
