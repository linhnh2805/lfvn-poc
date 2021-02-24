<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\LogCicRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class LogCicCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class LogCicCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     * 
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\LogCic::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/logcic');
        CRUD::setEntityNameStrings('logcic', 'log_cics');
    }

    /**
     * Define what happens when the List operation is loaded.
     * 
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        //CRUD::column('uuid');
        CRUD::column('start_time');
        CRUD::column('created_at');
        CRUD::column('request_type');
        CRUD::column('url');
        //CRUD::column('personal_id');
        //CRUD::column('contact_id');
        CRUD::column('status_code');
        CRUD::column('error_code');
        CRUD::column('error_message');
        CRUD::column('data');
        CRUD::column('start_time');
        CRUD::column('created_at');
        CRUD::column('updated_at');
        // CRUD::column('request_body');

        // remove a button
        $this->crud->removeButton('create');
        $this->crud->removeButton('update');
        $this->crud->removeButton('delete');

        /**
         * Columns can be defined using the fluent syntax or array syntax:
         * - CRUD::column('price')->type('number');
         * - CRUD::addColumn(['name' => 'price', 'type' => 'number']); 
         */
    }

    /**
     * Define what happens when the Create operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(LogCicRequest::class);

        CRUD::field('uuid');
        CRUD::field('request_type');
        CRUD::field('url');
        CRUD::field('personal_id');
        CRUD::field('contact_id');
        CRUD::field('status_code');
        CRUD::field('error_code');
        CRUD::field('error_message');
        CRUD::field('data');
        CRUD::field('start_time');
        CRUD::field('request_body');

        /**
         * Fields can be defined using the fluent syntax or array syntax:
         * - CRUD::field('price')->type('number');
         * - CRUD::addField(['name' => 'price', 'type' => 'number'])); 
         */
    }

    /**
     * Define what happens when the Update operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-update
     * @return void
     */
    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }

    protected function setupShowOperation()
    {
        // $this->setupShowOperation();
        $this->crud->addColumn([
            'name' => 'request_body', 'label' => 'Request Body', 'type' => 'textarea'
        ])->afterColumn('data');
        $this->crud->column('created_at');

        // remove a button
        $this->crud->removeButton('update');
        $this->crud->removeButton('delete');
    }
}
