INSERT INTO requests (name, theme, description, deadline, `level`, applicants, contact, `comments`, filling_date, status, decision_date, decision_comments, `file`, extras, created_at, updated_at, user_id, type_id, status_id)
SELECT
	libelle,
	theme,
	description,
	delai_production,
	niveau_requis,
	demandeur,
	mailcontact,
	commentaire,
	date_depot,
	CASE WHEN statut = 1 THEN
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
	CONCAT('{', '"doctoral_school":', '"', ecole_doctorale, '"', ',"fns":', '"', fns, '"', ',"doctoral_status":', '"', doctorat_statut, '"', ',"doctoral_level":', '"', niveau_actuel, '"', ',"tested_products":', '"', produits_testes, '"', ',"teachers_nbr":', '"', cardinalite, '"', ',"students_nbr":', '"', nbre_etudiant, '"', ',"action_type":', '"', type_intervention, '"', '}'),
	date_depot,
	date_depot,
	NULL,
	demande_type,
	decision
FROM
	Demande