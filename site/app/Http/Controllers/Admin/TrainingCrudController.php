<?php

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\TrainingRequest as StoreRequest;
use App\Http\Requests\TrainingRequest as UpdateRequest;
use Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class TrainingCrudController
 * @package App\Http\Controllers\Admin
 */
class TrainingCrudController extends CrudController
{
    use ListOperation;
    use CreateOperation;
    use UpdateOperation;
    use DeleteOperation;

    public function setup()
    {
        /*
        |--------------------------------------------------------------------------
        | CrudPanel Basic Information
        |--------------------------------------------------------------------------
        */
        CRUD::setModel('App\Models\Training');
        CRUD::setRoute(config('backpack.base.route_prefix') . '/training');
        CRUD::setEntityNameStrings('formation', 'formations');
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
            CRUD::addColumn(['name' => 'start', 'type' => 'datetime', 'label' => 'Début']);
            CRUD::addColumn(['name' => 'end', 'type' => 'datetime', 'label' => 'Fin']);
            CRUD::addColumn(['name' => 'visible', 'type' => 'check', 'label' => 'Visible?']);

            // Filters
            CRUD::addFilter([
                'name' => 'visible',
                'type' => 'dropdown',
                'label'=> 'Visibilité'
            ], [
                1 => 'Visible',
                2 => 'Non-visible'
            ], function($value) {
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
        });

        CRUD::operation(['create', 'update'], function() {
            // Fields
            CRUD::addField(['name' => 'name', 'type' => 'text', 'label' => 'Nom']);
            CRUD::addField(['name' => 'description', 'type' => 'summernote', 'label' => 'Description']);
            CRUD::addField([
                'name' => 'start',
                'type' => 'datetime_picker',
                'datetime_picker_options' => [
                    'format' => 'DD/MM/YYYY HH:mm',
                    'language' => 'fr'
                ],
                'allows_null' => true,
                'label' => 'Date début'
            ]);
            CRUD::addField([
                'name' => 'end',
                'type' => 'datetime_picker',
                'datetime_picker_options' => [
                    'format' => 'DD/MM/YYYY HH:mm',
                    'language' => 'fr'
                ],
                'allows_null' => true,
                'label' => 'Date fin'
            ]);
            CRUD::addField(['name' => 'visible', 'type' => 'checkbox', 'label' => 'Visible']);

            // add asterisk for fields that are required in TrainingRequest
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
}
