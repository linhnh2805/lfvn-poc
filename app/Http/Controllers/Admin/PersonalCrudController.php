<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\PersonalRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class PersonalCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class PersonalCrudController extends CrudController
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
        CRUD::setModel(\App\Models\Personal::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/personal');
        CRUD::setEntityNameStrings('personal', 'personals');
    }

    /**
     * Define what happens when the List operation is loaded.
     * 
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        CRUD::column('full_name');
        CRUD::column('gender');
        CRUD::column('dob');
        CRUD::column('job');
        //CRUD::column('education');
        //CRUD::column('job_position');
        //CRUD::column('marital_status');
        CRUD::column('national_id');
        CRUD::column('issue_date');
        CRUD::column('issue_at');
        CRUD::column('old_national_id');
        CRUD::column('passport');
        //CRUD::column('is_lend');
        CRUD::column('created_at');
        //CRUD::column('updated_at');
        CRUD::column('reserve_id');
        CRUD::column('status');
        //CRUD::column('province');
        //CRUD::column('district');
        //CRUD::column('ward');
        //CRUD::column('address');
        //CRUD::column('last_name');
        //CRUD::column('first_name');
        CRUD::column('birthday');
        //CRUD::column('ethnicity');
        //CRUD::column('religion');
        //CRUD::column('home_town');
        //CRUD::column('sex');
        //CRUD::column('expire');
        //CRUD::column('logiccheck');
        //CRUD::column('logicmessage');
        //CRUD::column('face_score');
        //CRUD::column('expiry');
        //CRUD::column('agreement_usage_information');
        //CRUD::column('agreement_receive_advertise');
        //CRUD::column('cic_fraud_check');
        //CRUD::column('cic_fraud_check_message');
        //CRUD::column('device_token');

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
        CRUD::setValidation(PersonalRequest::class);

        CRUD::field('full_name');
        CRUD::field('gender');
        CRUD::field('dob');
        CRUD::field('job');
        CRUD::field('education');
        CRUD::field('job_position');
        CRUD::field('marital_status');
        CRUD::field('national_id');
        CRUD::field('issue_date');
        CRUD::field('issue_at');
        CRUD::field('old_national_id');
        CRUD::field('passport');
        CRUD::field('is_lend');
        CRUD::field('reserve_id');
        CRUD::field('status');
        CRUD::field('province');
        CRUD::field('district');
        CRUD::field('ward');
        CRUD::field('address');
        CRUD::field('last_name');
        CRUD::field('first_name');
        CRUD::field('birthday');
        CRUD::field('ethnicity');
        CRUD::field('religion');
        CRUD::field('home_town');
        CRUD::field('sex');
        CRUD::field('expire');
        CRUD::field('logiccheck');
        CRUD::field('logicmessage');
        CRUD::field('face_score');
        CRUD::field('expiry');
        CRUD::field('agreement_usage_information');
        CRUD::field('agreement_receive_advertise');
        CRUD::field('cic_fraud_check');
        CRUD::field('cic_fraud_check_message');
        CRUD::field('device_token');

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
        // $this->setupCreateOperation();
        // Readonly field
        $this->crud->addField([
            'name' => 'full_name',
            'label' => 'Họ và tên',
            'type' => 'text',
            'attributes' => [
                'readonly' => 'readonly'
            ]
        ]);
        $this->crud->addField([
          'name' => 'job',
          'label' => 'Nghề nghiệp',
          'type' => 'text',
          'attributes' => [
              'readonly'  => 'readonly'
          ],
          'wrapper' => [ 
              'class' => 'form-group col-md-6'
          ]
        ]);
        $this->crud->addField([
          'name' => 'job_position',
          'label' => 'Chức vụ',
          'type' => 'text',
          'attributes' => [
              'readonly'  => 'readonly'
          ],
          'wrapper' => [ 
              'class' => 'form-group col-md-6'
          ]
        ]);

        $this->crud->addField([
          'name' => 'national_id',
          'label' => 'CMND/CCCD',
          'type' => 'text',
          'attributes' => [
              'readonly'  => 'readonly'
          ],
          'wrapper' => [ 
              'class' => 'form-group col-md-6'
          ]
        ]);
        
        $this->crud->addField([
          'name' => 'dob',
          'label' => 'Ngày sinh',
          'type' => 'text',
          'attributes' => [
              'readonly' => 'readonly'
          ],
          'wrapper' => [ 
              'class' => 'form-group col-md-6'
          ]
        ]);
        $this->crud->addField([
          'name' => 'address',
          'label' => 'Địa chỉ',
          'type' => 'text',
          'attributes' => [
              'readonly'  => 'readonly'
          ],
          'wrapper' => [ 
              'class' => 'form-group col-md-6'
          ]
        ]);
        $this->crud->addField([
          'name' => 'home_town',
          'label' => 'Quê quán',
          'type' => 'text',
          'attributes' => [
              'readonly'  => 'readonly'
          ],
          'wrapper' => [ 
              'class' => 'form-group col-md-6'
          ]
        ]);
        $this->crud->addField([
          'name' => 'issue_date',
          'label' => 'Ngày cấp',
          'type' => 'text',
          'attributes' => [
              'readonly'  => 'readonly'
          ],
          'wrapper' => [ 
              'class' => 'form-group col-md-6'
          ]
        ]);
        $this->crud->addField([
          'name' => 'issue_at',
          'label' => 'Nơi cấp',
          'type' => 'text',
          'attributes' => [
              'readonly'  => 'readonly'
          ],
          'wrapper' => [ 
              'class' => 'form-group col-md-6'
          ]
        ]);

        $this->crud->addField([
          'name' => 'logiccheck',
          'label' => 'Kiểm tra CMND',
          'type' => 'text',
          'attributes' => [
              'readonly' => 'readonly'
          ],
          'wrapper' => [ 
              'class' => 'form-group col-md-6'
          ]
        ]);
        $this->crud->addField([
          'name' => 'face_status',
          'label' => 'Kiểm tra khuôn mặt',
          'type' => 'text',
          'attributes' => [
              'readonly' => 'readonly'
          ],
          'wrapper' => [ 
              'class' => 'form-group col-md-6'
          ]
        ]);
        
        $this->crud->addField([
          'name' => 'created_at',
          'label' => 'Thời gian tạo',
          'type' => 'text',
          'attributes' => [
              'readonly'  => 'readonly'
          ],
          'wrapper' => [ 
              'class' => 'form-group col-md-6'
          ]
        ]);
      
        
        // Edit enable
        #$this->crud->field('status');
        $this->crud->addField([
          'name' => 'status',
          'label' => 'Trạng thái',
          'type' => 'select_from_array',
          'options' => [
            'DRAFT' => 'Chưa đăng ký',
            'SUBMITTED' => 'Đang xử lý',
            'ACTIVE' => 'Đang hoạt động',
            'DENY' => 'Từ chối'
          ],
          'wrapper' => [ 
            'class' => 'form-group col-md-6'
          ]
        ]);
        # $this->crud->field('device_token');
    }
}
