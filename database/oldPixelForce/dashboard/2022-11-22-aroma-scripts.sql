

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
