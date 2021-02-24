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
    <h4 class="mb-3">THÔNG TIN CƯ TRÚ</h4>
    <form class="needs-validation" novalidate action="step3" id="mainForm" method="POST">
      @csrf
      <input type="hidden" name="reserve_id" value="{{$reserve_id}}">
      <div class="row">
        <div class="col-md-12 mb-3">
          <label for="firstName">Địa chỉ hiện tại</label>
          <input type="text" class="form-control" id="current_address" name="current_address" placeholder="" value="" required>
          <div class="invalid-feedback">
            Hãy nhập địa chỉ hiện tại.
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-md-12 mb-3">
          <label for="firstName">Tỉnh thành</label>
          <input type="text" class="form-control" id="current_province" name="current_province" placeholder="" value="" required>
          <div class="invalid-feedback">
            Hãy nhập thông tin Tỉnh thành/Quận Huyện.
          </div>
        </div>
      </div>

      <h4>Địa chỉ đăng ký hộ khẩu thường trú</h4>
      <div class="d-block my-3">
        <div class="custom-control custom-radio">
          <input id="yes" name="residence_same_as_address" type="radio" class="custom-control-input" checked required>
          <label class="custom-control-label" for="yes">Trùng địa chỉ hiện tại</label>
        </div>
        <div class="custom-control custom-radio">
          <input id="no" name="residence_same_as_address" type="radio" class="custom-control-input" required>
          <label class="custom-control-label" for="no">Khác</label>
        </div>
      </div>

      <div class="row">
        <div class="col-md-12 mb-3">
          <label for="firstName">Địa chỉ đăng ký hộ khẩu thường trú</label>
          <input type="text" class="form-control" id="residence_address" name="residence_address" placeholder="" value="" required>
          <div class="invalid-feedback">
            Hãy nhập địa chỉ đăng ký.
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-md-12 mb-3">
          <label for="firstName">Tỉnh thành/Quyện huyện</label>
          <input type="text" class="form-control" id="residence_province" name="residence_province" placeholder="" value="" required>
          <div class="invalid-feedback">
            Hãy nhập Tỉnh thành/Quận huyện.
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-md-12 mb-3">
          <label for="firstName">Thời gian bắt đầu cư trú</label>
          <div class="input-group date">
            <input type="text" class="form-control datetime" id="residence_start_date" name="residence_start_date" required>
            <div class="input-group-append">
              <span class="fa fa-calendar input-group-text start_date_calendar" aria-hidden="true "></span>
            </div>
          </div>
          <!-- <input type="text" class="form-control datepicker date" id="residence_start_date" name="residence_start_date" placeholder="" value="" required> -->
          <div class="invalid-feedback">
            Hãy nhập Thời gian bắt đầu cư trú.
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-md-12 mb-3">
          <label for="firstName">Tình trạng cư trú</label>
          <input type="text" class="form-control" id="residence_status" name="residence_status" placeholder="" value="" required>
          <div class="invalid-feedback">
            Hãy chọn tình trạng cư trú.
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
<script src="{{ asset('vendor/datepicker/moment.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('vendor/datepicker/bootstrap-datepicker.min.js') }}" type="text/javascript"></script>
<link href="{{ asset('vendor/datepicker/bootstrap-datepicker.min.css') }}" type="text/css">
<script>
  // Example starter JavaScript for disabling form submissions if there are invalid fields
  (function() {
    'use strict';
    $('#step1').addClass('active');
    $('#step2').addClass('active');
    $('#step3').addClass('active');

    // $('#mainForm').submit(function() {
    //   $('#continueBtn i').removeClass('hidden');
    //   $('#continueBtn').prop('disabled', true);
    // });

    // Setup datepicker
    // $('input.datepicker').datepicker({
    //     uiLibrary: 'bootstrap4',
    //     iconsLibrary: 'fontawesome',
    // });

    $('#mainForm .input-group.date').datepicker({
        format: "yyyy-mm-dd",
        autoclose: true
    });

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