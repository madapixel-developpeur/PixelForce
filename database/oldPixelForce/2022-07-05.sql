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