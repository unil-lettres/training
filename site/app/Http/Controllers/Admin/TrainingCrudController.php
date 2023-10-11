<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\TrainingRequest as StoreRequest;
use App\Http\Requests\TrainingRequest as UpdateRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class TrainingCrudController
 */
class TrainingCrudController extends CrudController
{
    use CreateOperation;
    use DeleteOperation;
    use ListOperation;
    use UpdateOperation;

    public function setup()
    {
        /*
        |--------------------------------------------------------------------------
        | CrudPanel Basic Information
        |--------------------------------------------------------------------------
        */
        CRUD::setModel('App\Models\Training');
        CRUD::setRoute(config('backpack.base.route_prefix').'/training');
        CRUD::setEntityNameStrings('formation', 'formations');
        if (! $this->crud->getRequest()->has('order')) {
            CRUD::orderBy('created_at', 'DESC');
        }
    }

    public function setupListOperation()
    {
        // Columns
        CRUD::column(['name' => 'name', 'type' => 'text', 'label' => 'Nom']);
        CRUD::column(['name' => 'start', 'type' => 'datetime', 'label' => 'Début']);
        CRUD::column(['name' => 'end', 'type' => 'datetime', 'label' => 'Fin']);
        CRUD::column(['name' => 'visible', 'type' => 'check', 'label' => 'Visible?']);

        // Filters
        CRUD::filter('visible')
            ->type('dropdown')
            ->label('Visibilité')
            ->values([
                1 => 'Visible',
                2 => 'Non-visible',
            ])
            ->whenActive(function ($value) {
                switch (intval($value)) {
                    case 1:
                        CRUD::addClause('where', 'visible', 1);
                        break;
                    case 2:
                        CRUD::addClause('where', 'visible', 0);
                        break;
                }
            });

        // Enable exports
        CRUD::enableExportButtons();
    }

    protected function setupCreateOperation()
    {
        CRUD::setValidation(StoreRequest::class);

        // Fields
        CRUD::field(['name' => 'name', 'type' => 'text', 'label' => 'Nom']);
        CRUD::field(['name' => 'description', 'type' => 'summernote', 'label' => 'Description']);
        CRUD::field([
            'name' => 'start',
            'type' => 'datetime_picker',
            'datetime_picker_options' => [
                'format' => 'DD/MM/YYYY HH:mm',
                'language' => 'fr',
            ],
            'allows_null' => true,
            'label' => 'Date début',
        ]);
        CRUD::field([
            'name' => 'end',
            'type' => 'datetime_picker',
            'datetime_picker_options' => [
                'format' => 'DD/MM/YYYY HH:mm',
                'language' => 'fr',
            ],
            'allows_null' => true,
            'label' => 'Date fin',
        ]);
        CRUD::field(['name' => 'visible', 'type' => 'checkbox', 'label' => 'Visible']);

        // add asterisk for fields that are required in TrainingRequest
        CRUD::setRequiredFields(StoreRequest::class, 'create');
        CRUD::setRequiredFields(UpdateRequest::class, 'edit');
    }

    protected function setupUpdateOperation()
    {
        CRUD::setValidation(UpdateRequest::class);

        $this->setupCreateOperation();
    }
}
