<?php

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\TypeRequest as StoreRequest;
use App\Http\Requests\TypeRequest as UpdateRequest;
use Backpack\CRUD\CrudPanel;
use App\Models\Type;
use Illuminate\Http\Request;

/**
 * Class TypeCrudController
 * @package App\Http\Controllers\Admin
 * @property-read CrudPanel $crud
 */
class TypeCrudController extends CrudController
{
    public function setup()
    {
        /*
        |--------------------------------------------------------------------------
        | CrudPanel Basic Information
        |--------------------------------------------------------------------------
        */
        $this->crud->setModel('App\Models\Type');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/type');
        $this->crud->setEntityNameStrings('type', 'types');

        /*
        |--------------------------------------------------------------------------
        | CrudPanel Configuration
        |--------------------------------------------------------------------------
        */

        // Columns
        $this->crud->addColumn(['name' => 'name', 'type' => 'text', 'label' => 'Nom']);
        // Fields
        $this->crud->addField(['name' => 'name', 'type' => 'text', 'label' => 'Nom']);

        // add asterisk for fields that are required in TypeRequest
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

    public function typeOptions(Request $request) {
        $term = $request->input('term');
        $options = Type::where('name', 'like', '%'.$term.'%')->get()->pluck('name', 'id');
        return $options;
    }
}
