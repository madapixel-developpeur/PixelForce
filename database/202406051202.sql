INSERT INTO user (
    email,
    username,
    roles,
    password,
    nom,
    prenom,
    adresse,
    active,
    telephone,
    created_at,
    code_postal,
    stripe_data,
    account_status,
    ville,
    parrain_id
) 
SELECT
    CONCAT('mnakanyandriamihaja@+testCA',n.id, 'gmail.com'),
    'admin',
    '["ROLE_AGENT"]',
    '$2y$13$IrAViPtZVUC1NXCCvc.qUeWEFHtseSP5hxi4/411E.zAqW2YRECFO',
    CONCAT('NOM-', n.id),
    CONCAT('prenomA-', n.id),
    'Antananarivo',
    '0349331431',
    '2024-04-29 19:56:07',
    '00101',
    'a:0:{}',
    'Actif',
    '12',
    'Antananarivo',
    27
FROM (SELECT (t4.a*625+t3.a*25+t2.a*5+t1.a) as id FROM (SELECT 0 as a UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4) as t1,
 (SELECT 0 as a UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4) as t2,
 (SELECT 0 as a UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4) as t3,
 (SELECT 0 as a UNION SELECT 1 UNION SELECT 2 UNION SELECT 3 UNION SELECT 4) as t4) as n;
