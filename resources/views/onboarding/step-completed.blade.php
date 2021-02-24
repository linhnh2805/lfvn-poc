@extends('layouts.master')

@section('content')
<link rel="stylesheet" href="{{ asset('css/onboarding.css') }}">
<link rel="stylesheet" href="{{ asset('css/step1.css') }}">
<div class="py-5 text-center">
  <img class="d-block mx-auto mb-4" src="/images/lfvn-logo.png" alt="" width="72" height="72">
  <h2>ONBOARDING COMPLETED</h2>
  @include('layouts.message-error')
</div>

<div class="row">
  <div class="col-md-6">
    <table class="table table-bordered table-striped table-review">
      <tbody>
        <tr>
          <td>Họ và tên</td>
          <td>{{$personal->full_name}}</td>
        </tr>
        <tr>
          <td>Email</td>
          <td>{{$residence->current_address}}</td>
        </tr>
        <tr>
          <td>Số điện thoại</td>
          <td>{{$residence->current_province}}</td>
        </tr>
      </tbody>
    </table>
  </div>
</div>

<hr class="mb-4">
<div class="row">
  <div class="col-sm-12">
    <a class="btn btn-primary btn-lg btn-block" href="/" id="continueBtn"><i class="fa fa-home"></i> Trang chủ</a>
  </div>
</div>
@endsection

@section('scripts')
<script type="text/javascript" src="{{ asset('js/step1.js') }}"></script>
<script>
  $(document).ready(function() {
    $('#step1').addClass('active');
    $('#step2').addClass('active');
    $('#step3').addClass('active');
    $('#step4').addClass('active');
    $('#step5').addClass('active');

    $('#mainForm').submit(function() {
      $('#continueBtn i').removeClass('hidden');
      $('#continueBtn').prop('disabled', true);
    });
  });
</script>
@endsection