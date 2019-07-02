<?php

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\RequestRequest as StoreRequest;
use App\Http\Requests\RequestRequest as UpdateRequest;
use Backpack\CRUD\CrudPanel;

/**
 * Class RequestCrudController
 * @package App\Http\Controllers\Admin
 * @property-read CrudPanel $crud
 */
class RequestCrudController extends CrudController
{
    public function setup()
    {
        /*
        |--------------------------------------------------------------------------
        | CrudPanel Basic Information
        |--------------------------------------------------------------------------
        */
        $this->crud->setModel('App\Models\Request');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/request');
        $this->crud->setEntityNameStrings('demande', 'demandes');

        /*
        |--------------------------------------------------------------------------
        | CrudPanel Configuration
        |--------------------------------------------------------------------------
        */

        // Columns
        $this->crud->addColumn(['name' => 'name', 'type' => 'text', 'label' => 'Nom']);
        $this->crud->addColumn(['name' => 'description', 'type' => 'text', 'label' => 'Description']);
        $this->crud->addColumn(['name' => 'filling_date', 'type' => 'datetime', 'label' => 'Date dépot']);
        $this->crud->addColumn([
          'label' => "Catégorie",
          'type' => "select",
          'name' => 'type_id',
          'entity' => 'type',
          'attribute' => "name",
          'model' => "App\Models\Type"
        ]);
        $this->crud->addColumn([
          'name' => 'status',
          'label' => "Statut",
          'type' => 'select_from_array',
          'options' => ['new' => 'Nouveau', 'pending' => 'En attente', 'resolved' => 'Résolue']
        ]);
        $this->crud->addColumn(['name' => 'comments', 'type' => 'text', 'label' => 'Remarques']);

        // Fields
        $this->crud->addField(['name' => 'name', 'type' => 'text', 'label' => 'Libellé', 'tab' => 'Champs communs']);
        $this->crud->addField(['name' => 'description', 'type' => 'summernote', 'label' => 'Description', 'tab' => 'Champs communs']);
        $this->crud->addField([
          'name' => 'filling_date',
          'type' => 'datetime_picker',
          'datetime_picker_options' => [
            'format' => 'DD/MM/YYYY HH:mm',
            'language' => 'fr'
          ],
          'allows_null' => true,
          'label' => 'Date dépot',
          'default' => now(),
          'tab' => 'Champs communs'
        ]);
        $this->crud->addField(['name' => 'applicants', 'type' => 'text', 'label' => 'Demandeur(s)', 'tab' => 'Champs communs']);
        $this->crud->addField(['name' => 'theme', 'type' => 'text', 'label' => 'Thème', 'tab' => 'Champs communs']);
        $this->crud->addField([
          'name' => 'deadline',
          'type' => 'date_picker',
          'date_picker_options' => [
            'language' => 'fr'
          ],
          'allows_null' => true,
          'label' => 'Délai production',
          'tab' => 'Champs communs'
        ]);
        $this->crud->addField(['name' => 'level', 'type' => 'text', 'label' => 'Niveau requis', 'tab' => 'Champs communs']);
        $this->crud->addField(['name' => 'comments', 'type' => 'summernote', 'label' => 'Remarques', 'tab' => 'Champs communs']);
        $this->crud->addField(['name' => 'contact', 'type' => 'email', 'label' => 'Mail contact', 'tab' => 'Champs communs']);

        $this->crud->addField([
          'name' => 'doctoral_school',
          'label' => "École doctorale",
          'type' => 'text',
          'fake' => true,
          'store_in' => 'extras',
          'tab' => 'Champs chercheur/doctorant'
        ]);

        $this->crud->addField([
          'name' => 'fns',
          'label' => "Fns",
          'type' => 'checkbox',
          'fake' => true,
          'store_in' => 'extras',
          'tab' => 'Champs chercheur/doctorant'
        ]);
        $this->crud->addField([
          'name' => 'doctoral_status',
          'label' => "Doctorat statut",
          'type' => 'text',
          'fake' => true,
          'store_in' => 'extras',
          'tab' => 'Champs chercheur/doctorant'
        ]);
        $this->crud->addField([
          'name' => 'doctoral_level',
          'label' => "Niveau actuel",
          'type' => 'text',
          'fake' => true,
          'store_in' => 'extras',
          'tab' => 'Champs chercheur/doctorant'
        ]);
        $this->crud->addField([
          'name' => 'tested_products',
          'label' => "Produits testés",
          'type' => 'text',
          'fake' => true,
          'store_in' => 'extras',
          'tab' => 'Champs chercheur/doctorant'
        ]);

        $this->crud->addField([
          'name' => 'teachers_nbr',
          'label' => "Seul ou avec d'autres enseignants",
          'type' => 'checkbox',
          'fake' => true,
          'store_in' => 'extras',
          'tab' => 'Champs enseignant'
        ]);
        $this->crud->addField([
          'name' => 'students_nbr',
          'label' => "Avec un ou des étudiants",
          'type' => 'checkbox',
          'fake' => true,
          'store_in' => 'extras',
          'tab' => 'Champs enseignant'
        ]);
        $this->crud->addField([
          'name' => 'action_type',
          'label' => "Intervention pour toute une classe, pendant les cours",
          'type' => 'checkbox',
          'fake' => true,
          'store_in' => 'extras',
          'tab' => 'Champs enseignant'
        ]);

        $this->crud->addField([
          'name' => 'status',
          'label' => "Statut",
          'type' => 'select_from_array',
          'options' => ['new' => 'Nouveau', 'pending' => 'En attente', 'resolved' => 'Résolue'],
          'tab' => 'Champs d\'administration'
        ]);
        $this->crud->addField([
          'label' => "Catégorie",
          'type' => 'select',
          'name' => 'type_id',
          'entity' => 'type',
          'attribute' => 'name',
          'model' => "App\Models\Type",
          'tab' => 'Champs d\'administration'
        ]);
        $this->crud->addField([
          'label' => "Décisions",
          'type' => 'select',
          'name' => 'status_id',
          'entity' => 'status',
          'attribute' => 'name',
          'model' => "App\Models\Status",
          'tab' => 'Champs d\'administration'
        ]);
        $this->crud->addField([
          'name' => 'decision_date',
          'type' => 'datetime_picker',
          'datetime_picker_options' => [
            'format' => 'DD/MM/YYYY HH:mm',
            'language' => 'fr'
          ],
          'allows_null' => true,
          'label' => 'Date de décision',
          'tab' => 'Champs d\'administration'
        ]);
        $this->crud->addField([
          'name' => 'decision_comments',
          'type' => 'summernote',
          'label' => 'Commentaire relatif à la décision',
          'tab' => 'Champs d\'administration'
        ]);
        $this->crud->addField([
          'name' => 'file',
          'label' => 'Document',
          'type' => 'upload',
          'upload' => true,
          'tab' => 'Champs d\'administration'
        ]);
        $this->crud->addField([
          'label' => "Utilisateur",
          'type' => 'select',
          'name' => 'user_id',
          'entity' => 'user',
          'attribute' => 'name',
          'model' => "App\Models\BackpackUser",
          'default'   => auth()->user()->id,
          'tab' => 'Champs d\'administration'
        ]);

        // Filters
        $this->crud->addFilter([
          'name' => 'type_id',
          'type' => 'select2_ajax',
          'label'=> 'Catégorie',
          'placeholder' => 'Filtrer une catégorie'
        ],
        url('admin/type/ajax-type-options'),
        function($value) {
            $this->crud->addClause('where', 'type_id', $value);
        });
        $this->crud->addFilter([
          'name' => 'status_id',
          'type' => 'select2_ajax',
          'label'=> 'Décision',
          'placeholder' => 'Filtrer une décision'
        ],
        url('admin/status/ajax-status-options'),
        function($value) {
            $this->crud->addClause('where', 'status_id', $value);
        });
        $this->crud->addFilter([
          'name' => 'status',
          'type' => 'dropdown',
          'label'=> 'Statut'
        ], [
          'new' => 'Nouveau',
          'pending' => 'En attente',
          'resolved' => 'Résolue',
        ], function($value) {
            $this->crud->addClause('where', 'status', $value);
        });

        // add asterisk for fields that are required in RequestRequest
        $this->crud->setRequiredFields(StoreRequest::class, 'create');
        $this->crud->setRequiredFields(UpdateRequest::class, 'edit');

        // Enable exports
        $this->crud->enableExportButtons();
    }

    public function store(StoreRequest $request)
    {
        // your additional operations before save here
        $redirect_location = parent::storeCrud($request);
        // your additional operations after save here
        // use $this->data['entry'] or $this->crud->entry
        return $redirect_location;
    }

    public function update(UpdateRequest $request)
    {
        // your additional operations before save here
        $redirect_location = parent::updateCrud($request);
        // your additional operations after save here
        // use $this->data['entry'] or $this->crud->entry
        return $redirect_location;
    }
}
