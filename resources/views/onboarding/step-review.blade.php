@extends('layouts.master')

@section('content')
<link rel="stylesheet" href="{{ asset('css/onboarding.css') }}">
<link rel="stylesheet" href="{{ asset('css/step1.css') }}">
<div class="py-5 text-center">
  <img class="d-block mx-auto mb-4" src="/images/lfvn-logo.png" alt="" width="72" height="72">
  <h2>REVIEW ONBOARDING</h2>
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
          <td>Giới tính</td>
          <td>{{$personal->sex}}</td>
        </tr>
        <tr>
          <td>Nghề nghiệp</td>
          <td>{{$personal->job}}</td>
        </tr>
        <tr>
          <td>Trình độ học vấn</td>
          <td>{{$personal->education}}</td>
        </tr>
        <tr>
          <td>Chức vụ</td>
          <td>{{$personal->job_position}}</td>
        </tr>
        <tr>
          <td>Tình trạng hôn nhân</td>
          <td>{{$personal->marital_status}}</td>
        </tr>
      </tbody>
    </table>
  </div>

  <div class="col-md-6">
    <table class="table table-bordered table-striped table-review">
      <tbody>
        <tr>
          <td>Số CMND/CCCD</td>
          <td>{{$personal->national_id}}</td>
        </tr>
        <tr>
          <td>Ngày cấp</td>
          <td>{{$personal->issue_date}}</td>
        </tr>
        <tr>
          <td>Nơi cấp</td>
          <td>{{$personal->issue_at}}</td>
        </tr>
        <tr>
          <td>Số CMND cũ (nếu có)</td>
          <td>{{$personal->old_national_id}}</td>
        </tr>
        <tr>
          <td>Hộ chiếu (nếu có)</td>
          <td>{{$personal->passport}}</td>
        </tr>
      </tbody>
    </table>
  </div>
</div>

<div class="row">
  <div class="col-md-6">
    <table class="table table-bordered table-striped table-review">
      <tbody>
        <tr>
          <td>Địa chỉ hiện tại</td>
          <td>{{$residence->current_address}}</td>
        </tr>
        <tr>
          <td>Tỉnh thành/Quận huyện</td>
          <td>{{$residence->current_province}}</td>
        </tr>
        <tr>
          <td>Đăng ký hộ khẩu thường trú</td>
          <td>{{$residence->residence_same_as_address}}</td>
        </tr>
      </tbody>
    </table>
  </div>
  <div class="col-md-6">
    <table class="table table-bordered table-striped table-review">
      <tbody>
        <tr>
          <td>Thời gian bắt đầu cư trú</td>
          <td>{{$residence->residence_start_date}}</td>
        </tr>
        <tr>
          <td>Tình trạng cư trú</td>
          <td>{{$residence->residence_status}}</td>
        </tr>
      </tbody>
    </table>
  </div>
</div>

<div class="row">
  <div class="col-md-6">
    <table class="table table-bordered table-striped table-review">
      <tbody>
        <tr>
          <td>Email</td>
          <td>{{$contact->email}}</td>
        </tr>
        <tr>
          <td>Số điện thoại</td>
          <td>{{$contact->phone_number}}</td>
        </tr>
        <tr>
          <td>Thời gian nghe thẩm định</td>
          <td>{{$contact->available_time}}</td>
        </tr>
      </tbody>
    </table>
  </div>
</div>

<div class="row">
  <div class="col-md-6">
    <table class="table table-bordered table-striped table-review">
      <tbody>
        <tr>
          <td colspan="2">Người tham chiếu thứ nhất</td>
        </tr>
        <tr>
          <td>Họ và tên</td>
          <td>{{$contact->first_reference_name}}</td>
        </tr>
        <tr>
          <td>Số CMND/CCCD</td>
          <td>{{$contact->first_reference_national_id}}</td>
        </tr>
        <tr>
          <td>Quan hệ</td>
          <td>{{$contact->first_reference_relationship}}</td>
        </tr>
        <tr>
          <td>Số điện thoại</td>
          <td>{{$contact->first_reference_phone_number}}</td>
        </tr>
      </tbody>
    </table>
  </div>
  <div class="col-md-6">
    <table class="table table-bordered table-striped table-review">
      <tbody>
        <tr>
          <td colspan="2">Người tham chiếu thứ hai</td>
        </tr>
        <tr>
          <td>Họ và tên</td>
          <td>{{$contact->second_reference_name}}</td>
        </tr>
        <tr>
          <td>Số CMND/CCCD</td>
          <td>{{$contact->second_reference_national_id}}</td>
        </tr>
        <tr>
          <td>Quan hệ</td>
          <td>{{$contact->second_reference_relationship}}</td>
        </tr>
        <tr>
          <td>Số điện thoại</td>
          <td>{{$contact->second_reference_phone_number}}</td>
        </tr>
      </tbody>
    </table>
  </div>
</div>

<form class="needs-validation" novalidate action="step_review" id="mainForm" method="POST">
  @csrf
  <input type="hidden" name="reserve_id" value="{{$reserve_id}}">
  <hr class="mb-4">
  <div class="row">
    <div class="col-sm-12">
      <button class="btn btn-primary btn-lg btn-block" type="submit" id="continueBtn"><i class="fa fa-circle-notch fa-spin hidden"></i> Hoàn thành</button>
    </div>
  </div>
</form>
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