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
    use CreateOperation;
    use DeleteOperation;
    use InlineCreateOperation;
    use ListOperation;
    use UpdateOperation;

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
    }

    public function setupListOperation()
    {
        // Columns
        CRUD::column(['name' => 'name', 'type' => 'text', 'label' => 'Nom']);
    }

    protected function setupCreateOperation()
    {
        CRUD::setValidation(StoreRequest::class);

        // Fields
        CRUD::field(['name' => 'name', 'type' => 'text', 'label' => 'Nom']);

        // add asterisk for fields that are required in CategoryRequest
        CRUD::setRequiredFields(StoreRequest::class, 'create');
        CRUD::setRequiredFields(UpdateRequest::class, 'edit');
    }

    protected function setupUpdateOperation()
    {
        CRUD::setValidation(UpdateRequest::class);

        $this->setupCreateOperation();
    }

    public function categoryOptions(Request $request)
    {
        $term = $request->input('term');
        $options = Category::where('name', 'like', '%'.$term.'%')->get()->pluck('name', 'id');

        return $options;
    }
}
