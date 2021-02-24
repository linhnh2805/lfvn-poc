@extends('layouts.master')

@section('content')
<link rel="stylesheet" href="{{ asset('css/onboarding.css') }}">
<link rel="stylesheet" href="{{ asset('css/step1.css') }}">
<div class="py-5 text-center">
  <img class="d-block mx-auto mb-4" src="/images/lfvn-logo.png" alt="" width="72" height="72">
  <h2>ONBOARDING FORM</h2>
  @include('layouts.message-error')
</div>

<div class="row">
  <div class="col-md-8 offset-md-2">
    <h4 class="mb-3">Hình ảnh CMND/CCCD</h4>
    <form class="needs-validation" id="mainForm" novalidate action="step1" method="POST" enctype="multipart/form-data">
      @csrf
      <br>
      <div class="row">
        <div class="col-sm-6 imgUp">
          <div class="imagePreview"></div>
          <label class="btn btn-primary">
            Tải lên
            <input type="file" name="front" class="uploadFile img" value="Upload Photo" required>
          </label>
        </div><!-- col-4 -->
        <div class="col-sm-6 imgUp">
          <div class="imagePreview"></div>
          <label class="btn btn-primary">
            Tải lên
            <input type="file" name="back" class="uploadFile img" value="Upload Photo" required>
          </label>
        </div><!-- col-4 -->
      </div><!-- row -->

      <br>
      <h4 class="mb-3">Hình ảnh chân dung</h4>
      
      <div class="row">
        <div class="col-sm-6 imgUp">
          <div class="imagePreview"></div>
          <label class="btn btn-primary">
            Tải lên
            <input type="file" name="portrait" class="uploadFile img" value="Upload Photo" required>
          </label>
        </div><!-- col-4 -->
      </div><!-- row -->

      
      {!! RecaptchaV3::initJs() !!}
      {!! RecaptchaV3::field('onboarding') !!}
      @error('g-recaptcha-response')
      <div class="row">
        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
      </div>
      @enderror

      <hr class="mb-4">
      <div class="row">
        <div class="col-sm-12">
          <button class="btn btn-primary btn-lg btn-block" type="submit" id="continueBtn"><i class="fa fa-circle-notch fa-spin hidden"></i> Tiếp tục</button>
        </div>
      </div>
    </form>
  </div>
</div>
@endsection

@section('scripts')
<script type="text/javascript" src="{{ asset('js/step1.js') }}"></script>
<script>
  $(document).ready(function() {

    $('#step1').addClass('active');

    $('#mainForm').submit(function() {
      $('#continueBtn i').removeClass('hidden');
      $('#continueBtn').prop('disabled', true);
    });
  });
</script>
@endsection