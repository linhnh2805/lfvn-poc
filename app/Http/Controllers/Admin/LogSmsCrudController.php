<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\LogSmsRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class LogSmsCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class LogSmsCrudController extends CrudController
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
        CRUD::setModel(\App\Models\LogSms::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/logsms');
        CRUD::setEntityNameStrings('logsms', 'log_sms');
    }

    /**
     * Define what happens when the List operation is loaded.
     * 
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        CRUD::column('session_id');
        CRUD::column('start_time');
        //CRUD::column('url');
        //CRUD::column('request_type');
        CRUD::column('phone');
        CRUD::column('otp');
        //CRUD::column('request_body');
        CRUD::column('status_code');
        //CRUD::column('response_body');
        //CRUD::column('message_id');
        //CRUD::column('partner_id');
        CRUD::column('tel_co');
        CRUD::column('error');
        //CRUD::column('error_description');
        CRUD::column('created_at');
        //CRUD::column('updated_at');

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
        CRUD::setValidation(LogSmsRequest::class);

        CRUD::field('session_id');
        CRUD::field('start_time');
        CRUD::field('url');
        CRUD::field('request_type');
        CRUD::field('phone');
        CRUD::field('otp');
        CRUD::field('request_body');
        CRUD::field('status_code');
        CRUD::field('response_body');
        CRUD::field('message_id');
        CRUD::field('partner_id');
        CRUD::field('tel_co');
        CRUD::field('error');
        CRUD::field('error_description');

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
