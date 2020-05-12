<?php

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\StatusRequest as StoreRequest;
use App\Http\Requests\StatusRequest as UpdateRequest;
use Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\InlineCreateOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use App\Models\Status;
use Illuminate\Http\Request;

/**
 * Class StatusCrudController
 * @package App\Http\Controllers\Admin
 */
class StatusCrudController extends CrudController
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
        CRUD::setModel('App\Models\Status');
        CRUD::setRoute(config('backpack.base.route_prefix') . '/status');
        CRUD::setEntityNameStrings('décision', 'décisions');

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

            // add asterisk for fields that are required in StatusRequest
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

    public function statusOptions(Request $request) {
        $term = $request->input('term');
        $options = Status::where('name', 'like', '%'.$term.'%')->get()->pluck('name', 'id');
        return $options;
    }
}
