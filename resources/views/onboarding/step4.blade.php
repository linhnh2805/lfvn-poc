@extends('layouts.master')

@section('content')
<link rel="stylesheet" href="{{ asset('css/onboarding.css') }}">
<div class="py-5 text-center">
  <img class="d-block mx-auto mb-4" src="/images/lfvn-logo.png" alt="" width="72" height="72">
  <h2>ONBOARDING FORM</h2>
  @include('layouts.message-error')
</div>

<div class="row">
  <div class="col-md-8 offset-md-2">
    <h4 class="mb-3">THÔNG TIN LIÊN LẠC</h4>
    <form class="needs-validation" novalidate action="step4" id="mainForm" method="POST">
      @csrf
      <input type="hidden" name="reserve_id" value="{{$reserve_id}}">
      <div class="row">
        <div class="col-md-12 mb-3">
          <label for="firstName">Email</label>
          <input type="text" class="form-control" id="email" name="email" placeholder="" value="" required pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$">
          <div class="invalid-feedback">
            Hãy nhập email.
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-md-12 mb-3">
          <label for="firstName">Số điện thoại</label>
          <input type="text" class="form-control" id="phone_number" name="phone_number" placeholder="" value="" required pattern="[0-9]{10}">
          <div class="invalid-feedback">
            Hãy nhập số điện thoại.
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-md-12 mb-3">
          <label for="firstName">Số điện thoại thứ 2 (nếu có)</label>
          <input type="text" class="form-control" id="second_phone_number" name="second_phone_number" placeholder="" value="">
          <div class="invalid-feedback">
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-md-12 mb-3">
          <label for="firstName">Thời gian có thể nghe điện thoại thẩm định</label>
          <input type="text" class="form-control" id="available_time" name="available_time" placeholder="07h-09h" value="" required>
          <div class="invalid-feedback">
            Hãy nhập thời gian có thể nghe thẩm định.
          </div>
        </div>
      </div>

      <h4>Người tham chiếu thứ nhất</h4>
      <div class="muted">Bắt buộc là vợ/chồng với người đã kết hôn</div>
      <div class="row">
        <div class="col-md-12 mb-3">
          <label for="firstName">Họ và tên</label>
          <input type="text" class="form-control" id="first_reference_name" name="first_reference_name" placeholder="" value="" required>
          <div class="invalid-feedback">
            Hãy nhập họ và tên.
          </div>
        </div>
      </div>
      
      <div class="row">
        <div class="col-md-12 mb-3">
          <label for="firstName">Số CMND/CCCD</label>
          <input type="text" class="form-control" id="first_reference_national_id" name="first_reference_national_id" placeholder="" value="" required>
          <div class="invalid-feedback">
            Hãy nhập Số CMND/CCCD.
          </div>
        </div>
      </div>
      
      <div class="row">
        <div class="col-md-12 mb-3">
          <label for="firstName">Quan hệ</label>
          <!-- <input type="text" class="form-control" id="first_reference_relationship" name="first_reference_relationship" placeholder="" value="" required> -->
          <select class="form-control" id="first_reference_relationship" name="first_reference_relationship" required>
            <option value="">----------</option>
            <option value="Vợ">Vợ</option>
            <option value="Chồng">Chồng</option>
            <option value="Anh">Anh</option>
            <option value="Em">Em</option>
          </select>
          <div class="invalid-feedback">
            Hãy nhập quan hệ.
          </div>
        </div>
      </div>
      
      <div class="row">
        <div class="col-md-12 mb-3">
          <label for="firstName">Số điện thoại</label>
          <input type="text" class="form-control" id="first_reference_phone_number" name="first_reference_phone_number" placeholder="" value="" required pattern="[0-9]{10}">
          <div class="invalid-feedback">
            Hãy nhập Số điện thoại.
          </div>
        </div>
      </div>

      <h5>Địa chỉ đăng ký hộ khẩu</h5>
      <div class="d-block my-3">
        <div class="custom-control custom-radio">
          <input id="yes" name="register_address" type="radio" class="custom-control-input" required>
          <label class="custom-control-label" for="yes">Trùng với địa chỉ hiện tại của khách</label>
        </div>
        <div class="custom-control custom-radio">
          <input id="no" name="register_address" type="radio" class="custom-control-input" checked required>
          <label class="custom-control-label" for="no">Khác</label>
        </div>
      </div>

      <h4>Người tham chiếu thứ hai</h4>
      <div class="row">
        <div class="col-md-12 mb-3">
          <label for="firstName">Họ và tên</label>
          <input type="text" class="form-control" id="second_reference_name" name="second_reference_name" placeholder="" value="" required>
          <div class="invalid-feedback">
            Hãy nhập Họ và tên.
          </div>
        </div>
      </div>
      
      <div class="row">
        <div class="col-md-12 mb-3">
          <label for="firstName">Số CMND/CCCD</label>
          <input type="text" class="form-control" id="second_reference_national_id" name="second_reference_national_id" placeholder="" value="" required>
          <div class="invalid-feedback">
          Hãy nhập Số CMND/CCCD.
          </div>
        </div>
      </div>
      
      <div class="row">
        <div class="col-md-12 mb-3">
          <label for="firstName">Quan hệ</label>
          <!-- <input type="text" class="form-control" id="second_reference_relationship" name="second_reference_relationship" placeholder="" value="" required> -->
          <select class="form-control" id="second_reference_relationship" name="second_reference_relationship" required>
            <option value="">----------</option>
            <option value="Anh">Anh</option>
            <option value="Em">Em</option>
            <option value="Bố">Bố</option>
            <option value="Mẹ">Mẹ</option>
          </select>
          <div class="invalid-feedback">
            Hãy nhập Quan hệ.
          </div>
        </div>
      </div>
      
      <div class="row">
        <div class="col-md-12 mb-3">
          <label for="firstName">Số điện thoại</label>
          <input type="text" class="form-control" id="second_reference_phone_number" name="second_reference_phone_number" placeholder="" value="" required pattern="[0-9]{10}">
          <div class="invalid-feedback">
            Hãy nhập Số điện thoại.
          </div>
        </div>
      </div>
	  
      {!! RecaptchaV3::initJs() !!}
      {!! RecaptchaV3::field('onboarding') !!}
      @error('g-recaptcha-response')
      <div class="row">
        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
      </div>

      <hr class="mb-4">
      <button class="btn btn-primary btn-lg btn-block" id="continueBtn" type="submit"><i class="fa fa-circle-notch fa-spin hidden"></i> Tiếp tục</button>
    </form>
  </div>
</div>
@endsection

@section('scripts')
<script>
  // Example starter JavaScript for disabling form submissions if there are invalid fields
  (function() {
    'use strict';
    $('#step1').addClass('active');
    $('#step2').addClass('active');
    $('#step3').addClass('active');
    $('#step4').addClass('active');

    window.addEventListener('load', function() {
      // Fetch all the forms we want to apply custom Bootstrap validation styles to
      var forms = document.getElementsByClassName('needs-validation');

      // Loop over them and prevent submission
      var validation = Array.prototype.filter.call(forms, function(form) {
        form.addEventListener('submit', function(event) {
          if (form.checkValidity() === false) {
            event.preventDefault();
            event.stopPropagation();
          } else {
            $('#continueBtn i').removeClass('hidden');
            $('#continueBtn').prop('disabled', true);
          }
          form.classList.add('was-validated');
        }, false);
      });
    }, false);
  })();
</script>
@endsection