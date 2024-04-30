create or replace view inventaire_fille_details as 
select  f.*, i.date_inventaire
from inventaire_fille f 
join inventaire_mere i on f.mere_id = i.id; 

create or replace view inventaire_fille_details_valid as 
select * from inventaire_fille_details where (statut is NULL or statut != 0); 

create or replace view dernier_date_inventaire as 
select produit_id, max(date_inventaire) as dernier_date
from inventaire_fille_details_valid 
group by  produit_id; 

create or replace view dernier_inventaire as 
select i.*
from dernier_date_inventaire d join inventaire_fille_details_valid i on d.produit_id = i.produit_id 
and d.dernier_date = i.date_inventaire;

create or replace view produit_et_dernier_inventaire as 
select p.id, d.date_inventaire, coalesce(d.qte, 0) as qte
from produit p left join dernier_inventaire d on p.id = d.produit_id;

create  or replace view mouvement_valid as 
select * from mouvement where (statut is NULL or statut != 0);

create or replace view qte_mouvement_apres_dernier_inventaire as 
select p.id, sum(coalesce(m.entree, 0) - coalesce(m.sortie, 0)) as qte_mouvement
from produit_et_dernier_inventaire p 
join mouvement_valid m on p.id = m.produit_id and (p.date_inventaire is null or m.date_mouvement > p.date_inventaire)
group by p.id; 

create or replace view produit_qte_stock as 
select p.id, p.id as produit_id , p.qte + coalesce(qm.qte_mouvement, 0) as qte_stock
from produit_et_dernier_inventaire p 
left join qte_mouvement_apres_dernier_inventaire qm on p.id = qm.id;



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





create or replace view view_implantation_elmt_aroma_valid as 
select ie.id, 
ie.mere_id, 
ie.produit_id, 
ie.statut, 
coalesce(ie.qte_gratuit, 0) as qte_gratuit, 
coalesce(p.prix, 0) as prix_produit,
coalesce(p.prix_conseille, 0) as prix_conseille_produit
from implantation_elmt_aroma ie join produit_aroma p on  
ie.produit_id = p.id
where ie.statut is NULL or ie.statut != 0;

create or replace view view_implantation_aroma as 
select id, 
nom, 
description, 
image, 
statut, 
reassort, 
coalesce(qte_elmt, 0) as qte_elmt, 
coalesce(remise, 0) as remise,
mere_id
from  implantation_aroma;

create or replace view view_implantation_aroma_total as 
select i.id, sum(ie.prix_produit * (1. - i.remise/100) * i.qte_elmt) as total,
sum(ie.qte_gratuit) as ug
from view_implantation_aroma i join view_implantation_elmt_aroma_valid ie 
on i.id = ie.mere_id
group by i.id;

create or replace view view_implantation_aroma_total_full as 
select i.id, 
coalesce(total, 0) as total,
coalesce(ug, 0) as ug,
i.id as implantation_id
from implantation_aroma i left join view_implantation_aroma_total it on i.id = it.id;

create or replace view view_implantation_aroma_valid as 
select id, 
nom, 
description, 
image, 
statut, 
reassort, 
qte_elmt, 
remise,
mere_id
from  view_implantation_aroma where statut is NULL or statut != 0;

create or replace view view_implantation_mere_aroma_total as 
select im.id,
sum(i.reassort) as nbr_reassort,
sum(not i.reassort) as nbr_normal,
count(i.id) as nbr
from implantation_mere_aroma im join view_implantation_aroma_valid i on im.id = i.mere_id
group by im.id;


create or replace view view_implantation_mere_aroma_total_full as 
select im.id,
im.id as implantation_mere_id,
coalesce(i.nbr_reassort) as nbr_reassort,
coalesce(i.nbr_normal) as nbr_normal,
coalesce(i.nbr) as nbr
from implantation_mere_aroma im left join view_implantation_mere_aroma_total i on im.id = i.id;

create or replace view order_aroma_valide as 
select *
from order_aroma where status = 2;


