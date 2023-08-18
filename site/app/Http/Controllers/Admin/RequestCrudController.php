<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\RequestRequest as StoreRequest;
use App\Http\Requests\RequestRequest as UpdateRequest;
use App\Models\Category;
use App\Models\Request;
use App\Models\Status;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Http\Controllers\Operations\CloneOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\FetchOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class RequestCrudController
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
        CRUD::setRoute(config('backpack.base.route_prefix').'/request');
        CRUD::setEntityNameStrings('demande', 'demandes');
        if (! $this->crud->getRequest()->has('order')) {
            CRUD::orderBy('created_at', 'DESC');
        }
        $this->crud->enableDetailsRow();
    }

    public function setupListOperation()
    {
        // Columns
        CRUD::column([
            'name' => 'name',
            'type' => 'text',
            'label' => 'Nom',
        ]);
        CRUD::column([
            'name' => 'description',
            'type' => 'model_function',
            'label' => 'Description',
            'limit' => 60,
            'function_name' => 'cleanDescription',
            // Set priority to display action buttons before
            // description field in the responsive table
            'priority' => 2,
        ]);
        CRUD::column([
            'name' => 'filling_date',
            'type' => 'datetime',
            'label' => 'Date dépot',
        ]);
        CRUD::column([
            'label' => 'Catégorie',
            'type' => 'select',
            'name' => 'category_id',
            'entity' => 'category',
            'attribute' => 'name',
            'model' => "App\Models\Category",
        ]);
        CRUD::column([
            'name' => 'status_admin',
            'label' => 'Statut',
            'type' => 'select_from_array',
            'options' => Request::$status,
        ]);
        CRUD::column([
            'name' => 'type',
            'label' => 'Type',
            'type' => 'select_from_array',
            'options' => Request::$type,
        ]);
        CRUD::column([
            'name' => 'comments',
            'type' => 'model_function',
            'label' => 'Remarques',
            'function_name' => 'cleanComments',
        ]);

        // Filters
        CRUD::filter('category_id')
            ->type('select2_ajax')
            ->label('Catégorie')
            ->placeholder('Filtrer une catégorie')
            ->values(backpack_url('request/fetch/category'))
            ->method('POST')
            ->whenActive(function ($value) {
                CRUD::addClause('where', 'category_id', $value);
            });

        CRUD::filter('status_id')
            ->type('select2_ajax')
            ->label('Décision')
            ->placeholder('Filtrer une décision')
            ->values(backpack_url('request/fetch/status'))
            ->method('POST')
            ->whenActive(function ($value) {
                CRUD::addClause('where', 'status_id', $value);
            });

        CRUD::filter('status_admin')
            ->type('dropdown')
            ->label('Statut')
            ->values(Request::$status)
            ->whenActive(function ($value) {
                CRUD::addClause('where', 'status_admin', $value);
            });

        CRUD::filter('type')
            ->type('dropdown')
            ->label('Type')
            ->values(Request::$type)
            ->whenActive(function ($value) {
                CRUD::addClause('where', 'type', $value);
            });

        CRUD::filter('deadline')
            ->type('date_range')
            ->label('Délai de production')
            ->whenActive(function ($value) {
                $dates = json_decode($value);
                CRUD::addClause('where', 'deadline', '>=', $dates->from);
                CRUD::addClause('where', 'deadline', '<=', $dates->to.' 23:59:59');
            });

        // Enable exports
        CRUD::enableExportButtons();
    }

    protected function setupCreateOperation()
    {
        CRUD::setValidation(StoreRequest::class);

        // Fields
        CRUD::field(['name' => 'name', 'type' => 'text', 'label' => 'Libellé', 'tab' => 'Champs communs']);
        CRUD::field(['name' => 'description', 'type' => 'summernote', 'label' => 'Description', 'tab' => 'Champs communs']);
        CRUD::field([
            'name' => 'filling_date',
            'type' => 'datetime_picker',
            'datetime_picker_options' => [
                'format' => 'DD/MM/YYYY HH:mm',
                'language' => 'fr',
            ],
            'allows_null' => true,
            'label' => 'Date dépot',
            'default' => now(),
            'tab' => 'Champs communs',
        ]);
        CRUD::field(['name' => 'applicants', 'type' => 'text', 'label' => 'Demandeur(s)', 'tab' => 'Champs communs']);
        CRUD::field(['name' => 'theme', 'type' => 'text', 'label' => 'Thème', 'tab' => 'Champs communs']);
        CRUD::field([
            'name' => 'deadline',
            'type' => 'date_picker',
            'date_picker_options' => [
                'language' => 'fr',
            ],
            'allows_null' => true,
            'label' => 'Délai production',
            'tab' => 'Champs communs',
        ]);
        CRUD::field(['name' => 'level', 'type' => 'text', 'label' => 'Niveau requis', 'tab' => 'Champs communs']);
        CRUD::field(['name' => 'comments', 'type' => 'summernote', 'label' => 'Remarques', 'tab' => 'Champs communs']);
        CRUD::field(['name' => 'contact', 'type' => 'email', 'label' => 'Mail contact', 'tab' => 'Champs communs']);

        CRUD::field([
            'name' => 'doctoral_school',
            'label' => 'École doctorale',
            'type' => 'text',
            'fake' => true,
            'store_in' => 'extras',
            'tab' => 'Champs chercheur/doctorant',
        ]);

        CRUD::field([
            'name' => 'fns',
            'label' => 'Fns',
            'type' => 'checkbox',
            'fake' => true,
            'store_in' => 'extras',
            'tab' => 'Champs chercheur/doctorant',
        ]);
        CRUD::field([
            'name' => 'doctoral_status',
            'label' => 'Doctorat statut',
            'type' => 'text',
            'fake' => true,
            'store_in' => 'extras',
            'tab' => 'Champs chercheur/doctorant',
        ]);
        CRUD::field([
            'name' => 'doctoral_level',
            'label' => 'Niveau actuel',
            'type' => 'text',
            'fake' => true,
            'store_in' => 'extras',
            'tab' => 'Champs chercheur/doctorant',
        ]);
        CRUD::field([
            'name' => 'tested_products',
            'label' => 'Produits testés',
            'type' => 'text',
            'fake' => true,
            'store_in' => 'extras',
            'tab' => 'Champs chercheur/doctorant',
        ]);

        CRUD::field([
            'name' => 'teachers_nbr',
            'label' => "Seul ou avec d'autres enseignants",
            'type' => 'checkbox',
            'fake' => true,
            'store_in' => 'extras',
            'tab' => 'Champs enseignant',
        ]);
        CRUD::field([
            'name' => 'students_nbr',
            'label' => 'Avec un ou des étudiants',
            'type' => 'checkbox',
            'fake' => true,
            'store_in' => 'extras',
            'tab' => 'Champs enseignant',
        ]);
        CRUD::field([
            'name' => 'action_type',
            'label' => 'Intervention pour toute une classe, pendant les cours',
            'type' => 'checkbox',
            'fake' => true,
            'store_in' => 'extras',
            'tab' => 'Champs enseignant',
        ]);

        // Administration fields
        CRUD::field([
            'label' => 'Statut',
            'type' => 'select_from_array',
            'name' => 'status_admin',
            'options' => Request::$status,
            'tab' => 'Champs d\'administration',
        ]);
        CRUD::field([
            'label' => 'Type',
            'type' => 'select_from_array',
            'name' => 'type',
            'options' => Request::$type,
            'tab' => 'Champs d\'administration',
        ]);
        CRUD::field([
            'label' => 'Catégorie',
            'type' => 'relationship',
            'name' => 'category_id',
            'attribute' => 'name',
            'model' => "App\Models\Category",
            'placeholder' => 'Sélectionner une catégorie',
            'inline_create' => true,
            'tab' => 'Champs d\'administration',
        ]);
        CRUD::field([
            'label' => 'Décisions',
            'type' => 'relationship',
            'name' => 'status_id',
            'attribute' => 'name',
            'model' => "App\Models\Status",
            'placeholder' => 'Sélectionner une décision',
            'inline_create' => true,
            'tab' => 'Champs d\'administration',
        ]);
        CRUD::field([
            'label' => 'Date de décision',
            'name' => 'decision_date',
            'type' => 'datetime_picker',
            'datetime_picker_options' => [
                'format' => 'DD/MM/YYYY HH:mm',
                'language' => 'fr',
            ],
            'allows_null' => true,
            'tab' => 'Champs d\'administration',
        ]);
        CRUD::field([
            'label' => 'Commentaire relatif à la décision',
            'name' => 'decision_comments',
            'type' => 'summernote',
            'tab' => 'Champs d\'administration',
        ]);
        CRUD::field([
            'label' => 'Personnes ressources',
            'name' => 'contacts',
            'type' => 'repeatable',
            'subfields' => [
                [
                    'name' => 'contact',
                    'type' => 'text',
                    'label' => 'Contact',
                    'wrapper' => ['class' => 'form-group col-md-6'],
                ],
                [
                    'name' => 'notes',
                    'type' => 'textarea',
                    'label' => 'Notes',
                    'wrapper' => ['class' => 'form-group col-md-6'],
                ],
            ],
            'new_item_label' => 'Ajouter',
            'init_rows' => 1,
            'min_rows' => 1,
            'max_rows' => 10,
            'reorder' => true,
            'tab' => 'Champs d\'administration',
        ]);
        CRUD::field([
            'label' => 'Document',
            'name' => 'file',
            'type' => 'upload',
            'upload' => true,
            'tab' => 'Champs d\'administration',
        ])->withFiles([
            'disk' => 'uploads',
            'path' => 'uploads',
        ]);
        CRUD::field([
            'label' => 'Utilisateur',
            'type' => 'select',
            'name' => 'user_id',
            'entity' => 'user',
            'attribute' => 'name',
            'model' => "App\User",
            'default' => auth()->user()->id,
            'tab' => 'Champs d\'administration',
        ]);

        // add asterisk for fields that are required in RequestRequest
        CRUD::setRequiredFields(StoreRequest::class, 'create');
        CRUD::setRequiredFields(UpdateRequest::class, 'edit');
    }

    protected function setupUpdateOperation()
    {
        CRUD::setValidation(UpdateRequest::class);

        $this->setupCreateOperation();
    }

    protected function setupDeleteOperation()
    {
        // Automatically delete the uploaded files when the entry is deleted in the admin panel
        CRUD::field('file')->type('upload')->withFiles();
    }

    // Needed for category inline create route
    protected function fetchCategory()
    {
        return $this->fetch([
            'model' => Category::class,
            'query' => function ($model) {
                return $model->orderBy('name', 'ASC');
            },
        ]);
    }

    // Needed for status inline create route
    protected function fetchStatus()
    {
        return $this->fetch([
            'model' => Status::class,
            'query' => function ($model) {
                return $model->orderBy('name', 'ASC');
            },
        ]);
    }
}
