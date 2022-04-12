<?php

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\TypeRequest as StoreRequest;
use App\Http\Requests\TypeRequest as UpdateRequest;
use Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\InlineCreateOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use App\Models\Type;
use Illuminate\Http\Request;

/**
 * Class TypeCrudController
 * @package App\Http\Controllers\Admin
 */
class TypeCrudController extends CrudController
{
    use ListOperation;
    use CreateOperation;
    use InlineCreateOperation;
    use UpdateOperation;
    use DeleteOperation;

    public function setup()
    {
        /*
        |--------------------------------------------------------------------------
        | CrudPanel Basic Information
        |--------------------------------------------------------------------------
        */
        CRUD::setModel('App\Models\Type');
        CRUD::setRoute(config('backpack.base.route_prefix') . '/type');
        CRUD::setEntityNameStrings('type', 'types');
        if (!$this->crud->getRequest()->has('order')) {
            CRUD::orderBy('name', 'ASC');
        }

        /*
        |--------------------------------------------------------------------------
        | CrudPanel Configuration
        |--------------------------------------------------------------------------
        */

        CRUD::operation('list', function() {
            // Columns
            CRUD::addColumn(['name' => 'name', 'type' => 'text', 'label' => 'Nom']);
        });

        CRUD::operation(['create', 'update'], function() {
            // Fields
            CRUD::addField(['name' => 'name', 'type' => 'text', 'label' => 'Nom']);

            // add asterisk for fields that are required in TypeRequest
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

    public function typeOptions(Request $request) {
        $term = $request->input('term');
        $options = Type::where('name', 'like', '%'.$term.'%')->get()->pluck('name', 'id');
        return $options;
    }
}
