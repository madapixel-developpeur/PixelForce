

create or replace view vw_countfils as select count(*) fils,parrain_id from user group by parrain_id;

create or replace view vw_coach as select a.*,COALESCE(b.fils, 0) fils 
from user a left join vw_countfils b on a.id = b.parrain_id;