INSERT INTO requests (name, theme, description, deadline, `level`, applicants, contact, `comments`, filling_date,
                      status, decision_date, decision_comments, `file`, extras, created_at, updated_at, user_id,
                      type_id, status_id)
SELECT libelle,
       theme,
       description,
       delai_production,
       niveau_requis,
       demandeur,
       mailcontact,
       commentaire,
       date_depot,
       CASE
           WHEN statut = 1 THEN
               'new'
           WHEN statut = 2 THEN
               'pending'
           WHEN statut = 3 THEN
               'resolved'
           ELSE
               NULL
           END,
       date_decision,
       remarque,
       `document`,
       CONCAT('{', '"doctoral_school":', CASE
                                             WHEN ecole_doctorale IS NULL THEN
                                                 'null'
                                             ELSE
                                                 CONCAT('"', ecole_doctorale, '"')
           END, ',"fns":', '"', fns, '"', ',"doctoral_status":', CASE
                                                                     WHEN doctorat_statut IS NULL THEN
                                                                         'null'
                                                                     ELSE
                                                                         CONCAT('"', doctorat_statut, '"')
                  END, ',"doctoral_level":', CASE
                                                 WHEN niveau_actuel IS NULL THEN
                                                     'null'
                                                 ELSE
                                                     CONCAT('"', niveau_actuel, '"')
                  END, ',"tested_products":', CASE
                                                  WHEN produits_testes IS NULL THEN
                                                      'null'
                                                  ELSE
                                                      CONCAT('"', produits_testes, '"')
                  END, ',"teachers_nbr":', '"', cardinalite, '"', ',"students_nbr":', '"', nbre_etudiant, '"',
              ',"action_type":', '"', type_intervention, '"', '}'),
       date_depot,
       date_depot,
       NULL,
       demande_type,
       decision
FROM Demande
