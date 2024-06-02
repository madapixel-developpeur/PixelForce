create or replace view order_valide as 
select *
from `order` where status between 1 and 99;

create or replace view stat_vente_ecommerce_agent as 
select agent_id, secteur_id, count(id) as nbr_ventes, sum(amount) as ca
from order_valide group by agent_id, secteur_id; 

create or replace view stat_vente_ecommerce_tout_agent as 
select ase.id, ase.agent_id, ase.secteur_id, coalesce(sv.nbr_ventes, 0) as nbr_ventes,
coalesce(sv.ca, 0) as ca, ase.type_secteur_id
from (select * from agent_secteur_valide where type_secteur_id = 1) ase left join 
stat_vente_ecommerce_agent sv 
on (ase.agent_id, ase.secteur_id) = (sv.agent_id, sv.secteur_id);


create or replace view order_secu_valide as 
select os.*, (accomp_montant + prix_produit) * (1 + tva_pourcentage/100) as montant_ttc
from order_secu os where statut between 1 and 99;

create or replace view stat_vente_secu_agent as 
select agent_id, secteur_id, count(id) as nbr_ventes, sum(montant_ttc) as ca
from order_secu_valide group by agent_id, secteur_id; 

create or replace view stat_vente_secu_tout_agent as 
select ase.id, ase.agent_id, ase.secteur_id, coalesce(sv.nbr_ventes, 0) as nbr_ventes,
coalesce(sv.ca, 0) as ca, ase.type_secteur_id
from (select * from agent_secteur_valide where type_secteur_id = 3) ase left join 
stat_vente_secu_agent sv 
on (ase.agent_id, ase.secteur_id) = (sv.agent_id, sv.secteur_id);



create or replace view order_aroma_valide as 
select *
from order_aroma where status between 1 and 99;

create or replace view stat_vente_aroma_agent as 
select agent_id, secteur_id, count(id) as nbr_ventes, sum(montant_ttc) as ca
from order_aroma_valide group by agent_id, secteur_id; 


create or replace view stat_vente_aroma_tout_agent as 
select ase.id, ase.agent_id, ase.secteur_id, coalesce(sv.nbr_ventes, 0) as nbr_ventes,
coalesce(sv.ca, 0) as ca, ase.type_secteur_id
from (select * from agent_secteur_valide where type_secteur_id = 4) ase left join 
stat_vente_aroma_agent sv 
on (ase.agent_id, ase.secteur_id) = (sv.agent_id, sv.secteur_id);


create or replace view demande_devis_valide as 
select dd.* , d.price, d.id as devis_id, d.contrat_file_name
from demande_devis dd join devis d on dd.id = d.demande_devis_id and d.status_int = 1;

create or replace view stat_vente_dd_agent as 
select agent_id, secteur_id, count(id) as nbr_ventes, sum(price) as ca
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
select * from stat_vente_dd_tout_agent union all 
select * from stat_vente_aroma_tout_agent;

create or replace view stat_vente_agent as
select * from stat_vente_secu_agent union all 
select * from stat_vente_ecommerce_agent union all 
select * from stat_vente_dd_agent union all
select * from stat_vente_aroma_agent;

create or replace view stat_vente_secteur as 
select s.id as secteur_id, coalesce(t.nbr_ventes, 0) as nbr_ventes,
coalesce(t.ca, 0) as ca
from secteur_active s left join 
( select  secteur_id, sum(nbr_ventes) as nbr_ventes, sum(ca) as ca 
from stat_vente_agent group by secteur_id) t on s.id = t.secteur_id;





create or replace view all_type_order_valide as
select agent_id, secteur_id, client_id, montant_ttc as montant, date_commande from  order_secu_valide
union all
select agent_id, secteur_id, user_id, amount, order_date from order_valide 
union all 
select agent_id, secteur_id, client_id, price, date_demande from demande_devis_valide
union all 
select agent_id, secteur_id, user_id, montant_ttc, order_date from order_aroma_valide;

create or replace view all_type_order_valide_mois_annee as
select a.*, month(a.date_commande) as mois, year(a.date_commande) as annee
from all_type_order_valide a;

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






create or replace view stat_vente_admin as 
select sum(nbr_ventes) as nbr_ventes, sum(ca) as ca 
from stat_vente_agent;

DELIMITER //
DROP PROCEDURE IF EXISTS getRevenuAnneeMois //
CREATE PROCEDURE 
  getRevenuAnneeMois(agentIdParam INT, secteurIdParam INT, anneeParam INT, moisParam INT)
BEGIN  
	select sum(montant) as montant, count(agent_id) as nbr
from all_type_order_valide_mois_annee where (annee = anneeParam or anneeParam <= 0) and (mois = moisParam or moisParam <= 0) and (secteur_id = secteurIdParam or secteurIdParam <= 0 ) and (agent_id = agentIdParam or agentIdParam <= 0 ) 
   ;  
END 
//