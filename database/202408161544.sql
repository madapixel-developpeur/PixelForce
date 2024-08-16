SET @first_category_id = (
    SELECT id
    FROM categorie_formation
    WHERE statut = 1
    ORDER BY ordre_cat_formation
    LIMIT 1
);

UPDATE user u
JOIN (
    SELECT uf.agent_id
    FROM formation_agent uf
    JOIN formation f ON uf.formation_id = f.id
    WHERE f.categorie_formation_id = @first_category_id AND uf.statut = 'terminer'
) AS completed_users ON u.id = completed_users.agent_id
SET u.finished_one_video_formation = true;