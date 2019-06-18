<?php

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\StatusRequest as StoreRequest;
use App\Http\Requests\StatusRequest as UpdateRequest;
use Backpack\CRUD\CrudPanel;
use App\Models\Status;
use Illuminate\Http\Request;

/**
 * Class StatusCrudController
 * @package App\Http\Controllers\Admin
 * @property-read CrudPanel $crud
 */
class StatusCrudController extends CrudController
{
    public function setup()
    {
        /*
        |--------------------------------------------------------------------------
        | CrudPanel Basic Information
        |--------------------------------------------------------------------------
        */
        $this->crud->setModel('App\Models\Status');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/status');
        $this->crud->setEntityNameStrings('décision', 'décisions');

        /*
        |--------------------------------------------------------------------------
        | CrudPanel Configuration
        |--------------------------------------------------------------------------
        */

        // Columns
        $this->crud->addColumn(['name' => 'name', 'type' => 'text', 'label' => 'Nom']);
        // Fields
        $this->crud->addField(['name' => 'name', 'type' => 'text', 'label' => 'Nom']);

        // add asterisk for fields that are required in StatusRequest
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

    public function statusOptions(Request $request) {
        $term = $request->input('term');
        $options = Status::where('name', 'like', '%'.$term.'%')->get()->pluck('name', 'id');
        return $options;
    }
}
