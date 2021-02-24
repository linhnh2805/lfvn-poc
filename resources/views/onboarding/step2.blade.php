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
    <h4 class="mb-3">THÔNG TIN CÁ NHÂN</h4>
    <form class="needs-validation" novalidate action="step2" id="mainForm" method="POST">
      @csrf
      <input type="hidden" name="reserve_id" value="{{$reserve_id}}">
      <div class="row">
        <div class="col-md-12 mb-3">
          <label for="firstName">Họ và tên</label>
          <input type="text" class="form-control" id="fullName" name="full_name" value="{{$personal->full_name}}" required readonly>
          <div class="invalid-feedback">
            Hãy điền họ và tên.
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-md-12 mb-3">
          <label for="firstName">Ngày tháng năm sinh</label>
          <input type="text" class="form-control" id="dob" name="dob" value="{{$personal->dob}}" required readonly>
          <div class="invalid-feedback">
            Hãy nhập ngày tháng năm sinh.
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-md-12 mb-3">
          <label for="firstName">Nghề nghiệp</label>
          <input type="text" class="form-control" id="job" name="job" placeholder="" value="" required>
          <div class="invalid-feedback">
            Hãy nhập nghề nghiệp.
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-md-12 mb-3">
          <label for="firstName">Trình độ học vấn</label>
          <!-- <input type="text" class="form-control" id="education" name="education" placeholder="" value="" required> -->
          <select class="form-control" id="education" name="education" required>
            <option value="">----------</option>
            <option value="Đại học">Đại học</option>
            <option value="Trung học phổ thông">Trung học phổ thông</option>
            <option value="Thạc sĩ">Thạc sĩ</option>
          </select>
          <div class="invalid-feedback">
            Hãy nhập trình độ học vấn.
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-md-12 mb-3">
          <label for="firstName">Chức vụ</label>
          <input type="text" class="form-control" id="job_position" name="job_position" placeholder="" value="" required>
          <div class="invalid-feedback">
            Hãy nhập chức vụ.
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-md-12 mb-3">
          <label for="firstName">Tình trạng hôn nhân</label>
          <!-- <input type="text" class="form-control" id="marital_status" name="marital_status" placeholder="" value="" required> -->
          <select class="form-control" id="marital_status" name="marital_status" required>
            <option value="">----------</option>
            <option value="Độc thân">Độc thân</option>
            <option value="Đã có gia đình">Đã có gia đình</option>
          </select> 
          <div class="invalid-feedback">
            Hãy chọn tình trạng hôn nhân.
          </div>
        </div>
      </div>

      <div class="mb-3">
        <h3>Thông tin giấy tờ tuỳ thân</h3>
      </div>

      <div class="row">
        <div class="col-md-12 mb-3">
          <label for="firstName">Số CMND/CCCD</label>
          <input type="text" class="form-control" id="national_id" value="{{$personal->national_id}}" required readonly>
          <div class="invalid-feedback">
            Hãy nhập số CMND/CCCD.
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-md-12 mb-3">
          <label for="firstName">Ngày cấp</label>
          <input type="text" class="form-control" id="issue_date" value="{{$personal->issue_date}}" required readonly>
          <div class="invalid-feedback">
            Valid issue date is required.
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-md-12 mb-3">
          <label for="firstName">Nơi cấp</label>
          <input type="text" class="form-control" id="issue_at" value="{{$personal->issue_at}}" required readonly>
          <div class="invalid-feedback">
            Valid issue at is required.
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-md-12 mb-3">
          <label for="firstName">Số CMND/CCCD cũ (nếu có)</label>
          <input type="text" class="form-control" id="old_national_id" placeholder="" value="">
          <div class="invalid-feedback">
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-md-12 mb-3">
          <label for="firstName">Hộ chiếu (nếu có)</label>
          <input type="text" class="form-control" id="passport" placeholder="" value="">
          <div class="invalid-feedback">
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