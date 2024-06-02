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