@extends('layouts.master')

@section('content')
<link rel="stylesheet" href="{{ asset('css/onboarding.css') }}">
<link rel="stylesheet" href="{{ asset('css/step1.css') }}">
<div class="py-5 text-center">
  <img class="d-block mx-auto mb-4" src="/images/lfvn-logo.png" alt="" width="72" height="72">
  <h2>Onboarding form</h2>
  @include('layouts.message-error')
</div>

<div class="row">
  <div class="col-md-8 offset-md-2">
    <h4 class="mb-3">Hinh anh CMND/CCCD</h4>
    <form class="needs-validation" novalidate action="step1" method="POST" enctype="multipart/form-data">
      @csrf
      <br>
      <div class="row">
        <div class="col-sm-6 imgUp">
          <div class="imagePreview"></div>
          <label class="btn btn-primary">
            Upload
            <input type="file" name="front" class="uploadFile img" value="Upload Photo" required>
          </label>
        </div><!-- col-4 -->
        <div class="col-sm-6 imgUp">
          <div class="imagePreview"></div>
          <label class="btn btn-primary">
            Upload
            <input type="file" name="back" class="uploadFile img" value="Upload Photo" required>
          </label>
        </div><!-- col-4 -->
      </div><!-- row -->

      <br>
      <h4 class="mb-3">Hinh anh chan dung</h4>
      
      <div class="row">
        <div class="col-sm-6 imgUp">
          <div class="imagePreview"></div>
          <label class="btn btn-primary">
            Upload
            <input type="file" name="portrait" class="uploadFile img" value="Upload Photo" required>
          </label>
        </div><!-- col-4 -->
      </div><!-- row -->

      <hr class="mb-4">
      <div class="row">
        <div class="col-sm-12">
          <button class="btn btn-primary btn-lg btn-block" type="submit">Continue to checkout</button>
        </div>
      </div>
    </form>
  </div>
</div>
@endsection

@section('scripts')
<script type="text/javascript" src="{{ asset('js/step1.js') }}"></script>
@endsection