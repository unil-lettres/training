<?php

namespace App\Http\Controllers\Admin;

use App\Models\Request;
use App\Models\Status;
use App\Models\Type;
use Backpack\CRUD\app\Http\Controllers\CrudController;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\RequestRequest as StoreRequest;
use App\Http\Requests\RequestRequest as UpdateRequest;
use Backpack\CRUD\app\Http\Controllers\Operations\CloneOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\FetchOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class RequestCrudController
 * @package App\Http\Controllers\Admin
 */
class RequestCrudController extends CrudController
{
    use ListOperation;
    use CreateOperation;
    use UpdateOperation;
    use DeleteOperation;
    use FetchOperation;
    use CloneOperation;

    public function setup()
    {
        /*
        |--------------------------------------------------------------------------
        | CrudPanel Basic Information
        |--------------------------------------------------------------------------
        */
        CRUD::setModel('App\Models\Request');
        CRUD::setRoute(config('backpack.base.route_prefix') . '/request');
        CRUD::setEntityNameStrings('demande', 'demandes');
        if (!$this->crud->getRequest()->has('order')) {
            CRUD::orderBy('created_at', 'DESC');
        }

        /*
        |--------------------------------------------------------------------------
        | CrudPanel Configuration
        |--------------------------------------------------------------------------
        */

        CRUD::operation('list', function() {
            // Columns
            CRUD::addColumn(['name' => 'name', 'type' => 'text', 'label' => 'Nom']);
            CRUD::addColumn(['name' => 'description', 'type' => 'text', 'label' => 'Description']);
            CRUD::addColumn(['name' => 'filling_date', 'type' => 'datetime', 'label' => 'Date dépot']);
            CRUD::addColumn([
                'label' => "Catégorie",
                'type' => "select",
                'name' => 'type_id',
                'entity' => 'type',
                'attribute' => "name",
                'model' => "App\Models\Type"
            ]);
            CRUD::addColumn([
                'name' => 'status',
                'label' => "Statut",
                'type' => 'select_from_array',
                'options' => Request::$status
            ]);
            CRUD::addColumn(['name' => 'comments', 'type' => 'text', 'label' => 'Remarques']);

            // Filters
            CRUD::addFilter([
                'name' => 'type_id',
                'type' => 'select2_ajax',
                'label'=> 'Catégorie',
                'placeholder' => 'Filtrer une catégorie'
            ],
                url('admin/type/ajax-type-options'),
                function($value) {
                    CRUD::addClause('where', 'type_id', $value);
                });
            CRUD::addFilter([
                'name' => 'status_id',
                'type' => 'select2_ajax',
                'label'=> 'Décision',
                'placeholder' => 'Filtrer une décision'
            ],
                url('admin/status/ajax-status-options'),
                function($value) {
                    CRUD::addClause('where', 'status_id', $value);
                });
            CRUD::addFilter([
                'name' => 'status',
                'type' => 'dropdown',
                'label'=> 'Statut'
            ], Request::$status, function($value) {
                CRUD::addClause('where', 'status', $value);
            });
            CRUD::addFilter([
                'type' => 'date_range',
                'name' => 'deadline',
                'label'=> 'Délai de production'
            ],
            false,
            function($value) {
                $dates = json_decode($value);
                CRUD::addClause('where', 'deadline', '>=', $dates->from);
                CRUD::addClause('where', 'deadline', '<=', $dates->to . ' 23:59:59');
            });

            // Enable exports
            CRUD::enableExportButtons();
        });

        CRUD::operation(['create', 'update'], function() {
            // Fields
            CRUD::addField(['name' => 'name', 'type' => 'text', 'label' => 'Libellé', 'tab' => 'Champs communs']);
            CRUD::addField(['name' => 'description', 'type' => 'summernote', 'label' => 'Description', 'tab' => 'Champs communs']);
            CRUD::addField([
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
            CRUD::addField(['name' => 'applicants', 'type' => 'text', 'label' => 'Demandeur(s)', 'tab' => 'Champs communs']);
            CRUD::addField(['name' => 'theme', 'type' => 'text', 'label' => 'Thème', 'tab' => 'Champs communs']);
            CRUD::addField([
                'name' => 'deadline',
                'type' => 'date_picker',
                'date_picker_options' => [
                    'language' => 'fr'
                ],
                'allows_null' => true,
                'label' => 'Délai production',
                'tab' => 'Champs communs'
            ]);
            CRUD::addField(['name' => 'level', 'type' => 'text', 'label' => 'Niveau requis', 'tab' => 'Champs communs']);
            CRUD::addField(['name' => 'comments', 'type' => 'summernote', 'label' => 'Remarques', 'tab' => 'Champs communs']);
            CRUD::addField(['name' => 'contact', 'type' => 'email', 'label' => 'Mail contact', 'tab' => 'Champs communs']);

            CRUD::addField([
                'name' => 'doctoral_school',
                'label' => "École doctorale",
                'type' => 'text',
                'fake' => true,
                'store_in' => 'extras',
                'tab' => 'Champs chercheur/doctorant'
            ]);

            CRUD::addField([
                'name' => 'fns',
                'label' => "Fns",
                'type' => 'checkbox',
                'fake' => true,
                'store_in' => 'extras',
                'tab' => 'Champs chercheur/doctorant'
            ]);
            CRUD::addField([
                'name' => 'doctoral_status',
                'label' => "Doctorat statut",
                'type' => 'text',
                'fake' => true,
                'store_in' => 'extras',
                'tab' => 'Champs chercheur/doctorant'
            ]);
            CRUD::addField([
                'name' => 'doctoral_level',
                'label' => "Niveau actuel",
                'type' => 'text',
                'fake' => true,
                'store_in' => 'extras',
                'tab' => 'Champs chercheur/doctorant'
            ]);
            CRUD::addField([
                'name' => 'tested_products',
                'label' => "Produits testés",
                'type' => 'text',
                'fake' => true,
                'store_in' => 'extras',
                'tab' => 'Champs chercheur/doctorant'
            ]);

            CRUD::addField([
                'name' => 'teachers_nbr',
                'label' => "Seul ou avec d'autres enseignants",
                'type' => 'checkbox',
                'fake' => true,
                'store_in' => 'extras',
                'tab' => 'Champs enseignant'
            ]);
            CRUD::addField([
                'name' => 'students_nbr',
                'label' => "Avec un ou des étudiants",
                'type' => 'checkbox',
                'fake' => true,
                'store_in' => 'extras',
                'tab' => 'Champs enseignant'
            ]);
            CRUD::addField([
                'name' => 'action_type',
                'label' => "Intervention pour toute une classe, pendant les cours",
                'type' => 'checkbox',
                'fake' => true,
                'store_in' => 'extras',
                'tab' => 'Champs enseignant'
            ]);

            // Administration fields
            CRUD::addField([
                'name' => 'status',
                'label' => "Statut",
                'type' => 'select_from_array',
                'options' => Request::$status,
                'tab' => 'Champs d\'administration'
            ]);
            CRUD::addField([
                'label' => "Catégorie",
                'type' => "relationship",
                'name' => 'type_id',
                'attribute' => "name",
                'placeholder' => "Sélectionner une catégorie",
                'inline_create' => true,
                'tab' => 'Champs d\'administration'
            ]);
            CRUD::addField([
                'label' => "Décisions",
                'type' => 'relationship',
                'name' => 'status_id',
                'attribute' => "name",
                'placeholder' => "Sélectionner une décision",
                'inline_create' => true,
                'tab' => 'Champs d\'administration'
            ]);
            CRUD::addField([
                'label' => 'Date de décision',
                'name' => 'decision_date',
                'type' => 'datetime_picker',
                'datetime_picker_options' => [
                    'format' => 'DD/MM/YYYY HH:mm',
                    'language' => 'fr'
                ],
                'allows_null' => true,
                'tab' => 'Champs d\'administration'
            ]);
            CRUD::addField([
                'label' => 'Commentaire relatif à la décision',
                'name' => 'decision_comments',
                'type' => 'summernote',
                'tab' => 'Champs d\'administration'
            ]);
            CRUD::addField([
                'label' => 'Document',
                'name' => 'file',
                'type' => 'upload',
                'upload' => true,
                'tab' => 'Champs d\'administration',
                // https://github.com/Laravel-Backpack/CRUD/issues/2784
                'wrapper' => [
                    'data-field-name' => 'my_custom_field_name_to_avoid_file_field_bug'
                ]
            ]);
            CRUD::addField([
                'label' => "Utilisateur",
                'type' => 'select',
                'name' => 'user_id',
                'entity' => 'user',
                'attribute' => 'name',
                'model' => "App\User",
                'default'   => auth()->user()->id,
                'tab' => 'Champs d\'administration'
            ]);

            // add asterisk for fields that are required in RequestRequest
            CRUD::setRequiredFields(StoreRequest::class, 'create');
            CRUD::setRequiredFields(UpdateRequest::class, 'edit');
        });
    }

    protected function setupCreateOperation()
    {
        CRUD::setValidation(StoreRequest::class);
    }

    protected function setupUpdateOperation()
    {
        CRUD::setValidation(UpdateRequest::class);
    }

    // Needed for type inline create route
    public function fetchType()
    {
        return $this->fetch(Type::class);
    }

    // Needed for status inline create route
    public function fetchStatus()
    {
        return $this->fetch(Status::class);
    }
}
