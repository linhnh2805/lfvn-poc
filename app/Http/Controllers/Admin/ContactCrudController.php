<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ContactRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class ContactCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class ContactCrudController extends CrudController
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
        CRUD::setModel(\App\Models\Contact::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/contact');
        CRUD::setEntityNameStrings('contact', 'contacts');
    }

    /**
     * Define what happens when the List operation is loaded.
     * 
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        CRUD::column('person.full_name');
        CRUD::column('email');
        CRUD::column('phone_number');
        CRUD::column('second_phone_number');
        //CRUD::column('first_reference_name');
        //CRUD::column('first_reference_national_id');
        //CRUD::column('first_reference_relationship');
        //CRUD::column('first_reference_phone_number');
        //CRUD::column('first_reference_same_address');
        //CRUD::column('second_reference_name');
        //CRUD::column('second_reference_national_id');
        //CRUD::column('second_reference_relationship');
        //CRUD::column('second_reference_phone_number');
        CRUD::column('created_at');
        //CRUD::column('updated_at');
        //CRUD::column('agreement_usage_information');
        //CRUD::column('agreement_receive_advertise');
        CRUD::column('otp');
        CRUD::column('start_time');
        CRUD::column('expire_time');
        CRUD::column('reserve_id');
        CRUD::column('status');
        //CRUD::column('available_time');
        //CRUD::column('cic_credit_check');
        //CRUD::column('cic_credit_check_message');

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
        CRUD::setValidation(ContactRequest::class);

        CRUD::field('personal_id');
        CRUD::field('email');
        CRUD::field('phone_number');
        CRUD::field('second_phone_number');
        CRUD::field('first_reference_name');
        CRUD::field('first_reference_national_id');
        CRUD::field('first_reference_relationship');
        CRUD::field('first_reference_phone_number');
        CRUD::field('first_reference_same_address');
        CRUD::field('second_reference_name');
        CRUD::field('second_reference_national_id');
        CRUD::field('second_reference_relationship');
        CRUD::field('second_reference_phone_number');
        CRUD::field('agreement_usage_information');
        CRUD::field('agreement_receive_advertise');
        CRUD::field('otp');
        CRUD::field('start_time');
        CRUD::field('expire_time');
        CRUD::field('reserve_id');
        CRUD::field('status');
        CRUD::field('available_time');
        CRUD::field('cic_credit_check');
        CRUD::field('cic_credit_check_message');

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
        //$this->setupCreateOperation();
        // Readonly field
        $this->crud->addField([
            'name' => 'person.full_name',
            'label' => 'Full Name',
            'type' => 'text',
            'attributes' => [
                'readonly' => 'readonly'
            ],
            'wrapper' => [ 
                'class' => 'form-group col-md-6'
            ]
        ]);
        $this->crud->addField([
            'name' => 'person.national_id',
            'label' => 'National ID',
            'type' => 'text',
            'attributes' => [
                'readonly'  => 'readonly'
            ],
            'wrapper' => [ 
                'class' => 'form-group col-md-6'
            ]
        ]);
        $this->crud->addField([
            'name' => 'email',
            'label' => 'Email',
            'type' => 'text',
            'attributes' => [
                'readonly' => 'readonly'
            ],
            'wrapper' => [ 
                'class' => 'form-group col-md-6'
            ]
        ]);
        $this->crud->addField([
            'name' => 'phone_number',
            'label' => 'Phone Number',
            'type' => 'text',
            'attributes' => [
                'readonly' => 'readonly'
            ],
            'wrapper' => [ 
                'class' => 'form-group col-md-6'
            ]
        ]);

        
        $this->crud->addField([
            'name' => 'start_time',
            'label' => 'Start Time',
            'type' => 'datetime',
            'attributes' => [
                'readonly' => 'readonly'
            ],
            'wrapper' => [ 
                'class' => 'form-group col-md-6'
            ]
        ]);
        $this->crud->addField([
            'name' => 'expire_time',
            'label' => 'Expire Time',
            'type' => 'datetime',
            'attributes' => [
                'readonly' => 'readonly'
            ],
            'wrapper' => [ 
                'class' => 'form-group col-md-6'
            ]
        ]);

        // Edit enable
        $this->crud->addField([   // select_from_array
            'name'        => 'status',
            'label'       => "Status",
            'type'        => 'select_from_array',
            'options'     => ['ACTIVATING' => 'ACTIVATING', 'DONE' => 'DONE', 'EXPIRED' => 'EXPIRED']
        ]);
        $this->crud->field('otp');
    }
}
