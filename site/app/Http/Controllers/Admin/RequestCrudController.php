<?php

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\RequestRequest as StoreRequest;
use App\Http\Requests\RequestRequest as UpdateRequest;
use Backpack\CRUD\CrudPanel;

/**
 * Class RequestCrudController
 * @package App\Http\Controllers\Admin
 * @property-read CrudPanel $crud
 */
class RequestCrudController extends CrudController
{
    public function setup()
    {
        /*
        |--------------------------------------------------------------------------
        | CrudPanel Basic Information
        |--------------------------------------------------------------------------
        */
        $this->crud->setModel('App\Models\Request');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/request');
        $this->crud->setEntityNameStrings('demande', 'demandes');

        /*
        |--------------------------------------------------------------------------
        | CrudPanel Configuration
        |--------------------------------------------------------------------------
        */

        // Columns
        $this->crud->addColumn(['name' => 'name', 'type' => 'text', 'label' => 'Nom']);
        $this->crud->addColumn(['name' => 'description', 'type' => 'text', 'label' => 'Description']);
        $this->crud->addColumn([
            'name' => 'status',
            'label' => "Statut",
            'type' => 'select_from_array',
            'options' => ['new' => 'Nouveau', 'pending' => 'En attente', 'resolved' => 'Résolue'],
        ]);

        // Fields
        $this->crud->addField(['name' => 'name', 'type' => 'text', 'label' => 'Libellé']);
        $this->crud->addField(['name' => 'theme', 'type' => 'text', 'label' => 'Thème']);
        $this->crud->addField(['name' => 'description', 'type' => 'simplemde', 'label' => 'Description']);
        $this->crud->addField([
          'name' => '	deadline',
          'type' => 'date_picker',
          'datetime_picker_options' => [
            'format' => 'DD/MM/YYYY',
            'language' => 'fr'
          ],
          'allows_null' => true,
          'label' => 'Délai production'
        ]);
        $this->crud->addField(['name' => 'level', 'type' => 'text', 'label' => 'Niveau requis']);
        $this->crud->addField(['name' => 'applicants', 'type' => 'text', 'label' => 'Demandeur(s)']);
        $this->crud->addField(['name' => 'contact', 'type' => 'email', 'label' => 'Mail contact']);
        $this->crud->addField(['name' => 'comments', 'type' => 'simplemde', 'label' => 'Remarques']);
        $this->crud->addField([
          'name' => 'filling_date',
          'type' => 'datetime_picker',
          'datetime_picker_options' => [
            'format' => 'DD/MM/YYYY HH:mm',
            'language' => 'fr'
          ],
          'allows_null' => true,
          'label' => 'Date dépot'
        ]);
        $this->crud->addField([
          'name' => 'status',
          'label' => "Statut",
          'type' => 'select_from_array',
          'options' => ['new' => 'Nouveau', 'pending' => 'En attente', 'resolved' => 'Résolue'],
          'allows_null' => true
        ]);
        $this->crud->addField([
          'name' => 'decision_date',
          'type' => 'datetime_picker',
          'datetime_picker_options' => [
            'format' => 'DD/MM/YYYY HH:mm',
            'language' => 'fr'
          ],
          'allows_null' => true,
          'label' => 'Date de décision'
        ]);
        $this->crud->addField(['name' => 'decision_comments', 'type' => 'simplemde', 'label' => 'Commentaire relatif à la décision']);
        $this->crud->addField([
          'name' => 'file',
          'label' => 'Document',
          'type' => 'upload',
          'upload' => true
        ]);

        $this->crud->addField([  // Select
          'label' => "Catégorie",
          'type' => 'select',
          'name' => 'type_id', // the db column for the foreign key
          'entity' => 'type', // the method that defines the relationship in your Model
          'attribute' => 'name', // foreign key attribute that is shown to user
          'model' => "App\Models\Type"
        ]);

        // add asterisk for fields that are required in RequestRequest
        $this->crud->setRequiredFields(StoreRequest::class, 'create');
        $this->crud->setRequiredFields(UpdateRequest::class, 'edit');

        // Enable exports
        $this->crud->enableExportButtons();
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
