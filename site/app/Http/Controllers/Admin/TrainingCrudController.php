<?php

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\TrainingRequest as StoreRequest;
use App\Http\Requests\TrainingRequest as UpdateRequest;
use Backpack\CRUD\CrudPanel;

/**
 * Class TrainingCrudController
 * @package App\Http\Controllers\Admin
 * @property-read CrudPanel $crud
 */
class TrainingCrudController extends CrudController
{
    public function setup()
    {
        /*
        |--------------------------------------------------------------------------
        | CrudPanel Basic Information
        |--------------------------------------------------------------------------
        */
        $this->crud->setModel('App\Models\Training');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/training');
        $this->crud->setEntityNameStrings('training', 'trainings');

        /*
        |--------------------------------------------------------------------------
        | CrudPanel Configuration
        |--------------------------------------------------------------------------
        */

        // Columns
        $this->crud->addColumn(['name' => 'name', 'type' => 'text', 'label' => 'Nom']);
        $this->crud->addColumn(['name' => 'start', 'type' => 'datetime', 'label' => 'Début']);
        $this->crud->addColumn(['name' => 'end', 'type' => 'datetime', 'label' => 'Fin']);
        $this->crud->addColumn(['name' => 'visible', 'type' => 'check', 'label' => 'Visible?']);

        // Fields
        $this->crud->addField(['name' => 'name', 'type' => 'text', 'label' => 'Nom']);
        $this->crud->addField(['name' => 'description', 'type' => 'simplemde', 'label' => 'Description']);
        $this->crud->addField([
          'name' => 'start',
          'type' => 'datetime_picker',
          'datetime_picker_options' => [
            'format' => 'DD/MM/YYYY HH:mm',
            'language' => 'fr'
          ],
          'allows_null' => true,
          'label' => 'Date début'
        ]);
        $this->crud->addField([
          'name' => 'end',
          'type' => 'datetime_picker',
          'datetime_picker_options' => [
            'format' => 'DD/MM/YYYY HH:mm',
            'language' => 'fr'
          ],
          'allows_null' => true,
          'label' => 'Date fin'
        ]);
        $this->crud->addField(['name' => 'visible', 'type' => 'checkbox', 'label' => 'Visible']);

        // add asterisk for fields that are required in TrainingRequest
        $this->crud->setRequiredFields(StoreRequest::class, 'create');
        $this->crud->setRequiredFields(UpdateRequest::class, 'edit');
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