create or replace view stat_vente_aroma_tout_agent as 
select ase.id, ase.agent_id, ase.secteur_id, coalesce(sv.nbr_ventes, 0) as nbr_ventes,
coalesce(sv.ca, 0) as ca, ase.type_secteur_id
from (select * from agent_secteur_valide where type_secteur_id = 4) ase left join 
stat_vente_aroma_agent sv 
on (ase.agent_id, ase.secteur_id) = (sv.agent_id, sv.secteur_id);

create or replace view stat_vente_tout_agent as
select * from stat_vente_secu_tout_agent union all 
select * from stat_vente_ecommerce_tout_agent union all 
select * from stat_vente_dd_tout_agent union all 
select * from stat_vente_aroma_tout_agent;

create or replace view all_type_order_valide_mois_annee as
select a.*, month(a.date_commande) as mois, year(a.date_commande) as annee
from all_type_order_valide a;



-- COACH
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


-- ADMIN
create or replace view stat_vente_admin as 
select sum(nbr_ventes) as nbr_ventes, sum(ca) as ca 
from stat_vente_agent;



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
select agent_id, secteur_id, count(id) as nbr_ventes, sum(amount) as ca
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
select agent_id, secteur_id, user_id, amount, order_date from order_aroma_valide;

create or replace view all_type_order_valide_mois_annee as
select a.*, month(a.date_commande) as mois, year(a.date_commande) as annee
from all_type_order_valide a;







create or replace view stat_vente_admin as 
select sum(nbr_ventes) as nbr_ventes, sum(ca) as ca 
from stat_vente_agent;


create or replace view order_digital_valide as 
select dd.agent_id, dd.secteur_id, dd.client_id, od.created_at as date_order , od.amount, od.id as order_id
from order_digital od join devis d on od.devis_id = d.id join demande_devis dd on d.demande_devis_id = dd.id where od.statut = 1
union all
select dc.agent_id, dc.secteur_id, null, oddc.created_at, oddc.total_amount_ttc, oddc.id 
from order_digital_devis_company oddc join devis_company dc on oddc.devis_company_id = dc.id;

create or replace view stat_vente_dd_agent as 
select agent_id, secteur_id, count(order_id) as nbr_ventes, sum(amount) as ca
from order_digital_valide group by agent_id, secteur_id; 

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
select agent_id, secteur_id, client_id, amount, date_order from order_digital_valide
union all 
select agent_id, secteur_id, user_id, amount, order_date from order_aroma_valide;

create or replace view all_type_order_valide_mois_annee as
select a.*, month(a.date_commande) as mois, year(a.date_commande) as annee
from all_type_order_valide a;




create or replace view stat_vente_admin as 
select sum(nbr_ventes) as nbr_ventes, sum(ca) as ca 
from stat_vente_agent;




create or replace view order_aroma_valide as 
select *
from order_aroma where status between 1 and 99;

create or replace view stat_vente_aroma_agent as 
select agent_id, secteur_id, count(id) as nbr_ventes, sum(amount) as ca
from order_aroma_valide group by agent_id, secteur_id; 


create or replace view stat_vente_aroma_tout_agent as 
select ase.id, ase.agent_id, ase.secteur_id, coalesce(sv.nbr_ventes, 0) as nbr_ventes,
coalesce(sv.ca, 0) as ca, ase.type_secteur_id
from (select * from agent_secteur_valide where type_secteur_id = 4) ase left join 
stat_vente_aroma_agent sv 
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
select agent_id, secteur_id, client_id, amount, date_order from order_digital_valide
union all 
select agent_id, secteur_id, user_id, amount, order_date from order_aroma_valide;

create or replace view all_type_order_valide_mois_annee as
select a.*, month(a.date_commande) as mois, year(a.date_commande) as annee
from all_type_order_valide a;





create or replace view stat_vente_admin as 
select sum(nbr_ventes) as nbr_ventes, sum(ca) as ca 
from stat_vente_agent;


