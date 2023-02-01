<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\CategoryRequest as StoreRequest;
use App\Http\Requests\CategoryRequest as UpdateRequest;
use App\Models\Category;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\InlineCreateOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
use Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Illuminate\Http\Request;

/**
 * Class CategoryCrudController
 */
class CategoryCrudController extends CrudController
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
        CRUD::setModel('App\Models\Category');
        CRUD::setRoute(config('backpack.base.route_prefix').'/category');
        CRUD::setEntityNameStrings('catégorie', 'catégories');
        if (! $this->crud->getRequest()->has('order')) {
            CRUD::orderBy('name', 'ASC');
        }

        /*
        |--------------------------------------------------------------------------
        | CrudPanel Configuration
        |--------------------------------------------------------------------------
        */

        CRUD::operation('list', function () {
            // Columns
            CRUD::addColumn(['name' => 'name', 'type' => 'text', 'label' => 'Nom']);
        });

        CRUD::operation(['create', 'update'], function () {
            // Fields
            CRUD::addField(['name' => 'name', 'type' => 'text', 'label' => 'Nom']);

            // add asterisk for fields that are required in CategoryRequest
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

    public function categoryOptions(Request $request)
    {
        $term = $request->input('term');
        $options = Category::where('name', 'like', '%'.$term.'%')->get()->pluck('name', 'id');

        return $options;
    }
}
