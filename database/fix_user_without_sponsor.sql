
update
user u
join 
(
    select count(id) as total_direct_child, parrain_id 
    from user
    group by parrain_id
    HAVING total_direct_child >=2 
) as u1 on u1.parrain_id = u.id
set u.parrain_id = 46
where 
	u.parrain_id is null
    and u.id not in(46,50,21)