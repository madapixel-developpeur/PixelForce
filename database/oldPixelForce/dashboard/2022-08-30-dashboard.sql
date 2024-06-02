create or replace view demande_devis_valide as 
select dd.* , d.price, d.id as devis_id, d.contrat_file_name
from demande_devis dd join devis d on dd.id = d.demande_devis_id and d.status_int = 1;

create or replace view stat_vente_dd_agent as 
select agent_id, secteur_id, count(id) as nbr_ventes, sum(price) as ca
from demande_devis_valide group by agent_id, secteur_id; 

create or replace view all_type_order_valide as
select agent_id, secteur_id, client_id, montant_ttc as montant, date_commande from  order_secu_valide
union all
select agent_id, secteur_id, user_id, amount, order_date from order_valide 
union all 
select agent_id, secteur_id, client_id, price, date_demande from demande_devis_valide;